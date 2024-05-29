<?php
session_start();
require 'functionLogic.php';

// agar tidak bisa diakses langsung melalui URL
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

if (isset($_POST['cancel'])) {
    if (deleteAct($_POST['id_del']) > 0) {
        echo "<script> alert('Cancel berhasil'); window.location.href='profile.php'; </script>";
    }
}

if (isset($_POST['cancel-res'])) {
    if (deleteRes($_POST['id_cancel']) > 0) {
        echo "<script> alert('Cancel berhasil'); window.location.href='profile.php'; </script>";
    }
}

if (isset($_POST['save'])) {
    if (updateProf($_POST) > 0) {
        echo "<script>
            alert('Berhasil update!');
        </script>";
        header("Location: profile.php");
    }
}

if(isset($_POST['done'])){
    if(completeBook($_POST['id'], $_POST['complete']) > 0){

    }
}

// mengambil user id dengan session
$id = $_SESSION['id'];
$user = $connection->query("SELECT * FROM user WHERE id = '$id'");
$user_data = $user->fetch_object();

// // perintah memilih row pada tabel resort
$resort_data = $connection->query("SELECT rb.id, rb.name, rb.phone_num, rb.date, rb.date_out, rb.guest, rb.payment, rb.total, r.packet_name FROM resort_booking rb JOIN resort r ON resort_id = r.id  WHERE user_id_resort = '$user_data->id' AND NOT status = 1 ORDER BY date");

$activity_data = $connection->query("SELECT ab.id, ab.name, ab.phone_num, ab.date, ab.payment, a.act_name, a.harga FROM activity_booking ab JOIN activity a ON activity_ID = a.id WHERE user_id_act = '$user_data->id' AND NOT status = 1 ORDER BY date");

if(isset($_POST['search'])){
    $search = $_POST['search'];
    $resort_data = $connection->query("SELECT rb.id, rb.name, rb.phone_num, rb.date, rb.date_out, rb.guest, rb.payment, rb.total, r.packet_name FROM resort_booking rb JOIN resort r ON resort_id = r.id WHERE (rb.name LIKE '%$search%' OR r.packet_name LIKE '%$search%' OR rb.payment LIKE '%$search%') AND (user_id_resort = $id AND status = 0)");

    $activity_data = $connection->query("SELECT ab.id, ab.name, ab.phone_num, ab.date, ab.payment, a.act_name, ab.activity_ID, a.harga FROM activity_booking ab JOIN activity a ON activity_ID = a.id WHERE (ab.name LIKE '%$search%' OR a.act_name LIKE '%$search%' OR ab.payment LIKE '%$search%') AND (user_id_act = '$user_data->id' AND status = 0)");
}

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
    <link rel="icon" type="image/x-icon" href="img/iconB.png">
    <title>Bluebuk : My Profile</title>
</head>

