<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
    <title>Login</title>
</head>
<body>
        <div class="container">
            <div class="box form-box">
                <?php
                include("koneksi.php");
                if (isset($_POST['submit'])) {
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $password = mysqli_real_escape_string($con, $_POST['password']);
                    
                    // hasd to MD5
                    $hashed_password = md5($password);
                    
                    $result = mysqli_query($con, "SELECT * FROM tbl_user WHERE email='$email' AND password='$hashed_password'") or die("Select Error");
                    $row = mysqli_fetch_assoc($result);

                    if (is_array($row) && !empty($row)) {
                        $_SESSION['valid'] = $row['email'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['telepon'] = $row['telepon'];
                        $_SESSION['id'] = $row['id'];
                        header("Location: home.php");
                        exit();
                    } else {
                        echo "<div class='massage'>
                                <p>Wrong Username or Password</p>
                            </div> <br>";
                        echo "<a href='index.php'><button class='btn'>Go back</button></a>";
                    }
                } else {
                ?>

                <header>Login</header>
                <form action="" method="post">
                    <!-- Email -->
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" required>
                    </div>
                    <!-- Password -->
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                            <!-- Lupa Password -->
                            <div style="text-align: right; margin-top: 5px;">
                                <a href="forgot-password.php" style="font-size: 0.9em; text-decoration: none; color: #6c63ff;">Forgot Password?</a>
                            </div>
                    </div>
                    <!-- Submit -->
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login">
                    </div>
                    <div class="link">
                        Don't have account? <a href="register.php">Sign Up</a>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
</body>
</html>
