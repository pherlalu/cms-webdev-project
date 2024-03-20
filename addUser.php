<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 19, 2024
    Updated: 
    Description: Events page

 ****************/

include 'navbar.php';
include 'db_connect.php';

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
  // If the user is not an admin, redirect them to the home page
  header('Location: index.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize and validate the username
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  if (empty($username)) {
    die('Error: Username is required.');
  }

  // Hash the password
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  if (empty($password)) {
    die('Error: Password is required.');
  }

  // Validate the is_admin checkbox
  $is_admin = isset($_POST['is_admin']) ? 1 : 0;

  // Insert the new user into the database
  $stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, ?)");
  $stmt->execute(array($username, $password, $is_admin));

  // Redirect the user to the manage users page
  header('Location: manageUsers.php');
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/css/bootstrap.min.css" rel="stylesheet">

  <title>Add New User</title>
</head>

<body>
  <div class="container">
    <h1 class="mt-5 text-center">Add New User</h1>
    <form class="mt-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <div class="form-group form-check">
        <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input">
        <label for="is_admin" class="form-check-label">Admin</label>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Add User</button>
    </form>
  </div>
</body>

</html>