-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 06:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `black_beans`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_item_to_order` (IN `p_order_id` INT, IN `p_item_id` INT, IN `p_quantity` INT)   BEGIN
  INSERT INTO order_items (order_id, item_id, quantity)
  VALUES (p_order_id, p_item_id, p_quantity);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_new_order` (IN `p_employee_id` INT, IN `p_promo_id` INT)   BEGIN
  INSERT INTO orders (order_date, employee_id, promo_id, total_amount)
  VALUES (NOW(), p_employee_id, p_promo_id, 0.00);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getMenu` ()   SELECT m.item_id, m.name, m.price, m.description, m.image,
c.category_name
 FROM menu_items m
 JOIN categories c ON m.category_id = c.category_id
 ORDER BY m.item_id ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_orders_and_revenue_by_date` (IN `input_date` DATE)   BEGIN
    
    SELECT 
        o.order_id,
        o.order_date,
        i.name AS item_name,
        oi.quantity,
        (oi.quantity * i.price) AS subtotal
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu_items i ON oi.item_id = i.item_id
    WHERE DATE(o.order_date) = input_date;

    
    SELECT 
        SUM(oi.quantity * i.price) AS total_revenue
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN menu_items i ON oi.item_id = i.item_id
    WHERE DATE(o.order_date) = input_date;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_FilterMenuByMaxHarga` (IN `m_harga` DECIMAL(10,2), OUT `total_menu` INT, INOUT `info_text` VARCHAR(255))   BEGIN
    -- Hitung jumlah menu yang harganya di bawah m_harga
    SELECT COUNT(*) INTO total_menu
    FROM menu_items
    WHERE price <= m_harga;


    -- Ubah nilai info_text dengan tambahan informasi
    SET info_text = CONCAT(info_text, ' | Terdapat ', total_menu, ' menu di bawah Rp', m_harga);
   
    -- Tampilkan menu hasil filter
    SELECT item_id, name, price
    FROM menu_items
    WHERE price <= m_harga
    ORDER BY price DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_lokal_variabel` ()   BEGIN
   /* deklarasi lokal variabel */
   DECLARE a INT DEFAULT 10;  
   DECLARE b, c INT;    
   
   /* inisialisasi lokal variabel */  
   SET a = a + 100;  
   SET b = 2;  
   SET c = a + b;    
  BEGIN  
      /* deklarasi lokal variabel pada nested block */      
      DECLARE c INT;            
      SET c = 5;      
     
        /* akan menampilkan nilai variabel c pada nested block */      
      SELECT a, b, c;  
   END;    




