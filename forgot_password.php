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
    <style>
        body {
            padding: 0px !important;
        }
    </style>
</head>
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
            <?php
             if (isset($_POST["email"]) && empty($_POST["email"]))
                {
                    $error .= "<p>Email can not be empty.</p>";
                     if($error!="")
                {
                    echo "<div class='error'>".$error."</div><br/><a href='javascript:history.go(-1)'>Go Back</a>";
                }
                 } 
                
            elseif (isset($_POST["email"]) && (!empty($_POST["email"])))
            {
         
                require 'dbconfig.php';
                $con = db_connect();
                $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
                $email_data=$_POST["email"];
               if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $error .= "<p>Invalid email address. Please type a valid email address!</p>";
                }
                else
                {
                    $sel_query = "SELECT id FROM `companies` WHERE email='".$email."'";
                    $results = mysqli_query($con, $sel_query);
                    $row = mysqli_num_rows($results);
                    if (empty($row))
                    {
                        $error .= "<p>No user is registered with this email address!</p>";
                    }
                }

                if($error!="")
                {
                    echo "<div class='error'>".$error."</div><br/><a href='javascript:history.go(-1)'>Go Back</a>";
                }
                else
                {
                    $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
                    $expDate = date("Y-m-d H:i:s", $expFormat);
                    $key = md5(2418*2+$email);
                    $addKey = substr(md5(uniqid(rand(),1)),3,10);
                    $key = $key . $addKey;
                    mysqli_query($con, "INSERT INTO `password_reset_temp` (`email`, `key_data`, `exp_date`) VALUES ('".$email."', '".$key."', '".$expDate."');");
                    // $output = '<p>Dear user,</p>';
                    // $output .= '<p>Please click on the following link to reset your password.</p>';
                    // $output .= '<p>-------------------------------------------------------------</p>';
                    // $output .= '<p><a href="https://eworxs.app/EworxsAdmin/reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">https://eworxs.app/EworxsAdmin/reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';
                    // $output .= '<p>-------------------------------------------------------------</p>';
                    // $output .= '<p>Please be sure to copy the entire link into your browser. The link will expire after 1 day for security reasons.</p>';
                    // $output .= '<p>If you did not request this forgotten password email, no action is needed, your password will not be reset. However, you may want to log into your account and change your security password as someone may have guessed it.</p>';
                    // $output .= '<p>Thanks,</p>';
                    // $output .= '<p>Eworxs Team</p>';
                    // $message = $output;
                    // $subject = "Password Recovery - Eworxs.app";
                    // $from = 'support@eworxs.app';
                    // $headers = "From: $fromName"." <".$from.">";
                    // $returnpath = "-f" . $from;
                    // $email_to = $email;
                    // $mail = @mail($email_to, $subject, $message, $headers, $returnpath);
                    // if(!$mail)
                    // {
                    //     echo "Mailer Error: " . $mail->ErrorInfo;
                    // }

$apiKey = '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';
$senderEmail = 'info@eworxs.app';
$recipientEmail = $email;
$subject = "Password Recovery - Eworxs.app";
// $message = '<p>Click On This Link to Verify Email</p>'.$link;

 $output = '<p>Dear user,</p>';
     if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            {
                $linkdomain = "https";
            }
            else
            {
             $linkdomain = "http";
            }
            $linkdomain .= "://";
            $linkdomain .= $_SERVER['HTTP_HOST'];
                    $output .= '<p>Please click on the following link to reset your password.</p>';
                    $output .= '<p>-------------------------------------------------------------</p>';
                    $output .= '<p><a href="'.$linkdomain.'/EworxsAdmin/reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">https://eworxs.app/EworxsAdmin/reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';
                    $output .= '<p>-------------------------------------------------------------</p>';
                    $output .= '<p>Please be sure to copy the entire link into your browser. The link will expire after 1 day for security reasons.</p>';
                    $output .= '<p>If you did not request this forgotten password email, no action is needed, your password will not be reset. However, you may want to log into your account and change your security password as someone may have guessed it.</p>';
                    $output .= '<p>Thanks,</p>';
                    $output .= '<p>Eworxs Team</p>';
                    $message = $output;

// Define the SendGrid API endpoint
$sendgridApiUrl = 'https://api.sendgrid.com/v3/mail/send';

// Create an array of data to send in the request
$data = array(
    'personalizations' => array(
        array(
            'to' => array(
                array(
                    'email' => $recipientEmail
                )
            )
        )
    ),
    'from' => array(
        'email' => $senderEmail,
       
    ),
    'subject' => $subject,
    'content' => array(
        array(
            'type' => 'text/html',
            'value' => $message
        )
    )
);

$data = json_encode($data);

// Set up cURL to make the POST request
$ch = curl_init($sendgridApiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close the cURL session
curl_close($ch);

if ($httpCode == 202) {

 echo "<div class='error' style='color: #00a65a;font-size: 15px;text-align: center;'>
                        <p>An email has been sent to you with instructions on how to reset your password.</p>
                        </div><br /><br /><br />";
}
                    else
                    {
                        // echo "<div class='error' style='color: #00a65a;font-size: 15px;text-align: center;'>
                        // <p>An email has been sent to you with instructions on how to reset your password.</p>
                        // </div><br /><br /><br />";

                         echo "Mailer Error: " . $httpCode;
                    }
                }
            }
            else
            {
            ?>
            <form method="post" action="" name="reset">
                <div style="text-align: center;font-weight: 800;">
                    <center><strong>Enter Your Email Address:</strong></center>
                </div>
                <br />
                <input type="email" class="form-control" name="email" placeholder="username@email.com" style="border: 1px solid #e1e4e8 !important" />
                <div style="text-align:center;">
                    <input type="submit" class="theme-btn btn" value="Reset Password" />
                </div>
                <div style="text-align:center;">
                    <a href="https://eworxs.app/EworxsAdmin/admin_login.php">Login</a>
                </div>
            </form>
            <?php } 

            

            ?>
        </div>
    </div>
    <div class="designby-text">Designed By <a href="http://www.cresol.in/" target="blank">Cresol.in</a></div>
</div>
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
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
</body>
</html>
