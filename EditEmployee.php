<?php
require 'dbconfig.php'; 
$empName=$_REQUEST["EmpFirstName"];
$empLastName=$_REQUEST["EmpLastName"];
$empMobile=$_REQUEST["EmpMobile"];
$empPassword=$_REQUEST["EmpPassword"];
$userType=$_REQUEST["UserType"];
$userId=$_REQUEST["EmpId"]; 
$empEmail =$_REQUEST["EmpEmail"];


$db1 = db_connect(); 
$sqlUniqueMobile="SELECT Id FROM `workers` WHERE `Id` = $userId";
$exe2 = $db1->query($sqlUniqueMobile); 
if($empMobile==""){
	echo "mobile is required";
}
else if($empPassword==""){
	echo "password is required";
}
else if($exe2->num_rows > 0){

	
	$sqlUpdate = "UPDATE `workers` SET `first_Name` ='$empName', `phone` ='$empMobile',`password` ='".md5($empPassword)."',`UserType` ='$userType' WHERE `Id` = $userId";

					$exeUpdate = $db1->query($sqlUpdate);

					if($exeUpdate==1){

						echo "employee updated";
					}
					else{
						echo "employee not updated";
					}


}else{

	echo "employee not updated";
}

?>