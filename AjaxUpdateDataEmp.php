<?php

ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';

$db = db_connect(); 

$id = $_REQUEST['id'];

$first_name = $_REQUEST['editfirstName'];

$last_name = $_REQUEST['editlastName'];

$email = $_REQUEST['editemail'];

$phone = $_REQUEST['editphone']; 

$edit_local_address = $_REQUEST['edit_local_address']; 

$edit_permanent_address = $_REQUEST['edit_permanent_address']; 

$postal_code=$_REQUEST['editpostalCode'];

$company_id=$_REQUEST['editcompany']; 



$workRate=$_REQUEST['workRate']; 

$mileageRate=$_REQUEST['mileageRate'];

$latitude=$_REQUEST['latitude']; 

$longitude=$_REQUEST['longitude'];

 



if($_REQUEST['editpassword']!=''){ // Edit with passowrd

    $password = $_REQUEST['editpassword'];

    $password = md5($password); 

$data1= array("first_name"=>$first_name,"last_name"=>$last_name,"email"=>$email,"phone"=>$phone,"password"=>$password, "local_address"=>$edit_local_address,"permanent_address"=>$edit_permanent_address ,"work_rate"=>$workRate ,"mileage_rate"=>$mileageRate , 

"postal_code"=>$postal_code,"company_id"=>$company_id

);

}else { // Edit without password 

    $data1= array("first_name"=>$first_name,"last_name"=>$last_name,"email"=>$email,"phone"=>$phone,  "local_address"=>$edit_local_address,"permanent_address"=>$edit_permanent_address  ,"work_rate"=>$workRate ,"mileage_rate"=>$mileageRate ,

"postal_code"=>$postal_code,"company_id"=>$company_id

);

}







$jnparams = $data1;

 $uid=$id;



    if (empty($jnparams)) {

        return true;

    }



    $conditions = [];

    $uid = (int) $uid;



    foreach ($jnparams as $column => $value) {

        $conditions[] = "`{$column}` = '{$value}'";

    }



    $conditions = implode(',', $conditions);



$sql= "UPDATE  workers  SET {$conditions} WHERE id = {$uid}"; 



if ($db->query($sql) === TRUE) {

    $status=1;

		$message="Record Updated successfully.";

} else {

        $status=0;

		$message="Record not updated.". $db->error;

}



$db->close();



$data1= array("Status"=>$status,"Message"=>$message);

echo json_encode($data1);

?>