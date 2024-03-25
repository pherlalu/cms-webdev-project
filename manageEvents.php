<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 19, 2024
    Updated: 
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

// Handle the add user form submission
if (isset($_POST['add_user'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $is_admin = isset($_POST['is_admin']) ? 1 : 0;

  // Insert the new user into the database
  $stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, ?)");
  $stmt->execute(array($username, $password, $is_admin));
}

// Handle the show edit form submission
if (isset($_POST['show_edit_user'])) {
  $id = filter_var($_POST['event_id'], FILTER_SANITIZE_NUMBER_INT);

  // Get the user's current details from the database
  $stmt = $conn->prepare('SELECT * FROM runevents WHERE id = ?');
  $stmt->execute(array($id));
  $user_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle the edit user form submission
if (isset($_POST['edit_user'])) {
  $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $is_admin = isset($_POST['is_admin']) ? 1 : 0;

  // Update the user's details in the database
  $stmt = $conn->prepare("UPDATE users SET username = ?, is_admin = ? WHERE id = ?");
  $stmt->execute(array($username, $is_admin, $id));
}

// Handle the delete user form submission
if (isset($_POST['delete_user'])) {
  $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

  // Delete the user from the database
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
  $stmt->execute(array($id));
}

// Get all users from the database
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
                  <input type="hidden" name="id" value="<?= $user['id']; ?>">
                  <button type="button" class="btn btn-outline-primary edit-button" data-bs-toggle="modal" data-bs-target="#myModal" data-id="<?= $user['id']; ?>" data-username="<?= htmlspecialchars($user['username']); ?>" data-is-admin="<?= $user['is_admin'] ? 'Yes' : 'No'; ?>">Edit</button>
                  <input type="submit" name="delete_user" value="Delete" class="btn btn-outline-danger">
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
  <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="id" value="<?= isset($_SESSION['user_to_edit']['id']) ? $_SESSION['user_to_edit']['id'] : ''; ?>">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" class="form-control" value="<?= isset($_SESSION['user_to_edit']['username']) ? htmlspecialchars($_SESSION['user_to_edit']['username']) : ''; ?>" required>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input" <?= isset($_SESSION['user_to_edit']['is_admin']) && $_SESSION['user_to_edit']['is_admin'] ? 'checked' : ''; ?>>
              <label for="is_admin" class="form-check-label">Admin</label>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" name="edit_user" value="Save changes" class="btn btn-primary">
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