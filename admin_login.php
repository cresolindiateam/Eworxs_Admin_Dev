<?php
require 'dbconfig.php';
$con=db_connect();
function redirect($location) {
    header("Location: $location");
    exit;
}
if (isset($_POST['SignIn']) && !empty($_POST['SignIn'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    if (empty($username) || empty($password)) {
        $UsernameError = "Username or Password can not be empty.";
        echo "<script>alert('$UsernameError')</script>";
    } else {
        $stmt = $con->prepare("SELECT * FROM companies WHERE email = ? AND password = ? AND status = 1 AND role = 1");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_start();
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 1;
            redirect("companies_list.php");


        } else {

            

            $stmt = $con->prepare("SELECT * FROM companies WHERE email = ? AND password = ? AND status = 1 AND verification_status = 1 AND role = 2");
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                session_start();
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 2;
                $_SESSION['companyid'] = $row['id'];
                redirect("profile.php");
            } else {
                $stmt = $con->prepare("SELECT * FROM companies WHERE email = ? AND status = 1 AND verification_status = 0 and role= 2");
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $UsernameError = "Account is not verified. Please Check Your Email";
                    echo "<script>alert('$UsernameError')</script>";
                } else {
                    $UsernameError = "Invalid User or Password! Enter valid details.";
                    echo "<script>alert('$UsernameError')</script>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EWORXS | Automatically Track Your Mileage</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="description" content="Mileage Tracking,Work Hour Tracking,Document Capturing, Automated Invoicing &much more!">
    <meta name="keywords" content="Eworxs,Client Invoicing,Field Worker Managemnet,Automatic Mileage Tracking">
    <meta name="author" content="Eworxs Support">
    <meta property="og:image" content="http://eworxs.app/img/banner1.jpg">
    <meta property="og:image:secure" content="https://eworxs.app/img/banner1.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1344">
    <meta property="og:image:height" content="840">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
</head>
<style type="text/css">
.password-container {
  position: relative;
}
#password {
  padding-right: 30px; /* Add space for the eye icon */
}
.toggle-password {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  cursor: pointer;
}
</style>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="mycompany-name" style="font-family: unset; text-transform: uppercase; font-weight: bold; font-size: 48px; letter-spacing: 4px;">
            E<span style="font-size: 38px">worxs</span>
        </div>
        <hr>
        <img src="dist/img/mobile.png" style="display: none;">
        <div class="theme-form">
            <form action="admin_login.php" method="post">
                <div class="login-header" style="display: none">Sign in to Admin Panel</div>
                <div class="login-inner-box">
                    <div class="form-group has-feedback">
                        <label style="display:none">Email</label>
                        <input type="text" class="form-control" placeholder="Email" name="username">
                        <i class="fa fa-user login-inner-icon"></i>
                    </div>
                    <div class="form-group has-feedback">
                        <label style="display:none">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Password" name="password" autocomplete="off">
                        <i class="toggle-password fa fa-eye" style="color:#3e276d" onclick="togglePasswordVisibility()"></i>
                        <i class="fa fa-lock login-inner-icon"></i>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="forgot_password.php" class="text-right">Forgot Password?</a>
                        </div>
                        <div class="col-xs-12">
                            <center><input type="submit" name="SignIn" class="btn theme-btn" value="Sign In" /></center>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="designby-text" >Designed By <a href="http://www.cresol.in/" target="blank">Cresol.in</a></div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
<script type="text/javascript">
    function togglePasswordVisibility() {
  const passwordField = document.getElementById('password');
  const icon = document.querySelector('.toggle-password');
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    passwordField.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}
</script>
</body>
</html>
