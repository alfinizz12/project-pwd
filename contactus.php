<?php
session_start();
include 'functionLogic.php';
if (!isset($_SESSION['id'])) {
    $login_text = "Login";
    $login_class = "login-btn";
} else {
    $login_class = " ";
    $login_text = " ";
    $id = $_SESSION['id'];
    $photo = $connection->query("SELECT * FROM user WHERE id = $id");
    $img_profile = $photo->fetch_object();
    $profile = "<form action='profile.php'>
  <button class='profile'>Profile <img class='imgprof' src='img/$img_profile->photo' alt=''></button>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/da6c47344b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="style.css">
    <title>Contact Us</title>

</head>

<body class="contactus-page">
    <header>
        <nav class="p-4">
            <div class="container-fluid row">
                <div class="col-3">
                    <a class="navbar-brand" href="#">
                        <!-- <img src="icon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top"> -->
                        Bluebuk.
                    </a>
                </div>
                <div class="col-6 text-center">
                    <ul class="nav justify-content-center ms-4">
                        <li>
                            <a href="home.php">Home</a>
                        </li>
                        <li>
                            <a href="activity.php">Activity</a>
                        </li>
                        <li>
                            <a href="resort.php">Resort</a>
                        </li>
                        <li>
                            <a href="contactus.php" class="active" aria-current="page">Contact Us</a>
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


    <h1 class="contact-us-title">Contact Us</h1>
    <div class="box-contact card" style="padding-left: 10px; padding-right: 10px;">
        <div class="card-body">
            <h3 style="text-align: center;">We love to hear from you</h3><br>
            <form action="">
                <input class="form-control" type="text" placeholder="Name" required><br>
                <input class="form-control" type="email" placeholder="email" required><br>
                <textarea class="form-control" name="feedback" id="feedback" placeholder="your feedback" requireds></textarea><br>
                <button class="btn" style="color: white; background: #2b77a4" type="submit" >Submit</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-col">
            <div>
                <p>Our contact</p>
                <a href="">Bluebuk@gmail.com</a>
                <p>+1 086-43131</p>
            </div>
            <div>
                <p>Address</p>
                <p>555 Elmwood Avenue,<br>
                    Willow Creek, California <br> 98765
                    United States</p>
            </div>
            <div class="items">
                <p>Follow Us</p>
                <div class="icons">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-twitter-x"></i>
                    <i class="bi bi-youtube"></i>
                    <i class="bi bi-tiktok"></i>
                </div><br>
            </div>
            <div class="creator">
                <p>Creator
                <p>
                    <a href="creator">Aliyan Alfin</a><br>
                    <a href="creator">Aurelia Rana</a>
            </div>
            <h6 style="font-size: 10px;">copyright <i class="bi-c-circle"></i>2024 Bluebuk Creator Teams</h6>
        </div>
    </footer>

</body>

</html>