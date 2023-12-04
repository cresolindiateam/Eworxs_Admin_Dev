<?php
ini_set('date.timezone', 'Asia/Kolkata');
require_once('stripe/init.php');
require 'dbconfig.php';
//$db = db_connect();

//createProduct();
createPlan(2,1,20);


function createProduct(){
  $status=false;
  //$db = connect_db();

  \Stripe\Stripe::setApiKey('sk_test_eQACpuX8Ih8H3aiLk6vEy5If');

  try{
    $result = \Stripe\Product::create([
	  'name' => 'Eworxs Management',
	  'type' => 'service',
	]);

	print_r($result);


    // if(isset($result->id)){
    //   $custId=$result->id;
    //   $sql = "UPDATE stripe_customer_detail SET stripe_bank_token='$token' WHERE stripe_customer_id='$custId'"; 
    //   $exe = $db->query($sql);
    //   if($exe==1){
    //     $status=true;
    //     chargeCustomerSource($custId, $amount);
    //   }else{
    //     $data = array('Status'=>false, 'Message'=>"Customer token not updated.");
    //     echo json_encode($data);
    //   }
    // }else{
    //   $data = array('Status'=>false, 'Message'=>"Stripe token not updated.");
    //   echo json_encode($data);
    // }

  }catch (Exception $e){
    echo "Error: ".$e->getMessage();
  }
}

function createPlan($id,$type,$amount){
	$db = db_connect();
 $status=false;
 $interval="month";
 $nick_name="Monthly";
 $amount=$amount*100;
 if($type==2){
 	$interval="year";
 	$nick_name="Yearly";
 }

  \Stripe\Stripe::setApiKey('sk_test_eQACpuX8Ih8H3aiLk6vEy5If');

  try{
    $result = \Stripe\Plan::create([
	  'nickname' => $interval,
	  'product' => 'prod_Gvt29mzqQTYG3s',
	  'amount' => $amount,
	  'currency' => 'usd',
	  'interval' => $interval,
	  'usage_type' => 'licensed',
	]);

    if(isset($result->id)){
      $planId=$result->id;
      $productId=$result->product;

      $sql = "UPDATE plans SET plan_id='$planId',product_id='$productId' WHERE id='$id'"; 
      $exe = $db->query($sql);
      if($exe==1){
        $data = array('Status'=>false, 'Message'=>"Plan created.");
        echo json_encode($data);
      }else{
        $data = array('Status'=>false, 'Message'=>"Plan not updated.");
        echo json_encode($data);
      }
    }else{
      $data = array('Status'=>false, 'Message'=>"Stripe plan not Created.");
      echo json_encode($data);
    }

  }catch (Exception $e){
    echo "Error: ".$e->getMessage();
  }
}




// Stripe\Product Object ( [id] => prod_Gvt29mzqQTYG3s [object] => product [active] => 1 [attributes] => Array ( ) [created] => 1584535491 [description] => [images] => Array ( ) [livemode] => [metadata] => Stripe\StripeObject Object ( ) [name] => Eworxs Management [skus] => Stripe\Collection Object ( [object] => list [data] => Array ( ) [has_more] => [total_count] => 0 [url] => /v1/skus?product=prod_Gvt29mzqQTYG3s&active=true ) [statement_descriptor] => [type] => service [unit_label] => [updated] => 1584535491 )
?>