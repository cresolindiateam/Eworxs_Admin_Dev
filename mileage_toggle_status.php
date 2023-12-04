<?php
include "dbconfig.php";

session_start();
if ($_SESSION["role"] == 1) {
    echo "<script> window.location = 'admin_login.php'</script>";
}
// Include your database connection code here
$db = db_connect();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['status'])) {
        // Toggle the status in the database
        $status = $_POST['status'];
        $company_id = $_SESSION["companyid"];
        $query = "UPDATE companies SET mileage_status = $status WHERE id = $company_id";

          $db->query($query);
        echo json_encode(['status' => 'success', 'newStatus' => $status]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
