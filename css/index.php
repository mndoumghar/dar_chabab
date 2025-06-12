<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="main">
    <div class="container">
        <form action="loge.php" method="post" class="login-form">
            <h1>Login</h1>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" >
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" >
            </div>
            <input type="submit" name="login" value="Login">
            <div class="extra-options">
                <a href="forget.php">Forgot Password?</a>
                <span>or</span>
                <a href="register.php">Sign Up</a>
            </div>
        </form>
        <?php
            if (!empty($_SESSION['message']['text'])) {
                echo '<div class="alert ' . $_SESSION['message']['type'] . '">';
                echo $_SESSION['message']['text'];
                echo '</div>';
                unset($_SESSION['message']);
            }
            ?>
    </div>
    
</div>

</body>
</html>
