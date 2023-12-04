<?php
require 'dbconfig.php';
session_start();
$company_id = $_SESSION["companyid"];
$emp_id= $_REQUEST['emp_id'];
$tempName = "client companies list.csv";

$tempName = str_replace("  ", "'", $tempName);
$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);
$db=db_connect();
$sql = "SELECT id, company_id,first_name,last_name,email , phone , client_company_name , office_address,postal_code,created_at,work_rate, mileage_rate,due_date_range,clock_setting,return_mileage   FROM company_clients where company_id = $company_id and status=1 ORDER BY id DESC";
$exe = $db->query($sql);
$resultData = $exe->fetch_all(MYSQLI_ASSOC);
$db = null;
$data=array();
    foreach ($resultData as $key => $value)
    {
    	 $count=$key+1;
    	  $due_date_range_prefix='';
		     if($value['due_date_range']>0)
                   {
                    $due_date_range_prefix='Net '.$value['due_date_range'];
                   }
                   else
                   {
                    $due_date_range_prefix='Due on receipt';
                    
                   }
         $distance=(float)$value['distance']*2;
         $amount=$distance*(float)$value['client_mileage_rate'];
         $client_due_bal = (float)$amount+(float)$value['client_work_rate']*(float)$value['duration'];
	     $data[$key]['id']= $count;	 
	     $data[$key]['first_name']= $value['first_name'];
	     $data[$key]['last_name']= $value['last_name'];
	     $data[$key]['email']= $value['email'];
	     $data[$key]['phone']= $value['phone'];
	     $data[$key]['client_company_name']= $value['client_company_name'];
	     $data[$key]['office_address']= $value['office_address'];
         $data[$key]['postal_code']= $value['postal_code'];
         $data[$key]['created_at']= $value['created_at'];
         $data[$key]['hourly_rate']= $value['work_rate'];
         $data[$key]['mileage_rate']= $value['mileage_rate'];
         $data[$key]['due_date_range']= $due_date_range_prefix;
         // $data[$key]['clock_setting']= $value['clock_setting'];
          $data[$key]['return_mileage']= $value['return_mileage']==0?'No':'Yes';
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
 array('Id','First Name','Last Name','Email','Phone','Client Company Name','Office Address','Postal Code','Created At','Hourly Rate','Mileage Rate','Due Date Range','Return Mileage')
 );
outputCSV($data, $csvHeader);
?>