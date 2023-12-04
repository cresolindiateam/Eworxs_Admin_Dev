<?php
require 'dbconfig.php';
session_start();
$company_id = $_SESSION["companyid"];
$emp_id= $_REQUEST['emp_id'];
$tempName = "workers_list.csv";
$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);
$db=db_connect();


 $sql = "SELECT id,first_name,last_name,email,phone,permanent_address,postal_code,status,created_at,work_rate,mileage_rate FROM workers where company_id = $company_id and status=1 ORDER BY id";

$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
foreach ($data as $key => $value) {
	 $count=$key+1;
    $data[$key]["id"] = $count;
    $data[$key]["first_name"] = $value["first_name"];
    $data[$key]["last_name"] = $value["last_name"];
    $data[$key]["email"] = $value["email"];
    $data[$key]["phone"] = $value["phone"];
    $data[$key]["permanent_address"] = $value["permanent_address"];
    $data[$key]["postal_code"] = $value["postal_code"];
    $data[$key]["status"] = $value["status"];
    $data[$key]["created_at"] = $value["created_at"];
    $data[$key]["work_rate"] = $value["work_rate"];
    $data[$key]["mileage_rate"] = $value["mileage_rate"];
}


function outputCSV($data, $csvHeader) {
	$output = fopen("php://output", "w");  
	foreach ($csvHeader as $rowheader)
	fputcsv($output, $rowheader);  
	foreach ($data as $row)
	fputcsv($output, $row); // here you can change delimiter/enclosure
	fclose($output);
}
$csvHeader = array(			
 array('Id','First Name','last Name','Email','Phone','Home Address','Postal Code','Status','Created At','Hourly Rate','Mileage Rate')
 );
outputCSV($data, $csvHeader);
?>