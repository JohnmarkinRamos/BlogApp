<?php

session_start();

include "config.php";


if(!isset($_SESSION['user_id'])){

    header("Location:login.php");

    exit();

}

$id = $_POST['id'];

$title = trim($_POST['title']);

$body = trim($_POST['body']);

$user_id = $_SESSION['user_id'];


$query = "

UPDATE posts

SET

title='$title',

body='$body',

updated_at=NOW()

WHERE id='$id'

AND user_id='$user_id'

";


if(mysqli_query($conn, $query)){

    header("Location:my_post.php?success=Post%20updated%20successfully!");

    exit();

}

else{

    echo "Error: " . mysqli_error($conn);

}

?>