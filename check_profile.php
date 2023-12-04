<?php
require 'dbconfig.php';
session_start();
if ($_SESSION["role"] == 1) {
    echo "<script> window.location = 'admin_login.php'</script>";
} 
if($_SESSION['username']==""){
echo "<script> window.location = 'admin_login.php';</script>";
}

$company_id= $_SESSION['companyid'];
$db=db_connect(); 
$user_id = $_SESSION['companyid'];
$query = "SELECT id FROM companies WHERE id = '$user_id'  AND company_name!='' AND first_name!='' AND last_name!='' AND username!='' AND address!='' AND postal_code!='' AND phone!=''";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0)
{
    echo "complete";
} 
else 
{
    echo "incomplete";
}
?>