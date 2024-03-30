<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: March 24, 2024
    Description: Events page

 ****************/
include 'navbar.php';
include 'db_connect.php';

$search = '';
$query = "SELECT * FROM runevents";


$statement = $conn->prepare($query);
$statement->execute();

$distancesQuery = "SELECT * FROM distances";
$distancesStatement = $conn->prepare($distancesQuery);
$distancesStatement->execute();
$distances = $distancesStatement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://cdn.pixabay.com/photo/2023/10/04/14/15/man-8293794_1280.jpg" class="d-block w-100" alt="New Image 1">
      </div>
      <div class="carousel-item">
        <img src="https://quotefancy.com/media/wallpaper/1600x900/1734202-Amby-Burfoot-Quote-Life-is-a-marathon-not-a-sprint-pace-yourself.jpg" class="d-block w-100" alt="New Image 2">
      </div>
      <div class="carousel-item">
        <img src="https://cdn.pixabay.com/photo/2016/07/14/17/14/runners-1517155_1280.jpg" class="d-block w-100" alt="New Image 3">
      </div>
    </div>
  </div>
  <div class="container mt-4 shadow p-3 mb-5">
    <div class="row justify-content-center">
      <form class="row g-3 mb-4" method="POST" style="padding: 20px;">

        <div class="col-md-6 ">
          <div id="basic" class="form-outline">
            <input class="form-control form-control-lg search-input" type="search" name="search" placeholder="Search" aria-label="Search" value="<?= htmlspecialchars($search) ?>" style="margin-bottom: 10px;">
          </div>
        </div>

        <div class="col-md-2 d-grid align-items-center">
          <input class="btn btn-dark btn-lg" type="submit" value="Search" style="margin-top: 20px; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#343a40';" onmouseout="this.style.backgroundColor='#000000';" />
        </div>

        <div class="sort-options" style="display: flex; justify-content: space-between; align-items: center;">
          <div class="input-group mb-3" style="width: 50%;">
            <label class="input-group-text" for="distance_id">Distance Category</label>
            <select class="form-select" id="distance_id" name="distance_id" style="margin-bottom: 10px;">
              <option value="">-- All Distance --</option>
              <?php foreach ($distances as $distance) : ?>
                <option value="<?= htmlspecialchars($distance['distance_id']) ?>" <?= (isset($_POST['distance_id']) && $_POST['distance_id'] == $distance['distance_id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($distance['distance_type']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="sort-field input-group mb-3" style="width: 50%;">
            <label class="input-group-text" for="sort_field">Sort By:</label>
            <select class="form-select" id="sort_field" name="sort_field">
              <option value="">Choose...</option>
              <option value="event_name" <?= (isset($_POST['sort_field']) && $_POST['sort_field'] == 'event_name') ? 'selected' : '' ?>>Event Name</option>
              <option value="event_location" <?= (isset($_POST['sort_field']) && $_POST['sort_field'] == 'event_location') ? 'selected' : '' ?>>Event Location</option>
              <option value="event_date" <?= (isset($_POST['sort_field']) && $_POST['sort_field'] == 'event_date') ? 'selected' : '' ?>>Event Date</option>
            </select>
          </div>
          <div class="sort-direction input-group mb-3" style="width: 50%;">
            <div>
              <input type="radio" id="asc" name="sort_direction" value="asc" <?= (isset($_POST['sort_direction']) && $_POST['sort_direction'] == 'asc') ? 'checked' : '' ?>>
              <label for="asc"><i class="fas fa-arrow-up"></i> Ascending</label>
            </div>
            <div>
              <input type="radio" id="desc" name="sort_direction" value="desc" <?= (isset($_POST['sort_direction']) && $_POST['sort_direction'] == 'desc') ? 'checked' : '' ?>>
              <label for="desc"><i class="fas fa-arrow-down"></i> Descending</label>
            </div>
          </div>

          <input class="btn btn-outline-primary edit-button" type="reset" value="Clear All" />
        </div>

      </form>
    </div>
  </div>


  <?php include 'search_results.php'; ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script>
    var carousel = new bootstrap.Carousel(document.querySelector('#carouselExampleAutoplaying'), {
      interval: 1500,
      wrap: true
    });
  </script>
</body>


</html>