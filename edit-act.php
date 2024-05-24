<?php
    session_start();
    require 'functionLogic.php';

    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
    }

    if(isset($_POST['booking-button'])){
        if(editAct($_SESSION['id'] ,$_POST) > 0){
            echo "<script> alert('Booking Updated Successfully!'); window.location.href='profile.php'; </script>";
        } else {
            echo "<script> alert('Update Failed'); window.location.href='profile.php'; </script>";
        }
    }

    if(isset($_POST['edit-act-bt'])){
        $id = $_POST['id_edit'];
        $act_type = $_POST['activity'];
    } else {
        echo "<script> alert('Update Failed'); window.location.href='profile.php'; </script>";
    }
    
    function actSelect($act){
        global $act_type;
        if($act == $act_type) $act_name = "diving";
        else if ($act == $act_type) $act_name = "surfing";
        else if ($act == $act_type) $act_name = "snorkeling";
        else if ($act == $act_type) $act_name = "jetski";
        
        if(isset($act_name)) echo "selected";
    }

    $query = $connection->query("SELECT * FROM activity_booking WHERE id = $id");
    $row = $query->fetch_object();

    function paymentSelect($payment){
        global $row;
        if($payment == $row->payment) $payment_method = "Bank Transfer";
        else if($payment == $row->payment) $payment_method = "Debit/Credit";
        
        if(isset($payment_method)) echo "checked";
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
    <title>Document</title>
    <style>
        body {
            background-image: url(img/sand.png);
        }
        ::-webkit-scrollbar {
            display: none;
        }
        .card {
            margin-top: 90px;
            margin-left: 260px;
            margin-right: 260px;
            height: 420px;
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
                <h2 style="text-align: center; color:#2b77a4; margin-top: 25px; margin-left: 20px">Edit Activity Ticket</h2><br>
            </div>

            <form class="resort-booking" action="" method="post">
                <div class="row"><br>
                    <div class="col-6">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <label for="fullname">Full Name</label><br>
                        <input class="input-booking" type="text" placeholder="Insert Your Full Name" name="fullname" id="fullname" value="<?=$row->name?>" required><br>
                        <label for="phone">Phone</label><br>
                        <input class="input-booking" type="text" placeholder="Your Phone Number" name="phone" id="phone" value="<?=$row->phone_num?>"  required><br>
                    </div>

                    <div class="col-6">
                        <label for="fullname">Activity Choice</label><br>
                        <div class="input-booking">
                            <select class="tiperoom" name="tipeact" id="tipeact" required>
                                <option>Choose activities... </option>
                                <option <?=actSelect(1)?> value="Diving">Diving</option>
                                <option <?=actSelect(2)?> value="Surfing">Surfing</option>
                                <option <?=actSelect(3)?> value="Snorkeling">Snorkeling</option>
                                <option <?=actSelect(4)?> value="Jet Ski">Jet Ski</option>
                            </select>
                        </div>
                        <label for="act-date">Date</label><br>
                        <input class="input-booking" type="date" id="act-date" name="act-date" value="<?=$row->date?>" required>
                    </div>
                </div>
                <label for="">Payment Method :</label>
                <div class="payment row">
                    <div class="col">
                        <label class="paycard" for="paycard"><input type="radio" name="paycard" id="paycard" value="Debit/Credit" <?=paymentSelect("Debit/Credit")?>>&emsp;<i class="fa-regular fa-credit-card"></i> Debit/Credit card</label>
                    </div>
                    <div class="col">
                        <label class="paycard" for="tf-bank"><input type="radio" name="paycard" id="tf-bank" value="Bank Transfer" <?=paymentSelect("Bank Transfer")?>>&emsp;<i class="fa-solid fa-money-bill-transfer"></i> Bank Transfer</label>
                    </div>
                </div><br>

                <div class="">
                    <button class="form-book-btn" style="margin-bottom: 30px;" type="submit" name="booking-button">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>