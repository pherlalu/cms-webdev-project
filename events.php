<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: 
    Description: Events page

 ****************/

include 'navbar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <title>Bootstrap Example</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="position-relative overflow-hidden text-center bg-body-tertiary" style="background-image: url('https://cdn.pixabay.com/photo/2013/11/14/20/52/sports-210661_1280.jpg'); background-size: cover;">
    <div class="col-md-6 p-lg-5 mx-auto my-5">
      <h1 class="display-3 fw-bold">Get up and run!</h1>
      <h3 class="fw-normal text-muted mb-3">The body achieves what the mind believes.</h3>
      <div class="card text-center">
        <div class="card-header">
          Search for events
        </div>
        <div class="card-body">
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">

            <div class="btn-group ms-2">
              <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Large button
              </button>
              <ul class="dropdown-menu">
                ...
              </ul>
            </div>
            <button class="btn btn-outline-success ms-2" type="submit">Search</button>
          </form>

        </div>
        <div class="card-footer text-body-secondary">
          RunOutLoud
        </div>
      </div>
    </div>
  </div>


  <div class="card text-center">


    <?php

    include 'eventResults.php';

    include 'footer.php';

    ?>
  </div>
</body>

</html>