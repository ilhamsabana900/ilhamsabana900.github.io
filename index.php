<?php
//mengkoneksikan ke database
session_start();
include 'koneksi.php';

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Panci</title>
    <link rel="stylesheet" href="admin2/css/bootstrap.css" >
</head>
<body>

<?php include 'menu.php';  ?>
    <!-- konten -->
    <section class="konten">
        <div class="container">
            <h1>produk baru</h1>

            <div class="row">

                <?php $ambil= $koneksi->query("SELECT * FROM produk");?>
                <?php while($perproduk= $ambil->fetch_assoc()) {?>
                <div class="col-md-2">
                    <div class="thumbnail">
                        <img src="foto produk/<?php echo $perproduk["foto_produk"];?>" alt="">
                        <div class="caption">
                            <h3><?php echo $perproduk["nama_produk"];?></h3>
                            <h3>Rp. <?php echo number_format($perproduk["harga_produk"]) ;?></h3>
                            <a href="beli.php?id=<?php echo $perproduk['id_produk'];?>"class="btn btn-primary">beli</a>  
                            <a href="detail.php?id=<?php echo $perproduk['id_produk'];?>" class="btn btn-deafult">Detail</a>                      
                        </div>
                    </div>
                </div>
                <?php } ?>


            </div>
        </div>

      

    </section>
</body>
</html>