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
$params = [];

if (isset($_POST['distance_id']) && $_POST['distance_id'] !== '') {
  $selected_distance_id = $_POST['distance_id'];
  $query .= " WHERE distance_id = :distance_id";
  $params['distance_id'] = $selected_distance_id;
}

if (isset($_POST['search']) && !empty(trim($_POST['search']))) {
  $search = $_POST['search'];
  if (strpos($query, 'WHERE') !== false) {
    $query .= " AND (event_name LIKE :search OR event_location LIKE :search)";
  } else {
    $query .= " WHERE event_name LIKE :search OR event_location LIKE :search";
  }
  $params['search'] = "%$search%";
}

$statement = $conn->prepare($query);
$statement->execute($params);

$distancesQuery = "SELECT * FROM distances";
$distancesStatement = $conn->prepare($distancesQuery);
$distancesStatement->execute();
$distances = $distancesStatement->fetchAll(PDO::FETCH_ASSOC);

$count = $statement->rowCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://cdn.pixabay.com/photo/2021/09/27/10/02/running-6660185_1280.jpg" class="d-block w-100" alt="New Image 1">
        <!-- <div class="carousel-caption d-none d-md-block">
          <h5>New Image 1</h5>
          <p>Description for the first new image.</p>
        </div> -->
      </div>
      <div class="carousel-item">
        <img src="https://quotefancy.com/media/wallpaper/1600x900/1734202-Amby-Burfoot-Quote-Life-is-a-marathon-not-a-sprint-pace-yourself.jpg" class="d-block w-100" alt="New Image 2">

      </div>
      <div class="carousel-item">
        <img src="https://cdn.pixabay.com/photo/2016/07/14/17/14/runners-1517155_1280.jpg" class="d-block w-100" alt="New Image 3">
      </div>
    </div>
  </div>

  <div class="col-md-6 p-lg-5 mx-auto my-5">
    <div class="card text-bg-dark mb-3">
      <div class="card-header">
        Search for events
      </div>
      <div class="card-body">
        <form class="d-flex" method="POST">
          <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="<?= htmlspecialchars($search) ?>">
          <div class="form-group">
            <select class="form-control" id="distance_id" name="distance_id">
              <option value="">-Distance-</option>
              <?php foreach ($distances as $distance) : ?>
                <option value="<?= htmlspecialchars($distance['distance_id']) ?>" <?= (isset($_POST['distance_id']) && $_POST['distance_id'] == $distance['distance_id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($distance['distance_type']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <button class="btn btn-outline-success ms-2" type="submit">Search</button>
        </form>

      </div>
      <div class="card-header text-body-secondary">
        RunOutLoud
      </div>
    </div>
  </div>
  <table class="table d-flex justify-content-center">
    <tbody>
      <?php if ($count > 0) : ?>
        <tr>
          <td class="text-center">
            <p class="mt-3">
              <strong><?= $count ?></strong> Results Found
            </p>
          </td>
        </tr>

        <?php while ($row = $statement->fetch()) : ?>
          <tr>
            <td>
              <div class="card mb-3" style="max-width: 900px;">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="<?= $row['event_image_url'] ?>" class="img-fluid rounded-start" alt="...">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h2 class="card-title"><?= $row['event_name'] ?></h2>
                      <p class="card-text">
                      <h5 class="text-body-secondary">
                        <?= date("F d, Y", strtotime($row['event_date'])) ?>
                      </h5>
                      <h5 class="text-body-secondary"><?= $row['event_location'] ?></h5>
                      </p>
                      <p class="card-text"><?= $row['event_description'] ?></p>
                      <button>Race Details</button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endwhile ?>
      <?php else : ?>
        <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
          <h2 class="text-muted">No results found!</h2>
        </div>
      <?php endif ?>

    </tbody>
  </table>
  <?php include 'footer.php'; ?>
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