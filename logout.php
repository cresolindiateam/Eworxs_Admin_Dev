<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
    unset($_SESSION["companyid"]);
   

  	//echo "<script> window.location = 'http://prateekmobile.justevent.in/admin_login.php'</script>";

echo "<script> window.location = 'admin_login.php'</script>";

?>