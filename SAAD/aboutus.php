<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/aboutus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
   


</style>
<body>
    <!-- Header -->
    <input type="checkbox" id="bell">
    <label for="bell" class="label-bell"><i class="bx bx-bell"></i></label>

    <h3 class="head-t">1</h3>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <i class='bx bxl-codepen'></i>
                <span>HUHUHUHUHU</span>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>

        <div class="user">
            <div>
                <p class="bold">Ferd O.</p>
                <p>Admin</p>
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
                <a href="aboutus.html">
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

    <section class="hero">
        <div class="container">
            <h1 class="display-4">ABOUT US</h1>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctu.</p>    
        </div>
    </section>

    <section class="hero1">
        <div class="container">
            <img src="pics/bilao" alt="Bread Header">
            <div class="text-container">
                <h1 class="display-4">Home Sweet Bakery</h1>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            </div>
        </div>
    </section>
    


    <section class="highlight-section">
        <div class="text-container">
            <h2>Freshly Baked Bread Every Morning</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies ligula nec lectus accumsan luctus.</p>
        </div>
        <img src="pics/beng.jpg" alt="Freshly Baked Bread">
    </section>

    
<!-- Benefits Section -->
<section class="benefits-section">
    <div class="container">
        <h2 class="mb-3">Benefits of Breads</h2>
        <div class="cards-container">
            <!-- Benefit 1 -->
            <div class="card">
                <h5 class="card-title">There’s So Much Choice</h5>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <!-- Benefit 2 -->
            <div class="card">
                <h5 class="card-title">It Tastes Great</h5>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <!-- Benefit 3 -->
            <div class="card">
                <h5 class="card-title">Prebiotic Properties</h5>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <!-- Benefit 4 -->
            <div class="card">
                <h5 class="card-title">Fuel for Longer</h5>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <!-- Benefit 5 -->
            <div class="card">
                <h5 class="card-title">Folic Acid Boost</h5>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            <!-- Benefit 6 -->
            <div class="card">
                <h5 class="card-title">It’s Cost Effective</h5>
                <p>Lorem ipsum dolor sit amet.</p>
            </div>
            
        </div>
    </div>
</section>

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

    btn.onclick = function(){
        sidebar.classList.toggle('active')
    };
</script>

</html>