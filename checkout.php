<?php

session_start();

include 'koneksi.php';

//jik  tidak ada session pelanggan(blm login), mk dilarikan ke login.php

if(!isset($_SESSION['pelanggan'])){

    echo "<script>alert ('silahkan login dulu');</script>";
    echo "<script>location= 'login.php';</script>";
}

// if (empty($_SESSION['checkout']) or !isset($_SESSION['checkout'])) {

//     echo "<script>alert('checkout kosong, silahkan belanja dulu');</script>";
//     echo "<script>location= 'index.php';</script>";
// }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckOut</title>
    <link rel="stylesheet" href="admin2/css/bootstrap.css">
</head>
<body>
<?php include 'menu.php';  ?>
    <section class="konten">
        <div class="container">
            <h1>Keranjang Belanja</h1>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subharga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor=1;?>
                    <?php $totalbelanja = 0;?>
                    <?php foreach($_SESSION['keranjang'] as $id_produk => $jumlah) :?>
                    <!-- ambil prodauk dari database sesuai id produk -->
                    <?php 
                    
                    $ambil=$koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk' ");
                    $pecah=$ambil->fetch_assoc();
                    $subharga = $pecah['harga_produk'] * $jumlah;
                    ?>

                        <tr>
                        <td><?php echo $nomor;?></td>
                        <td><?php echo $pecah['nama_produk']; ?></td>
                        <td>Rp.<?php echo number_format($pecah["harga_produk"]) ;?></td>
                        <td><?php echo $jumlah;?></td>
                        <td>Rp. <?php echo number_format($subharga);?></td>
                    </tr>
                    <?php $nomor++;?>
                    <?php $totalbelanja += $subharga;?>
                    <?php endforeach?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total Belanja</th>
                        <th>Rp.<?php echo $totalbelanja;?> </th>
                    </tr>
                </tfoot>
            </table>

                    <form method="post">
                        
                        <div class="row">
                            <div class="col-md-4"> 
                                <input type="text" readonly value="<?php echo $_SESSION['pelanggan']['nama_pelanggan'];
                                ?> "class="form-control">
                            </div>
                            <div class="col-md-4">
                            <input type="text" readonly value="<?php echo $_SESSION['pelanggan']['telepon_pelanggan'];
                            ?> "class="form-control">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control"name="id_ongkir">
                                    <option value="">ongkos kirim</option>
                                    <?php
                                    $ambil = $koneksi->query("SELECT * FROM ongkir");
                                    while ($pertarif = $ambil->fetch_assoc()) {
                                        ?>
                                    <option value="<?php echo $pertarif['id_ongkir']?>">
                                        <?php echo ($pertarif['nama_kota']);?> - 
                                    Rp. <?php echo number_format ($pertarif['tarif']);?></option> 
                                    
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label >Alamat Lengkap Pengiriman</label>
                            <textarea name="alamat_pengiriman" id="" cols="30" rows="10" class="form-control" 
                            placeholder="masukkan alamat lengkap pengiriman (termasuk kode pos)"></textarea>
                        </div>
                        <button class="btn btn-primary" name="checkout">Checkout</button>
                    </form>

                    <?php 
                        if(isset($_POST['checkout']))
                        {
                        $id_pelanggan=$_SESSION['pelanggan']['id_pelanggan'];
                        $id_ongkir=$_POST['id_ongkir'];
                        $tanggal_pembelian= date("Y-m-d");
                        $alamat_pengiriman= $_POST['alamat_pengiriman'];

                        $ambil=$koneksi->query("SELECT * FROM ongkir WHERE id_ongkir='$id_ongkir'");
                        $arrayongkir = $ambil->fetch_assoc();
                        $nama_kota=$arrayongkir['nama_kota'];
                        $tarif=$arrayongkir['tarif'];


                        $totalpembelian=$totalbelanja + $tarif;

                        //1.menyimpan data ketable pembelian 
                        $koneksi->query("INSERT INTO pembelian (
                            id_pelanggan,id_ongkir,tanggal_pembelian,total_pembelian,nama_kota,tarif,alamat_pengiriman
                        )VALUES ('$id_pelanggan','$id_ongkir','$tanggal_pembelian','$totalpembelian','$nama_kota','$tarif','$alamat_pengiriman')");

                        //2. mendapatkan id pembelian barusan terjadi
                        $id_pembelian_barusan=$koneksi->insert_id;

                        foreach($_SESSION['keranjang']as $id_produk=> $jumlah){
                            // mendapat data produk berdasarkan id_produk
                            $ambil=$koneksi->query("SELECT*FROM produk WHERE id_produk='$id_produk'");   
                            $perproduk=$ambil->fetch_assoc();

                            $nama=$perproduk['nama_produk'];
                            $harga=$perproduk['harga_produk'];
                            $berat=$perproduk['berat_produk'];

                            $subberat=$perproduk['berat_produk']*$jumlah;
                            $subharga=$perproduk['harga_produk']*$jumlah;

                            $koneksi->query("INSERT INTO pembelian_produk(id_pembeli,id_produk,nama,harga,berat,subharga,subberat,jumlah)
                            VALUES ('$id_pembelian_barusan','$id_produk','$nama','$harga','$berat','$subharga','$subberat','$jumlah')");

                            //mengkosongkan keranjang belanja
                            unset($_SESSION['keranjang']);






                            //tampilan dialihkan ke pemnelian ke nota, nota dari pemberian barusan
                            echo "<script>alert('pembelian sukses');</script>";
                            echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";


                        }
                        }

                    ?>

                    
        </div>
    </section>


</body>
</html>