<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 24, 2024
    Updated: March 25, 2024
    Description: Add Events page

 ****************/
ob_start();

include 'navbar.php';
include 'db_connect.php';

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
  // If the user is not an admin, redirect them to the home page
  header('Location: index.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize and validate
  $event_name = filter_input(INPUT_POST, 'event_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $event_date = isset($_POST['event_date']) ? date("Y-m-d H:i:s", strtotime($_POST['event_date'])) : null;
  $event_location = filter_input(INPUT_POST, 'event_location',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $event_description = htmlspecialchars(strip_tags($_POST['event_description']), ENT_QUOTES, 'UTF-8');
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

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query = "INSERT INTO runevents (event_name, event_date, event_location, event_description, event_distance, event_image_url, distance_id) VALUES (:event_name, :event_date, :event_location, :event_description, :event_distance, :event_image_url, :distance_id)";
    $statement = $conn->prepare($query);

    // Bind values to the parameters
    $statement->bindValue(':event_name', $event_name);
    $statement->bindValue(':event_date', $event_date);
    $statement->bindValue(':event_location', $event_location);
    $statement->bindValue(':event_description', $event_description);
    $statement->bindValue(':event_distance', $event_distance);
    $statement->bindValue(':event_image_url', $event_image_url);
    $statement->bindValue(':distance_id', $distance_id, PDO::PARAM_INT); // Bind distance_id

    // Execute the INSERT.
    $statement->execute();

    // Redirect the user to the manage events page
    header('Location: manageEvents.php');
    exit();
  }
}

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Event</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tiny.cloud/1/jimddr1cbrdv8gayc9fr27ijy4hf0omx5h502auz20lj27jl/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <style>
    body {
      background: url('https://cdn.pixabay.com/photo/2013/02/05/15/18/landscape-78058_960_720.jpg') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
    }

    .card {
      background-color: rgba(255, 255, 255, 0.5);
    }
  </style>
</head>

<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Add New Event</h2>
          </div>
          <div class="card-body">
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="event_name" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="event_name" name="event_name" required>
              </div>
              <div class="mb-3">
                <label for="event_date" class="form-label">Event Date and Start Time</label>
                <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
              </div>
              <div class="mb-3">
                <label for="event_location" class="form-label">Event Location</label>
                <input type="text" class="form-control" id="event_location" name="event_location" required>
              </div>
              <div class="mb-3">
                <label for="event_description" class="form-label">Event Description</label>
                <textarea class="form-control" id="event_description" name="event_description" rows="5"></textarea>
              </div>
              <script>
                tinymce.init({
                  selector: '#event_description',
                  height: 300,
                  plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                  ],
                  toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                });
              </script>
              <div class="mb-3">
                <label for="event_distance" class="form-label">Event Distance (in miles)</label>
                <select class="form-control form-control-lg custom-select" id="event_distance" name="event_distance" required>
                  <option value="5K">5K</option>
                  <option value="10K">10K</option>
                  <option value="Half Marathon">Half Marathon</option>
                  <option value="Marathon">Marathon</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="event_image_url" class="form-label">Event Image URL</label>
                <input type="text" class="form-control" id="event_image_url" name="event_image_url" required>
              </div>
              <div class="mb-3">
                <label for="event_image" class="form-label">Upload Event Image</label>
                <input type="file" class="form-control" id="event_image" name="event_image">
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>