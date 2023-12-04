<?php
ob_start();
require 'dbconfig.php';
session_start();
$company_id = $_SESSION["companyid"];
$emp_id= $_REQUEST['emp_id'];
$tempName = "quick_book.csv";
$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);
ob_clean();

$db=db_connect();
define("start_date_default", date("Y-m-d", strtotime("-6 months")));
define("end_date_default", date("Y-m-d"));

 $sql = "SELECT client_visits.id as clientvisitesid,client_visits.client_work_rate AS client_work_rate,client_visits.client_mileage_rate AS client_mileage_rate,company_clients.client_company_name,company_clients.due_date_range,client_visits.client_name,client_visits.duration,client_visits.distance,workers.work_rate AS emp_work_rate,workers.mileage_rate AS emp_mileage_rate,company_clients.email AS client_email,company_clients.work_rate AS client_work_rate1,client_visits.return_mileage_status as return_mileage,company_clients.mileage_rate AS client_mileage_rate1,client_visits.visit_date,company_clients.postal_code AS ca_postal, workers.postal_code AS ic_postal,client_visits.mileage_status FROM client_visits JOIN workers ON(client_visits.worker_id=workers.id) 


 JOIN company_clients ON(client_visits.company_client_id=company_clients.id) JOIN companies ON(companies.id=company_clients.company_id) where company_clients.company_id = $company_id   ";

if(isset($_GET['action']))
{

   if (isset($_GET["start_date"])) {
            // Retrieve the submitted value
            $userInputstart = $_GET["start_date"];
        }
         if (isset($_GET["end_date"])) {
            // Retrieve the submitted value
            $userInputend = $_GET["end_date"];
        }
   $startdate = date('Y-m-d', strtotime($_GET['start_date']));
  $enddate =  date('Y-m-d', strtotime($_GET['end_date']));



$sql .= " AND client_visits.visit_date  BETWEEN '".$startdate."' AND '".$enddate."'";
}
else
{
  $sql .= " AND client_visits.visit_date  BETWEEN '".$startdate."' AND '".$enddate."'";
}
 
 $sql .=" ORDER BY client_visits.id DESC ";




$exe = $db->query($sql);
$resultData = $exe->fetch_all(MYSQLI_ASSOC);


// print_r($resultData);
$db = null;
$data=array();
$count=1000;
foreach ($resultData as $key => $value) {
    $count=$count+1;
    $due_days = $value['due_date_range'];
    $due_date = $value['visit_date'];
    if($due_days>0) {
        $due_days = "+".$due_days." day";
        $due_date = strtotime($due_days, strtotime($due_date));
        $due_date = date("Y-m-d", $due_date);
    }
    if($value['return_mileage']==0)
    {
    $distance=(float)$value['distance'];
}
else
{
 $distance=(float)$value['distance']*2;   
}
    $amount=$distance*(float)$value['client_mileage_rate'];
    $client_due_bal = (float)$amount+(float)$value['client_work_rate']*(float)$value['duration'];
    $data[$key]['id']= $count;    
    $data[$key]['client_company_name']= $value['client_company_name'];
    $data[$key]['visit_date']= $value['visit_date'];
    $data[$key]['ca_postal']= $value['ca_postal'];
    $data[$key]['client_email']= $value['client_email'];
    $data[$key]['ic_postal']= $value['ic_postal'];
    $data[$key]['due_date']= $due_date;
    $data[$key]['terms']= '';
        if($value['due_date_range']>0) {
        $data[$key]['terms']='Net '.$value['due_date_range'];
    } else {
        $data[$key]['terms']='Due on receipt';
    }
    $data[$key]['location']= '-';
    $data[$key]['memo']= '-';
    $data[$key]['item']= array('Field Service','TravelTime');
    $data[$key]['item_desc']= 'Field Service '.$value['visit_date'].'-'.$value['client_name'];
    $data[$key]['item_quantity']= array($value['duration'],$value['distance']);
    $data[$key]['item_rate']= array($value['client_work_rate'],$value['client_mileage_rate']);
    $data[$key]['item_amount']= $client_due_bal;
    $data[$key]['service_date']= $value['visit_date'];
    $data[$key]['mileage_status']= $value['mileage_status'];
}


