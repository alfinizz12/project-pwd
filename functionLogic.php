<?php
    $connection = new mysqli("localhost", "root", "", "bluebuk");

    function register($data){
        global $connection;

        $email = strtolower(stripslashes($data['email']));
        $username = strtolower(stripslashes($data['username']));
        $password = mysqli_real_escape_string($connection, $data['password']);
        $password_confirm = mysqli_real_escape_string($connection, $data['password_confirm']);

        // konfirmasi password
        if($password !== $password_confirm){
            echo "<script>
                 alert('Password tidak sesuai')
            </script>";
            return false;
        }

        // cek username di database
        $check_username = $connection->query("SELECT * FROM user where username = '$username'");

        if(mysqli_fetch_assoc($check_username)){
            echo "<script>
                 alert('Username sudah tersedia')
            </script>";
            return false;
        }

        // enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // masukkan data ke dalam database 
        $connection->query("INSERT INTO user VALUES('', '$email' , '$username', '$password', '')");

        return mysqli_affected_rows($connection);
    }

    function login($username, $password){
        global $connection;

        $username = $_POST["username"];
        $password = $_POST["password"];

        $result =  $connection->query("SELECT * FROM user WHERE username = '$username'");

        if(mysqli_num_rows($result) === 1){

            $row = mysqli_fetch_assoc($result);
            
            if(password_verify($password, $row["password"])){
                return true;
            }
        }
    }

    function booking($session, $data){
        global $connection;

        // ambil id dari session;

        $name = stripslashes($_POST['name']);
        $phone_num = $_POST['phone'];
        $date = $_POST["checkin"];
        $date_out = $_POST['checkout'];
        $guest = $_POST['number'];
        if(empty($request)){
            $request="None";
        } else {
            $request = $_POST['request'];
        }
        $payment = $_POST['payment'];
        $resort_id = $_POST['tiperoom'];

        // cek apakah date <= sekarang dan date < date_out
        $date_cek = new DateTime($date);
        $date_out_cek = new DateTime($date_out);
        $date_now = new DateTime();

        if($date_cek < $date_now){
            return false;
        } else if ($date_cek > $date_out_cek){
            return false;
        }


        // mengubah nama kamar menjadi id room
        if($resort_id == "Standard"){
            $id_room = 1;
        } else if ($resort_id == "Deluxe"){
            $id_room = 2;
        } else if($resort_id == "Suite") {
            $id_room = 3;
        }

        // mengambil harga
        $resort = mysqli_query($connection, "SELECT price FROM resort where id = '$id_room'");
        $price = mysqli_fetch_array($resort);


        // hitung total yang harus dibayar
        $total = $price[0];
        $req_price = ["Extra Bed" => 150000, "Extra Pillow & Bolster" => 50000];
        if($request !== "None"){
            foreach($request as $req){
                if(array_key_exists($req, $req_price)) {
                    // Add the extra cost to the total cost
                    $total += $req_price[$req];
                }
            }
        }

        // input data ke database
        $booking = mysqli_query($connection, "INSERT INTO resort_booking VALUES
            ( 
                '',
                '$name',
                '$phone_num',
                '$date',
                '$date_out',
                '$guest',
                '$payment',
                '$total',
                '$id_room',
                '$session'
            )"
        );

        return mysqli_affected_rows($connection);
    }

    function upload(){
        $namaFile = $_FILES['foto']['name'];
        $ukuranFile = $_FILES['foto']['size'];
        $error = $_FILES['foto']['error'];
        $tmpName = $_FILES['foto']['tmp_name'];
    
        // cek tidak ada foto yang diupload
        if ($error === 4){
            echo "<script>
            alert('pilih gambar terlebih dahulu');
            </script>";
    
            return false;
        }
    
        // memecah nama file dengan format
        // cek yang diupload gambar atau bukan
        $ekstensiGambarValid = ['jpg', 'png','jpeg'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
    
        if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
            echo "<script>
            alert('ANDA TIDAK MENGUPLOAD GAMBAR');
            </script>";
    
            return false;
        }
    
        if($ukuranFile > 9000000){
            echo "<script>
            alert('Ukuran foto terlalu besar');
            </script>";
    
            return false;
        }
        //generate nama baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;
        move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    
        return $namaFileBaru;
    }


    function update($data){
        global $connection;

        $id = $data['id'];
        $username = strtolower(stripslashes($data['username']));
        $fotoLama = $data['fotoLama'];

        $check_username = $connection->query("SELECT * FROM user WHERE username = '$username'");
        if (mysqli_fetch_assoc($check_username)) {
            echo "<script>
                alert('Username sudah tersedia')
            </script>";
            return false;
        }
        if($_FILES['foto']['error'] === 4){
            $foto = $fotoLama;
        } else {
            $foto = upload();
        }

        mysqli_query($connection, "UPDATE user SET  username = '$username', photo = '$foto' WHERE id = '$id'");
        return mysqli_affected_rows($connection);
    }
