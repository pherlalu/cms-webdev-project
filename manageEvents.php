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

// Handle the edit event form submission
if (isset($_POST['edit_event'])) {
  $id = filter_var($_POST['event_id'], FILTER_SANITIZE_NUMBER_INT);
  $eventname = filter_input(INPUT_POST, 'eventname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $is_active = isset($_POST['is_active']) ? 1 : 0;

  // Update the event's details in the database
  $stmt = $conn->prepare("UPDATE runevents SET eventname = ?, is_active = ? WHERE id = ?");
  $stmt->execute(array($eventname, $is_active, $id));
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
          <th scope="col" class="col-1">#</th>
          <th scope="col" class="col-2">Event Name</th>
          <th scope="col" class="col-1">Event Location</th>
          <th scope="col" class="col-2">Event Description</th>
          <th scope="col" class="col-1">Event Distance</th>
          <th scope="col" class="col-1">Event Date</th>
          <th scope="col" class="col-1">Event Cover Image</th>
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
            <td> <!-- displayed content is truncated to 100 characters. -->
              <?php if (strlen($runevent['event_description']) > 100) : ?>
                <?= substr($runevent['event_description'], 0, 100) ?>...
              <?php else : ?>
                <?= $runevent['event_description'] ?>
              <?php endif ?>
            </td>
            <td><?= htmlspecialchars($runevent['event_distance']); ?></td>
            <td><?= date("F d, Y", strtotime($runevent['event_date'])) ?></td>
            <td>
              <img src="<?= $runevent['event_image_url'] ?>" alt="Event Image" style="max-width: 100px;">
            </td>
            <td class="align-middle">
              <div class="btn-group" role="group" aria-label="Event Actions">
                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
                  <input type="hidden" name="id" value="<?= $runevent['event_id']; ?>"> <!-- Use event_id -->
                  <button type="button" class="btn btn-outline-primary edit-button" data-bs-toggle="modal" data-bs-target="#addEventModal" data-id="<?= $user['id']; ?>" data-username="<?= htmlspecialchars($user['username']); ?>" data-is-admin="<?= $user['is_admin'] ? 'Yes' : 'No'; ?>">Edit</button>
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
  <!-- Add Event Modal -->
  <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="addEvent.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="event_name" class="form-label">Event Name</label>
              <input type="text" class="form-control" id="event_name" name="event_name" required>
            </div>
            <div class="mb-3">
              <label for="event_date" class="form-label">Event Date</label>
              <input type="date" class="form-control" id="event_date" name="event_date" required>
            </div>
            <div class="mb-3">
              <label for="event_location" class="form-label">Event Location</label>
              <input type="text" class="form-control" id="event_location" name="event_location" required>
            </div>
            <div class="mb-3">
              <label for="event_description" class="form-label">Event Description</label>
              <textarea class="form-control" id="event_description" name="event_description" rows="5" required></textarea>
            </div>
            <div class="mb-3">
              <label for="event_distance" class="form-label">Event Distance (in miles)</label>
              <select class="form-control form-control-lg custom-select" id="event_distance" name="event_distance" required>
                <option value="5K">5K</option>
                <option value="10K">10K</option>
                <option value="Half Marathon">Half Marathon</option>
                <option value="Marathon">Marathon</option>
                <option value="Other">Other</option>
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
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <?php include 'footer.php'; ?>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.edit-button').click(function(e) {
        var id = $(this).data('id');
        var username = $(this).data('username');
        var isAdmin = $(this).data('is-admin') === 'Yes' ? true : false;

        $('input[name="id"]').val(id);
        $('#username').val(username);
        $('#is_admin').prop('checked', isAdmin);
      });
    });
  </script>

</body>

</html>