<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: 
    Description: About page

 ****************/

include 'navbar.php';
include 'sendemail.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>About - RunOutLoud</title>
</head>

<body>
  <header class="container-fluid  py-5 mb-5 position-relative">
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
      <div class="col-md-6"> <img class="img-fluid rounded-3 mb-4" src="https://source.unsplash.com/random/900x500?runner-medal" alt="Runner medal image"> </div>
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

    </div>
    <div class="row">
      <div class="col-md-6">
        <h2 class="text-body-emphasis"> <i class="bi bi-telephone-fill text-primary me-3"></i> Get in Touch </h2>
        <p class="lead"> For media inquiries, partnership opportunities, or any questions, please reach out to us
          through the contact form below. </p>
        <form class="lead" method="post">
          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
          </div>
          <div class="form-group">
            <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Send</button>
        </form>
      </div>
      <div class="col-md-6 d-flex align-items-center justify-content-center">
        <div class="card bg-light shadow p-4">
          <h2 class="card-title text-body-emphasis mb-4">
            <i class="bi bi-people-fill text-info me-3"></i>
            Contact Us
          </h2>
          <div class="card-body">
            <div class="contact-info lead">
              <div><i class="fas fa-map-marker-alt me-2"></i> Winnipeg City, Manitoba, Canada</div>
              <div><i class="fas fa-envelope me-2"></i> runoutloud@gmail.com</div>
              <div><i class="fas fa-phone me-2"></i> +1 800 111 222</div>
            </div>
          </div>
        </div>
      </div>


    </div>

    <!-- Toast Alert Container -->
    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 11">
      <?php echo $alert; ?>
    </div>

    <?php include 'footer.php'; ?>


    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
    <script>
      const constraints = {
        name: {
          presence: {
            allowEmpty: false
          }
        },
        email: {
          presence: {
            allowEmpty: false
          },
          email: true
        },
        message: {
          presence: {
            allowEmpty: false
          }
        }
      };

      const form = document.getElementById('contact-form');
      form.addEventListener('submit', function(event) {

        const formValues = {
          name: form.elements.name.value,
          email: form.elements.email.value,
          message: form.elements.message.value
        };


        const errors = validate(formValues, constraints);
        if (errors) {
          event.preventDefault();
          const errorMessage = Object
            .values(errors)
            .map(function(fieldValues) {
              return fieldValues.join(', ')
            })
            .join("\n");

          alert(errorMessage);
        }
      }, false);

      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }
    </script>

</body>

</html>