END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calculate_order_total` (`p_order_id` INT) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
  DECLARE total DECIMAL(10,2);
  DECLARE discount DECIMAL(5,2) DEFAULT 0;
  DECLARE promo INT;

  -- Hitung total harga tanpa diskon
  SELECT SUM(mi.price * oi.quantity)
  INTO total
  FROM order_items oi
  JOIN menu_items mi ON oi.item_id = mi.item_id
  WHERE oi.order_id = p_order_id;

  -- Ambil promo_id dari order
  SELECT promo_id
  INTO promo
  FROM orders
  WHERE order_id = p_order_id;

  -- Ambil diskon jika ada promo
  IF promo IS NOT NULL THEN
    SELECT discount_percent
    INTO discount
    FROM promotions
    WHERE promo_id = promo;
  END IF;

  -- Kembalikan total setelah diskon
  RETURN IFNULL(total, 0.00) * (1 - (discount / 100));
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_best_seller_by_category` (`input_category_id` INT) RETURNS VARCHAR(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE best_seller_name VARCHAR(255);

    SELECT i.name
    INTO best_seller_name
    FROM menu_items i
    JOIN order_items oi ON i.item_id = oi.item_id
    WHERE i.category_id = input_category_id
    GROUP BY i.item_id
    ORDER BY SUM(oi.quantity) DESC
    LIMIT 1;

    RETURN best_seller_name;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_item_status` (`p_item_id` INT) RETURNS VARCHAR(20) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
  DECLARE count_item INT;
  DECLARE status_item VARCHAR(20);

  SELECT COUNT(*) INTO count_item
  FROM menu_items
  WHERE item_id = p_item_id;

  IF count_item > 0 THEN
    SET status_item = 'available';
  ELSE
    SET status_item = 'unavailable';
  END IF;

  RETURN status_item;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `subdistrict` varchar(255) NOT NULL,
  `position_applied` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`id`, `name`, `contact`, `street`, `province`, `city`, `district`, `subdistrict`, `position_applied`, `photo`) VALUES
(1, 'Muhammad Azmi Salam', '085850603196', 'Kulalet', '32', '3204', 'Baleendah', 'Baleendah', 'Barista', 'goten.jpg'),
(2, 'Agus Supriadi', '081234567890', 'Cibaduyut', '32', '3216', 'Cibaduyut', 'Komplek Indah', 'Manajer', 'foto.jpg'),
(3, 'Anas Tahul', '081234567890', 'Bekasi', '35', '3505', 'Bekasi', 'Surikarto', 'CEO', 'Screenshot 2025-01-06 164946.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Coffee'),
(2, 'Tea'),
(3, 'Pastry');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `name`, `position`, `hire_date`, `shift_id`, `photo`) VALUES
(1, 'Bayu Pamungkas', 'Barista', '2023-06-15', 1, 'bayu.jpg'),
(2, 'Sari Lestari', 'Kasir', '2024-01-10', 2, 'sari.jpg'),
(3, 'Dewi Maharani', 'Barista', '2023-11-01', 3, 'dewi.jpg'),
(4, 'Rizky Pratama', 'Barista', '2023-12-05', 1, 'rizky.jpg'),
(5, 'Intan Nuraini', 'Kasir', '2024-02-20', 2, 'intan.jpg'),
(6, 'Fajar Nugraha', 'Barista', '2024-03-10', 3, 'fajar.jpg'),
(7, 'Citra Puspita', 'Waiter', '2024-01-05', 2, 'citra.jpg'),
(8, 'Marlina Putri', 'Cashier', '2024-01-10', 1, 'marlina.jpg'),
(10, 'Muhammad Azmi Salam', 'DIVISI KEORGANISASIAN', '2025-04-21', 3, 'goten.jpg'),
(11, 'Leonardo Dicaprio', 'Barista', '2025-04-03', 2, 'goten.jpg'),
(15, 'Agus Supriadi', 'Manajer', '2025-04-16', 1, 'foto.jpg'),
(16, 'Muhammad Azmi Salam', 'Barista', '2025-04-20', 1, 'goten.jpg'),
(17, 'Muhammad &#039;Azmi Salam', 'Barista', '2025-04-25', 2, 'goten.jpg'),
(18, 'Agus Supriadi', 'Manajer', '2025-04-11', 2, 'foto.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `name`, `description`, `price`, `category_id`, `image`) VALUES
(1, 'Espresso', 'Kopi espresso kuat dengan rasa pahit alami', 25000.00, 1, 'espresso.png'),
(2, 'Latte', 'Kopi latte lembut dengan susu segar', 30000.00, 1, 'latte.png'),
(3, 'Americano', 'Kopi Americano klasik dengan rasa ringan', 27000.00, 1, 'americano.png'),
(4, 'Cappuccino', 'Cappuccino berbuih tebal nan creamy', 32000.00, 1, 'cappuccino.png'),
(5, 'Green Tea', 'Teh hijau segar dengan aroma alami', 28000.00, 2, 'green_tea.png'),
(6, 'Black Tea', 'Teh hitam klasik dengan rasa pekat', 25000.00, 2, 'black_tea.png'),
(7, 'Matcha Latte', 'Matcha latte manis dengan aroma teh hijau', 35000.00, 2, 'matcha_latte.png'),
(8, 'Croissant', 'Croissant mentega renyah', 20000.00, 3, 'croissant.png'),
(9, 'Chocolate Muffin', 'Muffin coklat dengan isian leleh', 22000.00, 3, 'chocolate_muffin.png'),
(10, 'Cheese Danish', 'Pastry keju lembut dan manis', 24000.00, 3, 'cheese_danish.png'),
(11, 'Espresso', 'Kopi pekat dengan rasa kuat dan aroma khas', 28000.00, 1, 'espresso.png'),
(12, 'Oolong Tea', 'Teh oolong semi-fermentasi dengan cita rasa\nfloral', 29000.00, 2, 'oolong_tea.png'),
(13, 'Almond Croissant', 'Croissant renyah berisi krim almond manis', 26000.00, 3, 'almond_croissant.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `promo_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `employee_id`, `promo_id`, `total_amount`) VALUES
(1, '2025-04-06 09:30:00', 1, 1, 121500.00),
(2, '2025-04-06 14:00:00', 2, NULL, 58000.00),
(3, '2025-04-06 19:30:00', 3, 2, 25500.00),
(4, '2025-04-06 10:00:00', 4, 3, 44100.00),
(5, '2025-04-06 15:15:00', 5, 4, 45600.00),
(6, '2025-04-06 20:30:00', 6, NULL, 54000.00),
(7, '2025-04-16 21:10:51', 1, 1, 67500.00),
(9, '2025-05-08 22:09:53', 1, 1, 67500.00),
(10, '2025-05-08 22:58:50', 2, 2, 76500.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 1, 8, 1),
(3, 2, 2, 1),
(4, 2, 5, 1),
(5, 3, 2, 1),
(6, 4, 9, 1),
(7, 4, 3, 1),
(8, 5, 4, 1),
(9, 5, 6, 1),
(10, 6, 2, 1),
(11, 6, 10, 1),
(12, 1, 2, 3),
(13, 9, 1, 3),
(19, 10, 2, 3);

