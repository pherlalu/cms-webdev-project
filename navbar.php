<?php


/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 19, 2024
    Updated: 
    Description: Navigation Bar page

 ****************/

session_start();
include 'db_connect.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="styles.css">
  <title>RunOutLoud</title>
</head>

<body class="p-0 m-0 border-0 bd-example m-0 border-0">

  <nav class="navbar navbar-dark bg-dark navbar-toast">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="./assets/logo/logo-svg.svg" alt="Bootstrap" width="50" height="auto" class="d-inline-block align-text-top" />
      </a>
      <ul class="nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="navbar-brand" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="navbar-brand" href="events.php">Events</a>
        </li>
        <li class="nav-item">
          <a class="navbar-brand" href="about.php">About</a>
        </li>
      </ul>
      <div style="display: flex; align-items: center;">
        <?php if (isset($_SESSION['user'])) : ?>
          <?php if ($_SESSION['is_admin'] == 1) : ?>
            <span class="navbar-text">User: Admin</span>
          <?php else : ?>
            <span class="navbar-text">User: Normal User</span>
          <?php endif; ?>
          <a class="navbar-brand" href="logout.php">
            <span class="navbar-text">
              <button class="btn btn-outline-success" type="button" style="margin: 0px 10px;">Logout</button>
            </span>
          </a>
        <?php else : ?>
          <a class="navbar-brand" href="login.php">
            <span class="navbar-text">
              <button class="btn btn-outline-success" type="button" style="margin-right: 10px;">Login</button>
            </span>
          </a>
        <?php endif; ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
          <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) : ?>
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
              User: Admin
            </h5>
          <?php else : ?>
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
              User: Normal User
            </h5>
          <?php endif; ?>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="events.php">Events</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="about.php">About</a>
            </li>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) : ?>
              <li class="nav-item">
                <a class="nav-link active" href="manageUsers.php">Manage Users</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link active" href="manageEvents.php">
                  Manage Events Pages
                </a>
              </li>
            <?php endif; ?>
          </ul>
          <form class="d-flex mt-3" role="search" method="post" action="search_results.php">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" />
            <button class="btn btn-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </div>
  </nav>
  <!-- Toast Container -->
  <div class="toast-container">
    <?php if (isset($_SESSION['login_success'])) : ?>
      <div class="toast align-items-center bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            <?= $_SESSION['login_success'] ?>
          </div>
          <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
      <?php unset($_SESSION['login_success']); // Unset the session variable after displaying the message 
      ?>
    <?php endif; ?>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      var toastElList = [].slice.call(document.querySelectorAll('.toast'))
      var toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl, {
          autohide: true,
          delay: 3000
        }) // Autohide after 3 seconds
      });
      toastList.forEach(toast => toast.show()); // This show them
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>