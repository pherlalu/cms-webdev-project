<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: March 21, 2024
    Description: Index page

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
</head>
<header>
  <style>
  </style>

  <div class="carousel-inner">
    <video style="min-width: 100%; min-height: 100%" playsinline autoplay muted loop>
      <source class="h-100" src="./assets/video/cebumarathon2024.mp4" type="video/mp4" />
    </video>
    <div class="mask" ">
      <div class=" d-flex justify-content-center align-items-center h-100">
      <div class="carousel-text1">
        <h1 class="text-white mb-3">RUN WHILE YOU CAN</h1>
        <h5 class="text-white mb-4">
          “RunOutLoud” gives you the latest running events such as marathons and fun runs.
        </h5>

        <a class="btn btn-outline-light btn-lg m-2" href="events.php" role="button">Find your event</a>

      </div>
    </div>
  </div>
  </div>
</header>

<!--Main layout-->
<main class="mt-5">
  <div class="container">
    <section>
      <div class="row">
        <div class="col-md-6 gx-5 mb-4">
          <div class="bg-image hover-overlay ripple shadow-2-strong" data-mdb-ripple-color="light">
            <img src="https://cdn.pixabay.com/photo/2015/10/03/21/58/sport-970443_1280.jpg" class="img-fluid" />
            <a href="#!">
              <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
            </a>
          </div>
        </div>

        <div class="col-md-6 gx-5 mb-4">
          <h4><strong>Why do people run marathons?</strong></h4>
          <p>By Anne McCarthy, Features correspondent, @annemitchmcc</p>
          <p class="text-muted">
            Marathoning has come a long way since. The winner ran a time of 2:58:50 – nowadays this would be a respectable time for an amateur, but it's almost an hour slower than the fastest runners today. We also now understand a great deal more about the science of long-distance running, from its health impacts to the psychological motivations.</p>

          <p class="text-muted">
            With no hopes of winning a gold medal or getting one's name etched in sport history books, some may wonder why people run marathons at all. The training requires a major commitment of time, energy and sweat, and the races can be gruelling.
          </p>

          <a href="https://www.bbc.com/future/article/20210929-why-do-people-run-marathons">
            <p><strong>Read more..</strong></p>
          </a>

        </div>
      </div>
    </section>

    <hr class="my-5" />

    <section class="text-center">
      <h4 class="mb-5"><strong>Marathon Facts</strong></h4>

      <div class="row">
        <div class="col-lg-4 col-md-12 mb-4">
          <div class="card">
            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
              <img src="https://wnymedia.s3.us-east-2.amazonaws.com/wp-content/uploads/2022/11/07091348/2022-TCS-New-York-City-Marathon-1280x720.jpg" class="img-fluid" />
              <a href="#!">
                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
              </a>
            </div>
            <div class="card-body">
              <h5 class="card-title">The Biggest Marathon</h5>
              <p class="card-text">
                In November 2016, 51,388 runners from over 120 countries finished the New York Marathon, making it the record holder for most participants in a race. It also gained an astronomical 18 million impressions on Facebook.
              </p>
              <a href="https://www.popsugar.co.uk/fitness/Surprising-Facts-Trivia-About-Marathon-Running-43411669" class="btn btn-primary">See More</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
              <img src="https://www.siberiantimes.com/PICTURES/OTHERS/coldest-marathon-earth-Boris-Fyodorov/standard%20runner%20Boris%20Fyodorov%20with%20yakutian%20Ekhee%20Dyyl.jpg" style="height: 236px; object-fit: cover;" class="img-fluid" />
              <a href="https://www.popsugar.co.uk/fitness/Surprising-Facts-Trivia-About-Marathon-Running-43411669">
                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
              </a>
            </div>
            <div class="card-body">
              <h5 class="card-title">The Coldest Marathon Ever</h5>
              <p class="card-text">
                Russian jeweller Boris Fyodorov completed his first marathon as a solo runner in -38°C on New Year's Day 2014. The beginner completed his 26.2 miles in just over 5 hours, in the town of Oymyakon, Russia, which is the coldest settlement on the planet.
              </p>
              <a href="https://www.popsugar.co.uk/fitness/Surprising-Facts-Trivia-About-Marathon-Running-43411669" class="btn btn-primary">See More</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
              <img src="https://blogimage.vantagefit.io/vfitimages/2022/10/calorie-burned-walking.png" class="img-fluid" />
              <a href="#!">
                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
              </a>
            </div>
            <div class="card-body">
              <h5 class="card-title">The Calories Burnt During a Marathon</h5>
              <p class="card-text">
                The number of calories burnt while running varies slightly for individuals, as weight, gender, and speed all play a role. But, it's widely understood that you burn up to 100 calories per mile, which means you'll burn a whopping 2,620 calories during a marathon!
              </p>
              <a href="https://www.popsugar.co.uk/fitness/Surprising-Facts-Trivia-About-Marathon-Running-43411669" class="btn btn-primary">See More</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <hr class="my-5" />
    <section class="mb-5">
      <h4 class="mb-5 text-center">
        <strong>Want to register an account?</strong>
      </h4>

      <div class="form-check d-flex justify-content-center mb-4">
        <a class="btn btn-primary  btn-lg mb-4" href="events.php" role="button"> Sign up</a>
      </div>
    </section>
  </div>
</main>

<?php include "footer.php"; ?>

</html>