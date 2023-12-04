<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
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
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<style>
  body{
    padding: 0px !important;
  }
</style>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  <!-- <img src="dist/img/mobile.png"> -->
   <div class="mycompany-name" style="font-family: unset; text-transform: uppercase; font-weight: bold; font-size: 48px; letter-spacing: 4px;">E<span style="font-size: 38px">worxs</span>
   </div>
    <hr>
    <img src="dist/img/mobile.png" style="display: none;">
    <div class="theme-form" >

<?php
if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"]))
{
  require 'dbconfig.php'; 
  $con=db_connect();
  $key = $_GET["key"];
  $email = $_GET["email"];
  $curDate = date("Y-m-d H:i:s");
  $query = mysqli_query($con,"SELECT * FROM `password_reset_temp` WHERE `key_data`='".$key."' and `email`='".$email."';"
  );
  $row = mysqli_num_rows($query);
  if ($row=="")
  {
    $error .= '<h2>Invalid Link</h2><p>The link is invalid/expired. Either you did not copy the correct link
             from the email, or you have already used the key in which case it is deactivated.</p><p><a href="https://eworxs.app/EworxsAdmin/forgot_password.php">Click here</a> to reset password.</p>';
	}
  else
  {
    $row = mysqli_fetch_assoc($query);
    $expDate = $row['exp_date'];
      if ($expDate >= $curDate)
      {?>
      <form method="post" action="" name="update" >
        <div class="login-inner-box">
      <input type="hidden"  name="action" value="update" />
        <label><strong>Enter New Password:</strong></label><br />
      <div class="form-group has-feedback">
    
      <input type="password" class="form-control" name="pass1" maxlength="15" required />
      <i class="fa fa-lock login-inner-icon"></i>
      <br />
      </div>
       <label><strong>Re-Enter New Password:</strong></label><br />
      <div class="form-group has-feedback">
      <input type="password" class="form-control" name="pass2" maxlength="15" required/>
      <i class="fa fa-lock login-inner-icon"></i>
      </div>
      <br />
      <input type="hidden" name="email" value="<?php echo $email;?>"/>
      <input type="submit" class="btn theme-btn" value="Reset Password" />
      </div>
      </form>
    <?php
    }
    else
    {
    $error .= "<h2>Link Expired</h2><p>The link is expired. You are trying to use the expired link which 
                as valid only 24 hours (1 days after request).<br /><br /></p>";
    }
  }
  if($error!="")
  {
    echo "<div class='error'>".$error."</div><br />";
  }			
} 

if(isset($_POST["email"]) && isset($_POST["action"]) &&($_POST["action"]=="update"))
{
        require 'dbconfig.php'; 
      $con=db_connect();
      $error="";
      $pass1 = mysqli_real_escape_string($con,$_POST["pass1"]);
      $pass2 = mysqli_real_escape_string($con,$_POST["pass2"]);
      $email = $_POST["email"];
      $curDate = date("Y-m-d H:i:s");
      if ($pass1!=$pass2)
      {
       $error.= "<p>Password do not match, both password should be same.<br /><br /></p>";
      }
    if($error!="")
    {
     echo "<div class='error'>".$error."</div><br />";
    }
    else
    {
      $pass1 = md5($pass1);
      mysqli_query($con, "UPDATE `companies` SET `password`='".$pass1."' WHERE `email`='".$email."';");
      mysqli_query($con,"DELETE FROM `password_reset_temp` WHERE `email`='".$email."';");
      echo '<div class="error" style="color: #00a65a;font-size: 15px;text-align: center;"><p>Congratulations! Your password has been updated successfully.</p>
      <p><a href="https://eworxs.app/EworxsAdmin/admin_login.php">
      Click here</a> to Login.</p></div><br />';
    }		
}
?>

 </div>
  </div>
 <div class="designby-text">Designed By <a href="http://www.cresol.in/" target="blank">Cresol.in</a></div>
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
</body>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jQuery/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="plugins/jQuery/raphael-min.js"></script>
<!-- daterangepicker -->
<script src="plugins/jQuery/moment.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</script>
</body>
</html>
