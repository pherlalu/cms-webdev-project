<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize user input to escape HTML entities and filter out dangerous characters.
  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
  $event_name = filter_input(INPUT_POST, 'event_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $event_date = isset($_POST['event_date']) ? date("Y-m-d H:i:s", strtotime($_POST['event_date'])) : null;
  $event_location = filter_input(INPUT_POST, 'event_location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $event_description = strip_tags($_POST['event_description']);
  $event_distance = filter_input(INPUT_POST, 'event_distance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $event_image_url = filter_input(INPUT_POST, 'event_image_url', FILTER_SANITIZE_URL);

  // Query to get distance_id from distances table based on distance_type
  $distance_query = "SELECT distance_id FROM distances WHERE distance_type = :event_distance";
  $distance_stmt = $conn->prepare($distance_query);
  $distance_stmt->bindParam(':event_distance', $event_distance);
  $distance_stmt->execute();
  $distance_result = $distance_stmt->fetch();

  if ($distance_result) {
    $distance_id = $distance_result['distance_id'];

    // Update query
    $query = "UPDATE runevents SET event_name = :event_name, event_date = :event_date, event_location = :event_location, event_description = :event_description, event_distance = :event_distance, event_image_url = :event_image_url, distance_id = :distance_id WHERE event_id = :id";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindValue(':event_name', $event_name);
    $stmt->bindValue(':event_date', $event_date);
    $stmt->bindValue(':event_location', $event_location);
    $stmt->bindValue(':event_description', $event_description);
    $stmt->bindValue(':event_distance', $event_distance);
    $stmt->bindValue(':event_image_url', $event_image_url);

    $stmt->bindParam(':distance_id', $distance_id, PDO::PARAM_INT); // Bind distance_id
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    // Redirect after update.
    header('Location: manageEvents.php');
    exit;
  } else {
    header('Location: error.php');
    exit;
  }
} else {
  header('Location: error.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Error</title>
  <link rel="stylesheet" href="main.css" type="text/css">
</head>

<body>
  <div id="wrapper">
    <h1>An error occurred.</h1>
    <p>Sorry, something went wrong.</p>
    <a href="index.php">Return Home</a>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>