<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: 
    Description: About page

 ****************/

include 'navbar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta1/css/bootstrap.min.css" rel="stylesheet">

  <title>About - RunOutLoud</title>
</head>

<body>
  <div class="container my-5">
    <div class="p-5 text-center bg-body-tertiary rounded-3">
      <img class="mt-4 mb-3" style="color: var(--bs-indigo);" width="auto" height="500" src="https://wallpaper.dog/large/20446652.jpg" alt="Your Image Description">

      <h1 class="text-body-emphasis">About RunOutLoud</h1>
      <p class="col-lg-8 mx-auto fs-5 text-muted">
        RunOutLoud is an organization specifically designed for running events such as marathons and fun runs. We serve as a comprehensive platform for runners and event organizers alike.
      </p>
    </div>
  </div>
  <div class="container my-5">
    <div class="p-5 text-center bg-body-tertiary rounded-3">

      <h1 class="text-body-emphasis">Objectives</h1>
      <div class="col-lg-8 mx-auto fs-5 text-muted">
        <ul class="text-left">
          <li>Enable users to stay informed about running events in their area through the website.</li>
          <li>Motivate participants to engage in physical activity and highlight the benefits of regular exercise.</li>
          <li>Foster local community involvement and stimulate participation in sports events.</li>
          <li>Utilize events (fundraising) as a platform to raise awareness and funds for specific causes or organizations.</li>
        </ul>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>