<?php

session_start();

include "config.php";


if(!isset($_SESSION['user_id'])){

    header("Location:login.php");

    exit();

}


$post_id = $_POST['post_id'];

$body = trim($_POST['body']);

$user_id = $_SESSION['user_id'];


$query = "

INSERT INTO comments

(post_id, user_id, body)

VALUES

('$post_id', '$user_id', '$body')

";


if(mysqli_query($conn, $query)){

    header("Location:community.php");

    exit();

}

else{

    echo "Error: " . mysqli_error($conn);

}

?>