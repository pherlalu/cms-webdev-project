<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 19, 2024
    Updated: March 25, 2024
    Description: Manage Users page

 ****************/
include 'navbar.php';
include 'db_connect.php';

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
  // If the user is not an admin, redirect them to the home page
  header('Location: index.php');
  exit();
}

// Handle the delete event form submission
if (isset($_POST['delete_event'])) {
  $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

  // Delete the event from the database
  $stmt = $conn->prepare("DELETE FROM runevents WHERE event_id = ?");
  $stmt->execute(array($id));
}


// Get all runevents from the database
$stmt = $conn->prepare('SELECT * FROM runevents');
$stmt->execute();
$runevents = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/js/bootstrap.bundle.min.js"></script>
  <title>Manage Users</title>
</head>

<body>
  <div class="container py-5">
    <div class="row py-3">
      <div class="col-12">
        <h2 class="display-4">Manage Running Events Pages</h2>
      </div>
    </div>
    <table class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col" class="col-0.5">#</th>
          <th scope="col" class="col-1.5">Event Name</th>
          <th scope="col" class="col-1">Location</th>
          <th scope="col" class="col-2">Event Description</th>
          <th scope="col" class="col-1.5">Distance</th>
          <th scope="col" class="col-1.5">Event Date and Time</th>
          <th scope="col" class="col-1">Cover Image</th>
          <th scope="col" class="col-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1;
        foreach ($runevents as $runevent) : ?>
          <tr>
            <th scope="row"><?= $i++; ?></th>
            <td><?= htmlspecialchars($runevent['event_name']); ?></td>
            <td><?= htmlspecialchars($runevent['event_location']); ?></td>
            <td>
              <!-- displayed content is truncated to 100 characters. -->
              <?php if (strlen($runevent['event_description']) > 100) : ?>
                <?= substr($runevent['event_description'], 0, 100) ?>...
              <?php else : ?>
                <?= $runevent['event_description'] ?>
              <?php endif ?>
            </td>
            <td><?= htmlspecialchars($runevent['event_distance']); ?></td>
            <td><?= date("F d, Y H:i", strtotime($runevent['event_date'])) ?></td>
            <td>
              <img src="<?= empty($runevent['event_image_url']) ? 'assets/default/picture-not-available.jpg' : $runevent['event_image_url']  ?>" alt="Event Image" style="max-width: 100px;">

            <td class="align-middle">
              <div class="btn-group" role="group" aria-label="Event Actions">
                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
                  <input type="hidden" name="id" value="<?= $runevent['event_id']; ?>">
                  <button type="button" class="btn btn-outline-primary edit-button"><a href="editEvent.php?id=<?= $runevent['event_id']; ?> ">Edit</a></button>
                  <input type="submit" name="delete_event" value="Delete" class="btn btn-outline-danger">
                </form>

              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <a href="addEvent.php" class="btn btn-success mt-3">Add New Event</a>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>