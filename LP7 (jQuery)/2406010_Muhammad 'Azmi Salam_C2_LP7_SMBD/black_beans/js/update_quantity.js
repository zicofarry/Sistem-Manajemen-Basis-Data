// Fungsi untuk mengupdate jumlah quantity
function updateQuantity(item, change) {
    // Mendapatkan elemen input berdasarkan ID yang sesuai dengan item
    const quantityInput = document.getElementById('quantity_' + item);
    
    // Mendapatkan nilai saat ini dari input
    let currentQuantity = parseInt(quantityInput.value);

    // Menghitung jumlah baru
    let newQuantity = currentQuantity + change;

    // Memastikan nilai tidak kurang dari 1 dan tidak lebih dari 10
    if (newQuantity >= 1 && newQuantity <= 10) {
        quantityInput.value = newQuantity;
    }
}
