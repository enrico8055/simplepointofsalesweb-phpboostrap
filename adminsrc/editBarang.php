<?php
  session_start();
  include_once("../inc/koneksi.php");
  
  ini_set('file_uploads', 'On');
  

  if(isset($_POST['e']) && $_POST['e'] == "Yes"){
          $query = $conn->query("UPDATE barang SET hargabarang = ".$_POST['hrgbarang']." WHERE idbarang = ".$_POST['idbarang']);
          if($query){
            header("Location: ./status.php?s=barang");
          }else{
            header("Location: ./barang.php");
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

  <body>
    <!-- NAVBAR 1 -->
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container d-flex justify-content-between">
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
              <a class="nav-link" href="./transaksi.php">ListTransaksi</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="./barangmasuk.php">ListBarangMasuk</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="./barang.php">ListBarang</a>
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
            </ul>
          </div>
        </div>
    </nav>


    <div class="container">
      <h2 class="mt-3">Edit Barang</h2>
      <form method="post" onsubmit="return confirm('Do you really want insert this item?');" enctype="multipart/form-data">
        <label for="inputPassword5" class="form-label mt-4">Nama Barang</label>
        <input type="text" id="namabarang" class="form-control" aria-describedby="passwordHelpBlock" name="namabarang" value="<?php echo(explode("$",$_POST['edit'])[1]); ?>" disabled>

        <label for="inputPassword5" class="form-label mt-4">ID Barang</label>
        <input type="text" id="namabarang" class="form-control" aria-describedby="passwordHelpBlock" name="idbarang" value="<?php echo(explode("$",$_POST['edit'])[0]); ?>" disabled>
        <input type="hidden" id="namabarang" class="form-control" aria-describedby="passwordHelpBlock" name="idbarang" value="<?php echo(explode("$",$_POST['edit'])[0]); ?>"d>

        
        <label for="inputPassword5" class="form-label mt-4">Ubah Harga Jual Dari Rp. <?php echo(explode("$",$_POST['edit'])[2]); ?> Per Barang Menjadi:</label>
        <input type="number" id="hrgBarang" class="form-control" aria-describedby="passwordHelpBlock" name="hrgbarang" required>
        
        <button class="btn btn-success mt-4 mb-5 " id="edit" name="e" value="Yes">Edit</button>
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

