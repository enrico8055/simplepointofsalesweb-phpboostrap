<?php
  session_start();
  ini_set('file_uploads', 'On');
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
            if(!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"] == null){
              echo("<div class=\"alert alert-danger\" id=\"nodata\" role=\"alert\">Barang Gagal Ditambahkan! Kegagalan Server!</div>");
            }else{
              $ID = time();
              $target_dir = "../img/";
              $target_file = $target_dir . basename($ID.".jpg");
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
              if($check !== false && !file_exists($ID.".jpg") && $imageFileType == "jpg" && $_FILES["fileToUpload"]["size"] < 50000000) {
                $query = $conn->query("INSERT INTO barang(idbarang, namabarang, gambar, hargabarang, idsupplier, deskripsi) VALUES(".$ID.",'".$_POST['namabarang']."','".$target_file."','".$_POST['hrgbarang']."',".$_POST['idsupplier'].",'".$_POST['deskripsibarang']."')");
                if($query){
                  move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                  sleep(3);
                  header("Location: ./status.php?s=inputBarang");
                }else{
                  echo("<div class=\"alert alert-danger\" id=\"nodata\" role=\"alert\">Barang Gagal Ditambahkan! Pastikan Nama Barang Belum Pernah Ada!</div>");
                }
              } else {
                echo("<div class=\"alert alert-danger\" id=\"nodata\" role=\"alert\">Barang Gagal Ditambahkan! Pastikan Anda Memasukan File Gambar (JPG max 50MB)!</div>");
              }
          }
        }
      ?>
      <h2 class="mt-3">Input Barang</h2>
      <?php
            $query = $conn->query("SELECT * from supplier order by namasupplier asc");
            $supplier = array();
            while($row = $query -> fetch_assoc()){ 
                array_push($supplier, array(
                    'idsupplier' => $row['idsupplier'],
                    'namasupplier' => $row['namasupplier'],
                    'notelp' => $row['notelp'],
                    'alamat' => $row['alamat']
                ));
            }
            if(count($supplier)< 1 || count($supplier)< 1){
              echo("<div class=\"alert alert-danger \" id=\"null\" role=\"alert\">Pastikan Ada Data Supplier Sebelum Input Barang! ...</div>");
            }
      ?>
      <div id="frminp">
      <form method="post" onsubmit="return confirm('Do you really want insert this item?');" enctype="multipart/form-data">
        <label for="inputPassword5" class="form-label mt-4">Nama Barang</label>
        <input type="text" id="namabarang" class="form-control" aria-describedby="passwordHelpBlock" name="namabarang" required>

        <label for="inputPassword5" class="form-label mt-4">Supplier</label>
        <select class="form-select" aria-label="Default select example" name="idsupplier" id='idsupplier'>
          <?php
            for($i=0; $i<count($supplier);$i++){
          ?>
              <option value="<?php echo $supplier[$i]['idsupplier']?>"><?php echo  $supplier[$i]['namasupplier']?></option>
          <?php
            }
          ?>
        </select>
        
        <label for="inputPassword5" class="form-label mt-4">Harga Jual Per Barang</label>
        <input type="number" id="hrgBarang" class="form-control" aria-describedby="passwordHelpBlock" name="hrgbarang" required>

        <label for="inputPassword5" class="form-label mt-4">Deskripsi Barang</label>
        <textarea type="text" id="deskripsi" class="form-control" aria-describedby="passwordHelpBlock" name="deskripsibarang" maxlength="500" required></textarea>
        
        <label for="inputPassword5" class="form-label mt-4">Gambar Barang</label><br>
        <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg" required ><br>
        <button class="btn btn-success mt-4 mb-5 " id="insert" name="insert" value="Yes">Insert</button>
      </form>
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

