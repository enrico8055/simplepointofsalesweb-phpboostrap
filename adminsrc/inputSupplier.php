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


    <div class="container">
      <?php
        if(isset($_POST['insert']) && $_POST['insert'] == "Yes"){
          $ID = time();
          $query = $conn->query("INSERT INTO supplier(idsupplier, namasupplier, notelp, alamat) VALUES(".$ID.",'".$_POST['namasupplier']."',".$_POST['notelp'].",'".$_POST['alamat']."')");
          if($query){
            header("Location: ./status.php?s=inputSupplier");
          }else{
            echo("<div class=\"alert alert-danger\" role=\"alert\">Supplier Gagal Ditambahkan!Pastikan Nama Supplier Belum Pernah Ada!</div>");
          }
        }
      ?>
      <h2 class="mt-3">Input Supplier</h2>
      <form method="post" onsubmit="return confirm('Do you really want insert this supplier?');">
        <label for="inputPassword5" class="form-label mt-4">Nama Supplier</label>
        <input type="text" id="namabarang" class="form-control" aria-describedby="passwordHelpBlock" name="namasupplier" required>

        
        <label for="inputPassword5" class="form-label mt-4">Nomor HP Supplier</label>
        <input type="number" id="hrgBarang" class="form-control" aria-describedby="passwordHelpBlock" name="notelp" required>
        
        <label for="inputPassword5" class="form-label mt-4">Alamat Supplier</label>
        <input type="text" id="linkgbr" class="form-control" aria-describedby="passwordHelpBlock" name="alamat" required>

        <button class="btn btn-success mt-4 mb-5 " id="insert" name="insert" value="Yes">Insert</button>
      </form>
    </div>
    
    <script>
      $(document).ready(function(){
        window.history.forward();
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 4000);  
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>

