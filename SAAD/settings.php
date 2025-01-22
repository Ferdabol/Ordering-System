<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Header -->

    <input type="checkbox" id="bell">
    <label for="bell" class="label-bell"><i class="bx bx-bell"></i></label>

    <h3 class="head-t">1</h3>


    <!-- Sidebar -->
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <img src="pics/logo.png" alt="Logo">
                <h3>M's Bilao</h3>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>

        <div class="user">
            <div>
                <p class="bold"><?php echo $_SESSION['userinfo']['Fname'] . ' ' . substr($_SESSION['userinfo']['Lname'], 0, 1) . '.'; ?></p>
                <p>Customer</p>
            </div>
        </div>
        <ul>
            <li>
                <a href="homepage.php">
                    <i class="bx bxs-home"></i>
                    <span class="nav-item">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>
            <li>
                <a href="menu.php">
                    <i class="bx bx-food-menu"></i>
                    <span class="nav-item">Menu</span>
                </a>
                <span class="tooltip">Menu</span>
            </li>
            <li>
                <a href="profile.php">
                    <i class="bx bxs-smile"></i>
                    <span class="nav-item">Profile</span>
                </a>
                <span class="tooltip">Profile</span>
            </li>
            <li>
                <a href="aboutus.php">
                    <i class="bx bxs-info-circle"></i>
                    <span class="nav-item">About</span>
                </a>
                <span class="tooltip">About</span>
            </li>
            <li>
                <a href="login.php">
                    <i class="bx bx-log-out"></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
        </ul>
    </div>

    <!-- Profile Page -->
    <div class="profile-container">
        <div class="profile">
            <div class="profile-header">
                <img class="profile-img" src="pics/sample.jpg">
                <div class="profile-text-container">
                    <h1 class="profile-tile"><?php echo $_SESSION['userinfo']['Fname'] . ' ' . substr($_SESSION['userinfo']['Lname'], 0, 1) . '.'; ?></h1>
                    <p class="profile-email"><?php echo $_SESSION['userinfo']['Email']; ?></p>
                </div>
            </div>

            <div class="account-info">               
                <a href="profile.php" class="account-link"><span class="fa solid fa-user account-icon"></span>Account</a>
                <a href="settings.php" class="account-link"><span class="fa solid fa-gear account-icon"></span>Settings</a>
                <a href="orderhistory.php" class="account-link"><span class="fa solid fa-user account-icon"></span>Order History</a>
            </div>
        </div>

        <form class="account" method="post">
            <?php
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
<script>
    let btn = document.querySelector('#btn')
    let sidebar = document.querySelector('.sidebar')

    btn.onclick = function(){
        sidebar.classList.toggle('active')
    };
</script>
</html>