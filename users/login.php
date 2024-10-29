<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>Login Form</title>
        <link rel="stylesheet" href="../assets/css/login.css"/>
        <link rel="icon" type="image/x-icon" href="../assets/images/logo.png">
        <script src="https://accounts.google.com/gsi/client" async defer></script>
    </head>
    <body>
    <form class="form" method="post" name="login" action="loginBackend.php">
                <center>
                    <img src="../assets/images/logo.png" alt="" class="img img-fluid">
                </center>
                <hr />
                <h1 class="login-title">Login</h1>
                <input type="text" class="login-input" name="email" placeholder="Email" autofocus="true"/>
                <input type="password" class="login-input" name="password" placeholder="Password"/>
                <input type="submit" value="Login" name="submit" class="login-button"/>
                <p class="link">Don't have an account? <a href="registration.php">Register here!</a></p>
                <hr />
              
                
        </form>

      
    </body>
</html>