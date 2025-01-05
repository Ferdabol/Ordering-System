<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratory Activity 1</title>
    <link rel="stylesheet" type="text/css" href="LS.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post">
        <div class="uinput">
            <input type="text" id="email" name="email" placeholder="Email">
            <br>
            <input type="password" id="password" name="password" placeholder="Password"
            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$"
            title="Must contain at least 1 uppercase, 1 lowercase, one number, and at least 8 characters long">    
        </div>

        <input type="submit" value="Login">

        <div class="signup">
            Dont Have an account? <a href="signup.php">Sign up</a>
        </div>
    
        <div class="error">
            <?php
                session_start();

                include("connection.php");

                $attempts = 2;
                $time_out = 10;

                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    if (empty($email) || empty($password)) {
                        echo "Please enter your Username and Password";
                    } else {
                        if (isset($_SESSION['failed_attempts'][$email])) {
                            if ($_SESSION['failed_attempts'][$email]['attempts'] >= $attempts) {
                                echo 'Account blocked. Try again after ' . $time_out . ' minutes.';
                                exit;
                            }
                        }

                        $sql = "SELECT * FROM userinfo WHERE Email = '$email' AND Password = '$password'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) == 1) {
                            $row = mysqli_fetch_assoc($result);
                            $_SESSION['userinfo'] = $row;
                            unset($_SESSION['failed_attempts'][$email]);
                            header("Location: profile.php");
                            exit;
                        } else {
                            if (!isset($_SESSION['failed_attempts'][$email])) {
                                $_SESSION['failed_attempts'][$email] = array('attempts' => 1);
                            } else {
                                $_SESSION['failed_attempts'][$email]['attempts']++;
                            }
                            echo "Invalid email or password";
                        }
                    }
                }
            ?>
        </div>

    </div>
</body>
</html>