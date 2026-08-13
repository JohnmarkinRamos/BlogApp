<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - BLOG APP</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="auth-container">

    <div class="auth-box">

        <h1>WELCOME TO BLOG APP!</h1>

        <h2>Log in to continue your blogging journey.</h2>

        <form action="authenticate.php" method="POST">

            <input
                type="text"
                name="login"
                placeholder="Username or Email"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                required
            >

            <div class="form-buttons"> 
                
                <button type="submit"> Login </button> 
                
                <button type="reset" class="clear-button" > Clear </button> 
            
            </div>

        </form>

        <p style="margin-top: 20px; text-align: center; font-size: 14px;">

            Don't have an account?

            <a href="register.php">
                Register
            </a>

        </p>

    </div>

</div>

</body>

</html>