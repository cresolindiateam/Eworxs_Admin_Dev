<?php

ini_set('date.timezone', 'Asia/Kolkata');



require 'dbconfig.php';



$id=$_REQUEST["id"];

$db = db_connect();

// sql to delete a record

// $sql = "DELETE FROM companies WHERE id=$id";

$sql = "update companies set status=1  WHERE id=$id";

if ($db->query($sql) === TRUE) {

    $status=1;

		$message="Record activated successfully.";

} else {

        $status=0;

		$message="Record activated successfully.". $db->error;

}



$db->close();



$data1= array("Status"=>$status,"Message"=>$message);

echo json_encode($data1);

?>