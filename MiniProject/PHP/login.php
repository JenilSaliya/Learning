
<?php
session_start();
include("connection.php");
function login($username, $password)
{
    global $connect;
    $selectqry = "select * from user where username = '$username' and password='$password'";
    $result = mysqli_query($connect, $selectqry);
    $count = mysqli_num_rows($result);
    $userdata=mysqli_fetch_assoc($result);
    if ($count > 0) {
        if($username == 'admin'){
            $_SESSION['user_id'] =$userdata['user_id'];
            header("location:adminpanel.php");
        }
        else{
            header("location:expense.php");
            $_SESSION['user_id'] =$userdata['user_id'];
        }
       
    } else {
        return 'either email or password is wrong';
    }
}

function register($uName, $username, $gender, $email, $password)
{
    global $connect;


    $insertqry = "insert into user (uName, username, password, email, gender) values('$uName','$username','$password','$email','$gender')";
     mysqli_query($connect, $insertqry);
}

if (isset($_POST['btnlogin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $message=login($username, $password);
}

if (isset($_POST['btnreg'])) {
    $uName = $_POST['uName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    if ($_POST['password'] === $_POST['cPassword']) {
        global $connect;
        $selectuserid = "select user_id from user where username='$username'";
        $cUserid = mysqli_query($connect, $selectuserid);
        $count = mysqli_num_rows($cUserid);
        if ($count > 0) {
            $message = "$username username is not available";
        }
        else{
            if($username == 'admin'){
                $message = "Error : $username is not valid";
            }
            else{
                register($uName, $username, $gender, $email, $password);
            }
        }
        
    } else {
        $message = "Error : Password is not match please try again";
    }

}



?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Login</title>
    <link rel="stylesheet" href="../CSS/login.css">
    <link rel="stylesheet" href="../CSS/Utility.css">
</head>

<body>
    <?php
    if (isset($message)) {
        echo "<div class='error'>$message<button><div class='cancle'><ion-icon name='close'></ion-icon></div></div></button>";
    }
    ?>

    <main class="main">
        <div class="fbox login">
            <h2>Login</h2>
            <form method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required maxlength="8">
                    <label for="password">Password</label>
                </div>
                <button type="submit" class="btn" name="btnlogin">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>

        <div class="fbox registration">
            <h2>Create New Account</h2>
            <form method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="people"></ion-icon></span>
                    <input type="text" name="uName" required>
                    <label for="uName">Name</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="text" name="email" required>
                    <label for="email">Email</label>
                </div>
                <div class="radiobtn">
                    <input type="radio" name="gender" value="male">
                    <label>Male</label>
                    <input type="radio" name="gender" value="female">
                    <label>female</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required maxlength="8">
                    <label for="password">Password</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="cPassword" required maxlength="8">
                    <label for="cPassword"> Confirm Password</label>
                </div>
                <button type="submit" class="btn regbtn" name="btnreg">Create Account</button>
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </main>
    <script src="../JS/login.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>