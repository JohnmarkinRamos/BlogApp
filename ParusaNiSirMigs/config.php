<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "blog_app"
);

if(!$conn){

    die("Database Connection Failed");

}

?>