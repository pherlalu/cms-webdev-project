<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: 
    Description: Login page

 ****************/

session_start();

include 'db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

  <title>Sign In</title>

  <style>
    html,
    body {
      height: 100%;
    }

    .form-signin {
      width: 100%;
      max-width: 330px;
      padding: 15px;
      margin: auto;
    }
  </style>
</head>

<body>
  <div class="d-flex align-items-center justify-content-center vh-100">
    <form class="form-signin p-4 rounded shadow" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <h1 class="h3 mb-3 font-weight-normal text-center">Please sign in</h1>
      <label for="username" class="sr-only">Username</label>
      <input type="text" name="username" id="username" class="form-control mb-2" placeholder="Username" required autofocus>
      <label for="password" class="sr-only">Password</label>
      <input type="password" name="password" id="password" class="form-control mb-3" placeholder="Password" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2022</p>
    </form>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $username = $_POST['username'];
  $password = sha1($_POST['password']);

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1 ");
  $stmt->execute(array($username, $password));
  $checkuser = $stmt->rowCount();
  $user = $stmt->fetch();

  if ($checkuser > 0) {
    $_SESSION['user'] = $user['username'];
    $_SESSION['is_admin'] = $user['is_admin'];
    header('location: home.php');
  }
}

?>