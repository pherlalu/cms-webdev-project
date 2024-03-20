<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: 
    Description: Events page

 ****************/

include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 0)");
  $stmt->execute(array($username, $password));

  header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/css/bootstrap.min.css" rel="stylesheet">

  <title>Register Page</title>
</head>

<body>
  <div class="d-flex align-items-center justify-content-center vh-100">
    <form class="form-signin p-4 rounded shadow" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <h1 class="h3 mb-3 font-weight-normal text-center">Please register</h1>
      <label for="username" class="sr-only">Username</label>
      <input type="text" name="username" id="username" class="form-control mb-2" placeholder="Username" required autofocus>
      <label for="password" class="sr-only">Password</label>
      <input type="password" name="password" id="password" class="form-control mb-3" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
      <p class="mt-5 mb-3 text-muted text-center">© 2017-2022</p>
    </form>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>