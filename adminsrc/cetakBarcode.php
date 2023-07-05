<?php
  require '../vendor/autoload.php';
  session_start();
  $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
  if(!isset($_POST['cetak']) || $_POST['cetak'] == null ){
    header("Location: ../index.php");
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
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Sofia One:wght@300;400;500;700;900&display=swap"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title><?php echo("&nbsp");?></title>
  </head>
  <style>
  </style>
  <body class="container" id="body">
  <div class="container d-flex justify-content-center mt-5 ">
    <?php
      echo $generator->getBarcode(explode("$",$_POST['cetak'])[0], $generator::TYPE_CODE_128);
    ?>
  </div>  
  <div class="container d-flex justify-content-center">
    <?php
      echo "\n".explode("$",$_POST['cetak'])[0];
    ?>
  </div>  
    <script>
      $(document).ready(function(){
        window.history.forward();
        window.setTimeout(function() {
         window.print();
        }, 500);
        window.setTimeout(function() {
          location.replace("./barang.php");
        }, 3000);
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>



