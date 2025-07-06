<?php
 $conn = mysqli_connect('localhost', 'root', '', 'sigma');


 $query = "select * from provinces";
 $result = mysqli_query($conn, $query);


 if($result) {
     while($temp = mysqli_fetch_assoc($result)) {
         $datas[] = [
             "ID" => $temp["ID"],
             "name" => $temp["name"],
         ];
     }
 }


 mysqli_close($conn);
 header('Content-Type: application/json');
 echo json_encode($datas);