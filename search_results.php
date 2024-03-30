<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 19, 2024
    Updated: 
    Description: Search Results page

 ****************/

include 'db_connect.php';

$search = '';
$query = "SELECT * FROM runevents";
$params = [];
$sort_field = 'event_name';
$sort_direction = 'asc';
$distance_id = '';

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

// Sorting functionality
if (isset($_POST['sort_field']) && in_array($_POST['sort_field'], ['event_name', 'event_location', 'event_date'])) {
  $sort_field = $_POST['sort_field'];
}

if (isset($_POST['sort_direction']) && in_array($_POST['sort_direction'], ['asc', 'desc'])) {
  $sort_direction = $_POST['sort_direction'];
}

if (isset($_POST['distance_id']) && $_POST['distance_id'] !== '') {
  $distance_id = $_POST['distance_id'];
}

$query = "SELECT * FROM runevents ";

$params = [];
if (!empty($distance_id)) {
  $query .= "WHERE distance_id = :distance_id ";
  $params[':distance_id'] = $distance_id;
}

$query .= "ORDER BY $sort_field $sort_direction";
$stmt = $conn->prepare($query);
$stmt->execute($params);

$count = $stmt->rowCount();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <?php foreach ($results as $row) : ?>
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
                      <h5 class="text-body-secondary">Event Distance: <?= $row['event_distance'] ?></h5>
                      <h5 class="text-body-secondary"><?= $row['event_location'] ?></h5>
                      </p>
                      <p class="card-text"><?= $row['event_description'] ?></p>
                      <button class="btn btn-primary">Race Details</button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach ?>
      <?php else : ?>
        <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
          <h2 class="text-muted">No results found!</h2>
        </div>
      <?php endif ?>
    </tbody>
  </table>
  <?php include 'footer.php'; ?>
</body>

</html>