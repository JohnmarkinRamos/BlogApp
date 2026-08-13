<?php

session_start();

include "config.php";


$login = $_POST['login'];

$password = $_POST['password'];


$query = mysqli_query(

    $conn,

    "SELECT * FROM users

    WHERE username='$login'

    OR email='$login'"

);


$user = mysqli_fetch_assoc($query);


if($user && password_verify($password, $user['password'])){

    $_SESSION['user_id'] = $user['id'];

    $_SESSION['username'] = $user['username'];

    $_SESSION['login_input'] = $login;

    header("Location: my_post.php");

    exit();

}

else{

    echo "

    <script>

    alert('Invalid username/email or password');

    window.location='login.php';

    </script>

    ";

}

?>