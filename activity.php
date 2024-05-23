<?php
session_start();
include 'functionLogic.php';
if (!isset($_SESSION['id'])) {
    $login_text = "Login";
    $login_class = "login-btn";
    $must_login = "loginfirst";
} else {
    $login_class = " ";
    $login_text = " ";
    $id = $_SESSION['id'];
    $photo = $connection->query("SELECT * FROM user WHERE id = $id");
    $img_profile = $photo->fetch_object();
    $profile = "<form action='profile.php'>
  <button class='profile'>Profile <img class='imgprof' src='img/$img_profile->photo' alt=''></button>
</form>";
    $must_login = "bookform";
}

if (isset($_POST['booking-button'])) {
    if (act_booking($_SESSION["id"], $_POST) > 0) {
        echo "<script>
                alert('Berhasil booking!, silahkan cek di profil anda!');
            </script>";
    } else {
        echo "<script>
                alert('Gagal booking!');
            </script>";
    }
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
    <title>Activity</title>
</head>

<body class="activity-page">
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
                            <a href="home.php">Home</a>
                        </li>
                        <li>
                            <a class="active" aria-current="page" href="activity.php">Activity</a>
                        </li>
                        <li>
                            <a href="resort.php">Resort</a>
                        </li>
                        <li>
                            <a href="contact">Contact Us</a>
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

    <!-- 
    <div class="act-list">
        <h1 id="textabove">See Our Activity</h1>
        <div class="act-item">

        </div>
    </div> -->


    <div class="act-list">
        <h1 id="textabove">See Our Activity</h1>
        <div class="act-item">
            <div class="act-info-left">
                <h2><b>Diving</b></h2>
                <ul>
                    <li>Explore vibrant underwater worlds</li>
                    <li>Dive into history and uncover hidden treasures</li>
                    <li>Encounter sea turtles, manta rays, and more</li>
                    <li>Witness bioluminescent wonders under the stars</li>
                    <li>Capture the magic with photography and videography</li>
                </ul>
                <h5><b>Start from Rp500.000/pax</b></h5>
                <a class="button" onclick=modalPopUp(1)>Reserve</a>
            </div>
            <img src="img/dive.png" alt="">
        </div>

        <div class="act-item">
            <div class="act-info-right">
                <h2><b>Surfing</b></h2>
                <ul>
                    <li>Ride the waves and embrace the thrill of the ocean</li>
                    <li>Catch the perfect wave and ride the rush.</li>
                    <li>Balance, agility, and nature's harmony meet.</li>
                    <li>Laughter, stories, bonds that never fade.s</li>
                    <li>Capture the moment, freeze time with your lens.</li>
                </ul>
                <h5><b>Start from Rp170.000/pax</b></h5>
                <a class="button" onclick=modalPopUp(2)>Reserve</a>
            </div>
            <img src="img/surf.png" alt="">
        </div>

        <div class="act-item">
            <div class="act-info-left">
                <h2><b>Snorkeling</b></h2>
                <ul>
                    <li>Discover vibrant marine life just below the surface.</li>
                    <li>Feel the thrill of gliding through crystal-clear waters.</li>
                    <li>Experience nature's beauty firsthand.</li>
                    <li>Capture unforgettable moments.</li>
                </ul>
                <h5><b>Start from Rp220.000/pax</b></h5>
                <a class="button" onclick=modalPopUp(3)>Reserve</a>
            </div>
            <img src="img/snor.png" alt="">
        </div>

        <div class="act-item">
            <div class="act-info-right">
                <h2><b>Jet Ski</b></h2>
                <ul>
                    <li>Feel the ocean's pulse as you race across waves.</li>
                    <li>Savor the thrill of speeding through the water.</li>
                    <li>Master control and agility with every twist and turn.</li>
                    <li>Craft memories that echo the roar of engines, waves, and laughter.</li>
                </ul>
                <h5><b>Start from Rp150.000/pax</b></h5>
                <a class="button" onclick=modalPopUp(4)>Reserve</a>
            </div>
            <img src="img/jet.png" alt="">
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

    <!-- Modal -->
    <div class="loginfirst-container">
        <div id="loginfirst" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom loginfirst-box" style="max-width:800px">
                <div class="w3-center"><br>
                    <span onclick="document.getElementById('loginfirst').style.display='none'" class="w3-button w3-xlarge w3-display-topright cancel-top">&times;</span>
                    <h2><b>Want to reserve?</b></h2>
                </div>
                <div class="resort-booking">
                    <div class="modal-body">
                        <p>Hi! Before you reserve, please log in to ensure a seamless booking experience. Your account helps us personalize your stay and manage your reservations efficiently. Thank you for choosing us!</p>
                    </div>

                    <div class="w3-container w3-padding-16">
                        <button onclick="document.getElementById('loginfirst').style.display='none'" type="button" class="form-book-cancel">Cancel</button>
                        <a class="form-book-btn" href="login.php">Let's login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Booking Modal -->
    <div class="w3-container">
        <div id="bookform" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom bookform-box" style="max-width:800px">
                <div class="w3-center"><br>
                    <span onclick="document.getElementById('bookform').style.display='none'" class="w3-button w3-xlarge w3-display-topright cancel-top">&times;</span>
                    <h2><b>Booking Form</b></h2>
                </div>
                <form class="resort-booking" action="" method="post">
                    <div class="row"><br>
                        <div class="col-6">
                            <label for="fullname">Full Name</label><br>
                            <input class="input-booking" type="text" placeholder="Insert Your Full Name" name="fullname" id="fullname" required><br>
                            <label for="phone">Phone</label><br>
                            <input class="input-booking" type="text" placeholder="Your Phone Number" name="phone" id="phone" required><br>
                        </div>

                        <div class="col-6">
                            <label for="fullname">Activity Choice</label><br>
                            <div class="input-booking">
                                <select class="tiperoom" name="tipeact" id="tipeact" required>
                                    <option>Choose activities... </option>
                                    <option value="Diving">Diving</option>
                                    <option value="Surving">Surving</option>
                                    <option value="Snorkeling">Snorkeling</option>
                                    <option value="Jet Ski">Jet Ski</option>
                                </select>
                            </div>
                            <label for="act-date">Date</label><br>
                            <input class="input-booking" type="date" id="act-date" name="act-date" required>
                        </div>
                    </div>
                    <label for="">Payment Method :</label>
                    <div class="payment row">
                        <div class="col">
                            <label class="paycard" for="paycard"><input type="radio" name="paycard" id="paycard" value="Debit/Credit">&emsp;<i class="fa-regular fa-credit-card"></i> Debit/Credit card</label>
                        </div>
                        <div class="col">
                            <label class="paycard" for="tf-bank"><input type="radio" name="paycard" id="tf-bank" value="Bank Transfer">&emsp;<i class="fa-solid fa-money-bill-transfer"></i> Bank Transfer</label>
                        </div>
                    </div>

                    <div class="w3-container w3-padding-16">
                        <button onclick="document.getElementById('bookform').style.display='none'" type="button" class="form-book-cancel">Cancel</button>
                        <button class="form-book-btn" type="submit" name="booking-button">Booking</button>
                    </div>

                </form>

            </div>
        </div>
    </div>



    <script>
        function modalPopUp(data) {
            var id = data;
            document.getElementById('<?= $must_login ?>').style.display = 'block';
            if (id == 1) {
                var dropdown = document.getElementById("tipeact");
                dropdown.selectedIndex = 1;
            } else if (id == 2) {
                var dropdown = document.getElementById("tipeact");
                dropdown.selectedIndex = 2;
            } else if (id == 3) {
                var dropdown = document.getElementById("tipeact");
                dropdown.selectedIndex = 3;
            } else if (id == 4) {
                var dropdown = document.getElementById("tipeact");
                dropdown.selectedIndex = 4;
            }
        }
    </script>
</body>

</html>