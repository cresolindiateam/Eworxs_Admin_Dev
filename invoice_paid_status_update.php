<?php
require 'dbconfig.php'; 
$visit_id=$_REQUEST["visit_id"];
$status =$_REQUEST["status"];


$db1 = db_connect(); 
	
	$sqlUpdate = "UPDATE `client_visits` SET `invoice_paid_status` ='$status' WHERE `Id` = $visit_id";

					$exeUpdate = $db1->query($sqlUpdate);

					if($exeUpdate==1){

						echo "Invoice Paid Status Updated";
					}
					else{
						echo "Invoice Paid Status Not Updated";
					}




?>