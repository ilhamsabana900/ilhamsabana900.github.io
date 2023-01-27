<?php
session_start();
include 'koneksi.php';



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan</title>
    <link rel="stylesheet" href="admin2/css/bootstrap.css">
</head>
<body>

<?php include 'menu.php';  ?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Login Pelanggan</h3>
                </div>
                <div class="panel-body">
                    <form method="post">
                       <div class="form-group">
                        <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                       </div>
                       <div class="form-group">
                        <label for="pass">Password</label>
                            <input type="password" class="form-control" name="pass" id="pass">
                       </div>
                       <button class="btn btn-primary" name="login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php


//jika tombol login ditekan
if(isset($_POST['login']))
{
    $email= $_POST["email"];
    $password= $_POST["pass"];
//lakukan query ngecek akun di table pelanggan di db
    $ambil=$koneksi->query("SELECT * FROM pelanggan 
    WHERE email_pelanggan='$email' AND password_pelanggan='$password'");

//ngitung akun yang terambil
    $akunyangcocok=$ambil->num_rows;
//jk 1 akun yang cocok maka login
if($akunyangcocok==1)

{
    //anda sukses login
    //medapatkan akundalam bentuk array
        $akun=$ambil->fetch_assoc();

    //simpan session pelanggan
        $_SESSION["pelanggan"] = $akun;
        echo "<script>alert('anda sukses login, terima kasih');</script>";

        //jika sudah belanja
        if(isset($_SESSION['keranjang']) OR !empty($_SESSION['keranjang'])){
            
            echo "<script>location= 'checkout.php';</script>";
        }else{
            echo "<script>location= 'riwayat.php';</script>";
        }
        

}else{

    //anda gagal login
        echo "<script>alert('anda gagal login, periksa akun anda');</script>";
        echo "<script>location= 'login.php';</script>";
}

}




?>
</body>
</html>