<?php
  session_start();
  include_once("../inc/koneksi.php");


  if(isset($_POST['query']) && $_POST['query'] != null){
    // ambil data transaksi
    $query = $conn->query("SELECT *
                              FROM barang
                                  INNER JOIN supplier ON barang.idsupplier=supplier.idsupplier where barang.namabarang like '%".$_POST['query']."%' order by namabarang asc limit 20");

  }else{
    // ambil data transaksi
    $query = $conn->query("SELECT *
                              FROM barang
                                  INNER JOIN supplier ON barang.idsupplier=supplier.idsupplier;");
  }

  $barang = array();
  while($row = $query -> fetch_assoc()){ 
      array_push($barang, array(
          'idbarang' => $row['idbarang'],
          'idsupplier' => $row['idsupplier'],
          'namabarang' => $row['namabarang'],
          'hargabarang' => $row['hargabarang'],
          'gambar' => $row['gambar'],
          'namasupplier' => $row['namasupplier'],
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
              <a class="navbar-brand" href="../index.php" style="font-family:Pacifico;">
                  <img src="../img/logo.png" alt="" width="30" height="35" class="d-inline-block  align-text-top me-3">NECTARINE
              </a>
            </div>
            <div class="col">
            </div>
            <div class="col">
              <form class="d-flex " method="post">
                <input class="form-control me-2 rounded-pill" type="text" aria-label="Search" placeholder="Cari Berdasar Nama Barang" name="query">
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
          $query = $conn->query("DELETE FROM barang WHERE idbarang = ".explode("$",$_POST['del'])[0]);
          unlink(explode("$",$_POST['del'])[1]); //hapus file gambar dalam folder
          if($query){
            header("Location: ./status.php?s=barang");
          }else{
            echo("<div class=\"alert alert-danger\" id=\"status\" role=\"alert\">Barang Gagal Dihapus! (Barang Yang Sudah Memliki Transaksi/Stok Tidak Dapat Dihapus)!</div>");
          }
        }
      ?>
        <div class="container">
        <h2 class="mt-3"> List Barang</h2>
        <?php
          if(count($barang) < 1){
            echo("<div class=\"alert alert-danger\" role=\"alert\">Data Barang Tidak Ditemukan!</div>");
          }
        ?>
        <ul class="list-group mt-5">
          <?php
            for($i = 0; $i<count($barang); $i++){
          ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <ul class="list-group">
                  <p class="h6"><?php echo("Nama Barang : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$barang[$i]['namabarang']."<br>"); ?>
                  <p class="h6"><?php echo("Harga Jual Per Barang : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rp. ".$barang[$i]['hargabarang']."<br>"); ?>
                  <p class="h6"><?php echo("Id Barang : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$barang[$i]['idbarang']."<br>"); ?>
                  <p class="h6"><?php echo("Id Supplier : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$barang[$i]['idsupplier']."<br>"); ?>
                  <p class="h6"><?php echo("Nama Supplier : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$barang[$i]['namasupplier']."<br>"); ?>
                  <p class="h6"><?php echo("Stok : "."<br>"); ?></p>
                  <?php 
                    $masuk = $conn->query("SELECT SUM(jumlahbarang) AS jmlmas FROM rincibarangmasuk WHERE idbarang=".$barang[$i]['idbarang']);
                    $keluar = $conn->query("SELECT SUM(jumlahbarang) AS jmlkel FROM rincitransaksi WHERE idbarang=".$barang[$i]['idbarang']);
                    $sisastok = $masuk->fetch_assoc()['jmlmas'] - $keluar->fetch_assoc()['jmlkel'];
                    echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$sisastok." Buah<br>"); 
                  ?>
                </ul>
                <ul class="list-group align-items-center">
                  <form method="post" action="./editBarang.php" onsubmit="return confirm('Yakin ingin edit barang ini?');" class="">
                    <div>
                      <button class="btn btn-secondary btn-sm" type="submit" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover" name="edit" value="<?php echo($barang[$i]['idbarang']."$".$barang[$i]['namabarang']."$".$barang[$i]['hargabarang'])?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      </svg></div>

                  </form>

                  <form method="post" onsubmit="return confirm('Yakin ingin cetak barcode barang ini?');" class="mt-2" action="./cetakBarcode.php">
                    <div>
                      <button class="btn btn-warning btn-sm" type="submit" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover" name="cetak" value="<?php echo($barang[$i]['idbarang']."$".$barang[$i]['namabarang'])?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sticky" viewBox="0 0 16 16">
                        <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5v11A1.5 1.5 0 0 0 2.5 15h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 15 8.586V2.5A1.5 1.5 0 0 0 13.5 1h-11zM2 2.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V8H9.5A1.5 1.5 0 0 0 8 9.5V14H2.5a.5.5 0 0 1-.5-.5v-11zm7 11.293V9.5a.5.5 0 0 1 .5-.5h4.293L9 13.793z"/>
                      </svg></div>

                  </form>

                  <form method="post" onsubmit="return confirm('Yakin ingin hapus barang ini?');" class="mt-4">
                    <div>
                      <button class="btn btn-danger btn-sm" type="submit" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover" name="del" value="<?php echo($barang[$i]['idbarang']."$".$barang[$i]['gambar'])?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash-fill" viewBox="0 0 16 16">
                          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg></div>

                  </form>

                  
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
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>



