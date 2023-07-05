<?php
  session_start();
  include_once("../inc/koneksi.php");


  if(isset($_POST['query']) && $_POST['query'] != null){
    // ambil data transaksi
    $query = $conn->query("SELECT 	 pelanggan.namapelanggan, 
                                pelanggan.alamatpelanggan,
                                transaksi.tanggal AS tanggaltransaksi,
                                pelanggan.idpelanggan,
                                transaksi.idtransaksi,
                                pelanggan.nomorpelanggan,
                                SUM(rincitransaksi.hargabarang * rincitransaksi.jumlahbarang) AS total, transaksi.tanggal
                                FROM transaksi
                                INNER JOIN rincitransaksi ON transaksi.idtransaksi=rincitransaksi.idtransaksi
                                INNER JOIN pelanggan ON transaksi.idpelanggan=pelanggan.idpelanggan
                                INNER JOIN barang ON rincitransaksi.idbarang=barang.idbarang where transaksi.tanggal = '".date("Y-m-d",strtotime(str_replace('/','-',$_POST['query'])))."' GROUP BY transaksi.idtransaksi order by transaksi.idtransaksi desc limit 50;");

  }else if(isset($_POST['queryid']) && $_POST['queryid'] != null){
    $query = $conn->query("SELECT 	 pelanggan.namapelanggan, 
                                pelanggan.alamatpelanggan,
                                transaksi.tanggal AS tanggaltransaksi,
                                pelanggan.idpelanggan,
                                transaksi.idtransaksi,
                                pelanggan.nomorpelanggan,
                                SUM(rincitransaksi.hargabarang * rincitransaksi.jumlahbarang) AS total, transaksi.tanggal
                                FROM transaksi
                                INNER JOIN rincitransaksi ON transaksi.idtransaksi=rincitransaksi.idtransaksi
                                INNER JOIN pelanggan ON transaksi.idpelanggan=pelanggan.idpelanggan
                                INNER JOIN barang ON rincitransaksi.idbarang=barang.idbarang where transaksi.idtransaksi = ".$_POST['queryid']." GROUP BY transaksi.idtransaksi order by transaksi.idtransaksi desc limit 50;");
  }else{
    // ambil data transaksi
    $query = $conn->query("SELECT 	 pelanggan.namapelanggan, 
                                pelanggan.alamatpelanggan,
                                transaksi.tanggal AS tanggaltransaksi,
                                pelanggan.idpelanggan,
                                transaksi.idtransaksi,
                                pelanggan.nomorpelanggan,
                                SUM(rincitransaksi.hargabarang * rincitransaksi.jumlahbarang) AS total, transaksi.tanggal
                                FROM transaksi
                                INNER JOIN rincitransaksi ON transaksi.idtransaksi=rincitransaksi.idtransaksi
                                INNER JOIN pelanggan ON transaksi.idpelanggan=pelanggan.idpelanggan
                                INNER JOIN barang ON rincitransaksi.idbarang=barang.idbarang GROUP BY transaksi.idtransaksi order by transaksi.idtransaksi desc limit 50;");
  }

  $transaksi = array();
  while($row = $query -> fetch_assoc()){ 
      array_push($transaksi, array(
          'namapelanggan' => $row['namapelanggan'],
          'alamatpelanggan' => $row['alamatpelanggan'],
          'tanggaltransaksi' => $row['tanggaltransaksi'],
          'idpelanggan' => $row['idpelanggan'],
          'idtransaksi' => $row['idtransaksi'],
          'nomorpelanggan' => $row['nomorpelanggan'],
          'total' => $row['total'],
          'tanggal' => $row['tanggal'],
      ));
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
  </style>
  <body>
    
    <!-- NAVBAR 1 -->
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container d-flex justify-content-center">
          <div class="row container-fluid">
            <div class="col">
              <a class="navbar-brand " href="../index.php" style="font-family:Pacifico;">
                  <img src="../img/logo.png" alt="" width="30" height="35" class="d-inline-block  align-text-top me-3">NECTARINE
              </a>
            </div>
            <div class="col">
            </div>
            <div class="col">
              <form class="d-flex" method="post">
                <input class="form-control me-2 rounded-pill" type="date" aria-label="Search" name="query" id="querydate">
                <input class="form-control me-2 rounded-pill" type="search" aria-label="Search" placeholder="Cari Berdasar ID Transaksi" name="queryid" id="queryid">
                <button class="btn btn-success" type="submit">Search</button>
              </form>
            </div>
        </div>
    </nav>

    <!-- NAVBAR 2 -->
    <nav class="navbar navbar-expand-md navbar-light bg-light">
      <div class="container text-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
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
              <li class="nav-item">
              <a class="nav-link" href="./analisa.php">Rangkuman</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>




    





    <!-- List Cart -->
    <div class="container mt-3 mb-5">
      <?php
        //delete transaksi by id
        if(isset($_POST['del']) && $_POST['del'] != null){
          if(time() - $_POST['del'] < 600 ){
            $l = $conn->query("SELECT barang.idbarang, barang.namabarang, rincitransaksi.jumlahbarang, rincitransaksi.hargabarang as hargabarang
                                                  FROM transaksi
                                                  INNER JOIN rincitransaksi ON transaksi.idtransaksi=rincitransaksi.idtransaksi
                                                  INNER JOIN barang ON rincitransaksi.idbarang=barang.idbarang WHERE transaksi.idtransaksi = ".$_POST['del']);
            $daftarbarang = array();
            while($row = $l -> fetch_assoc()){ 
                array_push($daftarbarang, array(
                    'idbarang' => $row['idbarang'],
                    'namabarang' => $row['namabarang'],
                    'jumlahbarang' => $row['jumlahbarang'],
                    'hargabarang' => $row['hargabarang'],
                ));
            }
            $query = $conn->query("DELETE FROM transaksi WHERE idtransaksi = ".$_POST['del']);
            if($query){
              header("Location: ./status.php?s=transaksi");
            }else{
              echo("<div class=\"alert alert-danger\" id=\"status\" role=\"alert\">Transaksi Gagal Dihapus!</div>");
            }
          }else{
            echo("<div class=\"alert alert-danger\" id=\"status\" role=\"alert\">List Transaksi Gagal Dihapus! Transaksi Lebih Dari 10mnt Tidak Bisa Di Hapus!</div>");
          }
        }
      ?>
        <div class="container">
          <div class="row align-items-center">
            <div class="col">
              <h2 class=""> List Transaksi</h2>
            </div>
            <div class="col d-flex justify-content-end">
              <div class="row align-items-center">
                <div class="col d-flex justify-content-end  align-items-center">
                  Cari Berdasar ID?
                </div>
                <div class="col d-flex justify-content-start">
                  <input class="form-check-input" type="checkbox" value="yes" id="srchbyid" name="srchbyid">
                </div>
              </div>
            </div>
          </div>
        <?php
          if(count($transaksi) < 1){
            echo("<div class=\"alert alert-danger\" role=\"alert\">Data Transaksi Tidak Ditemukan! ...</div>");
          }
        ?>
        <ul class="list-group mt-5">
          <?php
            for($i = 0; $i<count($transaksi); $i++){
          ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <ul class="list-group">
                  <p class="h6"><?php echo("Id Transaksi : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$transaksi[$i]['idtransaksi']."<br>"); ?>
                  <p class="h6"><?php echo("Id Pelanggan : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$transaksi[$i]['idpelanggan']."<br>"); ?>
                  <p class="h6"><?php echo("Tanggal : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$transaksi[$i]['tanggal']."<br>"); ?>
                  <p class="h6"><?php echo("Nama Pelanggan : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$transaksi[$i]['namapelanggan']."<br>"); ?>
                  <p class="h6"><?php echo("Alamat Pelanggan : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$transaksi[$i]['alamatpelanggan']."<br>"); ?>
                  <p class="h6"><?php echo("Total : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rp. ".$transaksi[$i]['total']."<br>"); ?>
                </ul>
                <ul class="list-group align-items-center">
                  <form method="post" onsubmit="return confirm('Yakin mau cetak nota?');" action="./cetakNota.php">
                    <div>
                      <input type="hidden" name="idtransaksi" value="<?php echo($transaksi[$i]['idtransaksi']); ?>">
                      <input type="hidden" name="namapelanggan" value="<?php echo($transaksi[$i]['namapelanggan']); ?>">
                      <input type="hidden" name="nomorpelanggan" value="<?php echo($transaksi[$i]['nomorpelanggan']); ?>">
                      <input type="hidden" name="tanggal" value="<?php echo($transaksi[$i]['tanggal']); ?>">
                      <button class="btn btn-secondary btn-sm" type="submit" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover" name="del" value="<?php 
                                                    
                                                    echo($transaksi[$i]['idtransaksi']);
                                                ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                          <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                          <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>

                  </form>
                  <form method="post" onsubmit="return confirm('Yakin mau hapus transaksi ini?');" class="">
                    <div>
                      <button class="btn btn-danger btn-sm" type="submit" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover" name="del" value="<?php 
                                                    
                                                    echo($transaksi[$i]['idtransaksi']);
                                                ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash-fill" viewBox="0 0 16 16">
                          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg></div>

                  </form>
                  <p class="h6 mt-3">Detail</p>

                  <?php
                      $query = $conn->query("SELECT barang.namabarang, rincitransaksi.jumlahbarang, rincitransaksi.hargabarang as hargabarang
                                                FROM transaksi
                                                INNER JOIN rincitransaksi ON transaksi.idtransaksi=rincitransaksi.idtransaksi
                                                INNER JOIN barang ON rincitransaksi.idbarang=barang.idbarang WHERE transaksi.idtransaksi = ".$transaksi[$i]['idtransaksi']);
                      $daftarbarang = array();
                      while($row = $query -> fetch_assoc()){ 
                          array_push($daftarbarang, array(
                              'namabarang' => $row['namabarang'],
                              'jumlahbarang' => $row['jumlahbarang'],
                              'hargabarang' => $row['hargabarang'],
                          ));
                      }
                      for($j=0; $j<count($daftarbarang); $j++){
                  ?>
                          <p><?php echo($daftarbarang[$j]['jumlahbarang']."x ".$daftarbarang[$j]['namabarang']." @Rp.".$daftarbarang[$j]['hargabarang']); ?></p>
                  <?php
                      }
                  ?>
                </ul>
              
              </li>
              <br>
          <?php
            }
          ?>
        </ul>
    </div>
    </div>
    </div>
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

        var $input = $("#srchbyid");
        if (!$input.prop('checked')) {$("#queryid").hide();};
        $( "#srchbyid" ).click(function() {
          if ($input.prop('checked')) {
            $("#queryid").show();
            $("#querydate").hide();
          }
          else {
            $("#queryid").hide();
            $("#querydate").show();
          };
        });
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>



