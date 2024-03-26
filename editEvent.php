<?php
include 'navbar.php';
include 'db_connect.php';


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

  // Check if valid statement.
  if (!$event) {
    header("Location: index.php");
    exit;
  }
} else {
  $id = false; // False if we are not UPDATING or SELECTING.
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Event</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/css/bootstrap.min.css" rel="stylesheet">
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
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h2>Edit Event</h2>
      </div>
      <div class="card-body">
        <!-- Display errors if any -->
        <?php if (!empty($errors)) : ?>
          <div class="alert alert-danger">
            <ul>
              <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <!-- Form for editing event details -->
        <form action="process_post.php" method="POST">
          <input type="hidden" name="id" value="<?= isset($event['event_id']) ? $event['event_id'] : ''; ?>">
          <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="event_name" name="event_name" value="<?= isset($event['event_name']) ? $event['event_name'] : ''; ?>" required>
          </div>
          <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <?php $event_date = isset($event['event_date']) ? date('Y-m-d', strtotime($event['event_date'])) : ''; ?>
            <input type="date" class="form-control" id="event_date" name="event_date" value="<?= $event_date ?>" required>
          </div>
          <div class="mb-3">
            <label for="event_location" class="form-label">Event Location</label>
            <input type="text" class="form-control" id="event_location" name="event_location" value="<?= isset($event['event_location']) ? $event['event_location'] : ''; ?>" required>
          </div>
          <div class="mb-3">
            <label for="event_description" class="form-label">Event Description</label>
            <textarea class="form-control" id="event_description" name="event_description" rows="4" required><?= isset($event['event_description']) ? $event['event_description'] : ''; ?></textarea>
          </div>
          <div class="mb-3">
            <label for="event_distance" class="form-label">Event Distance (in miles)</label>
            <select class="form-control form-control-lg custom-select" id="event_distance" name="event_distance" required>
              <option value="5K" <?= ($event['event_distance'] === '5K') ? 'selected' : ''; ?>>5K</option>
              <option value="10K" <?= ($event['event_distance'] === '10K') ? 'selected' : ''; ?>>10K</option>
              <option value="Half Marathon" <?= ($event['event_distance'] === 'Half Marathon') ? 'selected' : ''; ?>>Half Marathon</option>
              <option value="Marathon" <?= ($event['event_distance'] === 'Marathon') ? 'selected' : ''; ?>>Marathon</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="event_image_url" class="form-label">Event Image URL</label>
            <input type="url" class="form-control" id="event_image_url" name="event_image_url" value="<?= isset($event['event_image_url']) ? $event['event_image_url'] : ''; ?>" required>
          </div>
          <button type="submit" name="edit_event" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>