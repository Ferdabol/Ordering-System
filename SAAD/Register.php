<?php
include("connection.php");

$notice = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone_Number'];
    $password = $_POST['Password'];
    $confirmPassword = $_POST['Confirm_Password'];
    $address = $_POST['Address'];

    // Basic validation
    if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword) || empty($address)) {
        $notice = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        $notice = "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL query
        $sql = "INSERT INTO userinfo (Fname, Lname, Email, Password, Phone_No, Address) 
                VALUES ('$fname', '$lname', '$email', '$hashedPassword', '$phone', '$address')";

        if ($conn->query($sql) === TRUE) {
            $notice = "Registration successful!";
        } else {
            $notice = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat-BLACK&display=swap" rel="stylesheet">
    <title>Temsiz</title>
</head>
<body background="profiles/tech.jpg">
    <section class="side">
        <img src="pics/logo.png" alt="">
    </section>

    <section class="main">

        <div class="login-container">
            <p class="title">REGISTER</p>
            <div class="separator"></div>
            <p class="welcome-message">To proceed, please provide the following information</p>

            <form class="login-form" method="POST">
                <div class="account-edit">
                    <div class="account-input">
                        <input type="text" name="Fname" placeholder="Fname" required>
                    </div>
                    <div class="account-input">
                        <input type="text" name="Lname" placeholder="Lname" required>
                    </div>
                </div>
                <div class="account-edit">
                    <div class="account-input">
                        <input type="email" name="Email" placeholder="Email" required>
                    </div>
                    <div class="account-input">
                        <input type="text" name="Phone_Number" placeholder="Phone Number" required>
                    </div>
                </div>
                <div class="account-edit">
                    <div class="account-input">
                        <input type="password" name="Password" placeholder="Password" required>
                    </div>
                    <div class="account-input">
                        <input type="password" name="Confirm_Password" placeholder="Confirm Password" required>
                    </div>
                </div>

                <div class="account-edit">
                    <div class="account-input">
                        <textarea name="Address" placeholder="Enter Address" required></textarea>
                    </div>
                </div>
                <button class="submit" type="submit">Register</button>
            </form>

            <p class="register-message">Already have an account? <a href="Login.php">Login</a></p>

            <?php if (!empty($notice)) { ?>
                <p style="color: red;"><?php echo $notice; ?></p>
            <?php } ?>
        </div>
    </section>
</body>
</html>
