<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: April 16, 2024
    Description: Race Details page

 ****************/
ob_start();
include 'navbar.php';
include 'db_connect.php';

include 'functions.php';

if (isset($_GET['id'])) {
  // Sanitize the id.
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

  if (!is_numeric($id)) {
    header("Location: index.php");
    exit;
  }

  // Build the parametrized SQL query using the filtered id.
  $query = "SELECT * FROM runevents WHERE event_id = :id";
  $statement = $conn->prepare($query);
  $statement->bindValue(':id', $id, PDO::PARAM_INT);

  // Execute the SELECT and fetch the single row returned.
  $statement->execute();
  $event = $statement->fetch();


  if (!$event) {
    header("Location: index.php");
    exit;
  }
} else {
  $id = false;
}


ob_end_flush();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Event</title>
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
            <h2>Edit Event</h2>
          </div>
          <div class="card-body">

            <form action="process_post.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?= isset($event['event_id']) ? $event['event_id'] : ''; ?>">
              <div class="mb-3">
                <label for="event_name" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="event_name" name="event_name" value="<?= isset($event['event_name']) ? $event['event_name'] : ''; ?>" required>
              </div>
              <div class="mb-3">
                <label for="event_date" class="form-label">Event Date</label>
                <?php $event_date = isset($event['event_date']) ? date("Y-m-d H:i:s", strtotime($event['event_date'])) : ''; ?>
                <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="<?= $event_date ?>" required>
              </div>
              <div class="mb-3">
                <label for="event_location" class="form-label">Event Location</label>
                <input type="text" class="form-control" id="event_location" name="event_location" value="<?= isset($event['event_location']) ? $event['event_location'] : ''; ?>" required>
              </div>
              <div class="mb-3">
                <label for="event_description" class="form-label">Event Description</label>
                <textarea class="form-control" id="event_description" name="event_description" rows="4" required><?= isset($event['event_description']) ? htmlspecialchars($event['event_description'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
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
                  convert_urls: false,
                  entities: "3"
                });
              </script>
              <div class="mb-3">
                <label for="event_distance" class="form-label">Event Distance (in miles)</label>
                <select class="form-control form-control-lg custom-select" id="event_distance" name="event_distance" required>
                  <option value="5K" <?= ($event['event_distance'] === '5K') ? 'selected' : ''; ?>>5K</option>
                  <option value="10K" <?= ($event['event_distance'] === '10K') ? 'selected' : ''; ?>>10K</option>
                  <option value="Half Marathon" <?= ($event['event_distance'] === 'Half Marathon') ? 'selected' : ''; ?>>
                    Half Marathon</option>
                  <option value="Marathon" <?= ($event['event_distance'] === 'Marathon') ? 'selected' : ''; ?>>Marathon
                  </option>
                </select>
              </div>

              <div class="mb-3">
                <label for="event_image_url" class="form-label">Event Image URL</label>
                <input type="text" class="form-control" id="event_image_url" name="event_image_url" value="<?php if (isset($event['event_image_url']) && filter_var($event['event_image_url'], FILTER_VALIDATE_URL)) : ?><?= $event['event_image_url'] ?><?php endif; ?>">
              </div>

              <label for="event_image" class="form-label">Uploaded Cover Image</label>
              <div class="mb-3">
                <img src="<?= empty($event['event_image_url']) || filter_var($event['event_image_url'], FILTER_VALIDATE_URL) ? 'assets/default/picture-not-available.jpg' : $event['event_image_url']  ?>" alt="Event Cover" class="img-thumbnail" width="200">

                <?php if ((empty($event['event_image_url'])) || ($event['event_image_url'] == 'assets/default/picture-not-available.jpg') || filter_var($event['event_image_url'], FILTER_VALIDATE_URL)) : ?>
                  <div>
                    <p>Currently, no event photo is uploaded</p>
                  </div>
                <?php else : ?>
                  <div class="form-check mb-3">
                    <input type="hidden" name="event_image" value="0">
                    <input type="checkbox" class="form-check-input" id="event_image" name="event_image" value="1">
                    <label class="form-check-label" for="event_image">Delete Event Cover Photo</label>
                  </div>
                <?php endif; ?>
              </div>
              <label class="form-check-label" for="event_image">Add/Change Event Cover Photo</label>
              <div class="mb-3">
                <input type="file" class="form-control-file" name="event_image" id="event_image">

                <?php if (isset($_SESSION['error_message'])) : ?>
                  <p class="alert alert-danger mt-2"><?= htmlspecialchars($_SESSION['error_message']); ?></p>
                  <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>