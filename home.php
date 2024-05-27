<?php
session_start();
include "functionLogic.php";

if (!isset($_SESSION['id'])) {
  $login_text = "Login";
  $login_class = "login-btn";
} else {
  $login_class = " ";
  $login_text = " ";
  $id = $_SESSION['id'];
  $photo = $connection->query("SELECT * FROM user WHERE id = $id");
  $image_profile = $photo->fetch_object();
  $profile = "<form action='profile.php'>
  <button class='profile'>Profile <img class='imgprof' src='img/$image_profile->photo' alt=''></button>
</form>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://kit.fontawesome.com/da6c47344b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  <title>Bluebuk</title>
</head>

<body class="home-page">
  <header>
    <nav class="p-4">
      <div class="container-fluid row">
        <div class="col-3">
          <a class="navbar-brand" href="#">
            Bluebuk.
          </a>

        </div>
        <div class="col-6 text-center">
          <ul class="nav justify-content-center ms-4">
            <li>
              <a class="active" aria-current="page" href="home.php">Home</a>
            </li>
            <li>
              <a href="activity.php">Activity</a>
            </li>
            <li>
              <a href="resort.php">Resort</a>
            </li>
            <li>
              <a href="contactus.php">Contact Us</a>
            </li>
          </ul>
        </div>
        <div class="col-3">
          <a class="<?= $login_class ?>" id="login" href="login.php"><?= $login_text ?></a>
          <?php if (isset($profile)) echo $profile ?>
        </div>
      </div>
    </nav>
  </header>

  <div class="upperpage">
    <h1><b>Bluebuk.</b></h1>
    <form class="box">
      <input type="search" placeholder="Search">
      <a href="">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-search" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
        </svg>
      </a>
    </form>
  </div>

  <div class="act">
    <h1>Our Activity</h1>
    <h4>Make waves of memories at our beachside getaway!</h4>
    <div class="row">
      <div class="act-img col-3">
        <a href="activity.php"><img src="img/2.png" class="card-img-top" alt="HTML tutorial"></a>
        <div class="imgtxtcenter">Diving</div>
      </div>

      <div class="act-img col-3">
        <a href="activity.php"><img src="img/1.png" class="card-img-top" alt="HTML tutorial"></a>
        <div class="imgtxtcenter">Surfing</div>
      </div>

      <div class="act-img col-3">
        <a href="activity.php"><img src="img/3.png" class="card-img-top" alt="HTML tutorial"></a>
        <div class="imgtxtcenter">Snorkeling</div>
      </div>

      <div class="act-img col-3">
        <a href="activity.php"><img src="img/4.png" class="card-img-top" alt="HTML tutorial"></a>
        <div class="imgtxtcenter">Jet Ski</div>
      </div>
    </div>
    <form action="activity.php">
      <button>Learn More</button>
    </form>
  </div>

  <!-- <h1 class="rst-caption">Check Our Resort & Hotel</h1> -->
  <div class="crs-box"></div>
  <div class="carousel">
    <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/rst.png" class="d-block w-100" alt="Resort">
        </div>
        <div class="carousel-item">
          <img src="img/rst2.png" class="d-block w-100" alt="Resort">
        </div>
        <div class="carousel-item">
          <img src="img/rst3.png" class="d-block w-100" alt="Resort">
        </div>
      </div>
      <div class="caption">
        <h1><b>Bluebuk Resort</b></h1>
        <h3>A perfect place for your vacation stay.</h3>
        <form action="resort.php">
          <button class="book">Learn More</button>
        </form>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <h2 class="about ms-5 mt-5"><b>Welcome to Bluebuk Beach & Resort</b></h2>
  <div class="underpage row">
    <div class="reason col">
      <h4>Escape to Your Dream Beach Getaway</h4>
      <p>At Bluebuk Beach & Resort, we invite you to experience the ultimate beachfront retreat. Nestled along the pristine shores oF Bluebuk beach, our resort offers a haven of tranquility and luxury amidst breathtaking natural beauty. Whether you're seeking a romantic getaway, a family vacation, or simply a rejuvenating escape, Paradise Cove has everything you need for an unforgettable experience</p>
      <br>
      <h4>Explore the Surroundings</h4>
      <p>Beyond the resort, Bluebuk Beach & Resort offers a wealth of attractions and activities to explore:</p>
      <ul>
        <li>Beachcombing and Sunbathing: Spend your days lounging on the soft sands, soaking up the sun, and taking leisurely walks along the shoreline.</li>
        <li>Local Excursions: Discover the natural wonders and cultural treasures of the area with guided tours, hiking adventures, and visits to nearby attractions.</li>
        <li>Shopping and Dining: Immerse yourself in the local culture with visits to charming seaside towns, artisanal markets, and authentic restaurants serving regional specialties.</li>
      </ul>
    </div>

    <div class="reason col">
      <h4>Discover Our Amenities</h4>
      <p>From luxurious accommodations to world-class amenities, Bluebuk Beach & Resort has something for everyone to enjoy:</p>
      <ul>
        <li>Luxurious Accommodations: Choose from a variety of stylishly appointed rooms, suites, and beachfront villas, each designed to provide the utmost comfort and relaxation.</li>
        <li>Beachfront Dining: Indulge your palate with exquisite cuisine and breathtaking ocean views at our on-site restaurants and bars, serving a tantalizing selection of fresh seafood, international dishes, and tropical cocktails.</li>
        <li>Infinity Pool and Spa: Relax and unwind poolside at our infinity pool, offering stunning views of the ocean. For ultimate relaxation, pamper yourself with a rejuvenating spa treatment at our full-service spa.</li>
        <li>Water Sports and Activities: Embark on exciting adventures with our range of water sports and activities, including snorkeling, diving, Surfing, and more. Our dedicated staff are on hand to help you make the most of your beach experience.</li>
        <li>Weddings and Events: Say "I do" in paradise with our stunning beachfront wedding venues and personalized event planning services. Whether you're planning a romantic beach wedding or a corporate retreat, Paradise Cove offers the perfect setting for any occasion.</li>
      </ul>
    </div>
  </div>
  <div class="reason">
    <h4>Plan Your Stay</h4>
    <p>Ready to experience the beauty and luxury of Bluebuk Beach & Resort? Explore our website to learn more about our accommodations, amenities, and <br>special offers. Book your stay today and start counting down the days until your dream beach getaway.</p>
  </div><br>

  <h2 style="text-align: center;"><b>Our Customer Reviews</b></h2>
  <div class="scrollrating">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h3>Winter&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></h3><br>
          <p>This is a very nice place to stay!</p><br>
          <h6>2 weeks ago &emsp;&emsp;&emsp;&emsp;
            <button onclick="likeactive('like1')"><i class="fa-regular fa-thumbs-up" id="like1"></i></button></h6>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h3>Karina&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></h3><br>
          <p>Amazing dive spots, saw so much marine life!</p><br>
          <h6>1 month ago &emsp;&emsp;&emsp;&emsp;
            <button onclick="likeactive('like2')"><i class="fa-regular fa-thumbs-up" id="like2"></i></button></h6>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h3>Zilong&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></h3><br>
          <p style="margin-bottom: 25px;">Incredible resort, beachfront access makes<br>everything easy!</p>
          <h6>1 week ago &emsp;&emsp;&emsp;&emsp;
            <button onclick="likeactive('like3')"><i class="fa-regular fa-thumbs-up" id="like3"></i></button></h6>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h3>Jeremy&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></h3><br>
          <p>Jet ski rentals available, fun for the whole family!</p><br>
          <h6>3 months ago &emsp;&emsp;&emsp;&emsp;
            <button onclick="likeactive('like4')"><i class="fa-regular fa-thumbs-up" id="like4"></i></button></h6>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h3>Alexa&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></h3><br>
          <p style="margin-bottom: 25px;">Snorkeling gear provided, hassle-free and<br>enjoyable!</p>
          <h6>2 months ago &emsp;&emsp;&emsp;&emsp;
            <button onclick="likeactive('like5')"><i class="fa-regular fa-thumbs-up" id="like5"></i></button></h6>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h3>Aamon&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></h3><br>
          <p style="margin-bottom: 25px;">Jet skiing with friends, unforgettable <br> memories made!</p>
          <h6>1 month ago &emsp;&emsp;&emsp;&emsp;
            <button onclick="likeactive('like6')"><i class="fa-regular fa-thumbs-up" id="like6"></i></button></h6>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h3>Berry&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></h3><br>
          <p style="margin-bottom: 25px;">Beachside bonfires after a day of fun, <br>magical evenings!</p>
          <h6>3 months ago &emsp;&emsp;&emsp;&emsp;
            <button onclick="likeactive('like7')"><i class="fa-regular fa-thumbs-up" id="like7"></i></button></h6>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h3>Keyla&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></h3><br>
          <p style="margin-bottom: 25px;">Beachfront lounging after activities, pure <br>relaxation!</p>
          <h6>2 months ago &emsp;&emsp;&emsp;&emsp;
            <button onclick="likeactive('like8')"><i class="fa-regular fa-thumbs-up" id="like8"></i></button></h6>
        </div>
      </div>
    </div>
  </div>




  <footer>
    <div class="row">
      <div class="col-md-4">
        <h3>Contact Us</h3>
        <a href="">Bluebook@gmail.com</a>
        <p>086-43131</p>
      </div>
      <div class="col-md-4">
        <h3>Address</h3>
        <p>555 Elmwood Avenue, Apartment 301
          Sunset Valley Apartments
          Suite B-17
          Willow Creek, California 98765
          United States</p><br>
        <br>
        <h6 style="font-size: 10px;">copyright <i class="bi-c-circle"></i> Bluebuk Creator Teams</h6>
      </div>
      <div class="col-md-4">
        <div class="items">
          <h3>Follow Us</h3>
          <div class="icons">
            <i class="bi bi-instagram"></i>
            <i class="bi bi-twitter-x"></i>
            <i class="bi bi-youtube"></i>
            <i class="bi bi-tiktok"></i>
          </div><br>
          <div class="creator">
            <h3>Creator</h3>
            <a href="creator">Aliyan Alfin</a><br>
            <a href="creator">Aurelia Rana</a>
          </div>
        </div>

      </div>

    </div>

  </footer>
</body>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
    let likeButtons = document.querySelectorAll(".fa-thumbs-up");
    likeButtons.forEach(function(button) {
      let isLiked = localStorage.getItem(button.id);
      if (isLiked === "true") {
        button.classList.remove("fa-regular");
        button.classList.add("fa-solid");
      } else {
        button.classList.remove("fa-solid");
        button.classList.add("fa-regular");
      }
    });
  });

  function likeactive(buttonId) {
    let likeButton = document.getElementById(buttonId);
    if (likeButton.classList.contains("fa-regular")) {
      likeButton.classList.remove("fa-regular");
      likeButton.classList.add("fa-solid");
      localStorage.setItem(buttonId, "true");
    } else {
      likeButton.classList.remove("fa-solid");
      likeButton.classList.add("fa-regular");
      localStorage.setItem(buttonId, "false");
    }
  }
  </script>

</html>
