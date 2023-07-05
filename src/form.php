<?php
  session_start();
  include_once("../inc/koneksi.php");
  if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == null){
    header("Location: ./kategori.php");
  }
  if(isset($_POST['del'])){
    unset($_SESSION['cart'][$_POST['del']]);
    if($_SESSION['cart'] == null){
      header("Location: ./kategori.php");
    }
  }

  if(isset($_POST['additembyid'])){
    $lbrg = $conn->query("SELECT * from barang where idbarang = ".$_POST['idbrg']);
    $brg = $lbrg -> fetch_assoc();
    if($brg != null){
      if(!array_key_exists($brg['namabarang'] ,$_SESSION['cart'])){
        $_SESSION['cart'][$brg['namabarang']] = array((int)$_POST['jmlhbrg'],(float)$brg['hargabarang'], (int)$_POST['idbrg']);
      }else{
        $_SESSION['cart'][$brg['namabarang']][0] = $_SESSION['cart'][$brg['namabarang']][0] + (int)$_POST['jmlhbrg'];
      }
    }else{
      echo("<script>alert('Id Barang Tidak Ditemukan!');</script>");
    }
  }
  if(isset($_POST['form'])){
    $TID = time();
    $cancel = 0;
    foreach($_SESSION['cart'] as $name => $data){ //cek apakah stok tersedia?
      $masuk = $conn->query("SELECT SUM(jumlahbarang) AS jmlmas FROM rincibarangmasuk WHERE idbarang=".$data[2]);
      $keluar = $conn->query("SELECT SUM(jumlahbarang) AS jmlkel FROM rincitransaksi WHERE idbarang=".$data[2]);
      $sisastok = $masuk->fetch_assoc()['jmlmas'] - $keluar->fetch_assoc()['jmlkel'];
      if(($sisastok - $data[0]) < 0){
        $cancel = 1;
      };
    }
    if($cancel != 1){
      if(isset($_POST['isOld']) && $_POST['isOld'] == "yes"){ //kalo pelanggan yang sudah pernah ada
        $query = $conn->query("INSERT INTO transaksi(idtransaksi, tanggal, idpelanggan) VALUES(".$TID.",'".date("Y-m-d")."',".$_POST['idpelanggan'].")");
        $pelanggan = $conn->query("SELECT * from pelanggan where idpelanggan = ".$_POST['idpelanggan']);
        $pelanggan = $pelanggan -> fetch_assoc();
        $_SESSION['namapelanggan'] = $pelanggan['namapelanggan'];
        $_SESSION['idtransaksi'] = $TID;
        $_SESSION['nomorpelanggan'] = $pelanggan['nomorpelanggan'];
        $_SESSION['alamatpelanggan'] = $pelanggan['alamatpelanggan'];
      }else{ //untuk pelanggan baru
        $q = $conn->query("INSERT INTO pelanggan(idpelanggan, namapelanggan, alamatpelanggan, nomorpelanggan) VALUES(".$TID.",'".$_POST['namapelanggan']."','".$_POST['alamatpelanggan']."','".$_POST['nomorpelanggan']."')");
        $query = $conn->query("INSERT INTO transaksi(idtransaksi, tanggal, idpelanggan) VALUES(".$TID.",'".date("Y-m-d")."',".$TID.")");
        $_SESSION['namapelanggan'] = $_POST['namapelanggan'];
        $_SESSION['idtransaksi'] = $TID;
        $_SESSION['alamatpelanggan'] = $_POST['alamatpelanggan'];
        $_SESSION['nomorpelanggan'] = $_POST['nomorpelanggan'];
      }
      if($query){
        foreach($_SESSION['cart'] as $name => $data){
            $query = $conn->query("INSERT INTO rincitransaksi(idtransaksi, idbarang, jumlahbarang, hargabarang) VALUES(".$TID.",".$data[2].",".$data[0].",".$data[1].")");
        }
        header("Location: ./cetakNota.php");
      }else{
        echo("<script>alert('Server Failed! Please Re Input!');</script>");
      }
    }else{
      echo("<script>alert('Transaksi Gagal ! Beberapa Stok Barang Habis!');</script>");
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>NECTARINE</title>
  </head>
  <style>
  @media only screen and (max-width: 600px) {
    #c {
      max-width: 150px;
    };
  }
  @media only screen and (max-width: 600px) {
    #i {
      height: 140px;
    };
  }
  @media only screen and (min-width: 600px) {
    #i {
      height: 220px;
    };
  }
  @media only screen and (min-width: 600px) {
    #c {
      max-width: 250px;
    }
  }
  </style>
  <body>
    <!-- NAVBAR 1 -->
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container d-flex justify-content-center">
          <div class="row container-fluid">
            <div class="col">
              <a class="navbar-brand" href="../index.php" style="font-family:Pacifico;">
                  <img src="../img/logo.png" alt="" width="30" height="35" class="d-inline-block  align-text-top me-3">NECTARINE
              </a>
            </div>
        </div>
    </nav>

    <!-- NAVBAR 2 -->
    <nav class="navbar navbar-expand navbar-light bg-light">
      <div class="container text-center">
        <div class="mx-auto">
          <div class="" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
              <a class="nav-link" href="./kategori.php">Back to Store</a>
              </li>
              <li class="nav-item">
                <form class="d-flex" method="post">
                  <input class="form-control me-2 rounded" type="number" placeholder="Jumlah Barang" aria-label="Search" name="jmlhbrg" required>
                  <input class="form-control me-2 rounded" type="number" placeholder="ID Barang" aria-label="Search" name="idbrg" required>
                  <button class="btn-sm btn-success" type="submit" name="additembyid">Add</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
    </nav>





    <!-- List Cart -->
    <div class="container mt-3 mb-5">
      <div class="container">
      <div class="container">
      <div class="container">
      <div class="container">
      <div class="container">
        <div class="container text-center">
        <h2> List Cart</h2>
        <ul class="list-group mt-5">
          <?php
            $totalHarga = 0;
            foreach($_SESSION['cart'] as $name => $data){
              $totalHarga += $data[0] * $data[1];
          ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo($data[0]."x ".$name." @ Rp. ".$data[1]); ?>
                  <form method="post" onsubmit="return confirm('Do you really want delete this item?');">
                    <button class="btn btn-primary btn-sm" type="submit" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover" name="del" value="<?php echo($name)?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                      </svg>
                </form>
              </li>
          <?php
            }
          ?>
        </ul>
    </div>
    </div>
    </div>
  </div>
