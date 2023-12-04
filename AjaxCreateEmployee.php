<?php
ini_set('date.timezone', 'Asia/Kolkata'); 
require 'dbconfig.php'; 
$first_name=$_REQUEST["first_name"];
$last_name=$_REQUEST["last_name"];
$email=$_REQUEST["email"];
$phone=$_REQUEST["phone"];
$password=$_REQUEST["password"];
$password = md5($password);
$local_address=$_REQUEST["local_address"];
$permanent_address=$_REQUEST["permanent_address"];
$postal_code=$_REQUEST["postal_code"];
$company=$_REQUEST["company"];
$workRate=$_REQUEST["workRate"];
$mileageRate=$_REQUEST["mileageRate"];
$latitude=$_REQUEST["latitude"];
 $longitude=$_REQUEST["longitude"];

$datetime = date("Y-m-d H:i:s");
$data1= array();
$status=0;
$message="";
$db = db_connect();
$sqlUniqueEmail="SELECT id FROM workers WHERE email = '$email'";
$exeEmail = $db->query($sqlUniqueEmail);
$sqlUniqueMobile="SELECT id FROM workers WHERE phone = '$phone'";
$exeMobile = $db->query($sqlUniqueMobile);
if($exeEmail->num_rows>0){ 
	$message="Email already used.";
}else if($exeMobile->num_rows>0){ 
	$message="Phone already used.";
}else{ 
	$sqlInsert = "INSERT INTO workers(company_id,first_name,last_name,email,phone,password,local_address,permanent_address,postal_code,status,created_at,work_rate,mileage_rate,latitude, longitude)"." VALUES('$company','$first_name','$last_name','$email','$phone','$password','$local_address','$permanent_address','$postal_code',1,now(),'$workRate','$mileageRate','$latitude','$longitude')";
	$exeInsert = $db->query($sqlInsert);
	$last_id = $db->insert_id;
	if(!empty($last_id)){
		$status=1;
		$message="New Worker Created.";
	}else{
		
		$message="Worker did not Created.";
	}
}
$db->close();
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>