--
-- Triggers `order_items`
--
DELIMITER $$
CREATE TRIGGER `add_item_to_order_trigger` AFTER INSERT ON `order_items` FOR EACH ROW BEGIN
  -- Hanya untuk mencatat waktu penambahan item ke dalam order
  INSERT INTO order_items_log (order_id, item_id, action, timestamp)
  VALUES (NEW.order_id, NEW.item_id, 'Added', NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `remove_item_from_order_trigger` AFTER DELETE ON `order_items` FOR EACH ROW BEGIN
  
  INSERT INTO order_items_log (order_id, item_id, action, timestamp)
  VALUES (OLD.order_id, OLD.item_id, 'Removed', NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_after_delete_order_item` AFTER DELETE ON `order_items` FOR EACH ROW BEGIN
  DECLARE item_price INT;

  
  SELECT price INTO item_price
  FROM menu_items
  WHERE item_id = OLD.item_id;

  
  UPDATE orders
  SET total_amount = total_amount - (item_price * OLD.quantity)
  WHERE order_id = OLD.order_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_after_insert_order_item` AFTER INSERT ON `order_items` FOR EACH ROW BEGIN
  DECLARE item_price INT;

  
  SELECT price INTO item_price
  FROM menu_items
  WHERE item_id = NEW.item_id;

  
  UPDATE orders
  SET total_amount = total_amount + (item_price * NEW.quantity)
  WHERE order_id = NEW.order_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_items_log`
--

CREATE TABLE `order_items_log` (
  `log_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  `action_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_date`, `amount_paid`, `payment_method`) VALUES
(1, 1, '2025-04-06 09:35:00', 58500.00, 'Cash'),
(2, 2, '2025-04-06 14:05:00', 48000.00, 'Debit Card'),
(3, 3, '2025-04-06 19:35:00', 40000.00, 'E-Wallet'),
(4, 4, '2025-04-06 10:05:00', 48600.00, 'Cash'),
(5, 5, '2025-04-06 15:20:00', 43200.00, 'E-Wallet'),
(6, 6, '2025-04-06 20:35:00', 59000.00, 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `promo_id` int(11) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `discount_percent` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`promo_id`, `description`, `discount_percent`, `start_date`, `end_date`, `image`) VALUES
(1, 'Diskon Akhir Pekan', 10.00, '2025-04-20', '2025-04-21', 'p1.jpg'),
(2, 'Diskon Member', 15.00, '2025-04-01', '2025-12-31', 'p2.jpg'),
(3, 'Diskon Awal Bulan', 10.00, '2025-04-01', '2025-04-07', 'p3.jpg'),
(4, 'Grand Opening Cafe', 20.00, '2025-04-01', '2025-04-30', 'p4.jpg'),
(6, 'MAMAMAAAAA', 22.00, '2025-04-02', '2025-05-11', 'goten.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `shift_id` int(11) NOT NULL,
  `shift_name` varchar(50) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`shift_id`, `shift_name`, `start_time`, `end_time`) VALUES
(1, 'Shift Pagi', '08:00:00', '13:00:00'),
(2, 'Shift Siang', '13:00:00', '18:00:00'),
(3, 'Shift Malam', '18:00:00', '23:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `shift_id` (`shift_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `promo_id` (`promo_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `order_items_log`
--
ALTER TABLE `order_items_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promo_id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`shift_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_items_log`
--
ALTER TABLE `order_items_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `shift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`shift_id`);

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`promo_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
