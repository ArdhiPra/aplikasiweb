<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Navbar gradient background for welcome text */
        .navbar-top {
            background: linear-gradient(90deg, #A52A2A, #4682B4);
            color: white;
            text-align: center;
            font-size: 1rem;
            padding: 5px;
            font-family: Arial, sans-serif;
        }

        /* Navbar lower part */
        .navbar-main {
            background-color: white;
            padding: 8px 20px;
            border-bottom: 2px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Logo styling */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.7rem;
            color: #A52A2A;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand span {
            color: #4682B4;
        }

        /* Home icon and label styling */
        .navbar-nav .nav-link {
            color: black;
            font-size: 1.2rem;
            margin-right: 20px;
            display: flex;
            align-items: center;
        }

        /* Search bar styling */
        .search-bar {
            position: relative;
            width: 75%;
            max-width: 250px;
            margin: 0 auto;
            display: flex;
            align-items: center;
        }

        .search-input {
            width: 100%;
            border-radius: 20px;
            border: 1px solid #ccc;
            padding: 5px 15px 5px 35px;
            font-size: 1rem;
        }

        .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            color: black;
        }

        /* Icon styling for cart and profile */
        .navbar-icons i {
            font-size: 1.5rem;
            color: black;
            margin-left: 30px;
            cursor: pointer;
        }

        .navbar-icons i:hover {
            color: #4682B4; /* Ubah warna saat hover */
            transform: scale(1.2); /* Perbesar ikon */
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <div class="navbar-top">
        Welcome to YourPC.id
    </div>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg navbar-main">
        <div class="d-flex align-items-center">
            <!-- Brand/logo -->
            <a class="navbar-brand" href="home.php">
                <span style="color: #A52A2A;">Y</span>our<span style="color: #4682B4;">PC</span>.id
            </a>
            <!-- Home Icon -->
            <a href="home.php" class="nav-link d-flex align-items-center">
            <i class="bi bi-pc-display m-1"></i></i> Pre-Build
            </a>
        </div>
        <!-- Right Icons (Cart and Profile) -->
        <div class="navbar-icons d-flex align-items-center">
            <a href="cart.php"><i class="bi bi-cart3"></i></a>
            <a href="profile.php"><i class="bi bi-person-circle"></i></a>
        </div>
    </nav>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

</body>
</html>
