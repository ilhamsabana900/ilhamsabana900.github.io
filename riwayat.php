<?php
//mengkoneksikan ke database
session_start();
include 'koneksi.php';

// jika tidak ada session pelanggan(blm login)
if(!isset($_SESSION['pelanggan']) OR empty($_SESSION['pelanggan']))
{
    echo "<script>alert('silahkan login');</script>";
    echo "<script>location= 'login.php';</script>";
    exit();
}
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

<section class="riwayat">
    <div class="container">
        <h3>Riwayat Belanja <?php echo $_SESSION['pelanggan']['nama_pelanggan'];?></h3>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 1;
                    //mendapatkan id pelangkan yang login dari session
                $id_pelanggan=$_SESSION['pelanggan']['id_pelanggan'];

                

                $ambil=$koneksi->query("SELECT*FROM pembelian WHERE id_pelanggan=$id_pelanggan");
                while($pecah =$ambil->fetch_assoc()){

                ?>
                <tr>
                    <td><?php echo $nomor;?></td>
                    <td><?php echo $pecah['tanggal_pembelian'];?></td>
                    <td><?php echo $pecah['status_pembelian'];?></td>
                    <td>Rp. <?php echo number_format($pecah['total_pembelian']);?></td>
                    <td>
                        <a href="nota.php?id=<?php echo $pecah['id_pembeli']?>" class="btn btn-info">Nota</a>
                        <a href="pembayaran.php?id=<?php echo $pecah['id_pembeli'];?>" class="btn btn-success">Pembayaran</a>
                    </td>
                </tr>
                <?php $nomor++;?>
                <?php }?>
                
            </tbody>
        </table>


    </div>
</section>

</body>
</html>



