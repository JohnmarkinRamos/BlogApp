<?php

session_start();

include "config.php";

if(!isset($_SESSION['user_id'])){

    header("Location:login.php");

    exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>New Post - BLOG APP</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

    <h2>NEW POST</h2>

    <div class="post-form">

        <form action="save_post.php" method="POST">

            <p>Post Title</p>

            <input
                type="text"
                name="title"
                placeholder="Enter your post title"
                required
            >

            <p>Content</p>

            <textarea
                name="body"
                placeholder="Write your content..."
                required
            ></textarea>

            <br><br>

            <button type="submit">
                Submit
            </button>

            <a href="my_post.php" class="cancel-link">
                Cancel
            </a>

        </form>

    </div>

</div>

</body>

</html>