// function outputCSV($data, $csvHeader) {
//     $output = fopen("php://output", "w");  
//     foreach ($csvHeader as $rowheader) {
//         fputcsv($output, $rowheader);
//     }

    // foreach ($data as $row) {
    //     if (count($row['item']) > 1) {
    //         foreach ($row['item'] as $key12 => $row1) {
    //             if ($key12 == 0) {
    //                 if ($row['id'] || $row['client_company_name'] || $row['visit_date'] || $row['due_date'] || $row['terms'] || $row['location'] || $row['memo'] || $row['item'] || $row['item_desc'] || $row['item_quantity'] || $row['item_rate'] || $row['item_amount']) {
    //                     fputcsv($output, array($row['id'], $row['client_company_name'], $row['visit_date'], $row['due_date'], $row['terms'], $row['location'], $row['memo'], $row1, $row['item_desc'], $row['item_quantity'][$key12], $row['item_rate'][$key12], $row['item_quantity'][$key12] * $row['item_rate'][$key12], $row['service_date'], $row['client_email']));
    //                 }
    //             } else {
    //                 if ($row['id'] || $row['client_company_name'] || $row['visit_date'] || $row['due_date'] || $row['terms'] || $row['location'] || $row['memo'] || $row['item'] || $row['item_desc'] || $row['item_quantity'] || $row['item_rate'] || $row['item_amount']) {
    //                     $mil_desc='Travel time '.$row['ic_postal'].'  To  '.$row['ca_postal'];
    //                     fputcsv($output, array($row['id'],'','','','','','',$row1,$mil_desc,$row['item_quantity'][$key12]*2,$row['item_rate'][$key12],$row['item_quantity'][$key12]*2*$row['item_rate'][$key12],'',''));
    //                 }    
    //             }
    //         }
    //     } else {
    //         fputcsv($output, $row);
    //     }
    // }
//     fclose($output);
// }
$csvHeader = array(            
 array('*InvoiceNO','*Customer','*InvoiceDate','*DueDate','Terms','Location','Memo','Item(Product/Service)','ItemDescription','ItemQuantity','ItemRate','*ItemAmount','Service Date','Client\'s email address')
);
// $data123=outputCSV($data, $csvHeader);


function exportCSVInGroups($data, $groupSize = 100,$csvHeader) 
{
    $totalRows = count($data);


    // Create a directory to store CSV files if it doesn't exist
    if (!is_dir('csv_exports')) 
    {
        mkdir('csv_exports', 0777, true);
    }
    
    // Initialize group counter and file counter
    $groupCount = 1;
    $fileCount = 1;

 
    
    // Loop through data and export in groups
    for ($start = 0; $start < $totalRows; $start += $groupSize) {


        // Create a new CSV file
        $csvFileName = "csv_exports/quick_book{$groupCount}_file{$fileCount}.csv";
        
        $csvFile = fopen($csvFileName, 'w');
        
     
        
            foreach ($csvHeader as $rowheader) {
        fputcsv($csvFile, $rowheader);
    }

        // Write data to CSV file
         for ($i = $start; $i < min($start + $groupSize, $totalRows); $i++) {
        

         if (count($data[$i]['item']) > 1) {



  foreach ($data[$i]['item'] as $key12 => $row1) {
                 if ($key12 == 0) {
                    if ($data[$i]['id'] || $data[$i]['client_company_name'] || $data[$i]['visit_date'] || $data[$i]['due_date'] || $data[$i]['terms'] || $data[$i]['location'] || $data[$i]['memo'] || $data[$i]['item'] || $data[$i]['item_desc'] || $data[$i]['item_quantity'] || $data[$i]['item_rate'] || $data[$i]['item_amount']) {
                        fputcsv($csvFile, array($data[$i]['id'], $data[$i]['client_company_name'], $data[$i]['visit_date'], $data[$i]['due_date'], $data[$i]['terms'], $data[$i]['location'], $data[$i]['memo'], $row1, $data[$i]['item_desc'], $data[$i]['item_quantity'][$key12], $data[$i]['item_rate'][$key12], $data[$i]['item_quantity'][$key12] * $data[$i]['item_rate'][$key12], $data[$i]['service_date'], $data[$i]['client_email']));
                    }
                } else {
                    if ($data[$i]['id'] || $data[$i]['client_company_name'] || $data[$i]['visit_date'] || $data[$i]['due_date'] || $data[$i]['terms'] || $data[$i]['location'] || $data[$i]['memo'] || $data[$i]['item'] || $data[$i]['item_desc'] || $data[$i]['item_quantity'] || $data[$i]['item_rate'] || $data[$i]['item_amount']) {
                        $mil_desc='Travel time '.$data[$i]['ic_postal'].'  To  '.$data[$i]['ca_postal'];


                         if($data[$i]['mileage_status'][$key12]==1){
                        fputcsv($csvFile, array($data[$i]['id'],'','','','','','',$row1,$mil_desc,$data[$i]['item_quantity'][$key12]*2,$data[$i]['item_rate'][$key12],$data[$i]['item_quantity'][$key12]*2*$data[$i]['item_rate'][$key12],'',''));
                         }
                         else
                         {
                            fputcsv($csvFile, array($data[$i]['id'],'','','','','','',$row1,$mil_desc,0,$data[$i]['item_rate'][$key12],0*2*$data[$i]['item_rate'][$key12],'',''));
                         }
                    }    
                }

 }
 }

}
        
        fclose($csvFile);
        
        // Increment file counter and group counter as needed
        $fileCount++;
        if ($fileCount > $groupSize) {
            $fileCount = 1;
            $groupCount++;
        }
    }
}


