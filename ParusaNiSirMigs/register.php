<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - BLOG APP</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="auth-container">

    <div class="auth-box">

        <h1>Create Your Account</h1>

        <h2>Sign up and start sharing your thoughts.</h2>

        <form action="save_register.php" method="POST">

            <input
                type="text"
                name="username"
                placeholder="Username"
                required
            >

            <input
                type="email"
                name="email"
                placeholder="Email"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                required
            >

            <input
                type="password"
                name="confirm_password"
                placeholder="Confirm Password"
                required
            >

            <div class="form-buttons">

                <button type="submit"> Register </button> 

                <button type="reset" class="clear-button" > Clear </button>
            
            </div>

        </form>

        <p style="margin-top: 20px; text-align: center; font-size: 14px;">

            Already have an account?

            <a href="login.php">
                Login
            </a>

        </p>

    </div>

</div>

</body>

</html>