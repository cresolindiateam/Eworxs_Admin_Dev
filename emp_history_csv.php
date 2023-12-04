<?php
require 'dbconfig.php';


$emp_id= $_REQUEST['emp_id'];
$tempName = "emp_list.csv";

$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);

$db=db_connect();

$sql="SELECT client_visits.id as clientvisitesid,client_visits.worker_work_rate as emp_work_rate,client_visits.worker_mileage_rate as emp_mileage_rate,client_visits.client_name,client_visits.company_id,client_visits.visit_date,client_visits.visit_address,client_visits.departure_time,client_visits.arrival_time,client_visits.duration,client_visits.distance,client_visits.pdf_file,client_visits.created_at,client_visits.image,workers.first_name as emp_first_name,workers.last_name as emp_last_name,workers.email as emp_email,workers.work_rate AS emp_work_rate1,workers.mileage_rate AS emp_mileage_rate1,client_visits.return_mileage_status as mileage_status,company_clients.client_company_name,company_clients.office_address as company_address,company_clients.email as company_email,company_clients.work_rate AS client_work_rate,company_clients.mileage_rate AS client_mileage_rate,company_clients.due_date_range,client_visits.mileage_status FROM client_visits JOIN workers ON(client_visits.worker_id=workers.id) JOIN company_clients ON(client_visits.company_client_id=company_clients.id) JOIN companies ON(workers.company_id=companies.id) where client_visits.worker_id = $emp_id ORDER BY client_visits.id DESC";;




	$exe = $db->query($sql);
    $resultData = $exe->fetch_all(MYSQLI_ASSOC);
   $db = null;
    $data=array();
  

    foreach ($resultData as $key => $value){
 
 if($value['mileage_status']==1)
                        {
      if($value['return_mileage']==0)
                        {
                         $distance=(float)$value['distance'];
                        }
                        else
                         {
                          $distance=(float)$value['distance']*2;
                         }
         }
         else
         {  
         	 if($value['return_mileage']==0)
                        {
                         $distance=0;                        }
                        else
                         {
                          $distance=0;
                         }
         }


		$amount=$distance*(float)$value['emp_mileage_rate'];
		$emp_due_bal = (float)$amount+(float)$value['emp_work_rate'];



	    $data[$key]['id']= $value['clientvisitesid'];
	    $data[$key]['emp_name']= $value['emp_first_name']." ".$value['emp_last_name'];
	    $data[$key]['emp_email']= $value['emp_email'];
	    $data[$key]['emp_work_rate']= $value['emp_work_rate'];
	    if($value['mileage_status']==1){
	    $data[$key]['emp_mileage_rate']=$value['emp_mileage_rate'];
	}
	else
	{
		 $data[$key]['emp_mileage_rate']='';
	}
	    $data[$key]['duration']= $value['duration'];

	    if($value['mileage_status']==1){
	    $data[$key]['distance']= $distance;
	}
else
{
	$data[$key]['distance']= '';
}

	 if($value['mileage_status']==1){
	    $data[$key]['return_mileage']= $value['return_mileage']==0?'No':'Yes';
	}
	else
	{
		$data[$key]['return_mileage']= '';
	}
	    $data[$key]['amount']= $emp_due_bal;
	    $data[$key]['client_name']= $value['client_name'];
	    $data[$key]['client_company_name']= $value['client_company_name'];
	    $data[$key]['visit_date']= $value['visit_date'];
	    $data[$key]['visit_address']= $value['visit_address'];

	  }



function outputCSV($data, $csvHeader) {
	$output = fopen("php://output", "w");  
	foreach ($csvHeader as $rowheader)
	fputcsv($output, $rowheader);  
	foreach ($data as $row)
	fputcsv($output, $row); // here you can change delimiter/enclosure
	fclose($output);
}


 // if($value['mileage_status']==1){
$csvHeader = array(			
 array('Id','Worker Name','Worker Email','Worker Work Rate','Worker Mileage Rate','Duration','Distance','Return Mileage','Amount','Client Name','Client Company Name','Visit Date','Visit Address')
 );
// }
// else
// {
// 	$csvHeader = array(			
//  array('Id','Worker Name','Worker Email','Worker Work Rate','Duration','Amount','Client Name','Client Company Name','Visit Date','Visit Address')
//  );
// }

outputCSV($data, $csvHeader);



?>