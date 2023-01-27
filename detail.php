<?php session_start();?>
<?php include 'koneksi.php'?>
<?php

// mendapatkan id produk dari url
$id_produk=$_GET["id"];

// query ambil data
$ambil=$koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
$detail=$ambil->fetch_assoc();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="admin2/css/bootstrap.css">
</head>
<body>
<?php include 'menu.php';  ?>

    <section class="konten">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="foto produk/<?php echo $detail['foto_produk'];?>" class="img-responsive">
                </div>
                <div class="col-md-4">
                    <h2><?php echo $detail['nama_produk'];?></h2>
                    <h4>Rp. <?php echo $detail['harga_produk'];?></h4>

                    <form method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" min="1" class="form-control" name="jumlah">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" name="beli">Beli</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                        if(isset($_POST["beli"])){
                             //mendapatkan jumlah yang diinputkan
                        $jumlah=$_POST['jumlah'];

                        //masukkan diekranjang bekanja
                        $_SESSION['keranjang'][$id_produk] = $jumlah;

                        echo "<script>alert('produk telah masuk kekeranjang belanja');</script>";
                        echo "<script>location='keranjang.php';</script>";
                        
                        }


                    ?>

                    <p><?php echo $detail ['deskripsi_produk'] ?></p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>