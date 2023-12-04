<?php 
require 'dbconfig.php';
ini_set("session.gc_maxlifetime", "3600");
ini_set("session.cookie_lifetime","3600");
session_start();
if(isset($_SESSION['username'])){
  if($_SESSION['username']==""){
    echo "<script> window.location = 'admin_login.php'</script>";
  }
}else{
  echo "<script> window.location = 'admin_login.php'</script>";
}
if ($_SESSION["role"] == 1) {
    echo "<script> window.location = 'admin_login.php'</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$num=0;
$db=db_connect();

$company_id = $_SESSION["companyid"];
$oldpass=md5($_POST['OldPAss']);
$company_id=$_SESSION['companyid'];
$newpassword=md5($_POST['NewPAss']);
$sql=mysqli_query($db,"SELECT password FROM companies where password='$oldpass' && id='$company_id'");
if($sql->num_rows>0)
{
  $sqlUpdate="update companies set password='$newpassword' where id='$company_id'";
  $exeUpdate = mysqli_query($db,$sqlUpdate);
  if($exeUpdate==1)
  {
    echo "company password updated";
   }
  else
  {
    echo "company password not updated";
   }

}
else
{
 echo "old password is not correct";
}
}
?>

