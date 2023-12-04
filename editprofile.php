<?php
require 'dbconfig.php';
session_start();
if ($_SESSION["role"] == 1) {
    echo "<script> window.location = 'admin_login.php'</script>";
} 
if($_SESSION['username']==""){
echo "<script> window.location = 'admin_login.php';</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$first_name=$_REQUEST["first_name"];
$user_name=$_REQUEST["user_name"];
$last_name=$_REQUEST["last_name"];
$phone=$_REQUEST["phone"];
$postal_code=$_REQUEST["postal_code"];
$company_name=$_REQUEST["company_name"];
$address=$_REQUEST["address"]; 
$email =$_REQUEST["email"];
$client_invoice_check =$_REQUEST["client_invoice_check"];
$db1 = db_connect(); 
$sqlUniqueMobile="SELECT Id FROM `companies` WHERE `email` = '$email'";
$exe2 = $db1->query($sqlUniqueMobile); 
if($phone==""){
	echo "mobile is required";
}
else if($user_name==""){
	echo "user name is required";
}
else if($company_name==""){
	echo "company name is required";
}
else if($exe2->num_rows > 0)
{
    $sqlUpdate = "UPDATE `companies` SET `first_Name` ='$first_name', `phone` ='$phone',`address` ='$address',`postal_code` ='$postal_code',`last_name` ='$last_name',`username` ='$user_name',`company_name` ='$company_name',`send_invoice_status_client` ='$client_invoice_check' WHERE `email` = '$email'";
	$exeUpdate = $db1->query($sqlUpdate);
     if($exeUpdate==1)
     {
       echo "company profile updated";
	 }
	 else
	 {
		echo "company profile not updated";
	 }
 }
 else
 {
   echo "company profile not updated";
 }
}

?>