<?php
  session_start();
  ini_set('file_uploads', 'On');

  if(!isset($_GET['s'])){
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

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

    <div class="container mt-5">
    <div class="alert alert-success" role="alert" data-aos="fade-down" data-aos-duration="1500">
      Tindakan Berhasil! Klik <a href="./<?php echo($_GET['s']); ?>.php" class="alert-link">Disini</a> Untuk Melanjutkan!
    </div>
    </div>
    
    <script>
      $(document).ready(function(){
          window.history.forward();

          setTimeout(function(){
            window.location.replace("../index.php");
          }, 15000);
      });
    </script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>

