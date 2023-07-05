<?php
  session_start();
  include_once("../inc/koneksi.php");

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
    <nav class="navbar navbar-expand-md navbar-light bg-light">
      <div class="container text-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNavDropdown">
          <div class="navbar-nav" id="navbarNav">
          <ul class="navbar-nav">
              <li class="nav-item">
              <a class="nav-link active" href="./transaksi.php">ListTransaksi</a>
              </li>
              <li class="nav-item">
              <a class="nav-link active" href="./barangmasuk.php">ListBarangMasuk</a>
              </li>
              <li class="nav-item">
              <a class="nav-link active" href="./barang.php">ListBarang</a>
              </li>
              <li class="nav-item">
              <a class="nav-link active" href="./supplier.php">ListSupplier</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="./inputBarangMasuk.php">InputBarangMasuk</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="./inputBarang.php">InputBarang</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="./inputSupplier.php">InputSupplier</a>
              </li>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="./analisa.php">Rangkuman</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>


  <div class="container">
    <h2 class="mt-3">Rangkuman Data</h2>
    <form class="mt-5" method="post">
      <div class="row">
        <div class="col-5 d-flex justify-content-center my-auto">
            <h6>Dari:</h6>
        </div>
        <div class="col-5 d-flex justify-content-center my-auto">
          <h6>Sampai:</h6>
        </div>
        <div class="col-2 d-flex justify-content-center my-auto">
        </div>
      <div class="row">
        <div class="col-5 d-flex justify-content-center my-auto">
            <input class="form-control me-2 rounded-pill" type="date" aria-label="Search"  name="dari" required>
        </div>
        <div class="col-5 d-flex justify-content-center my-auto">
            <input class="form-control me-2 rounded-pill" type="date" aria-label="Search"  name="sampai" required>
        </div>
        <div class="col-2 d-flex justify-content-center my-auto">
            <div>
              <button class="btn btn-danger btn-sm" type="submit" name="query" value="query">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
            </div>
        </div>
      </div>
      
    </form>

    <?php
      if(isset($_POST['query']) && $_POST['query'] != null){
        $totalmasuk = $conn->query("SELECT 
                                  SUM(rincibarangmasuk.jumlahbarang) AS totalbarangmasuk, 
                                  SUM(rincibarangmasuk.hargamasuk*rincibarangmasuk.jumlahbarang) AS totaluangkeluar
                                FROM barangmasuk
                                INNER JOIN rincibarangmasuk ON barangmasuk.idmasuk=rincibarangmasuk.idmasuk
                                where barangmasuk.tanggalmasuk BETWEEN '".date("Y-m-d",strtotime(str_replace('/','-',$_POST['dari'])))."' AND '".date("Y-m-d",strtotime(str_replace('/','-',$_POST['sampai'])))."'");
        $totalkeluar = $conn->query("SELECT 
                                  SUM(rincitransaksi.jumlahbarang) AS totalbarangkeluar, 
                                  SUM(rincitransaksi.hargabarang*rincitransaksi.jumlahbarang) AS totaluangmasuk
                                FROM transaksi
                                INNER JOIN rincitransaksi ON transaksi.idtransaksi=rincitransaksi.idtransaksi
                                WHERE transaksi.tanggal BETWEEN '".date("Y-m-d",strtotime(str_replace('/','-',$_POST['dari'])))."' AND '".date("Y-m-d",strtotime(str_replace('/','-',$_POST['sampai'])))."';");
        $masukperbarang = $conn->query("SELECT 
                                  barang.namabarang AS namabarang, 
                                  SUM(rincibarangmasuk.jumlahbarang) AS jumlahbarang
                                FROM barangmasuk
                                INNER JOIN rincibarangmasuk ON barangmasuk.idmasuk=rincibarangmasuk.idmasuk
                                INNER JOIN barang ON barang.idbarang=rincibarangmasuk.idbarang
                                WHERE barangmasuk.tanggalmasuk BETWEEN '".date("Y-m-d",strtotime(str_replace('/','-',$_POST['dari'])))."' AND '".date("Y-m-d",strtotime(str_replace('/','-',$_POST['sampai'])))."'
                                GROUP BY barang.namabarang
                                ;");
        $keluarperbarang = $conn->query("SELECT 
                                  barang.namabarang AS namabarang, 
                                  SUM(rincitransaksi.jumlahbarang) AS jumlahbarang
                                FROM transaksi
                                INNER JOIN rincitransaksi ON transaksi.idtransaksi=rincitransaksi.idtransaksi
                                INNER JOIN barang ON barang.idbarang=rincitransaksi.idbarang
                                WHERE transaksi.tanggal BETWEEN '".date("Y-m-d",strtotime(str_replace('/','-',$_POST['dari'])))."' AND '".date("Y-m-d",strtotime(str_replace('/','-',$_POST['sampai'])))."'
                                GROUP BY barang.namabarang
                                ;");

        $totalmasuk = $totalmasuk->fetch_assoc();
        $totalkeluar = $totalkeluar->fetch_assoc();
        $mperbarang = array();
        while($row = $masukperbarang -> fetch_assoc()){ 
            array_push($mperbarang, array(
                'namabarang' => $row['namabarang'],
                'jumlahbarang' => $row['jumlahbarang']
            ));
        }
        $kperbarang = array();
        while($row = $keluarperbarang -> fetch_assoc()){ 
            array_push($kperbarang, array(
                'namabarang' => $row['namabarang'],
                'jumlahbarang' => $row['jumlahbarang']
            ));
        }

        if(count($mperbarang) >0 &&  count($kperbarang) >0){
    ?>
            <h4 class="mt-5">Selama <?php echo(date("Y-m-d",strtotime(str_replace('/','-',$_POST['dari'])))) ?> Sampai <?php echo(date("Y-m-d",strtotime(str_replace('/','-',$_POST['sampai'])))) ?></h4>
            <hr>

            <h6 class="mt-3">Total Uang Keluar :</h6>
            <p><?php echo("Rp. ".$totalmasuk['totaluangkeluar']) ?></p>
            <h6>Total Barang Masuk :</h6>
            <p><?php echo($totalmasuk['totalbarangmasuk']." Barang") ?></p>
            <h6>Rinci Barang Masuk :</h6>
            <ul>
            <?php
              for($j=0; $j<count($mperbarang); $j++){
            ?>
                <li>
                  <p><?php echo($mperbarang[$j]['namabarang']." ".$mperbarang[$j]['jumlahbarang']." Item") ?></p>
                </li>
            <?php
              }
            ?>

            <hr>

            </ul>
            <h6>Total Uang Masuk :</h6>
            <p><?php echo("Rp. ".$totalkeluar['totaluangmasuk']) ?></p>
            <h6>Total Barang Keluar :</h6>
            <p><?php echo($totalkeluar['totalbarangkeluar']." Barang") ?></p>
            <h6>Rinci Barang Masuk :</h6>
            <ul>
            <?php
              for($j=0; $j<count($kperbarang); $j++){
            ?>
                <li>
                  <p><?php echo($kperbarang[$j]['namabarang']." ".$kperbarang[$j]['jumlahbarang']." Item") ?></p>
                </li>
            <?php
              }
            ?>

    <?php
      }else{
        echo("<div class=\"alert mt-4 alert-danger\" role=\"alert\">Data  Tidak Ditemukan! ...</div>");
      }
      }
    ?>

  </div>




    
    
    <script>
      $(document).ready(function(){
        window.history.forward();
        $('#myModal').on('shown.bs.modal', function () {
          $('#myInput').trigger('focus')
        })
        window.setTimeout(function() {
            $("#status").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 4000);  
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>



