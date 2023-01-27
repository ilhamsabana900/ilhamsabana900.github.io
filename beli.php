<?php
session_start();
//mendapatkan id produk dri url
$id_produk=$_GET['id'];

//jika sudah ad aproduk itu dikeranjang maka jumlahnya +1
if(isset($_SESSION['keranjang'][$id_produk])){
    $_SESSION['keranjang'][$id_produk] +=1;
}

//jika blm ada dikeranjang maka produk itu dibeli 1
else{
    $_SESSION['keranjang'][$id_produk] = 1 ;
}
//  echo "<pre>";
// print_r($_SESSION);
//  echo "</pre>";

//larikan kehalaman keranjang
echo "<script>alert('produk telah masuk kedalam keranjang');</script>";
echo "<script>location='keranjang.php';</script>";
?>