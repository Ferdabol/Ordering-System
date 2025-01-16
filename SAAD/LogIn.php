<?php
    session_start();
    include("connection.php");

    // Check if the login form has been submitted
    if(isset($_POST["login"])) {
        $email = $_POST["Email"];
        $password = $_POST["password"];

        // Query the userinfo table to check if the email and password match
        $sql = "SELECT * FROM userinfo WHERE Email = '$email' AND Password = '$password'";
        $result = mysqli_query($conn, $sql);

        // Check if a matching record is found
        if(mysqli_num_rows($result) == 1) {
            // Fetch the user data from the result
            $row = mysqli_fetch_assoc($result);

            $_SESSION['userinfo'] = $row;

            header("Location: profile.php");
            exit;
        } else {
            // Display an error message if the email and password don't match
            $notice = "Invalid email or password";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat-BLACK&display=swap" rel="stylesheet">
    <title>Temsiz</title>
</head>
<body background="profiles/tech.jpg">
    <section class="side">
        <img src="profiles/logo_vector.png" alt="">
    </section>

    <section class="main">
        <div class="login-container">
            <p class="title">EWAN</p>
            <div class="separator"></div>
            <p class="welcome-message">Please, provide login credential to proceed and have access to all our services</p>

            <form class="login-form" method="post">
                <div class="form-control">
                    <input type="text" placeholder="Email" name="Email">
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-control">
                    <input type="password" placeholder="Password" name="password">
                    <i class="fas fa-lock"></i>
                </div>
                <button class="submit" name="login">Login</button>
            </form>

            <?php if(isset($notice)) { ?>
                <p style="color: red;"><?php echo $notice; ?></p>
            <?php } ?>
        </div>
    </section>
</body>
</html>