</div>

    
  <div class="container mt-5">
  <h4>Total Price : <?php echo "Rp. ".$totalHarga?></h4>
      
  </div>




  <!-- Form -->
  <div class="container mt-5" id="tes">
    
    <h2 class="mt-5"> Customer</h2>
    <form class="mt-3" method="post" onsubmit="return confirm('Yakin ingin checkout? Pastikan Data Sudah Benar!');" id="formpelanggan">
    <label for="inputPassword5" class="form-label mt-3">Return Customer?</label>
        <div></div>
        <input class="form-check-input" type="checkbox" value="yes" id="isOldCustomer" name="isOld">

    <div id=olcustomer>
      <label for="inputPassword5" class="form-label mt-4">Customer:</label>
      <?php
        $query = $conn->query("SELECT * FROM pelanggan");
        $pelanggan = array();
        while($row = $query -> fetch_assoc()){ 
            array_push($pelanggan, array(
                'idpelanggan' => $row['idpelanggan'],
                'namapelanggan' => $row['namapelanggan'],
                'alamatpelanggan' => $row['alamatpelanggan'],
                'nomorpelanggan' => $row['nomorpelanggan']
            ));
        };
        if(count($pelanggan)<1){
          echo("<div class=\"alert alert-danger\" id=\"nodata\" role=\"alert\">Data Pelanggan Tidak Ditemukan!</div>");
        }else{
      ?>
      <select class="form-select" aria-label="Default select example" name="idpelanggan" id="idpelanggan">
        <?php
          for($i = 0; $i < count($pelanggan);$i++){
        ?>
            <option value="<?php echo $pelanggan[$i]['idpelanggan']?>"><?php echo $pelanggan[$i]['namapelanggan']." >> ".$pelanggan[$i]['alamatpelanggan']?></option>
        <?php
          }
        ?>
      </select>
      <?php
          }
      ?>
    </div>

      <div id="frm">
      <div class="form-group row mt-1" >
        <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="nama" name="namapelanggan" placeholder="Name" required>
        </div>
      </div>
      <div class="form-group row mt-1">
        <label for="staticEmail" class="col-sm-2 col-form-label">Address</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="alamat" name="alamatpelanggan" placeholder="Address" required>
        </div>
      </div>
      <div class="form-group row mt-1">
        <label for="staticEmail" class="col-sm-2 col-form-label">Phone Number</label>
        <div class="col-sm-10">
        <input type="number" class="form-control" id="nohp" name="nomorpelanggan" placeholder="PhoneNumber" required>
        </div>
      </div>
    </div>
      <p class="text-danger mt-5">*10 menit setelah transaksi tercatat, transaksi tidak dapat di hapus! Pastikan Data Benar!</p>
      
      <button type="submit" id="btnsub" name="form" value="ok" class="btn btn-success" >Checkout</button>
    </form>
    <button class="btn btn-danger mt-3"><a href="./kategori.php?done=1" style="text-decoration: none; color:white">Cancel</a></button>
  </div>
    
  <script>
      $(document).ready(function(){
        window.history.forward();
        var $input = $("#isOldCustomer");
        if (!$input.prop('checked')) {$("#olcustomer").hide();};
        $( "#isOldCustomer" ).click(function() {
          if ($input.prop('checked')) {
            $("#olcustomer").show();$("#nama").attr('disabled','disabled');$("#alamat").attr('disabled','disabled');$("#nohp").attr('disabled','disabled');$("#frm").hide();
            if($('#nodata').length){
              $('#btnsub').hide();
            }
          }
          else {
            $("#olcustomer").hide();$("#nama").removeAttr('disabled');$("#alamat").removeAttr('disabled');$("#nohp").removeAttr('disabled');$("#frm").show();
            if($('#nodata').length){
              $('#btnsub').show();
            }
          };
        });
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>



