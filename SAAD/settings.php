<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Header -->

    <h3 class="logo">HUHUHUHUHU</h3>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-menu">
            <span class="fa fa-home"></span>
            <a href="#">Home</a>
        </div>
        <div class="sidebar-menu">
            <span class="fa fa-bars"></span>
            <a href="menu.php">Menu</a>
        </div>
        <div class="sidebar-menu">
            <span class="fa fa-user"></span>
            <a href="settings.php">Profile</a>
        </div>
        <div class="sidebar-menu">
            <span class="fa fa-address-card"></span>
            <a href="#">About Us</a>
        </div>
        <div class="sidebar-menu">
            <span class="fa fa-phone"></span>
            <a href="#">Contact</a>
        </div>   
    </div>

    <!-- Profile Page -->
    <div class="profile-container">
        <div class="profile">
            <div class="profile-header">
                <img class="profile-img" src="sample.jpg">
                <div class="profile-text-container">
                    <h1 class="profile-tile">Ferdabol</h1>
                    <p class="profile-email">tae@gmail.com</p>
                </div>
            </div>

            <div class="account-info">               
                <a href="profile.php" class="account-link"><span class="fa solid fa-user account-icon"></span>Account</a>
                <a href="settings.php" class="account-link"><span class="fa solid fa-gear account-icon"></span>Settings</a>
                <a href="#" class="account-link"><span class="fa solid fa-bell account-icon"></span>Notification</a>
                <a href="#" class="account-link"><span class="fa solid fa-user account-icon"></span>Order History</a>
            </div>
        </div>

        <form class="account" method="post">
            <?php
                session_start();
                include("connection.php");

                if (isset($_SESSION['userinfo'])) {
                    $userinfo = $_SESSION['userinfo'];

                    if (isset($_POST['save'])) {
                        $ID = $userinfo['ID'];
                        $Fname = $_POST['Fname'];
                        $Lname = $_POST['Lname'];
                        $Email = $_POST['Email'];
                        $Phone_No = $_POST['Phone_No'];
                        $Address = $_POST['Address'];
                        

                        $stmt = $conn->prepare("UPDATE userinfo SET `Fname` = ?, `Lname` = ?, `Email` = ?, `Phone_No` = ?, `Address` = ? WHERE `ID` = ?");
                        $stmt->bind_param("sssssi", $Fname, $Lname, $Email, $Phone_No, $Address,  $userinfo['ID']);

                        if ($stmt->execute()) {
                            echo "Account information updated successfully!";
                            $_SESSION['userinfo'] = array(
                                'ID' => $ID,
                                'Fname' => $Fname,
                                'Lname' => $Lname,
                                'Email' => $Email,
                                'Phone_No' => $Phone_No,
                                'Address' => $Address
                            );
                            header("Location: settings.php");
                            exit;
                        } else {
                            echo "Error updating account information: " . $conn->error;
                        }
                    }
                    ?>
                    
                        <div class="account-header">
                            <h1 class="account-title">Account Settings</h1>
                            <div class="btn-container">
                                <button class="btn-save" type="submit" name="save">Save</button>
                            </div>
                        </div>

                        <div class="account-edit">
                            <div class="account-input">
                                <label>First Name</label>
                                <input type="text" name="Fname">
                            </div>
                            <div class="account-input">
                                <label>Last Name</label>
                                <input type="text" name="Lname">
                            </div>
                        </div>

                        <div class="account-edit">
                            <div class="account-input">
                                <label>Email</label>
                                <input type="email" name="Email">
                            </div>
                            <div class="account-input">
                                <label>Phone Number</label>
                                <input type="text" name="Phone_No">
                            </div>
                        </div>

                        <div class="account-edit">
                            <div class="account-input">
                                <label>Password</label>
                                <input type="email" name="Email">
                            </div>
                            <div class="account-input">
                                <label>Confirm Password</label>
                                <input type="text" name="Phone_No">
                            </div>
                        </div>

                        <div class="account-edit">
                            <div class="account-input">
                                <label>Address</label>
                                <textarea name="Address"></textarea>
                            </div>
                        </div>
                    
                    <?php
                } else {
                    echo "You are not logged in.";
                }
            ?>
        </form>
    </div>
</body>
</html>