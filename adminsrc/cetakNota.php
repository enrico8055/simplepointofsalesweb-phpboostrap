<?php
  session_start();
  include_once("../inc/koneksi.php");
  
  if(!isset($_POST['idtransaksi'])){
    header("Location: ../index.php");
  }

  $query = $conn->query("SELECT barang.namabarang, rincitransaksi.jumlahbarang, rincitransaksi.hargabarang as hargabarang
                                                FROM transaksi
                                                INNER JOIN rincitransaksi ON transaksi.idtransaksi=rincitransaksi.idtransaksi
                                                INNER JOIN barang ON rincitransaksi.idbarang=barang.idbarang WHERE transaksi.idtransaksi = ".$_POST['idtransaksi']);
  $daftarbarang = array();
  while($row = $query -> fetch_assoc()){ 
      array_push($daftarbarang, array(
          'namabarang' => $row['namabarang'],
          'jumlahbarang' => $row['jumlahbarang'],
          'hargabarang' => $row['hargabarang'],
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

    <title><?php echo("&nbsp");?></title>
  </head>
  <style>
  </style>
  <body class="container" id="body">
  <div class="container">
  <div class="container"> 
  <div class="container">
    <p class="d-flex justify-content-center h3" id="title" style="font-family:Pacifico;">NECTARINE</p>
    <p class="d-flex justify-content-center h6">Jl. Pandanaran 114, Semarang</p>
    <div class="row">
          <div class="col ">
          <p class="d-flex justify-content-start h6" ><?php echo($_POST['idtransaksi'])?></p>
          </div>
          <div class="col ">
          <p class="d-flex justify-content-end h6"><?php echo($_POST['namapelanggan'])?></p>
          </div>
        </div>
    <div class="row">
          <div class="col ">
          <p class="d-flex justify-content-start h6" ><?php echo($_POST['tanggal'])?></p>
          </div>
          <div class="col ">
            <p class="d-flex justify-content-end h6"><?php echo($_POST['nomorpelanggan'])?></p>
          </div>
        </div>
    <div class="d-flex justify-content-center">
      <hr class="dashed d-flex" style="border-top: 2px dashed #999; width: 500px;">
    </div>
    <?php
      $totalHarga = 0;
      for($j=0; $j<count($daftarbarang); $j++){
        $totalHarga += $daftarbarang[$j]['jumlahbarang'] * $daftarbarang[$j]['hargabarang'];
    ?>
        <div class="row">
          <div class="col ">
          <p class="d-flex justify-content-start h6" ><?php echo($daftarbarang[$j]['jumlahbarang']."x ".$daftarbarang[$j]['namabarang']." @Rp.".$daftarbarang[$j]['hargabarang']); ?></p>
          </div>
          <div class="col ">
            <p class="d-flex justify-content-end h6"><?php echo("Rp. ".$daftarbarang[$j]['jumlahbarang']*$daftarbarang[$j]['hargabarang']."<br>"); ?></p>
          </div>
        </div>
    <?php
      }
    ?>
    <div class="row mt-3">
          <div class="col ">
          </div>
          <div class="col ">
          <p class="d-flex justify-content-end h5">Total : <?php echo "Rp. ".$totalHarga?></p>
          </div>
    </div>
    <p class="d-flex justify-content-center h4 mt-4" id="thank">Thank You</p>
    <p class="d-flex justify-content-center h4 mt-1">(+62)81224670606</p>
  </div>  
    <script>
      $(document).ready(function(){
        window.history.forward();
        $('#title').click(function(){
          window.print();
        })
        $('#thank').click(function(){
          location.replace("./transaksi.php");
        })
        window.setTimeout(function() {
         window.print();
        }, 500);
        window.setTimeout(function() {
          location.replace("./transaksi.php");
        }, 3000);
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>



