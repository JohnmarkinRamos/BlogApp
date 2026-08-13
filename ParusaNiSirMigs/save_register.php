<?php

include "config.php";

$username = $_POST['username'];

$email = $_POST['email'];

$password = $_POST['password'];

$confirm_password = $_POST['confirm_password'];

if($password != $confirm_password){

    echo "

    <script>

    alert('Password does not match');

    window.location='register.php';

    </script>

    ";

    exit();

}


$check = mysqli_query(

    $conn,

    "SELECT * FROM users

    WHERE username='$username'"

);

if(mysqli_num_rows($check)>0){

    echo "

    <script>

    alert('Username already exists');

    window.location='register.php';

    </script>

    ";

    exit();

}

$hashed_password = password_hash(

    $password,

    PASSWORD_DEFAULT

);


$sql = "

INSERT INTO users

(username,email,password)

VALUES

('$username','$email','$hashed_password')

";

if(mysqli_query($conn,$sql)){

    echo "

    <script>

    alert('Registration Successful');

    window.location='login.php';

    </script>

    ";

}

else{

    echo "Registration Failed";

}

?>