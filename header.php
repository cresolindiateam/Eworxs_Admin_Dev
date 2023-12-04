<?php
require 'dbconfig.php';
ini_set("session.gc_maxlifetime", "3600");
ini_set("session.cookie_lifetime","3600");
session_start();
if(isset($_SESSION['username'])){
  if($_SESSION['username']==""){
    echo "<script> window.location = 'admin_login.php'</script>";
  }
}



// else{
//   echo "<script> window.location = 'admin_login.php'</script>";
// }






?>
  <header class="main-header">
    <a href="javascript:void(0)" class="logo">
     </a>
    <nav class="navbar navbar-static-top">
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu pr-20 active">
            <a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a>
          </li>
        </ul>
     </div>
    </nav>
  </header>

