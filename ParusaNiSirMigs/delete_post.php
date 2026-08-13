<?php

session_start();

include "config.php";


if(!isset($_SESSION['user_id'])){

    header("Location:login.php");

    exit();

}


$id = $_GET['id'];

$user_id = $_SESSION['user_id'];


$query = "

DELETE FROM posts

WHERE id='$id'

AND user_id='$user_id'

";


if(mysqli_query($conn, $query)){

    header("Location:my_post.php?deleted=Post%20deleted%20successfully!");

    exit();

}

else{

    echo "Error: " . mysqli_error($conn);

}

?>