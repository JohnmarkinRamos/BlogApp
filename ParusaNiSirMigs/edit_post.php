<?php

session_start();

include "config.php";

if(!isset($_SESSION['user_id'])){

    header("Location:login.php");

    exit();

}

$id = $_GET['id'];

$user_id = $_SESSION['user_id'];

$query = mysqli_query(

    $conn,

    "SELECT * FROM posts
     WHERE id='$id'
     AND user_id='$user_id'"

);

$post = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Post - BLOG APP</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

    <h2>Edit Post</h2>

    <div class="post-form">

        <form action="update_post.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $post['id']; ?>"
            >

            <p>Post Title</p>

            <input
                type="text"
                name="title"
                value="<?= htmlspecialchars($post['title']); ?>"
                required
            >

            <p>Content</p>

            <textarea
                name="body"
                required
            ><?= htmlspecialchars($post['body']); ?></textarea>

            <br><br>

            <button type="submit">
                Update
            </button>

            <a href="my_post.php" class="cancel-link">
                Cancel
            </a>

        </form>

    </div>

</div>

</body>

</html>