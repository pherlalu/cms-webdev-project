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
  <header class="container-fluid bg-secondary text-white py-5 mb-5 position-relative">
    <div class="container text-center">
      <h1 class="display-4">About RunOutLoud</h1>
      <p class="lead mb-0">
        Our purpose, our mission, and our story
      </p>
    </div>
  </header>

  <div class="container my-5">
    <div class="row">
      <div class="col-md-6">
        <h2 class="text-body-emphasis">
          <i class="bi bi-house-door-fill me-3 text-primary"></i>
          Our Purpose
        </h2>
        <p class="lead">
          RunOutLoud is an organization created to bring running events such as marathons and fun runs to the forefront.
          We serve as a central hub for runners and event organizers alike, offering a comprehensive platform for
          staying informed, staying active, and staying connected.
        </p>
      </div>
      <div class="col-md-6">
        <img class="img-fluid rounded-3 mb-4" src="https://source.unsplash.com/random/900x500?running" alt="Running event image">
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <img class="img-fluid rounded-3 mb-4" src="https://source.unsplash.com/random/900x500?running-goals" alt="Running goals image">
      </div>
      <div class="col-md-6">
        <h2 class="text-body-emphasis">
          <i class="bi bi-check2-circle text-success me-3"></i>
          Our Objectives
        </h2>
        <ul class="lead text-muted">
          <li>Enable users to stay informed about running events in their area through the website.</li>
          <li>Motivate participants to engage in physical activity and highlight the benefits of regular exercise.</li>
          <li>Foster local community involvement and stimulate participation in sports events.</li>
          <li>Utilize events (fundraising) as a platform to raise awareness and funds for specific causes or
            organizations.</li>
        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <h2 class="text-body-emphasis">
          <i class="bi bi-people-fill text-info me-3"></i>
          Our Team
        </h2>
        <p class="lead">
          Our team is a diverse group of passionate individuals committed to promoting active lifestyles and community
          engagement through running events.
        </p>
        <p class="lead">
          We are runners, organizers, and supporters who believe in the power of running to bring people together and
          make a positive impact on local communities.
        </p>
      </div>
      <div class="col-md-6">
        <img class="img-fluid rounded-3 mb-4" src="https://source.unsplash.com/random/900x500?team-spirit" alt="Team spirit image">
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <h2 class="text-body-emphasis">
          <i class="bi bi-star-fill text-warning me-3"></i>
          Our Impact
        </h2>
        <p class="lead">
          Since our inception, RunOutLoud has helped thousands of runners connect with events and organizations in their
          communities.

        </p>
        <p class="lead"> We are proud to have facilitated numerous fundraising campaigns, supported local causes, and
          encouraged a healthier lifestyle for participants of all ages and abilities. </p>
      </div>
      <div class="col-md-6"> <img class="img-fluid rounded-3 mb-4" src="https://source.unsplash.com/random/900x500?runner-medal" alt="Runner medal image"> </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <h2 class="text-body-emphasis"> <i class="bi bi-telephone-fill text-primary me-3"></i> Get in Touch </h2>
        <p class="lead"> For media inquiries, partnership opportunities, or any questions, please reach out to us
          through the contact form below. </p>
      </div>
      <div class="col-md-6"> <img class="img-fluid rounded-3 mb-4" src="https://source.unsplash.com/random/900x500?contact-form" alt="Contact form image"> </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>