exportCSVInGroups($data,100,$csvHeader);


$directory = 'csv_exports';
 $files = scandir($directory);
$files = array_diff($files, array('.', '..'));

$zip = new ZipArchive();
$zipFileName = 'csv_exports.zip';
$zip->open($zipFileName, ZipArchive::CREATE);

foreach ($files as $file) {
    $zip->addFile($directory . '/' . $file, $file);
}

$zip->close();

// Set headers to force download
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
header('Content-Length: ' . filesize($zipFileName));
readfile($zipFileName);


// Delete the ZIP file after download
unlink($zipFileName);
deleteDirectory($directory);

function deleteDirectory($dir) {
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $filePath = $dir . DIRECTORY_SEPARATOR . $file;
                if (is_dir($filePath)) {
                    deleteDirectory($filePath);
                } else {
                    unlink($filePath);
                }
            }
        }
        rmdir($dir);
    }
}

?>

 
 <?php
// require 'dbconfig.php';
// session_start();
// $company_id = $_SESSION["companyid"];
// $emp_id = $_REQUEST['emp_id'];
// $batchSize = 10; // Number of records per batch

// $db = db_connect();
// define("start_date_default", date("Y-m-d", strtotime("-6 months")));
// define("end_date_default", date("Y-m-d"));

//  $sql = "SELECT client_visits.id as clientvisitesid,company_clients.client_company_name,company_clients.due_date_range,client_visits.duration,client_visits.distance,workers.work_rate AS emp_work_rate,workers.mileage_rate AS emp_mileage_rate,company_clients.email AS client_email,company_clients.work_rate AS client_work_rate,company_clients.mileage_rate AS client_mileage_rate,client_visits.visit_date,company_clients.postal_code AS ca_postal, workers.postal_code AS ic_postal FROM client_visits JOIN workers ON(client_visits.employee_id=workers.id) JOIN company_clients ON(client_visits.company_id=company_clients.id) where company_clients.company_id = $company_id  AND client_visits.visit_date  BETWEEN '".start_date_default."' AND '".end_date_default."'   ORDER BY client_visits.id DESC ";
// $exe = $db->query($sql);
// $resultData = $exe->fetch_all(MYSQLI_ASSOC);
// $db = null;

// $totalRecords = count($resultData);

// // Determine the number of batches
// $totalBatches = ceil($totalRecords / $batchSize);

// // Loop through and create CSV files
// for ($batchNumber = 1; $batchNumber <= $totalBatches; $batchNumber++) {
//     $start = ($batchNumber - 1) * $batchSize;
//     $end = min($start + $batchSize, $totalRecords);
    
//     $data = array_slice($resultData, $start, $end - $start);
//     $csvFileName = "batch_" . $batchNumber . ".csv";

//     $output = fopen($csvFileName, 'w');
    
//     // Add CSV header here if needed

//     foreach ($data as $row) {
//         // Process and format your data here as needed
//         fputcsv($output, $row);
//     }

//     fclose($output);

//     // Send the CSV file for download
//     header("Content-Type: application/csv");
//     header("Content-Disposition: attachment; filename=" . $csvFileName);
//     readfile($csvFileName);

//     // Remove the temporary CSV file (optional)
//     unlink($csvFileName);
// }
?>
 