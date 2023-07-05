<?php
  session_start();
  $curl = curl_init();
  if(isset($_GET['s']) &&$_GET['s'] == 'cancel'){
    session_destroy();
  }
  curl_setopt($curl, CURLOPT_URL, 'https://reqres.in/api/users?page=2');
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
  $data = curl_exec($curl);
  curl_close($curl);
  $data = json_decode($data, true);
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
        <div class="container d-flex justify-content-center">
          <div class="row container-fluid">
            <div class="col">
              <a class="navbar-brand" href="#" style="font-family: 'Pacifico', serif;">
                  <img src="./img/logo.png" alt="" width="30" height="35" class="d-inline-block  align-text-top me-3" >NECTARINE
              </a>
            </div>
        </div>
    </nav>

    <!-- NAVBAR 2 -->
    <nav class="navbar navbar-expand navbar-light bg-light">
      <div class="container text-center">
        <div class="mx-auto">
          <div class="" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./src/about.php">About</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>

    <!-- JUMBORTRON -->
    <div class="jumbotron mt-5"  >
      <div class="container">
        <h1 class="display-4" data-aos="fade-right" data-aos-duration="2000" style="font-family: 'Pacifico', serif;">NECTARINE</h1>
        <p class="lead" data-aos="fade-right" data-aos-duration="2000">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4" data-aos="fade-right" data-aos-duration="2000">
        <p data-aos="fade-right" data-aos-duration="2000">It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <a class="btn btn-success btn-md" href="./src/kategori.php" role="button" data-aos="zoom-in" data-aos-duration="5000">CheckOut</a>
        <a class="btn btn-secondary btn-md" href="./adminsrc/transaksi.php" role="button" data-aos="zoom-in" data-aos-duration="5000">Admin</a>
      </div>
    </div>


    <div id="carouselExampleIndicators" class="carousel slide container mt-5 mb-5" data-bs-ride="carousel" data-aos="fade-left" data-aos-duration="2000">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./img/4.png" class="d-block w-100 rounded-pill" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/5.jpg" class="d-block w-100 rounded-pill" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/6.jpg" class="d-block w-100 rounded-pill" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>

