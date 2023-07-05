<?php
  session_start();
  include_once("../inc/koneksi.php");
  
  if(!isset($_SESSION['inputcart'])){
    $_SESSION['inputcart'] = array();
  }

  if(isset($_POST['del']) && $_POST['del'] != null){
    unset($_SESSION['inputcart'][$_POST['del']]);
    if($_SESSION['cart'] == null){
      header("Location: ./inputBarangMasuk.php");
    }
  }

  if(isset($_POST['insert']) && $_POST['insert'] == "Yes"){
    if(count($_SESSION['inputcart'])>0){
      $TID = time();
      $query = $conn->query("INSERT INTO barangmasuk(idmasuk, tanggalmasuk) VALUES(".$TID.",'".date("Y-m-d")."')");
      if($query){
        foreach($_SESSION['inputcart'] as $name => $data){
          $query = $conn->query("INSERT INTO rincibarangmasuk(idmasuk, idbarang, jumlahbarang, hargamasuk) VALUES(".$TID.",".$data[2].",".$data[0].",".(int)$data[1].")");
        }
        if($query){
          header("Location: ./cetakBarcodeInputBarang.php");
        }else{
          echo("<script>alert('Stok Gagal Ditambahkan! Coba Lagi!');</script>");
        }
      }else{
        echo("<script>alert('Stok Gagal Ditambahkan! Coba Lagi!');</script>");
      }
    }else{
        echo("<script>alert('Stok Gagal Ditambahkan Karena Keranjang Kosong! Coba Lagi!');</script>");
    }
  }


  if(isset($_POST['inputcart']) && $_POST['inputcart'] == "yes"){
    $x = explode("$", $_POST['idbarang']);
    if(!array_key_exists($x[0] ,$_SESSION['inputcart'])){
      $_SESSION['inputcart'][$x[0]] = array((int)$_POST['jmlbarang'],(float)$_POST['hrgbarang'], (int)$x[1]);
      header("Location: ./inputBarangMasuk.php");
    }else{
      $_SESSION['inputcart'][$x[0]][0] = $_SESSION['inputcart'][$x[0]][0] + (int)$_POST['jmlbarang'];
      $_SESSION['inputcart'][$x[0]][1] = (int)$_POST['hrgbarang'];
      header("Location: ./inputBarangMasuk.php");
    }
  }


  $query = $conn->query("SELECT * from barang order by namabarang asc");
  $barang = array();
  while($row = $query -> fetch_assoc()){ 
      array_push($barang, array(
          'idbarang' => $row['idbarang'],
          'namabarang' => $row['namabarang'],
          'hargabarang' => $row['hargabarang'],
          'gambar' => $row['gambar'],
      ));
  }

  $query = $conn->query("SELECT * from supplier");
  $supplier = array();
  while($row = $query -> fetch_assoc()){ 
      array_push($supplier, array(
          'idsupplier' => $row['idsupplier'],
          'namasupplier' => $row['namasupplier'],
          'notelp' => $row['notelp'],
          'alamaat' => $row['alamat'],
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


        <div class="container" >
          <h2 id="ctitle">Input Cart</h2>
          

          <ul class="list-group">
            <?php
            if(count($_SESSION['inputcart']) < 1){
              echo("<script>$('#ctitle').hide();</script>");
            }
            foreach($_SESSION['inputcart'] as $name => $data){
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
        <h2 class="mt-3">Input Barang Masuk</h2>
        <?php
            if(count($barang)< 1 || count($supplier)< 1){
              echo("<div class=\"alert alert-danger \" id=\"null\" role=\"alert\">Pastikan Ada Data Barang Dan Supplier Sebelum Input Stok! ...</div>");
            }
          ?>
        <div id="frminp">
      <p class="text-danger">*10 menit setelah transaksi tercatat, transaksi tidak dapat di hapus! Pastikan Data Benar!</p>
      <form method="post">
        <label for="inputPassword5" class="form-label mt-4">Nama Barang</label>
        <select class="form-select" aria-label="Default select example" name="idbarang" id='idbarang'>
          <?php
            for($i=0; $i<count($barang);$i++){
          ?>
              <option value="<?php echo $barang[$i]['namabarang'].'$'.$barang[$i]['idbarang']?>"><?php echo  $barang[$i]['namabarang']?></option>
          <?php
            }
          ?>
        </select>

        <label for="inputPassword5" class="form-label mt-4">Jumlah Barang</label>
        <input type="number" id="jmlbarang" class="form-control" aria-describedby="passwordHelpBlock" name="jmlbarang" required>

        <label for="inputPassword5" class="form-label mt-4">Harga Modal Per Barang</label>
        <input type="number" id="hrgBarang" class="form-control" aria-describedby="passwordHelpBlock" name="hrgbarang" required>
        
        <button class="btn btn-success mt-4 mb-5 " id="add cart" name="inputcart" value="yes">add to cart</button>
      </form>
      <div class="d-flex justify-content-end">
        <form method="post" onsubmit="return confirm('Are you sure you want to insert the data? Make sure the data is correct!');">
          <button class="btn btn-danger mt-45 " id="insert" name="insert" value="Yes">Insert</button>
      </form>
      </div>
        </div>
    </div>
    
    <script>
      $(document).ready(function(){
        window.history.forward();
        window.setTimeout(function() {
            $("#nodata").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 4000); 

        if($('#null').length){
          $("#frminp").hide();
        }else{
          $("#frminp").show();
        }
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>

