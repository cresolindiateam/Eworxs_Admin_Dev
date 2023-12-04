<?php
ini_set('date.timezone', 'Asia/Kolkata');
$db = db_connect();

$sqlInsert = "INSERT INTO employees(company_id,first_name,last_name,email,phone,password,local_address,permanent_address,postal_code,status,created_at) values('2','komko','mokmko','romil@gmail.com','123465','kmko','mkom','komokm','omokm',1,now())";
$exeInsert = $db->query($sqlInsert);
$last_id = $db->insert_id;
if(!empty($last_id)){
	$message="New Employee Created.";
}else{
	$message="Employee did not Created.";
}

echo $message;


function db_connect(){
$server = '50.62.209.18:3306'; // this may be an ip address instead
    $user = 'eworxs';
    $pass = 'eworxs123!@#';
    $database = 'EworxsDB'; // name of your database

      // Create connection
  $conn= mysqli_connect($server,$user,$pass,$database);
  return $conn;
  if(!$conn){
  die("Connection failed: " . mysqli_connect_error());
}
}
?>