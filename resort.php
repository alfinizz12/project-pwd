<?php
session_start();

require  'functionLogic.php';

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

if(isset($_POST['booking-button'])){
    if(booking($_SESSION["id"],$_POST) > 0){
        echo "<script>
            alert('Berhasil booking!, silahkan cek di profil anda!');
        </script>";
    } else {
        echo "<script>
            alert('Gagal booking!, silahkan cek kembali tanggal yang diinput!');
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/da6c47344b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="style.css">
    <title>Resort</title>

</head>

<body class="resort-page">
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
                            <a class="active" aria-current="page" href="resort.php">Resort</a>
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

    <!-- Resort Room Type -->
    <h1 class="rst-capt">Choose Your Room</h1>
    <div class="room">
        <div class="room-item">
            <div class="card" style="width: 18rem;">
                <img src="img/standart.png" class="card-img-top" alt="standart room">
                <div class="card-body">
                    <h3 class=""><b>Standard Room</b></h3><br>
                    <p><i class="fa-solid fa-user-group"></i> 2 adults 1 kids</p>
                    <p><i class="fa-solid fa-bed"></i> Single queen bed/twin bed</p>
                    <p><i class="fa-solid fa-utensils"></i> Without breakfast</p>
                    <p><i class="fa-solid fa-ban-smoking"></i> Non-smoking</p>
                    <h5><b>Rp450.000/night</b></h5>
                    <a href="#" class="room-book" onclick=modalPopUp(1)>Booking</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="img/deluxe.png" class="card-img-top" alt="deluxe room">
                <div class="card-body">
                    <h3 class=""><b>Deluxe Room</b></h3><br>
                    <p><i class="fa-solid fa-user-group"></i> 4 adults</p>
                    <p><i class="fa-solid fa-bed"></i> Single king bed/twin bed</p>
                    <p><i class="fa-solid fa-utensils"></i> Breakfast 2 pax</p>
                    <p><i class="fa-solid fa-ban-smoking"></i> Non-smoking</p>
                    <h5><b>Rp775.000/night</b></h5>
                    <a href="#" class="room-book" onclick=modalPopUp(2)>Booking</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="img/premium.png" class="card-img-top" alt="premium room">
                <div class="card-body">
                    <h3 class=""><b>Suite Room</b></h3><br>
                    <p><i class="fa-solid fa-user-group"></i> 4 adults 1 kids</p>
                    <p><i class="fa-solid fa-bed"></i> 2 rooms king size bed</p>
                    <p><i class="fa-solid fa-utensils"></i> Breakfast 4 pax</p>
                    <p><i class="fa-solid fa-smoking"></i> Smoking balcony</p>
                    <h5><b>Rp1.050.000/night</b></h5>
                    <a href="#" class="room-book" onclick=modalPopUp(3)>Booking</a>
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

    <!-- Modal Booking-->
    <div class="w3-container" style="z-index: 12;">
        <div id="bookform" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom bookform-box" style="max-width:800px">
                <div class="w3-center"><br>
                    <span onclick="document.getElementById('bookform').style.display='none'" class="w3-button w3-xlarge w3-display-topright cancel-top">&times;</span>
                    <h2><b>Resort Booking Form</b></h2>
                </div>
                <form class="resort-booking" action="resort.php" method="post">
                    
                    <div class="row"><br>
                        <div class="col-6">
                        <label for="name">Full Name</label><br>
                        <input class="input-booking" type="text" placeholder="Insert Your Full Name" name="name" id="name" required><br>
                            <label for="checkin">Check-in date</label><br>
                            <input class="input-booking" type="date" id="checkin" name="checkin" required>
                            <label for="tiperoom">Select your room type</label>
                        </div>

                        <div class="col-6">
                            <label for="phone">Phone</label><br>
                            <input class="input-booking" type="text" placeholder="Your Phone Number" name="phone" id="phone" required><br>
                            <label for="checkout">Check-out date</label><br>
                            <input class="input-booking" type="date" id="checkout" name="checkout" required>
                            <label for="number">Number of Adults :</label>
                        </div>

                        <div class="type-number">
                            <div class="input-booking">
                                <select class="tiperoom" name="tiperoom" id="tiperoom" required>
                                    <option>Choose room type... </option>
                                    <option value="Standard">Standard</option>
                                    <option value="Deluxe">Deluxe</option>
                                    <option value="Suite">Suite</option>
                                </select>
                            </div>
                            <div class="number-guest">
                                <button class="numberbtn" type="button" onclick="subtract()"><i class="fa-solid fa-minus"></i></button>
                                <input class="number-input" type="number" id="number" name="number" value="0" min="0" max="5">
                                <button class="numberbtn" type="button" onclick="add()"><i class="fa-solid fa-plus"></i></button>
                            </div>

                        </div>
                    </div>

                    <label for="additional">Additional Request :</label>
                    <div class="form-check form-switch cekbok">
                        <input class="form-check-input" type="checkbox" role="switch" id="extrabed" name="request[]"  value="Extra Bed">
                        <label class="form-check-label" for="extrabed">Extra Bed + Rp150.000</label>
                    </div>
                    <div class="form-check form-switch cekbok">
                        <input class="form-check-input" type="checkbox" role="switch" id="extrapillow" name="request[]" value="Extra Pillow & Bolster">
                        <label class="form-check-label" for="extrapillow">Extra Pillow & Bolster + Rp50.000</label>
                    </div>
                    <p></p>
                    <label for="">Payment Method :</label>
                    <div class="payment row">
                        <div class="col">
                            <label class="paycard" for="paycard"><input type="radio" name="payment" id="paycard" value="Debit/Credit card">&emsp;<i class="fa-regular fa-credit-card"></i> Debit/Credit card</label>
                        </div>
                        <div class="col">
                            <label class="paycard" for="tf-bank"><input type="radio" name="payment" id="tf-bank" value="Bank Transfer">&emsp;<i class="fa-solid fa-money-bill-transfer"></i> Bank Transfer</label>
                        </div>
                    </div><br>

                    <div class="w3-container w3-padding-16 button-booking-form">
                        <button onclick="document.getElementById('bookform').style.display='none'" type="button" class="form-book-cancel">Cancel</button>
                        <button class="form-book-btn" type="submit" name="booking-button" onclick="return confirm('Yakin data yang anda masukkan sudah benar?')">Booking</button>
                    </div>
                </form>

                
            </div>
        </div>
    </div>

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


    <script>
        function add() {
            var input = document.getElementById("number");
            var currentValue = parseInt(input.value);

            if (currentValue < 5) {
                input.value = currentValue + 1;
            }
        }

        function subtract() {
            var input = document.getElementById("number");
            var currentValue = parseInt(input.value);

            if (currentValue > 0) {
                input.value = currentValue - 1;
            }
        }

        function modalPopUp(data){
            var id = data;
            document.getElementById('<?= $must_login ?>').style.display='block';
            // untuk mengambil id berdasarkan tipe room
            if(id == 1){
                var dropdown = document.getElementById("tiperoom");
                dropdown.selectedIndex = 1;
            } else if (id == 2){
                var dropdown = document.getElementById("tiperoom");
                dropdown.selectedIndex = 2;
            } else if(id == 3){
                var dropdown = document.getElementById("tiperoom");
                dropdown.selectedIndex = 3;
            }
        }

    </script>

</body>

</html>
