<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 19, 2024
    Updated: 
    Description: Search Results page

 ****************/

include 'db_connect.php';

$query = "SELECT * FROM runevents";
$params = [];
$sort_field = 'event_name';
$sort_direction = 'asc';
$distance_id = '';
$search = '';

if (isset($_POST['search']) && !empty(trim($_POST['search']))) {
  $search = $_POST['search'];
  if (strpos($query, 'WHERE') !== false) {
    $query .= " AND (event_name LIKE :search OR event_location LIKE :search)";
  } else {
    $query .= " WHERE event_name LIKE :search OR event_location LIKE :search";
  }
  $params[':search'] = "%$search%";
}
if (isset($_POST['distance_id']) && $_POST['distance_id'] !== '') {
  $selected_distance_id = $_POST['distance_id'];
  if (strpos($query, 'WHERE') !== false) {
    $query .= " AND distance_id = :distance_id";
  } else {
    $query .= " WHERE distance_id = :distance_id";
  }
  $params[':distance_id'] = $selected_distance_id;
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

$query .= " ORDER BY $sort_field $sort_direction";
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <title>Bootstrap Example</title>
</head>

<body>
  <div class="container">
    <table>
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
            <div class="card mb-3 shadow" style="width: 100%;">
              <div class="row g-0">
                <div class="col-md-4" style="max-width: 300px;">
                  <img src="<?= $row['event_image_url'] ?>" class="rounded mx-auto d-block w-100 h-100" alt="...">
                </div>
                <div class="col-md-7">
                  <div class="card-body">
                    <div>
                      <h2 class="card-title"><?= $row['event_name'] ?></h2>
                      <div class="h6">
                        <time>
                          <i class="fas fa-calendar-alt mr-2"></i> <?= date("F d, Y", strtotime($row['event_date'])) ?>
                        </time>
                      </div>
                      <div class="d-flex">
                        <h4 class="me-3"><span class="badge bg-info"><i class="fas fa-running"></i>
                            <?= $row['event_distance'] ?></span></h4>
                        <h4><span class="badge bg-info"><i class="fas fa-map-marker-alt"></i>
                            <?= $row['event_location'] ?></span></h4>
                      </div>
                      <div class="lead">
                        <?php if (strlen($row['event_description']) > 150) : ?>
                        <?= substr($row['event_description'], 0, 150) ?>
                        <span>...</span>
                        <?php else : ?>
                        <?= $row['event_description'] ?>
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                  <button class="btn btn-outline-primary">Race Details</button>
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
  </div>

  <?php include 'footer.php'; ?>
</body>

</html>