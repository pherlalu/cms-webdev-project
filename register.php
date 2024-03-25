<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: March 21, 2024
    Description: Register page

 ****************/

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  // Check if passwords match
  if ($password !== $confirmPassword) {
    $message = "Passwords do not match!";
  } else {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, 0)");
    $stmt->execute(array($username, $email, $hashedPassword));

    header('Location: login.php');
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

  <title>Register Page</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6 order-lg-2">
        <div class="form-container">
          <form class="form-signin p-4 rounded" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <h1 class="h3 mb-3 font-weight-normal text-center">Please register</h1>

            <label for="username" class="sr-only">Username</label>
            <input type="text" name="username" id="username" class="form-control mb-3" placeholder="Username" required autofocus>


            <label for="email" class="sr-only">Email</label>
            <input type="email" name="email" id="email" class="form-control mb-3" placeholder="Email Address" required autofocus>

            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" id="password" class="form-control mb-3" placeholder="Password" required>

            <label for="confirmPassword" class="sr-only">Confirm Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control mb-3" placeholder="Confirm Password" required>

            <?php if (isset($message)) : ?>
              <div class="alert alert-danger" role="alert">
                <?= $message ?>
              </div>
            <?php endif; ?>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
          </form>

          <div class="text-center mt-3">
            <a href="#!" class="forgot-password-link">Forgot password?</a>
            <p class="login-wrapper-footer-text">Already have an account? <a href="login.php" class="text-reset">Login here</a></p>
            <p class="mt-3 mb-0 text-muted">© 2017-2022</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 order-lg-1">
        <div class="img-container <?php if (empty($message)) echo 'animateL'; ?>">
          <div class="img-overlay p-4 rounded">
            <h1 class="h3 mb-3 font-weight-normal text-center text-white">Welcome to RunOutLoud!</h1>
            <p class="text-center text-white">Sign up to join us</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>