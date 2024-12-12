<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
    <link rel="icon" href="images/yplogo.png"> 
    <title>Sign UP</title>
</head>
<body>

<div class="container">
    <div class="box form-box">

    <?php
    include("koneksi.php");
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $telepon = $_POST['telepon'];

        $hashed_password = md5($password);

        // check email
        $verift_query = mysqli_query($con, "SELECT email FROM tbl_user WHERE email='$email'");
        
        if (mysqli_num_rows($verift_query) != 0) {
            echo "<div class='massage'>
                    <p>This email is already used, try another one</p>
                </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
        } else {
            
            //add data
            $insert_query = "INSERT INTO tbl_user (email, username, password, telepon) 
                            VALUES ('$email', '$username', '$hashed_password', '$telepon')";

        //pesan 
            if (mysqli_query($con, $insert_query)) {
                echo "<div class='message'>
                        <p>Registration successful</p>
                    </div> <br>";
                echo "<a href='index.php'><button class='btn'>Login Now</button></a>";
            } else {
                echo "<div class='message'>
                        <p>Error: " . mysqli_error($con) . "</p>
                    </div> <br>";
            }
        }
    } else {
    ?>
        <header>Sign UP</header>
        <form action="" method="post">
            <!-- Email -->
            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" required>
            </div>
            <!-- Username -->
            <div class="field input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off" required>
            </div>
            <!-- Password -->
            <div class="field input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="off" required>
            </div>
            <!-- Telepon -->
            <div class="field input">
                <label for="telepon">Phone</label>
                <input type="text" name="telepon" id="telepon" autocomplete="off" required >
            </div>
            <!-- Submit -->
            <div class="field">
                <input type="submit" class="btn" name="submit" value="Sign Up">
            </div>
            <div class="link">
                Already a member? <a href="index.php">Log in</a>
            </div>
        </form>
    <?php } ?>
    </div>
</div>

</body>
</html>
