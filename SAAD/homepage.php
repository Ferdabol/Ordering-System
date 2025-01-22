<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Header -->
    <input type="checkbox" id="bell">
    <label for="bell" class="label-bell"><i class="bx bx-bell"></i></label>

    <h3 class="head-t" type="hidden">3wad</h3>

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

    <!-- Main Content -->
    <div class="container">
        <div class="text-section">
            <div class="badge">M'S BILAO</div>
            <h1>FRESHLY PREPARED BILAO FOR YOU</h1>
            <p>Bringing the smell and taste of your favorite Filipino dishes to your door. By fresh, we mean fresh...</p>
            <a href="menu.php">Shop All Food</a>
        </div>
        <div class="image-section">
            <img src="pics/b.jpg" alt="Pastry Box">         
        </div>
    </div>

    <!-- Additional Section -->
    <div class="additional-section">
        <h2>More About Our Products</h2>
        <p>We carefully prepare each bilao with love and use only the finest ingredients. Experience the joy of freshly cooked Filipino dishes.</p>
       
        <div class="images">
            <img src="pics/b1.jpg" alt="Product 1">
            <img src="pics/b2.jpg" alt="Product 2">
            <img src="pics/b3.jpg" alt="Product 3">
            <img src="pics/b4.jpg" alt="Product 4">
            <img src="pics/b.jpg" alt="Product 5">
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <h3>STAY CONNECTED</h3>
        <p>Follow us on our social media channels and stay up-to-date with our latest offers and news.</p>
        <div class="social-links">
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-instagram"></a>
            <a href="#" class="fa fa-twitter"></a>
            <a href="#" class="fa fa-pinterest"></a>
        </div>
    </div> 

    <script>
        let btn = document.querySelector('#btn')
        let sidebar = document.querySelector('.sidebar')

        btn.onclick = function() {
            sidebar.classList.toggle('active')
        };
    </script>
</body>
</html>
