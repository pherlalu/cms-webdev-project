<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: 
    Description: Race Details page

 ****************/

include 'navbar.php';
include 'db_connect.php';

if (isset($_GET['event_id'])) { // Retrieve blog to be edited, if id GET parameter is in URL.
  // Sanitize the id. Like above but this time from INPUT_GET.
  $id = filter_input(INPUT_GET, 'event_id', FILTER_SANITIZE_NUMBER_INT);

  // Check for non-numeric id, redirect the user back to the index page. 
  if (!is_numeric($id)) {
    header("Location: index.php");
    exit;
  }

  // Build the parametrized SQL query using the filtered id.
  $query = "SELECT * FROM runevents WHERE event_id = :event_id";
  $statement = $conn->prepare($query);
  $statement->bindValue(':event_id', $id, PDO::PARAM_INT);

  // Execute the SELECT and fetch the single row returned.
  $statement->execute();
  $event = $statement->fetch();

  // Check if valid statement, redirect the user back to the index page. 
  if (!$event) {
    header("Location: index.php");
    exit;
  }
} else {
  $id = false; // False if we are not UPDATING or SELECTING.
  $event = []; // Initialize $event as an empty array
}



function addReview($name, $comment)
{
  echo '<div class="media mt-5 mb-4">
              <img src="https://via.placeholder.com/50x50" alt="Reviewer Avatar" class="mr-3 rounded-circle">
              <div class="media-body">
                <h5 class="mt-0 mb-1">' . htmlspecialchars($name) . '</h5>
                <p>' . htmlspecialchars($comment) . '</p>
              </div>
            </div>';
}

if (isset($_POST['submit-review'])) {
  $name = $_POST['review-name'];
  $comment = $_POST['review-comment'];
  addReview($name, $comment);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Details</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e9T9hXmJ58bldgTk+" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 mt-3">
        <img src="<?= $event['event_image_url'] ?>" alt="Event Image" class="img-fluid">
      </div>
      <div class="col-md-6">
        <h1 class="display-4 mb-4">Event Details</h1>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group mb-3">
              <label for="event_name"><i class="fas fa-clipboard-list"></i> Event Name:</label>
              <input type="text" class="form-control" id="event_name" value="<?= $event['event_name'] ?>" readonly>
            </div>
            <div class="form-group mb-3">
              <label for="event-date"><i class="fas fa-calendar-alt"></i> Event Date:</label>
              <input type="text" class="form-control" id="event-date" value="<?= date("F d, Y", strtotime($event['event_date'])) ?>" readonly>
            </div>
            <div class="form-group mb-3">
              <label for="event-location"><i class="fas fa-map-marker-alt"></i> Event Location:</label>
              <input type="text" class="form-control" id="event-location" value="<?= $event['event_location'] ?>" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group mb-3">
              <label for="event-size"><i class="fas fa-users"></i> Event Size:</label>
              <input type="text" class="form-control" id="event-size" value="15000 - 29999 participants" readonly>
            </div>
            <div class="form-group mb-3">
              <label for="event-distance"><i class="fas fa-tachometer-alt"></i> Event Distance:</label>
              <input type="text" class="form-control" id="event-distance" value="<?= $event['event_distance'] ?>" readonly>
            </div>
            <div class="form-group mb-3">
              <label for="event-city"><i class="fas fa-city"></i> Event City:</label>
              <input type="text" class="form-control" id="event-city" value="<?= trim(explode(',', $event['event_location'])[0]) ?>" readonly>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 mt-5">
        <h3 class="display-6 mb-4">About the event</h3>
        <p class="lead">
          <?= $event['event_description'] ?>
        </p>



        <div class="col-md-6 mt-5">
          <h3 class="display-6 mb-4">Race Details:</h3>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Category</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Date:</td>
                <td><?= date("d M, Y (D)", strtotime($event['event_date'])) ?></td>

              </tr>
              <tr>
                <td>Start Time:</td>
                <td><?= date("g:i a", strtotime($event['event_date'])) ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6 mt-5">
        <img src="https://source.unsplash.com/random/900x500?running" alt="Event Image" class="img-fluid">
        <h3 class="display-6 mb-4 mt-5">Races offered by this event:</h3>
        <p class="lead">
          You have
          <strong><?= $days_until_event = (new DateTime($event['event_date']))->diff(new DateTime('now'))->days ?></strong>
          days to prepare for the <?= $event['event_name'] ?> running event on
          <?= date("F d, Y", strtotime($event['event_date'])) ?>.
        </p>
      </div>
    </div>

    <div class="container mt-5">
      <div class="row d-flex align-items-center">
        <div class="col-md-6 mx-auto mt-5">
          <h3 class="display-6 mb-4 text-center">Reviews:</h3>
          <div class="reviews-container text-center">
            <div class="review-item">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="far fa-star"></i>

            </div>
            <div class="ml-3 d-flex flex-column">
              <div>No reviews yet. Be the first to share your experience!</div>
              <form class="mt-5" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                  <label for="review-name">Name:</label>
                  <input type="text" class="form-control" id="review-name" name="review-name" required>
                </div>
                <div class="form-group">
                  <label for="review-comment">Comment:</label>
                  <textarea class="form-control" id="review-comment" name="review-comment" rows="3" required></textarea>
                </div>
                <button type="submit" name="submit-review" class="btn btn-primary">Submit</button>
              </form>

              <div class='media mt-5 mb-4'>
                <img src='https://via.placeholder.com/50x50' alt='Reviewer Avatar' class='mr-3 rounded-circle'>
                <div class='media-body'>
                  <h5 class='mt-0 mb-1'>{$name}</h5>
                  <p>{$comment}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybB5IXNxFw" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>