<?php
session_start();
require 'functionLogic.php';

// agar tidak bisa diakses langsung melalui URL
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

// mengambil user id dengan session
$uname = $_SESSION['username'];
$user_id = mysqli_query($connection, "SELECT id FROM user WHERE username = '$uname'");
$id_self = mysqli_fetch_array($user_id);

// mengambil user email dengan user id
$email_user = mysqli_query($connection, "SELECT email FROM user WHERE username = '$uname'");
$email = mysqli_fetch_array($email_user);

// perintah memilih row pada tabel resort
$resort_data = mysqli_query($connection, "SELECT * FROM resort_booking WHERE user_id_resort = '$id_self[0]' ");

// menhitung jumlah row pada table
$count_data = mysqli_num_rows($resort_data);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/da6c47344b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Profile</title>
</head>

<body class="profile-page">
    <div class="prof-up">
        <form action="home.php"><button class="back-button"><i class="fa-solid fa-arrow-left"></i></button></form>
        <h2>My Profile</h2>
    </div>
    <div class="prof-inside">
        <div class="my-profile">
            <img src="img/profil.jpeg" alt="">
            <div class="uname-profile">
                <p>Username</p>
                <label for="">
                    <h3><?= $_SESSION['username'] ?></h3>
                </label>
            </div>
            <div class="uname-profile email-prof">
                <p>Email</p>
                <label for="">
                    <p><?= $email[0] ?></p>
                </label>
            </div>
            <button class="editprof" onclick="popup()">edit</button>
            <div class="logout-btn">
                <?php if (isset($_SESSION['username'])) {
                    echo "<form action='logout.php'><button>log out</button></form>";
                }
                ?>
            </div>
        </div>

        <div class="booking-list">
            <div class="act-bookinglist">

            </div>
            <div class="rst-bookinglist">

            </div>
        </div>
    </div>





    <!-- <div class="profile-box">
        <div class="profile-pic">
            <img src="img/profil.jpeg" alt="">
            <div class="uname-prof">
                <h3><?= $_SESSION['username'] ?></h3>
                <p><?= $email[0] ?></p>
            </div>
            <div>
                <button class="editprof" onclick="popup()"><u>edit</u></button>
            </div>
            <div class="logout-btn">
                <?php if (isset($_SESSION['username'])) {
                    echo "<form action='logout.php'><button>log out</button></form>";
                }
                ?>

            </div>
        </div>
        <div class="mybooking">
            <h2>My Bookings</h2>
            <?php
            if ($count_data === 0) {
                // echo "KOSONG";
                $def = "<div class='the-booking'>
                <h2>No Booking</h2>
                </div>";
            }
            ?>

            <div class="vertical-menu">
                <?php if (isset($def)) echo $def; ?>
                <?php while ($resort_data_fetch = mysqli_fetch_assoc($resort_data)) : ?>
                    <?php
                    if ($resort_data_fetch['resort_id'] == 1) {
                        $room_type = "Standard";
                    } else if ($resort_data_fetch['resort_id'] == 2) {
                        $room_type = "Deluxe";
                    } else if ($resort_data_fetch['resort_id'] == 3) {
                        $room_type = "Suite";
                    }
                    ?>

                    <div class="ticket-book">
                        <h2>My Ticket</h2>//
                        <div class="ticket-up">
                            <h6>ticket type</h6>
                        </div>
                        <div class="ticket-up">
                            <h3>Room Booking</h3>
                            <h3><?= $room_type ?> Room</h3>
                        </div>
                        <div>
                            <table class="ticket-inside">
                                <tr>
                                    <td>Check-in date</td>
                                    <td>Check-out date</td>
                                    <td>Total</td>
                                    <td rowspan="2"><i class="bi bi-qr-code"></i></td>//
                                </tr>
                                <tr>
                                    <td><?= $resort_data_fetch['date']; ?></td>
                                    <td><?= $resort_data_fetch['date_out']; ?></td>
                                    <td><?= $resort_data_fetch['total']; ?></td>
                                </tr>
                                <tr></tr>
                            </table>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div> -->

    <!-- modal edit profile  -->
    <div class="popup-edit" id="popup-edit1">
        <div class="overlay-edit"></div>
        <div class="edit-content">
            <div class="close-btn" onclick="popup()">&times;</div>
            <h2>Edit My Profile</h2>
            <form action="" enctype="multipart/form-data">
                <img class="image-edit" src="img/profil.jpeg" alt="">
                <input type="file" name="foto" id="foto">
                <input type="text" name="username" class="input-field" placeholder="Username" required>
                <button type="submit" class="login-button" name="save">Save</button>
            </form>
        </div>
    </div>

    <script>
        function popup() {
            document.getElementById("popup-edit1").classList.toggle("active");
        }
    </script>

</body>

</html>