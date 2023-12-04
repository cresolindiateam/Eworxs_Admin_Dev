<?php
include "dbconfig.php";
session_start();
if ($_SESSION["role"] == 1) {
    echo "<script> window.location = 'admin_login.php'</script>";
}
// Include your database connection code here
$db = db_connect();

    


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    

    if (isset($_GET['toggle_select'])) {
        
        // Toggle the status in the database
        $company_id = $_SESSION["companyid"];
        $query = "select mileage_status from  companies  WHERE id = $company_id";
     
        $mileage_status='';
        $mileage_exe1 = $db->query($query);
              if($mileage_exe1->num_rows > 0) 
                {
                            $dataResult1 = $mileage_exe1->fetch_all(MYSQLI_ASSOC);
                            $mileage_status = $dataResult1[0]["mileage_status"];
                           
                }
        echo json_encode(['status' => 'success', 'newStatus' => $mileage_status]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request1']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
