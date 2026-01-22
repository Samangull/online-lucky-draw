<?php
session_start();
require('connection.php');
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VU Alumni-Student ConnectBook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Font Awesome -->
    <link href="assests/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="assests/js/jquery.min.js"></script>
    <script src="assests/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f9fc;
        }

        .navbar {
            background: linear-gradient(90deg, #007bff, #00c6ff);
            border: none;
        }

        .navbar .navbar-brand {
            font-size: 20px;
            font-weight: bold;
            color: #fff !important;
        }

        .navbar-nav > li > a {
            color: #fff !important;
            font-weight: 500;
            padding: 12px 16px;
        }

        .navbar-nav > li > a:hover,
        .navbar-nav > .active > a {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        .navbar-right > li > a {
            font-size: 14px;
        }

        .user-welcome {
            color: white;
            font-weight: 500;
            margin-top: 10px;
            margin-right: 15px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap"></i>Online Lucky Draw System
            </a>
        </div>

        <ul class="nav navbar-nav">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>

            <?php if (isset($_SESSION['name'])): ?>
                <li><a href="profile.php"><i class="fa fa-user"></i>Profile</a></li>
          
                <li><a href="lucky_draw_results.php"><i class="fa fa-list"></i>View Result</a></li>

   <li><a href="events.php"><i class="fa fa-list"></i> View Lucky Draws</a></li>


            <?php endif; ?>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <?php if (isset($_SESSION['name'])): ?>
                <li class="user-welcome">Welcome, <strong><?php echo $_SESSION['name']; ?></strong></li>
                <li><a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            <?php else: ?>
                <li><a href="login.php"><i class="fa fa-user-graduate"></i> User Login</a></li>
            
                <li><a href="register.php"><i class="fa fa-user-plus"></i> Register</a></li>
                <li><a href="admin/login.php"><i class="fa fa-user-shield"></i> Admin Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

</body>
</html>
