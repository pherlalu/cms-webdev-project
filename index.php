<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: 
    Description: Index page

 ****************/

include 'navbar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <title>Bootstrap Example</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

  <div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img width="auto" height="800" src="https://www.winnipegfreepress.com/wp-content/uploads/sites/2/2022/05/NEP8650599.jpg" class="d-block w-100" alt="First slide">
        <div class="carousel-caption d-none d-md-block text-center">
          <h5>First slide label</h5>
          <p>Some representative placeholder content for the first slide.</p>
          <a href="events.php">
            <button class="btn btn-primary">Find your events</button>
          </a>
        </div>
      </div>
      <div class="carousel-item">
        <img width="auto" height="800" src="https://mybestruns.com/photo/106.jpg" class="d-block w-100" alt="Second slide">

        <div class="carousel-caption d-none d-md-block">
          <h5>Second slide label</h5>
          <p>Some representative placeholder content for the second slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img width="auto" height="800" src="https://pixabay.com/get/gdae5a99a8b20031c02ac3079315acac82c748b3690173b52667e328bfd143c1f7b4cf793af042de0bba456ebd746503af4d7057f9da90323f224a49d1e21c3e6_1280.jpg" class="d-block w-100" alt="Second slide">

        <div class="carousel-caption d-none d-md-block">
          <h5>Third slide label</h5>
          <p>Some representative placeholder content for the third slide.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <?php

  include 'footer.php';


  ?>

</body>

</html>