<body class="profile-page">
    <div class="prof-up">
        <form action="home.php"><button class="back-button"><i class="fa-solid fa-arrow-left"></i></button></form>
        <h2>My Profile</h2>
        <div class="profile-search">
            <form class="box" method="post">
                <input type="search" placeholder="Search" name="search">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </a>
            </form>
        </div>
    </div>
    <div class="prof-inside">
        <div class="my-profile">
            <img src="img/<?= $user_data->photo ?>" alt="profpic">
            <div class="uname-profile">
                <p>Username</p>
                <label for="">
                    <h3><?= $user_data->username ?></h3>
                </label>
            </div>
            <div class="uname-profile email-prof">
                <p>Email</p>
                <label for="">
                    <p><?= $user_data->email ?></p>
                </label>
            </div>
            <button class="editprof" onclick="popup()">Customize</button>
            <div class="logout-btn">
                <form action='logout.php'><button onclick="return confirm('Yakin ingin logout? Anda akan dikembalikan ke landing page')">log out</button></form>
            </div>
        </div>

        <div class="booking-list">
            <div class="act-bookinglist">
                <h2 class="mybooking-title">My Activity Booking</h2>
                <div class="vertical-menu">
                    <?php if (isset($def)) echo $def ?>
                    <?php while ($activity_data_fetch = $activity_data->fetch_object()) : ?>

                        <?php

                        $date_now = new DateTime();
                        $date_check = new DateTime($activity_data_fetch->date);
                        $button_status = $button = $done_button = $done_status = "";
                        if ($date_now >= $date_check) {
                            $button_status = "disabled";
                            $button = "dis-button";
                        } else {
                            $done_button = "dis-button";
                            $done_status = "disabled";
                        }
                        ?>
                        <div class="ticket-book">
                            <h2>My Ticket</h2>
                            <div class="ticket-up">
                                <h6>ticket type</h6>
                            </div>
                            <div class="ticket-up">
                                <h3>Activity Booking</h3>
                                <h3><?= $activity_data_fetch->act_name ?></h3>
                            </div>
                            <div>
                                <table class="ticket-inside">
                                    <tr>
                                        <td>Date</td>
                                        <td>Total</td>
                                    </tr>
                                    <tr>
                                        <?php
                                        $activity_data_fetch->date = date("d M Y", strtotime($activity_data_fetch->date));

                                        $activity_data_fetch->harga = 'Rp. ' . number_format($activity_data_fetch->harga, 0, ',', ',');
                                        ?>
                                        <td><?= $activity_data_fetch->date; ?></td>
                                        <td><?= $activity_data_fetch->harga ?></td>
                                    </tr>

                                </table>
                                <div class="cancel-edit-booking">
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?= $activity_data_fetch->id ?>">
                                        <input type="hidden" name="complete" value="activity_booking">
                                        <td><button class="done-book <?php if (isset($done_button)) echo $done_button; ?>" type="submit" name="done" <?php if (isset($done_status)) echo $done_status?> onclick="return confirm('Yakin ingin menyelesaikan pemesanan?')"><i class="fa-solid fa-check"></i></button></td>
                                    </form>
                                    <form action="" method="post">
                                        <input type="hidden" name="id_del" value="<?= $activity_data_fetch->id ?>">
                                        <td><button name="cancel" class="cancel-booking <?php if (isset($button)) echo $button; ?>" <?php if (isset($button_status)) echo $button_status ?> onclick="return confirm('Yakin ingin cancel pemesanan?')"><i class="fa-solid fa-xmark"></i></button></td>
                                    </form>
                                    <form action="edit-act.php" method="post">
                                        <input type="hidden" name="id_edit" value="<?= $activity_data_fetch->id?>">
                                        <input type="hidden" name="activity" value="<?= $activity_data_fetch->act_name ?>">
                                        <td><button name="edit-act-bt" class="edit-booking <?php if (isset($button)) echo $button; ?>" <?php if (isset($button_status)) echo $button_status ?>><i class="fa-solid fa-pen"></i></button></td>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="rst-bookinglist">
                <h2 class="mybooking-title">My Resort Booking</h2>
                <div class="vertical-menu">
                    <?php if (isset($def)) echo $def; ?>
                    <?php while ($resort_data_fetch = $resort_data->fetch_object()) : ?>

                        <?php
                        $date_now = new DateTime();
                        $date_check_res = new DateTime($resort_data_fetch->date);
                        $button_status_r = $button_r = $done_button_r = $done_status_r = "";
                        if ($date_now >= $date_check_res) {
                            $button_status_r = "disabled";
                            $button_r = "dis-button";
                        } else {
                            $done_button_r = "dis-button";
                            $done_status_r = "disabled";
                        }
                        ?>

                        <div class="ticket-book">
                            <h2>My Ticket</h2>
                            <div class="ticket-up">
                                <h6>ticket type</h6>
                            </div>
                            <div class="ticket-up">
                                <h3>Resort Booking</h3>
                                <h3><?= $resort_data_fetch->packet_name ?> Room</h3>
                            </div>
                            <div>
                                <table class="ticket-inside">
                                    <tr>
                                        <td>Check-in date</td>
                                        <td>Check-out date</td>
                                        <td>Total</td>
                                    </tr>
                                    <tr>
                                        <?php
                                        $resort_data_fetch->date = date("d M Y", strtotime($resort_data_fetch->date));

                                        $resort_data_fetch->date_out = date("d M Y", strtotime($resort_data_fetch->date_out));

                                        $resort_data_fetch->total = 'Rp. ' . number_format($resort_data_fetch->total, 0, ',', ',');

                                        ?>
                                        <td><?= $resort_data_fetch->date; ?></td>
                                        <td><?= $resort_data_fetch->date_out; ?></td>
                                        <?php ?>
                                        <td><?= $resort_data_fetch->total; ?></td>
                                    </tr>
                                </table>
                                <div class="cancel-edit-booking">
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?= $resort_data_fetch->id ?>">
                                        <input type="hidden" name="complete" value="resort_booking">
                                        <td><button class="done-book <?php if (isset($done_button_r)) echo $done_button_r ?>" type="submit" name="done" <?php if (isset($done_status_r)) echo $done_status_r ?> onclick="return confirm('Yakin ingin menyelesaikan pemesanan?')"><i class="fa-solid fa-check"></i></button></td>
                                    </form>
                                    <form action="" method="post">
                                        <input type="hidden" name="id_cancel" value="<?= $resort_data_fetch->id ?>">
                                        <td><button class="cancel-booking <?php if (isset($button_r)) echo $button_r ?>" name="cancel-res" <?php if (isset($button_status_r)) echo $button_status_r ?> onclick="return confirm('Yakin ingin cancel pemesanan?')"><i class="fa-solid fa-xmark"></i></button></td>
                                    </form>
                                    <form action="edit-rst.php?id=<?= $resort_data_fetch->id ?>" method="post">
                                        <td><button class="edit-booking <?php if (isset($button_r)) echo $button_r; ?>" name="edit-res" <?php if (isset($button_status_r)) echo $button_status_r ?>><i class="fa-solid fa-pen"></i></button></td>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- modal edit profile  -->
    <div class="popup-edit" id="popup-edit1">
        <div class="overlay-edit"></div>
        <div class="edit-content">
            <div class="close-btn" onclick="popup()">&times;</div>
            <h2>Edit My Profile</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $user_data->id ?>">
                <input type="hidden" name="fotoLama" value="<?= $user_data->photo ?>">
                <input type="hidden" name="namaLama" value="<?= $user_data->username ?>">
                <img class="image-edit" src="img/<?= $user_data->photo ?>" alt="" id="prof-pic">
                <label class="update-img" for="input-foto">Update Image</label>
                <input class="link-img-update" type="file" accept="img/jpeg, img/jpg, img/png" name="foto" id="input-foto">
                <input type="text" name="namaBaru" class="input-field" placeholder="Username" value="<?= $user_data->username ?>" required>
                <button type="submit" class="login-button" name="save">Save</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="">
            <div class="col-md-4">
                <div class="items">
                    <h3>Follow Us</h3>
                    <div class="icons">
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-twitter-x"></i>
                        <i class="bi bi-youtube"></i>
                        <i class="bi bi-tiktok"></i>
                    </div><br>
                    <h6 style="font-size: 10px;">copyright <i class="bi-c-circle"></i> Bluebuk Creator Teams</h6>
                    <br>
                    <div class="creator">
                        <h3>Creator</h3>
                        <a href="creator">Aliyan Alfin</a><br>
                        <a href="creator">Aurelia Rana</a>
                    </div>
                </div>

            </div>

        </div>

    </footer>

    <script>
        function popup() {
            document.getElementById("popup-edit1").classList.toggle("active");
        }

        let profilePic = document.getElementById("prof-pic");
        let inputFoto = document.getElementById("input-foto");

        inputFoto.onchange = function() {
            profilePic.src = URL.createObjectURL(inputFoto.files[0]);
        }
    </script>

</body>

</html>
