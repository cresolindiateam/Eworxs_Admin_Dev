<?php

ini_set('date.timezone', 'Asia/Kolkata');



require 'dbconfig.php';



$company_name=$_REQUEST["company_name"];

$first_name=$_REQUEST["first_name"];

$last_name=$_REQUEST["last_name"];

$email=$_REQUEST["email"];

$phone=$_REQUEST["phone"];

//$password=$_REQUEST["password"];



//$password = password_hash($password, PASSWORD_DEFAULT);

//$logo=$_REQUEST["logo"];

$postal_code=$_REQUEST["postal_code"];

$work_rate=$_REQUEST["work_rate"];

$mileage_rate=$_REQUEST["mileage_rate"];

$due_date_range=$_REQUEST["due_date_range"];

$company=$_REQUEST["company"];

$clock=$_REQUEST["clock"];

$office_address=$_REQUEST["office_address"];

$return_mileage = $_REQUEST["return_mileage"];



$status_data=1;

$datetime = date("Y-m-d H:i:s");

$data1= array();

$status=0;

$message="";

$db = db_connect();





$sqlUniqueEmail="SELECT id FROM company_clients WHERE email = '$email'";

$exeEmail = $db->query($sqlUniqueEmail);



$sqlUniqueMobile="SELECT id FROM company_clients WHERE phone = '$phone'";

$exeMobile = $db->query($sqlUniqueMobile);



if($exeEmail->num_rows>0){

	$message="Email already used.";

}else if($exeMobile->num_rows>0){

	$message="Phone already used.";

}else{

	/*$sqlInsert = "INSERT INTO companyclients(company_name,company_id,first_name,last_name,email,phone,password,postal_code,work_rate,mileage_rate,due_date_range,status,created_at,clock_setting,office_address)"." VALUES('$company_name',$company,'$first_name','$last_name','$email','$phone','$password','$postal_code','$work_rate','$mileage_rate','$due_date_range',$status_data,now(),'$clock','$office_address')";*/

	

	$sqlInsert = "INSERT INTO company_clients(client_company_name,company_id,first_name,last_name,email,phone,postal_code,work_rate,mileage_rate,due_date_range,status,clock_setting,office_address,return_mileage)"." VALUES('$company_name',$company,'$first_name','$last_name','$email','$phone','$postal_code','$work_rate','$mileage_rate',$due_date_range,$status_data,'$clock','$office_address',$return_mileage)";

 

	$exeInsert = $db->query($sqlInsert);

	$last_id = $db->insert_id;

	if(!empty($last_id)){

		$status=1;

		$message="New Company Client Created.";

	}else{

		$message="Company Client did not Created.";

	}

}

$db->close();



$data1= array("Status"=>$status,"Message"=>$message);

echo json_encode($data1);

?>