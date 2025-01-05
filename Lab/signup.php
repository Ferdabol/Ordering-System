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
    <h1>Sign Up</h1>

    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="uinput">
        <input type="text" name="fname" placeholder="First Name">
        <br>
        <input type="text" name="lname" placeholder="Last Name">
        <br>
        <input type="text" name="email" placeholder="Email">
        <br>
        <input type="password" name="password" placeholder="Password"
        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$"
        title="Must contain at least 1 uppercase, 1 lowercase, one number, and at least 8 characters long">  
      </div>

      
      <input type="submit" value="Sign up">

      <div class="signup">
        Already Have an account? <a href="login.php">Login</a>
      </div>

      <div class="error">
        <?php
          include ('connection.php');

          if($_SERVER['REQUEST_METHOD'] == "POST") {
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            if(empty($fname) || empty($lname) || empty($email) || empty($password)) {
              echo "Please fill in all fields";
            }
            else {
              $sql = "INSERT INTO userinfo (fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$password')";
              mysqli_query($conn, $sql);
            }

            mysqli_close($conn);
          }
        ?>
      </div>
    </div>
  </body>
</html>