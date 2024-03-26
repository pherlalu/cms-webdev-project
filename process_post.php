<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize user input to escape HTML entities and filter out dangerous characters.
  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
  $event_date = isset($_POST['event_date']) ? date('Y-m-d', strtotime($_POST['event_date'])) : null;
  $event_location = filter_input(INPUT_POST, 'event_location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $event_description = filter_input(INPUT_POST, 'event_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $event_distance = filter_input(INPUT_POST, 'event_distance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Query to get distance_id from distances table based on distance_type
  $distance_query = "SELECT distance_id FROM distances WHERE distance_type = :event_distance";
  $distance_stmt = $conn->prepare($distance_query);
  $distance_stmt->bindParam(':event_distance', $event_distance);
  $distance_stmt->execute();
  $distance_result = $distance_stmt->fetch();

  if ($distance_result) {
    $distance_id = $distance_result['distance_id'];

    // Update query
    $query = "UPDATE runevents SET event_date = :event_date, event_location = :event_location, event_description = :event_description, event_distance = :event_distance, distance_id = :distance_id WHERE event_id = :id";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':event_date', $event_date);
    $stmt->bindParam(':event_location', $event_location);
    $stmt->bindParam(':event_description', $event_description);
    $stmt->bindParam(':event_distance', $event_distance);
    $stmt->bindParam(':distance_id', $distance_id, PDO::PARAM_INT); // Bind distance_id
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the UPDATE.
    $stmt->execute();

    // Redirect after update.
    header('Location: manageEvents.php');
    exit;
  } else {
    // Handle case where distance_type was not found
    // You can redirect to an error page or handle this as needed
    header('Location: error.php');
    exit;
  }
} else {
  // If not a POST request, redirect to an error page
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