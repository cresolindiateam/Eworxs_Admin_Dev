<?php 
include "dbconfig.php";
$db = db_connect();
if(isset($_POST['option']))
{
$amount_plan=$_POST['option'];

 $plan_sql ="SELECT id,amount FROM `plans` where plan_id='".$amount_plan."'";
      
       
        $plan_exe = $db->query($plan_sql);


          $dataResult = $plan_exe->fetch_all(MYSQLI_ASSOC);



          echo  $dataResult[0]['amount'];
}

?>