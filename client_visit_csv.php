<?php
require 'dbconfig.php';
session_start();
$company_id = $_SESSION["companyid"];
$emp_id= $_REQUEST['emp_id'];
$tempName = "client_visit_list.csv";
$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);
$db=db_connect();
$sql="SELECT client_visits.id as clientvisitesid,client_visits.client_work_rate AS client_work_rate,client_visits.client_mileage_rate AS client_mileage_rate,client_visits.client_name,client_visits.company_client_id,client_visits.visit_date,client_visits.visit_address,client_visits.departure_time,client_visits.arrival_time,client_visits.duration,client_visits.distance,client_visits.pdf_file,client_visits.created_at,client_visits.image,workers.first_name as emp_first_name,workers.last_name as emp_last_name,workers.email as emp_email,workers.work_rate AS emp_work_rate,workers.mileage_rate AS emp_mileage_rate,company_clients.client_company_name,company_clients.office_address as company_address,company_clients.email as company_email,company_clients.work_rate AS client_work_rate1,company_clients.mileage_rate AS client_mileage_rate1,company_clients.due_date_range,client_visits.mileage_status,client_visits.return_mileage_status as return_mileage FROM client_visits JOIN workers ON(client_visits.worker_id=workers.id) JOIN company_clients ON(client_visits.company_client_id=company_clients.id) JOIN companies ON(workers.company_id=companies.id) where workers.company_id = $company_id and client_visits.visit_status = 1 ORDER BY client_visits.id DESC";
$exe = $db->query($sql);
$resultData = $exe->fetch_all(MYSQLI_ASSOC);
$db = null; 
$data=array();
    foreach ($resultData as $key => $value)
    {
    	 $count=$key+1;
    	 $due_days = $value['due_date_range'];
         $due_date = $value['visit_date'];
		  if($due_days>0)
		  {
			$due_days = "+".$due_days." day";
			$due_date = strtotime($due_days, strtotime($due_date));
			$due_date = date("Y-m-d", $due_date);
		  }

 if($value['return_mileage'] == 0)
                    {
         $distance=(float)$value['distance'];

     }  

     else
     {
     	$distance=(float)$value['distance']*2;
     }
         $amount=$distance*(float)$value['client_mileage_rate'];
     

 if($value['mileage_status'] == 1)
                    {


         $client_due_bal = (float)$amount+(float)$value['client_work_rate']*(float)$value['duration'];
	     }
	     else
	     {
	     	$client_due_bal = (float)$value['client_work_rate']*(float)$value['duration'];
	     }

	     $data[$key]['id']= $count;	 
	     $data[$key]['client_name']= $value['client_name'];
	     $data[$key]['visit_date']= $value['visit_date'];
	     $data[$key]['visit_address']= $value['visit_address'];
	     $data[$key]['arrival_time']= $value['arrival_time'];
	     $data[$key]['departure_time']= $value['departure_time'];
	     
	     
	  	    if($value['pdf_file']=="")
		    {
		      $data[$key]['pdf_file']= 'Invoice not sent';
		    }
		     else
		     {
		       $data[$key]['pdf_file']= 'Invoice sent'; 
		     };
         $data[$key]['created_at']= $value['created_at'];
         $data[$key]['worker_name']= $value['emp_first_name'].' '.$value['emp_last_name'];
         $data[$key]['client_company_name']= $value['client_company_name'];
         $data[$key]['company_address']= $value['company_address'];
         $data[$key]['company_email']= $value['company_email'];
          $data[$key]['client_work_rate']= $value['client_work_rate'];
         $data[$key]['duration']= $value['duration'];
        $data[$key]['client_mileage_rate']= $value['client_mileage_rate'];


                    if($value['mileage_status'] == 1)
                    {
                    	if($value['return_mileage'] == 0)
                    {
                      $data[$key]['client_mileage']= $value['distance'];
                  }

                  else
                  {
                  	$data[$key]['client_mileage']= $value['distance']*2;
                  }
                    }
                    else
                    {
                    	$data[$key]['client_mileage']= 0;
                    }


          $data[$key]['client_mileage_amount']= $client_due_bal;
         $data[$key]['due_date_range']= $due_date;
        
        
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
 array('Id','Client Name','Visit Date','Visit Address','Arrival Time','Departure Time','Invoice','Created At','Worker\'s Name','Client Company Name','Company Address','Company Email','Client Work Rate','Duration','Client Mileage Rate','Mileage','Total Amount','Client Due Date')
 );
outputCSV($data, $csvHeader);
?>