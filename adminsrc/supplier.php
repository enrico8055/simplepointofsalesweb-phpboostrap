<?php
  session_start();
  include_once("../inc/koneksi.php"); 


  if(isset($_POST['query']) && $_POST['query'] != null){
    // ambil data transaksi
    $query = $conn->query("SELECT * from supplier where namasupplier like '%".$_POST['query']."%' order by namasupplier asc limit 20");

  }else{
    // ambil data transaksi
    $query = $conn->query("SELECT * from supplier order by namasupplier asc limit 20");
  }

  $supplier = array();
  while($row = $query -> fetch_assoc()){ 
      array_push($supplier, array(
          'idsupplier' => $row['idsupplier'],
          'namasupplier' => $row['namasupplier'],
          'notelp' => $row['notelp'],
          'alamat' => $row['alamat'],
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
              <form class="d-flex " method="post">
                <input class="form-control me-2 rounded-pill" type="text" aria-label="Search" placeholder="Cari Berdasar Nama Supplier" name="query">
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
          $query = $conn->query("DELETE FROM supplier WHERE idsupplier = ".explode("$",$_POST['del'])[0]);
          if($query){
            header("Location: ./status.php?s=supplier");
          }else{
            echo("<div class=\"alert alert-danger\" id=\"status\" role=\"alert\">Supplier Gagal Dihapus! (Supplier Yang Sudah Memliki Transaksi/Produk Tidak Dapat Dihapus)!</div>");
          }
        }
      ?>
        <div class="container">
        <h2 class="mt-3"> List Supplier</h2>
        <?php
          if(count($supplier) < 1){
            echo("<div class=\"alert alert-danger\" role=\"alert\">Data Supplier Tidak Ditemukan!</div>");
          }
        ?>
        <ul class="list-group mt-5">
          <?php
            for($i = 0; $i<count($supplier); $i++){
          ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <ul class="list-group">
                  <p class="h6"><?php echo("Nama Supplier : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$supplier[$i]['namasupplier']."<br>"); ?>
                  <p class="h6"><?php echo("Alamat : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$supplier[$i]['alamat']."<br>"); ?>
                  <p class="h6"><?php echo("No HP : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(+62)".$supplier[$i]['notelp']."<br>"); ?>
                  <p class="h6"><?php echo("Id Supplier : "."<br>"); ?></p>
                  <?php echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$supplier[$i]['idsupplier']."<br>"); ?>
                </ul>
                <ul class="list-group align-items-center">
                  <form method="post" action="./editSupplier.php" onsubmit="return confirm('Yakin ingin edit supplier ini?');" class="">
                    <div>
                      <button class="btn btn-secondary btn-sm" type="submit" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover" name="edit" value="<?php echo($supplier[$i]['idsupplier']."$".$supplier[$i]['namasupplier']."$".$supplier[$i]['notelp']."$".$supplier[$i]['alamat'])?>">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      </svg></div>

                  </form>
                  <form method="post" onsubmit="return confirm('Yakin ingin hapus supplier ini?');" class="mt-3">
                    <div>
                      <button class="btn btn-danger btn-sm" type="submit" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover" name="del" value="<?php echo($supplier[$i]['idsupplier'])?>">
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



