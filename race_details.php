<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: 
    Description: Race Details page

 ****************/
ob_start();
include 'navbar.php';
include 'db_connect.php';
include 'functions.php';

if (isset($_GET['event_id'])) {

  $id = filter_input(INPUT_GET, 'event_id', FILTER_SANITIZE_NUMBER_INT);

  if (!is_numeric($id)) {
    header("Location: index.php");
    exit;
  }

  $query = "SELECT * FROM runevents WHERE event_id = :event_id";
  $statement = $conn->prepare($query);
  $statement->bindValue(':event_id', $id, PDO::PARAM_INT);

  $statement->execute();
  $event = $statement->fetch();

  if (!$event) {
    header("Location: index.php");
    exit;
  }
  $query = "SELECT c.*, u.username as user_name 
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.event_id = :event_id
            ORDER BY c.comment_date DESC";
  $statement = $conn->prepare($query);
  $statement->bindValue(':event_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $comments = $statement->fetchAll();
} else {
  $id = false;
  $event = [];
  $comments = [];
}
if (isset($_GET['error']) && !empty($_GET['error'])) {
  $messageError = $_GET['error'];
} else {
  $messageError = "";
}
if (isset($_POST['submit-review'])) {
  $comment = $_POST['review-comment'];
  $event_id = $_POST['event_id'];
  $userID = getCurrentUserID();
  $messageError = "";
  // Validate the CAPTCHA
  if (!validateCaptcha($_POST['captcha-input'])) {
    // Display an error message
    $messageError = "The CAPTCHA code you entered is incorrect. Please try again.";
    header("Location: race_details.php?event_id=$event_id&error=$messageError");
    exit;
  } else {
    $query = "INSERT INTO comments (user_id, name, comment_text, comment_date, event_id) VALUES (:userID, :name, :comment, NOW(), :event_id)";
    $statement = $conn->prepare($query);
    if ($userID) {
      $statement->bindValue(':userID', $userID);
      $statement->bindValue(':name', getCurrentUserName());
    } else {
      $name = $_POST['review-name'];
      $statement->bindValue(':userID', null);
      $statement->bindValue(':name', $name);
    }
    $statement->bindValue(':comment', $comment);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    header("Location: race_details.php?event_id=$event_id");
    unset($messageError);
    exit;
  }
}
ob_end_flush();
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
          <?= htmlspecialchars_decode($event['event_description'], ENT_QUOTES) ?>
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
        <hr>
        <div class="col-md-6 mx-auto mt-5">
          <h3 class="display-6 text-center">Reviews:</h3>
          <div class="reviews-container text-center">

            <div class="ml-3 d-flex flex-column">
              <div>
                <?= empty($comments) ? "No reviews yet. Be the first to share your experience!" : "Feel free to share your experience!" ?>
              </div>
              <form class="mt-5" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                <?php $userID = getCurrentUserID(); ?>
                <?php if ($userID == 0) : ?>
                  <div class="form-group">
                    <label for="review-name">Name:</label>
                    <input type="text" class="form-control" id="review-name" name="review-name" placeholder="Enter your name.." required>
                  </div>
                <?php endif; ?>

                <div class="form-group">
                  <label for="review-comment">Comment:</label>
                  <textarea class="form-control" id="review-comment" name="review-comment" placeholder="Share your experience.." rows="3" required></textarea>
                </div>
                <div class="form-group">
                  <img src="captcha_image.php" alt="CAPTCHA" id="captcha-image" class="img-fluid rounded" style="height: 50px; border: 1px solid black; margin-top: 10px;">
                  <p class="text-danger">
                    <?= !empty($messageError) ? $messageError : "" ?>
                  </p>
                </div>
                <div class="form-group">
                  <label for="captcha-input">Enter the CAPTCHA text:</label>
                  <input type="text" class="form-control" id="captcha-input" placeholder="Enter the CAPTCHA code above.." name="captcha-input" required>
                </div>
                <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                <button type="submit" name="submit-review" class="btn btn-primary mt-3 mb-5">Submit</button>
              </form>


            </div>
          </div>
        </div>
        <hr>
        <div class="media  mb-4">
          <?php foreach ($comments as $comment) : ?>
            <div class="card mt-5 mb-4">
              <div class="card-body">
                <div class="media">
                  <img src='https://source.unsplash.com/random/50x50?profile' alt='Reviewer Avatar' class='mr-3 rounded-circle'>
                  <div class='media-body'>
                    <h5 class='mt-0 mb-1'><?= htmlspecialchars($comment['name']) ?></h5>
                    <div class="review-item">
                      <?php for ($i = 0; $i < 5; $i++) : ?>
                        <i class="fas fa-star"></i>
                      <?php endfor; ?>
                      <?php for ($i = 5; $i < 5; $i++) : ?>
                        <i class="far fa-star"></i>
                      <?php endfor; ?>
                    </div>
                    <p><?= htmlspecialchars($comment['comment_text']) ?></p>
                    <p><?= date("F d, Y", strtotime($comment['comment_date'])) ?></p>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybB5IXNxFw" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
      $(document).ready(function() {
        $('#review-form').on('submit', function(event) {
          // validate captcha
          var captchaInput = $('#captcha-input').val();
          var captcha = $('#captcha-image').attr('src').split('&')[1].split('=')[1];
          if (captchaInput != captcha) {
            // Display an error message
            $('.form-group p.text-danger').text("The CAPTCHA code you entered is incorrect. Please try again.");
            event.preventDefault();
            return false;
          }
        });
      });
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>