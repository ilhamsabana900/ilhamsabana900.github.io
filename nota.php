<?php
session_start();
include 'koneksi.php';?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembelian</title>
    <link rel="stylesheet" href="admin2/css/bootstrap.css">
</head>
<body>
<?php include 'menu.php';  ?>
    <section class="konten">
        <div class="container">

                <!-- disini kita copy aja dari detail admin -->
                <h2>Detail Pembelian</h2>

<?php 

$ambil= $koneksi->query("SELECT * FROM pembelian JOIN pelanggan 
	ON pembelian.id_pelanggan=pelanggan.id_pelanggan 
	WHERE pembelian.id_pembeli='$_GET[id]'");
$detail=$ambil->fetch_assoc();

 ?>





 <strong><?php echo $detail['nama_pelanggan']; ?></strong><br>
 <p>
 	<?php echo $detail['telepon_pelanggan']; ?><br>
 	<?php echo $detail['email_pelanggan']; ?>
 </p>


 <div class="row">
    <div class="col-md-4">
        <h3>Pembeli</h3>
        <strong>No. Pembelian : <?php echo $detail['id_pembeli']?></strong><br>
        Tanggal : <?php echo $detail['tanggal_pembelian'];?><br>
        Total : <?php echo number_format( $detail['total_pembelian']);?>
    </div>
    <div class="col-md-4">
        <h3>Pelanggan</h3><br>
        <strong><?php echo $detail['nama_pelanggan']; ?></strong><br>
        <p>
            <?php echo $detail['telepon_pelanggan']; ?><br>
            <?php echo $detail['email_pelanggan']; ?>
        </p>
    </div>
    <div class="col-md-4">
        <h3>Pengiriman</h3>
        <strong><?php echo $detail['nama_kota']?></strong><br>
        Ongkos Kirim : Rp. <?php echo number_format($detail['tarif']);?><br>
        Alamat : <?php echo $detail['alamat_pengiriman']?>
    </div>
 </div>

 <table class="table table-bordered">
 	<thead>
 		<tr>
 			<th>No</th>
 			<th>Nama</th>
 			<th>Harga</th>
            <th>Berat</th>
 			<th>Jumlah</th>
            <th>Sub Berat</th>
 			<th>Sub Total</th>
 		</tr>
 	</thead>
 	<tbody><?php $nomor=1; ?>
 		<?php $ambil= $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembeli='$_GET[id]'"); ?>
 		<?php while($pecah=$ambil->fetch_assoc()) {?>
 		<tr>
 			<td><?php echo $nomor; ?></td>
 			<td><?php echo $pecah['nama']; ?></td>
 			<td>Rp. <?php echo number_format($pecah['harga']) ?></td>
            <td><?php echo $pecah['berat'] ?> Gr</td>
 			<td><?php echo $pecah['jumlah']; ?></td>
 			<td><?php echo $pecah['subberat'] ?> Gr</td>
             <td>Rp. <?php echo number_format($pecah['subharga']) ?></td>
 		</tr>
 	<?php } ?>
 	<?php $nomor++; ?>
 	</tbody>

 </table>

 <div class="row">
        <div class="col-md-7">
            <div class="alert alert-info">
                <p>
                    silahkan melakukan pembayaran Rp. <?php echo number_format($detail['total_pembelian']); ?>  ke <br>
                    <strong>BANK BCA 67128832 M. ILHAM SYA"BANA</strong>
                </p>
            </div>
        </div>
 </div>

        </div>
    </section>
</body>
</html>