<?php

session_start();

include "config.php";


if (!isset($_SESSION['user_id'])) {

    header("Location:login.php");

    exit();

}


$user_id = $_SESSION['user_id'];

$post_id = $_POST['post_id'];


/* check if liked */
$check = mysqli_query(

    $conn,

    "
    SELECT id

    FROM likes

    WHERE post_id='$post_id'

    AND user_id='$user_id'
    "

);


/* remove like */
if (mysqli_num_rows($check) > 0) {

    mysqli_query(

        $conn,

        "
        DELETE FROM likes

        WHERE post_id='$post_id'

        AND user_id='$user_id'
        "

    );

}


/* add like */
else {

    mysqli_query(

        $conn,

        "
        INSERT INTO likes
        (post_id, user_id)

        VALUES
        ('$post_id', '$user_id')
        "

    );

}


/* return */

if (isset($_SERVER['HTTP_REFERER'])) {

    header("Location: " . $_SERVER['HTTP_REFERER']);

}

else {

    header("Location: community.php");

}

exit();

?>