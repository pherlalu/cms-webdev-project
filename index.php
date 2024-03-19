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
        <img height="900" src="https://www.winnipegfreepress.com/wp-content/uploads/sites/2/2022/05/NEP8650599.jpg" class="d-block w-100" alt="First slide">
        <div class="carousel-caption d-none d-md-block text-center">
          <h1>Runner's Logic</h1>
          <h5>I'm TIRED. I think I'll go for a Run!</h5>
          <a href="events.php">
            <button class="btn btn-primary">Find your events</button>
          </a>
        </div>
      </div>
      <div class="carousel-item">
        <img height="900" src="https://mybestruns.com/photo/106.jpg" class="d-block w-100" alt="Second slide">

        <div class="carousel-caption d-none d-md-block">
          <h1>Get up and run!</h1>
          <h5>The body achieves what the mind believes.</h5>
        </div>
      </div>
      <div class="carousel-item">
        <img height="900" src="https://img.shetu66.com/2023/07/18/1689668645651692.png" class="d-block w-100" alt="Second slide">

        <div class="carousel-caption d-none d-md-block">
          <h1>Live Life</h1>
          <h5>Life is short. RUNNING make it seem longer.</h5>
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
  <?php include 'footer.php'; ?>

</body>

</html>