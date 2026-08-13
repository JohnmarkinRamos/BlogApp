<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Logout - BLOG APP</title>

</head>

<body>

<script>

    const confirmLogout = confirm(
        "Are you sure you want to logout?"
    );

    if (confirmLogout) {

        <?php

        session_unset();

        session_destroy();

        ?>

        window.location.href = "login.php";

    }

    else {

        window.location.href = "my_post.php";

    }

</script>

</body>

</html>