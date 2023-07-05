<?php
  session_start();
  if(!isset($_SESSION['cart']) || $_SESSION['cart'] == null || !isset($_SESSION['idtransaksi']) || !isset($_SESSION['namapelanggan']) || !isset($_SESSION['alamatpelanggan']) || !isset($_SESSION['nomorpelanggan'])){
    header("Location: ./kategori.php");
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
          <p class="d-flex justify-content-start h6" ><?php echo($_SESSION['idtransaksi'])?></p>
          </div>
          <div class="col ">
          <p class="d-flex justify-content-end h6"><?php echo($_SESSION['namapelanggan'])?></p>
          </div>
        </div>
    <div class="row">
          <div class="col ">
          <p class="d-flex justify-content-start h6" ><?php echo(date("Y-m-d"))?></p>
          </div>
          <div class="col ">
            <p class="d-flex justify-content-end h6"><?php echo($_SESSION['nomorpelanggan'])?></p>
          </div>
        </div>
    <div class="d-flex justify-content-center">
      <hr class="dashed d-flex" style="border-top: 2px dashed #999; width: 500px;">
    </div>
    <?php
      $totalHarga = 0;
      foreach($_SESSION['cart'] as $name => $data){
        $totalHarga += $data[0] * $data[1];
    ?>
        <div class="row">
          <div class="col ">
          <p class="d-flex justify-content-start h6" ><?php echo($data[0]."x ".$name." @Rp.".$data[1]); ?></p>
          </div>
          <div class="col ">
            <p class="d-flex justify-content-end h6"><?php echo("Rp. ".$data[0]*$data[1]."<br>"); ?></p>
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
          location.replace("./kategori.php?done=1");
        })
        window.setTimeout(function() {
         window.print();
        }, 500);
        window.setTimeout(function() {
          location.replace("./kategori.php?done=1");
        }, 3000);
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>



