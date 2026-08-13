<?php

session_start();

include "config.php";


if(!isset($_SESSION['user_id'])){

    header("Location:login.php");

    exit();

}


$user_id = $_SESSION['user_id'];

$title = trim($_POST['title']);

$body = trim($_POST['body']);


$query = "

INSERT INTO posts

(user_id, title, body)

VALUES

('$user_id', '$title', '$body')

";


if(mysqli_query($conn, $query)){

    header("Location:my_post.php?success=Post%20created%20successfully!");

    exit();

}

else{

    echo "Error: " . mysqli_error($conn);

}

?>