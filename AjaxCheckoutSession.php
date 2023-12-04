<?php
require_once('stripe/init.php');
require 'dbconfig.php';
ini_set('date.timezone', 'Asia/Kolkata');
$db = db_connect();
$cust_id=$_REQUEST["cust_id"];
$plan_id=$_REQUEST["plan_id"];
$company_id=$_REQUEST["company_id"];

$sql = "SELECT plan_id FROM plans WHERE id='$plan_id'";
$exe = $db->query($sql);
$dataResult = $exe->fetch_all(MYSQLI_ASSOC);
$plan_id_st = $dataResult[0]['plan_id'];


\Stripe\Stripe::setApiKey('sk_test_eQACpuX8Ih8H3aiLk6vEy5If');

$result = \Stripe\Checkout\Session::create([
  'customer' => $cust_id,
  'payment_method_types' => ['card'],
  'subscription_data' => [
    'items' => [[
      'plan' => $plan_id_st,
    ]],
  ],
  'success_url' => 'http://eworxs.vipscollege.com/EworxsAdmin/plan_success.php?company_id='.$company_id.'&plan_id='.$plan_id,
  'cancel_url' => 'http://eworxs.vipscollege.com/EworxsAdmin/plan_failed.php',
]);

//print_r($result);

if(isset($result->id)){
  $checkoutId=$result->id;
  $data1= array("Status"=>1,"Message"=>$checkoutId);
  echo json_encode($data1);
}else{
  $data1= array("Status"=>0,"Message"=>"Session did not created.");
  echo json_encode($data1);
}


?>