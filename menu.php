     <!-- navbar -->
     <nav class="navbar navbar-defaut">
        <div class="container">
        <ul class="nav navbar-nav">
            <li><a href="index.php">home</a></li>
            <li><a href="keranjang.php">keranjang</a></li>
            <!-- jika sudah (ada session pelanggan)  -->
            <?php if(isset($_SESSION["pelanggan"])): ?>

                <li><a href="logout.php">logout</a></li>

            <?php else: ?>
                 <li><a href="login.php">login</a></li>
                 
            <?php endif; ?>
            <!-- selain itu(belm login) brarti belm ada session pelanggan -->
            <li><a href="riwayat.php">Riwayat belanja</a></li>
           <li><a href="daftar.php">daftar</a></li>
            <li><a href="checkout.php">checkout</a></li>
        </ul>
       </div>
    </nav>