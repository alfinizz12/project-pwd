<?php
session_start();
require 'functionLogic.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

$id = $_GET['id'];


if (isset($_POST['editres-button'])) {
    if (editRes($_SESSION['id'], $_POST) > 0) {
        echo "<script> alert('Booking Updated Successfully!'); window.location.href='profile.php'; </script>";
    } else if(editRes($_SESSION['id'], $_POST) == 0) {
        header("Location: profile.php");
    } else {
        echo "<script> alert('Booking Update Failed!'); window.location.href='profile.php'; </script>";
    }
}


$edit_res = $connection->query("SELECT * FROM resort_booking WHERE id = $id");
$row = $edit_res->fetch_object();
$row->total = (int)"$row->total";

// cek jenis pembayaran
if ($row->payment == "Bank Transfer") {
    $bank = "checked";
} else {
    $cred = "checked";
}

// cek room type
if ($row->resort_id == 1) {
    $std = "selected";
} else if ($row->resort_id == 2) {
    $dlx = "selected";
} else {
    $ste = "selected";
}

$extrabed = $extrapillow = "";

// cek request tambahan
if ($row->total >= 450000 && $row->total <= 650000) {
    if ($row->total == 450000) {
        $extrabed = " ";
        $extrapillow = " ";
    } else if ($row->total == 500000) {
        $extrabed = " ";
        $extrapillow = "checked";
    } else if ($row->total == 650000) {
        $extrabed = "checked";
        $extrapillow = "checked";
    }
} else if ($row->total >= 775000 && $row->total <= 975000) {
    if ($row->total == 775000) {
        $extrabed = " ";
        $extrapillow = " ";
    } else if ($row->total == 825000) {
        $extrabed = " ";
        $extrapillow = "checked";
    } else if ($row->total == 975000) {
        $extrabed = "checked";
        $extrapillow = "checked";
    }
} else if ($row->total >= 1050000 && $row->total <= 1250000) {
    if ($row->total == 1050000) {
        $extrabed = " ";
        $extrapillow = " ";
    } else if ($row->total == 1100000) {
        $extrabed = " ";
        $extrapillow = "checked";
    } else if ($row->total == 1250000) {
        $extrabed = "checked";
        $extrapillow = "checked";
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
    <script src="https://kit.fontawesome.com/da6c47344b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Edit-Resort-Ticket</title>
    <style>
        body {
            background-image: url(img/sand.png);
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .card {
            transform: scale(.95);
            margin-top: 10px;
            margin-left: 260px;
            margin-right: 260px;
            height: 600px;
            box-shadow: 3px 3px #2b77a4;
            border: 2px solid #2b77a4;
        }
    </style>
</head>

<body>
    <div class="card justify-content-center">
        <div class="card-body">
            <div class="upperside" style="display: flex;">
                <form action="profile.php"><button class="back-button"><i class="fa-solid fa-arrow-left"></i></button></form>
                <h2 style="text-align: center; color:#2b77a4; margin-top: 25px; margin-left: 20px">Edit Resort Ticket</h2><br>
            </div>

            <form class="resort-booking" action="" method="post">
                <input type="hidden" name="id" value="<?=$_GET['id']?>">
                <div class="row"><br>
                    <div class="col-6">
                        <label for="name">Full Name</label><br>
                        <input class="input-booking fullname-input" type="text" placeholder="Insert Your Full Name" name="name" id="name" value="<?= $row->name ?>" required><br>
                        <label for="checkin">Check-in date</label><br>
                        <input class="input-booking" type="date" id="checkin" name="checkin" value="<?= $row->date ?>" required>
                        <label for="tiperoom">Select your room type</label>
                    </div>

                    <div class="col-6">
                        <label for="phone">Phone</label><br>
                        <input class="input-booking" type="text" placeholder="Your Phone Number" name="phone" id="phone" value="<?= $row->phone_num ?>" required><br>
                        <label for="checkout">Check-out date</label><br>
                        <input class="input-booking" type="date" id="checkout" name="checkout" value="<?= $row->date_out ?>" required>
                        <label for="number">Number of Adults :</label>
                    </div>

                    <div class="type-number">
                        <div class="input-booking">
                            <select class="tiperoom" name="tiperoom" id="tiperoom" required>
                                <option>Choose room type... </option>
                                <option <?php if (isset($std)) echo $std ?> value="Standard">Standard</option>
                                <option <?php if (isset($dlx)) echo $dlx ?> value="Deluxe">Deluxe</option>
                                <option <?php if (isset($ste)) echo $ste ?> value="Suite">Suite</option>
                            </select>
                        </div>
                        <div class="number-guest" style="width: 125px;">
                            <button class="numberbtn" type="button" onclick="subtract()"><i class="fa-solid fa-minus"></i></button>
                            <input class="number-input" type="number" id="number" name="number" value="<?= $row->guest ?>" min="0" max="5">
                            <button class="numberbtn" type="button" onclick="add()"><i class="fa-solid fa-plus"></i></button>
                        </div>

                    </div>
                </div>

                <label for="additional">Additional Request :</label>
                <div class="form-check form-switch cekbok">
                    <input class="form-check-input" type="checkbox" role="switch" id="extrabed" name="request[]" value="Extra Bed" <?php if (isset($extrabed)) echo $extrabed?>>
                    <label class="form-check-label" for="extrabed">Extra Bed + Rp150.000</label>
                </div>
                <div class="form-check form-switch cekbok">
                    <input class="form-check-input" type="checkbox" role="switch" id="extrapillow" name="request[]" value="Extra Pillow & Bolster" <?php if (isset($extrapillow)) echo $extrapillow ?>>
                    <label class="form-check-label" for="extrapillow">Extra Pillow & Bolster + Rp50.000</label>
                </div>
                <p></p>
                <label for="">Payment Method :</label>
                <div class="payment row">
                    <div class="col">
                        <label class="paycard" for="paycard"><input type="radio" name="payment" id="paycard" value="Debit/Credit card" <?php if (isset($cred)) echo $cred ?>>&emsp;<i class="fa-regular fa-credit-card"></i> Debit/Credit card</label>
                    </div>
                    <div class="col">
                        <label class="paycard" for="tf-bank"><input type="radio" name="payment" id="tf-bank" value="Bank Transfer" <?php if (isset($bank)) echo $bank ?>>&emsp;<i class="fa-solid fa-money-bill-transfer"></i> Bank Transfer</label>
                    </div>
                </div><br>

                <div class="w3-container w3-padding-16 button-booking-form">
                    <button class="form-book-btn" type="submit" name="editres-button" onclick="return confirm('Yakin akan mengubah data yang anda masukkan?')">Save</button>
                </div>
            </form>

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
    </script>
</body>

</html>
