<!DOCTYPE html>
<html lang="en">
<?php 
    require_once 'inc/functions.php';
    session_name("userLogin");
    session_start(
        [
            "cookie_lifetime" => 300,
        ]   
    );
    $username = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING );
    $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING );
    $logout = filter_input(INPUT_POST, 'logout', FILTER_SANITIZE_STRING );
    echo $username;
    echo "</br>";
    echo $password;
    echo "</br>"; 
    $fp = fopen('C:/xampp/htdocs/PHP-projects/php-crud/DB/user.txt', "r");
    $error = false;
    if($username && $password){
        $_SESSION['loggedin'] = false;
        $_SESSION['user'] = false;
        $_SESSION['role'] = false;
        while($data = fgetcsv($fp)){
            if($data[0] == $username && $data[1] == sha1($password)){
                $_SESSION['loggedin'] = true;
                $_SESSION['user'] = $username;
                $_SESSION['role'] = $data[2];
                header('location:index.php');
            }
        }
        if(!$_SESSION['loggedin']){
            $error = true;
        }
    }

    if(isset( $_GET['logout'])){
        $_SESSION['loggedin'] = false;
        $_SESSION['user'] = false;
        $_SESSION['role'] = false;
        session_destroy();
        header('location:index.php');
    }
    if($logout == 1){
        $_SESSION['loggedin'] = false;
        $_SESSION['user'] = false;
        $_SESSION['role'] = false;
        session_destroy();
        header('location:auth.php');
    }
    
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container main-container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <header class="app-header">
                    <h1>Welcome!</h1>
                    <p>Your Students Management Dashboard, You can change your all students information hare</p>
                    <hr>
                    <?php include_once ('templates/nav.php'); ?>
                    <hr>
                </header>
            </div>
        </div>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <h2>Login Your Account</h2>
                    
                    <?php if ( isset($_SESSION['loggedin']) ) {
                        echo "<h3> Hello Admin, Welcome! </h3>";
                    } else {
                        echo "<h3> Hello Stranger, Login Below </h3>";
                    }
                    ?>
                    <?php
                    if ( $error ) {
                        echo "<blockquote>Username and Password didn't match</blockquote>";
                    } 
                    if ( !isset($_SESSION['loggedin'] )):
                    ?>
                    <form  method="POST">
                        <label for="user">User Name</label>
                        <input type="text" name="user" id="user" value="">
                        <label for="pass">Password</label>
                        <input type="password" name="pass" id="pass" value="" >
                        <button type="submit" name="submit" class="button button-primary">Login</button>
                    </form>
                    <?php else: ?>
                    <form  method="POST">
                        <input type="hidden" name="logout" value="1">
                        <button type="submit" name="submit" class="button button-primary">Log out</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>


    </div>
    <script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>