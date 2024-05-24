<?php
session_start();
require 'functionLogic.php';

// agar tidak bisa diakses langsung melalui URL
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

if(isset($_POST['cancel'])){
    if(deleteAct($_POST['id_del']) > 0){
        echo "<script> alert('Cancel berhasil'); window.location.href='profile.php'; </script>";
    }
}

if(isset($_POST['cancel-res'])){
    if(deleteRes($_POST['id_cancel']) > 0){
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

// mengambil user id dengan session
$id = $_SESSION['id'];
$user = $connection->query("SELECT * FROM user WHERE id = '$id'");
$user_data = $user->fetch_object();

// // perintah memilih row pada tabel resort
$resort_data = $connection->query("SELECT * FROM resort_booking WHERE user_id_resort = '$user_data->id' ORDER BY date DESC");
$activity_data = $connection->query("SELECT * FROM activity_booking WHERE user_id_act = '$user_data->id' ORDER BY date DESC");

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
        <div class="profile-search">
            <form class="box">
                <input type="search" placeholder="Search">
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
            <img src="img/<?=$user_data->photo?>" alt="profpic">
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
            <button class="editprof" onclick="popup()">edit</button>
            <div class="logout-btn">
                <form action='logout.php'><button onclick="return confirm('Yakin ingin logout? Anda akan dikembalikan ke landing page')">log out</button></form>
            </div>
        </div>

        <div class="booking-list">
            <div class="act-bookinglist">
                <h2 class="mybooking-title">My Activity Booking</h2>
                <div class="vertical-menu">
                    <?php if (isset($def)) echo $def?>
                    <?php while ($activity_data_fetch = $activity_data->fetch_object()) : ?>

                        <?php
                            $activity = $connection->query("SELECT * FROM activity WHERE id = $activity_data_fetch->activity_ID");
                            $act_detail = $activity->fetch_object();
                            $act_type = $act_detail->act_name;
                            $total = $act_detail->harga;

                            $date_now = new DateTime();
                            $date_check = new DateTime($activity_data_fetch->date);
                            $button_status = "";
                            $button = "";
                            if($date_now >= $date_check) {
                                $button_status = "disabled";
                                $button = "dis-button";
                            }
                        ?>

                        <div class="ticket-book">
                            <h2>My Ticket</h2>
                            <div class="ticket-up">
                                <h6>ticket type</h6>
                            </div>
                            <div class="ticket-up">
                                <h3>Activity Booking</h3>
                                <h3><?= $act_type ?></h3>
                            </div>
                            <div>
                                <table class="ticket-inside">
                                    <tr>
                                        <td >Date</td>
                                        <td>Total</td>
                                    </tr>
                                    <tr>
                                        <?php
                                        $activity_data_fetch->date = date("d M Y", strtotime($activity_data_fetch->date));

                                        $total = 'Rp. ' . number_format($total, 0, ',', ',');
                                        ?>
                                        <td><?= $activity_data_fetch->date; ?></td>
                                        <td><?= $total ?></td>
                                    </tr>

                                </table>
                                <div class="cancel-edit-booking">
                                    <form action="" method="post">
                                        <input type="hidden" name="id_del" value="<?=$activity_data_fetch->id?>">
                                        <td><button name="cancel" class="cancel-booking <?php if(isset($button)) echo $button;?>" <?php if(isset($button_status))echo $button_status?> onclick="return confirm('Yakin ingin cancel pemesanan?')">Cancel</button></td>
                                    </form>
                                    <form action="edit-act.php" method="post">
                                        <input type="hidden" name="id_edit" value="<?=$activity_data_fetch->id?>">
                                        <input type="hidden" name="activity" value="<?=$activity_data_fetch->activity_ID?>">
                                        <td><button name="edit-act-bt" class="edit-booking <?php if(isset($button)) echo $button;?>" <?php if(isset($button_status)) echo $button_status ?>>Edit</button></td>
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
                        $resort = $connection->query("SELECT * FROM resort WHERE id = $resort_data_fetch->resort_id");
                        $res_detail = $resort->fetch_object();
                        $room_type = $res_detail->packet_name;
                        $date_now = new DateTime();
                        $date_check_res = new DateTime($resort_data_fetch->date);
                        $button_status_r = "";
                        $button_r = "";
                        if($date_now >= $date_check_res) {
                            $button_status_r = "disabled";
                            $button_r = "dis-button";
                        } 
                        ?>

                        <div class="ticket-book">
                            <h2>My Ticket</h2>
                            <div class="ticket-up">
                                <h6>ticket type</h6>
                            </div>
                            <div class="ticket-up">
                                <h3>Resort Booking</h3>
                                <h3><?= $room_type ?> Room</h3>
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
                                        <input type="hidden" name="id_cancel" value="<?=$resort_data_fetch->id?>">
                                        <td><button class="cancel-booking <?php if(isset($button_r)) echo $button_r?>" name="cancel-res" <?php if(isset($button_status_r)) echo $button_status_r?> onclick="return confirm('Yakin ingin cancel pemesanan?')">Cancel</button></td>
                                    </form>
                                    <form action="edit-rst.php" method="post">
                                        <input type="hidden" name="id_edit" value="<?=$resort_data_fetch->id?>">
                                        <td><button class="edit-booking <?php if(isset($button_r)) echo $button_r;?>" name="edit-res" <?php if(isset($button_status_r)) echo $button_status_r ?>>Edit</button></td>
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
                    <br><div class="creator">
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
