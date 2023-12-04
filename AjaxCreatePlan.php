<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('date.timezone', 'Asia/Kolkata');
require_once('../stripe-php-master/init.php');
require 'dbconfig.php';


$plan_name=$_REQUEST["plan_name"];
$plan_amount=$_REQUEST["plan_amount"];
$plan_type=$_REQUEST["plan_type"];
$plan_duration=$_REQUEST["plan_duration"];
$num_emp=$_REQUEST["num_emp"];

$db = db_connect();


$sqlInsert = "INSERT INTO plans(plan_name,amount,duration_type,num_emp,status,created_at,plan_type)VALUES('$plan_name','$plan_amount','$plan_duration','$num_emp',0,now(),'$plan_type')";
$exeInsert = $db->query($sqlInsert);
$last_id = $db->insert_id;
if(!empty($last_id)){  
	createStripePlan($last_id,$plan_duration,$plan_amount,$db,$plan_name);
}else{
	$db->close();
	$data1= array("Status"=>0,"Message"=>"Plan did not Created.");
	echo json_encode($data1);
}





function createStripePlan($id,$type,$amount,$db,$plan_name){
 $interval="month";
 $nick_name="Monthly";
 $amount=$amount*100;
 if($type==2){
 	$interval="year";
 	$nick_name="Yearly";
 }

//ajay code
$pro_id='';
$product_data='';
$sqlInsert2 = "select plan_id,product_id from plans where plan_name ='".$plan_name."'";

$exeInsert2 = $db->query($sqlInsert2);
$data=mysqli_fetch_assoc($exeInsert2);

$pro_id=$data['product_id']; 
//ajay code end

\Stripe\Stripe::setApiKey('sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm'); 
  try{ 
	// One time code for create product 
	//  $responseData = \Stripe\Product::create([
	// 	'name' => 'Eworxs Product',
	//   ]); 
	//   $data1= array("Status"=>1,"Message"=>$responseData);
	//   echo json_encode($data1);
	//   exit();

    // $result = \Stripe\Plan::create([
	//   'nickname' => $interval,
	//   'product' => 'prod_LbPBe4sMWC4Zjr',
	//   'amount' => $amount, 
	//   'currency' => 'usd',
	//   'interval' => $interval,
	//   'usage_type' => 'licensed',
	// ]);
  
/*	$stripe = new \Stripe\StripeClient('sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm');*/
	 

		$stripe = new \Stripe\StripeClient('sk_test_51Lp88OSGrsTiiR1Y13QK9rOuQ5xf7LLXJJCOn3A0SHvak6HKJsaLX85M0sA9AYjV2A0pjbYGskDZWRBeFUIVbFE700ChyxmP2i'); 
	 

if($pro_id!='')
{
    $product_data=$pro_id;
}
else
{
    	 	$datap= $stripe->products->create([
  'name' => $plan_name
]);

    $product_data=$datap->id;
}
	 
	 //prod_LbPBe4sMWC4Zjr
	$result = $stripe->prices->create([
		'unit_amount' => $amount, 
		'currency' => 'usd',
		'recurring' => ['interval' => $interval],
		'product' => $product_data
		
		
	  ]); 
		 
    if(isset($result->id)){
      $planId=$result->id;
      $productId=$result->product;
      $sql = "UPDATE plans SET plan_id='$planId',product_id='$productId',status=1 WHERE id='$id'"; 
      $exe = $db->query($sql);
      if($exe==1){
      	$db->close();
      	$data1= array("Status"=>1,"Message"=>'Plan Created');
		echo json_encode($data1);
      }else{
      	$db->close();
      	$data1= array("Status"=>0,"Message"=>"Plan not updated.");
		echo json_encode($data1);
      }
    }else{
    	$db->close();
    	$data1= array("Status"=>0,"Message"=>"Stripe plan not Created.");
		echo json_encode($data1);
    }

  }catch (Exception $e){
  	$db->close();
  	$data1= array("Status"=>0,"Message"=>"Error: ".$e->getMessage());
	echo json_encode($data1);
  }
}



?>