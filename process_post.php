<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: April 16, 2024
    Description: Edit Event page

 ****************/
include 'db_connect.php';
include 'functions.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $event_name = filter_input(INPUT_POST, 'event_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $event_date = isset($_POST['event_date']) ? date("Y-m-d H:i:s", strtotime($_POST['event_date'])) : null;
    $event_location = filter_input(INPUT_POST, 'event_location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $event_distance = filter_input(INPUT_POST, 'event_distance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $event_image_url = filter_input(INPUT_POST, 'event_image_url', FILTER_SANITIZE_URL);
    $event_image = filter_input(INPUT_POST, 'event_image', FILTER_SANITIZE_URL);
    // $event_description = filter_input(INPUT_POST, 'event_description', FILTER_SANITIZE_URL);
    $event_description = strip_tags($_POST['event_description']);

    // Query to get distance_id from distances table based on distance_type
    $distance_query = "SELECT distance_id FROM distances WHERE distance_type = :event_distance";
    $distance_stmt = $conn->prepare($distance_query);
    $distance_stmt->bindParam(':event_distance', $event_distance);
    $distance_stmt->execute();
    $distance_result = $distance_stmt->fetch();

    if ($distance_result) {
      $distance_id = $distance_result['distance_id'];

      // Handle image upload if a new image was selected
      $event_image_path = '';
      if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // Directory to store uploaded images
        $file_name = $_FILES['event_image']['name'];
        $file_tmp = $_FILES['event_image']['tmp_name'];
        $event_image_path = $upload_dir . $file_name;
        $error_upload = '';
        // Extract filename and extension
        $file_name1 = pathinfo($file_name, PATHINFO_FILENAME);
        $file_ext2 = pathinfo($file_name, PATHINFO_EXTENSION);

        // Check if the uploaded file is an image
        if (file_is_an_image($file_tmp, $event_image_path)) {
          move_uploaded_file($file_tmp, $event_image_path);

          // Resized Max Width 400px: original_filename_medium.ext
          $medium_image = $upload_dir . $file_name1 . '_resize.' . $file_ext2;
          resize_img($event_image_path, $medium_image, 100);
        } else {
          throw new Exception("The uploaded file is not a valid image.");
        }
      } else if (!empty($event_image_url)) {
        $event_image_path = $event_image_url;
      } else {
        $event_image_path = 'assets/default/picture-not-available.jpg';
      }



      // Handle image deletion if the delete checkbox is checked
      if (isset($_POST['event_image']) && $_POST['event_image'] == 1) {
        $query = "SELECT event_image_url FROM runevents WHERE event_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute(array($id));
        $events = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($events && isset($events['event_image_url'])) {
          $filename = $events['event_image_url'];
          // Extract filename and extension
          $file_name1 = pathinfo($filename, PATHINFO_FILENAME);
          $file_ext2 = pathinfo($filename, PATHINFO_EXTENSION);
          $filename_resize = 'uploads/' . $file_name1 . '_resize.' . $file_ext2;

          echo $file_name;
          echo $filename_resize;
          if (file_exists($filename) || file_exists($filename_resize)) {
            unlink($filename);
            unlink($filename_resize);

            $query = "UPDATE runevents SET event_image_url = NULL WHERE event_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute(array($id));

            $query = "SELECT * FROM runevents WHERE event_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute(array($id));
            $events = $stmt->fetch(PDO::FETCH_ASSOC);
          }
        }
      }

      // Update query
      $query = "UPDATE runevents SET event_name = :event_name, event_date = :event_date, event_location = :event_location, event_description = :event_description, event_image_url = :event_image_url, event_distance = :event_distance, distance_id = :distance_id WHERE event_id = :id";
      $stmt = $conn->prepare($query);

      // Bind parameters
      $stmt->bindValue(':event_name', $event_name);
      $stmt->bindValue(':event_date', $event_date);
      $stmt->bindValue(':event_location', $event_location);
      $stmt->bindValue(':event_description', $event_description);
      $stmt->bindValue(':event_distance', $event_distance);
      $stmt->bindValue(':event_image_url', $event_image_path);
      $stmt->bindParam(':distance_id', $distance_id, PDO::PARAM_INT); // Bind distance_id
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      $stmt->execute();

      // Check if the update was successful
      if ($stmt->rowCount() == 0) {
        // Handle update failure
        echo "Error: Unable to update running event.";
      }

      // Redirect after update.
      header('Location: manageEvents.php');
      exit;
    }
  } catch (PDOException $e) {
    // Handle database errors
    error_log("Error: " . $e->getMessage());
  } catch (Exception $e) {
    // Handle other exceptions
    $_SESSION['error_message'] = $e->getMessage();
    header("Location: editEvent.php?id=$id");
    exit;
  } finally {
    // Close the database connection
    $conn = null;
  }
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