<?php
  include_once("../inc/koneksi.php");
  session_start();
  $curl = curl_init();

  if(isset($_GET['done']) && $_GET['done'] == 1){ //kalo sudah cetak nota
    session_destroy();
    header("Location: ./kategori.php");
  }

  if(!isset($_GET['page'])){ //atur halaman kategori
    $_GET['page'] = 1;
  }

  if(isset($_POST['query']) && $_POST['query'] != null && strtolower($_POST['query']) != "all"){ //search bar
    $query = $conn->query("SELECT * FROM barang where namabarang like '%".$_POST['query']."%'");
  }else{
    $query = $conn->query("SELECT * FROM barang");
  }
  $barang = array();
  while($row = $query -> fetch_assoc()){ 
      array_push($barang, array(
          'idbarang' => $row['idbarang'],
          'namabarang' => $row['namabarang'],
          'hargabarang' => $row['hargabarang'],
          'gambar' => $row['gambar'],
          'deskripsi' => $row['deskripsi'],
      ));
  };


  if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
  }
  if(isset($_POST['cart']) && isset($_POST['quantity'])){
    if(!array_key_exists($_POST['cart'] ,$_SESSION['cart'])){
      $_SESSION['cart'][$_POST['cart']] = array((int)$_POST['quantity'],(float)$_POST['price'], (int)$_POST['idbarang']);
    }else{
      $_SESSION['cart'][$_POST['cart']][0] = $_SESSION['cart'][$_POST['cart']][0] + (int)$_POST['quantity'];
    }
  }

  $jumlahCart = 0;
  foreach($_SESSION['cart'] as $name => $x){
      $jumlahCart += $x[0];
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

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <title>Nagatomi</title>
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
  @media only screen and (min-width: 600px) {
    #btc {
      margin-top: -3px;
    }
  }
  @media only screen and (max-width: 600px) {
    #btc {
      margin-top: 2px;
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
            <div class="col">
              <form class="d-flex" method="post">
                <input class="form-control me-2 rounded-pill" type="search" placeholder="Type All For All Item" aria-label="Search" size="75" name="query">
                <button class="btn-sm btn-success" type="submit">Search</button>
              </form>
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

              </li>
              <li class="nav-item">   
                    <a class="nav-link" href="#"><?php echo $jumlahCart." Item"; ?></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link bg-warning rounded-pill text-dark <?php
                    if(count($_SESSION['cart']) != 0){
                      echo "d-block";
                    }else{
                      echo "d-none";
                    }
                  ?>" href="./form.php" >CheckOut</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>

    <!-- CARD -->
    <div class="container">
      <div class=" row mt-3" id="card">
      <?php
        if(count($barang) < 1){
          echo ("<div class=\"alert alert-danger\" role=\"alert\" id=\"noitem\">No Items Found!</div>");
        }
        if(isset($_GET['page'])){
          $start = ($_GET['page']-1)*12;
        }else{
          $start = 1;
        }
        $end = $start + 12;
        for($i = $start; $i < $end;$i++){
          if(isset($barang[$i]) ){
            $masuk = $conn->query("SELECT SUM(jumlahbarang) AS jmlmas FROM rincibarangmasuk WHERE idbarang=".$barang[$i]['idbarang']);
            $keluar = $conn->query("SELECT SUM(jumlahbarang) AS jmlkel FROM rincitransaksi WHERE idbarang=".$barang[$i]['idbarang']);
            $sisastok = $masuk->fetch_assoc()['jmlmas'] - $keluar->fetch_assoc()['jmlkel'];
            if($sisastok < 1){
              continue;
            }
      ?>
            <div class="col text-center "  >
              <div class="card text-dark mb-3 shadow mt-3 mx-auto"  id="c" data-toggle="tooltip" data-placement="bottom" title="<?php echo $barang[$i]['deskripsi'] ?>" data-aos="<?php if($i % 2 != 0){echo "fade-left";}else{echo "fade-right";}?>" data-aos-duration="1500">
                <img src="../img/<?php echo $barang[$i]['gambar'] ?>" class="card-img-top" alt="Image Not Available..." id="i">
                <div class="card-body">
                  <h5 class="card-title text-truncate"><?php echo $barang[$i]['namabarang'] ?></h5>
                  <p class="card-text text-truncate"><?php 
                  
                  echo "Rp. ".$barang[$i]['hargabarang']." Remaining ".$sisastok." Items"; 
                  ?> 
                    <form method="post">
                      <input  type="number" step="1" min="1" max="<?php echo $sisastok ?>" name="quantity" value="1" title="Qty" class="input-text qty text" size="50" pattern="" inputmode="">
                      <input type="hidden" name="price" value="<?php echo $barang[$i]['hargabarang'] ?>">
                      <input type="hidden" name="idbarang" value="<?php echo $barang[$i]['idbarang'] ?>">
                      <button  class="btn btn-primary btn-sm" type="submit" name="cart" value="<?php echo $barang[$i]['namabarang'] ?>" id="btc">
                        add to cart
                      </button>
                    </form>
                  </p>
                </div>
              </div>
            </div>
      <?php
          }else{
            continue;
          }
        }
      ?>    
    </div>
    
    <!-- PAGINATION -->
    <div class="container mx-auto mt-5" id="pagination" data-aos="flip-left" data-aos-duration="1000">
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <a class="page-link" href="./kategori.php?page=<?php 
                if(isset($_GET['page']) && $_GET['page'] != 1){
                  echo $_GET['page']-1;
                }else{
                  echo "1";
                }
              ?>" tabindex="-1">Previous</a>
            </li>
            <?php
              for($j = 0; $j < count($barang)/12;$j++){
            ?>
                <li class="page-item">
                  <a class="page-link" href="./kategori.php?page=<?php echo $j+1;?>"><?php echo $j+1;?></a>
                </li>
            <?php
              }
            ?>
          </ul>
    </div>
    <script>
      $(document).ready(function(){
        if ( $( "#noitem" ).length > 0) {
            $( "#pagination" ).hide();
        }
      });
    </script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>

