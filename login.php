<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: March 21, 2024
    Description: Login page

 ****************/
session_start();
include 'db_connect.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
  $stmt->execute(array($username));
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['username'];
    $_SESSION['is_admin'] = $user['is_admin'];
    $_SESSION['login_success'] = 'Successfully logged in!';
    if ($_SESSION['is_admin'] == 0) {
      header('location: index.php');
    }
    if ($_SESSION['is_admin'] == 1) {
      header('location: index.php');
    }
  } else {
    $message = 'Invalid username or password';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <link rel="stylesheet" href="styles.css">
  <title>Sign In</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6">
        <div class="form-container ">
          <form class="form-signin p-4 rounded" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <h1 class="h3 mb-3 font-weight-normal text-center">Welcome to RunOutLoud!</h1>

            <label for="username" class="sr-only">Username</label>
            <input type="text" name="username" id="username" class="form-control mb-3" placeholder="Username" required autofocus>

            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" id="password" class="form-control mb-3" placeholder="Password" required>

            <?php if (!empty($message)) : ?>
              <div class="alert alert-danger" role="alert">
                <?= $message ?>
              </div>
            <?php endif; ?>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
          </form>

          <div class="text-center mt-3">
            <a href="#!" class="forgot-password-link">Forgot password?</a>
            <p class="login-wrapper-footer-text">Don't have an account? <a href="register.php" class="text-reset">Register here</a></p>
            <p class="login-wrapper-footer-text"><a href="index.php" class="text-reset">Go Back to Homepage</a></p>
            <p class="mt-3 mb-0 text-muted">© 2024</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="img-container  <?php if (empty($message)) echo 'animateR'; ?>">
          <div class="img-overlay p-4 rounded">
            <h1 class="h3 mb-3 font-weight-normal text-center text-white">Welcome to RunOutLoud!</h1>
            <p class="text-center text-white">Login in your account and Get Started.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>