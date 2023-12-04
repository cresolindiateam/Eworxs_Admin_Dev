<?php
ini_set('date.timezone', 'Asia/Kolkata');
require 'dbconfig.php';

$db = db_connect();
$id = $_REQUEST['id'];
$first_name = $_REQUEST['editfirstName'];
$last_name = $_REQUEST['editlastName'];
/*$email = $_REQUEST['editemail'];*/
$phone = $_REQUEST['editphone'];

$company_name = $_REQUEST['editcompanyName'];
/*$work_rate = $_REQUEST['editworkRate']; 
$mileage_rate =$_REQUEST['editmileageRate']; 
$due_date_range=$_REQUEST['editdateRange'];*/
$postal_code=$_REQUEST['editpostalCode'];
$status_data=$_REQUEST['editstatus'];

/*$data1= array("first_name"=>$first_name,"last_name"=>$last_name,"email"=>$email,"phone"=>$phone,"password"=>$password,"company_name"=>$company_name, "work_rate"=>$work_rate,"mileage_rate"=>$mileage_rate , 
"due_date_range"=>$due_date_range,"postal_code"=>$postal_code,"status"=>$status_data
);*/

if($_REQUEST['editpassword']!=''){
  $password = $_REQUEST['editpassword'];
  $password = md5($password); 
  $data1= array("first_name"=>$first_name,"last_name"=>$last_name,"phone"=>$phone,"password"=>$password,"company_name"=>$company_name,"postal_code"=>$postal_code,"status"=>$status_data);
} else {
   $data1= array("first_name"=>$first_name,"last_name"=>$last_name,"phone"=>$phone,"company_name"=>$company_name,"postal_code"=>$postal_code,"status"=>$status_data);
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

$sql= "UPDATE companies  SET {$conditions} WHERE id = {$uid}"; 



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