<?php
ini_set('date.timezone', 'Asia/Kolkata');
require_once('stripe/init.php');
require 'dbconfig.php';
session_start();
$id=$_REQUEST["id"];
$company_id = $_SESSION['companyid'];

$db = db_connect();

$sqlUnique = "SELECT * FROM client_subscriptions WHERE plan_id='$id' && company_id='$company_id' && status=1";
$exeUnique = $db->query($sqlUnique);
if($exeUnique->num_rows>0){
  $db->close();
  $data1= array("Status"=>0,"Message"=>"This plan is already purchased.");
  echo json_encode($data1);
}else{
  $custId = getCustomerId($db,$company_id);
  if($custId==null){
    $db->close();
    $data1= array("Status"=>0,"Message"=>"Customer did not created.");
    echo json_encode($data1);
  }else{
    $data1= array("Status"=>1,"Message"=>$custId);
    echo json_encode($data1);
    // $sql = "SELECT card_added FROM companies WHERE id='$company_id'";
    // $exe = $db->query($sql);
    // if($exe->num_rows>0){
    //   $dataResult = $exe->fetch_all(MYSQLI_ASSOC);
    //   $card_added = $dataResult[0]['card_added'];
    //   if($card_added==0){
    //     $db->close();
    //     $data1= array("Status"=>2,"Message"=>"Insert card detail.");
    //     echo json_encode($data1);
    //   }else{
    //     $data1= array("Status"=>1,"Message"=>$custId);
    //     echo json_encode($data1);
    //   }
    // }


    //  $sqlInsert = "INSERT INTO client_subscriptions(plan_id,subscription_id,company_id,status,created_at)VALUES('$id','','$company_id',1,now())";
    // $exeInsert = $db->query($sqlInsert);
    // $last_id = $db->insert_id;
    // if(!empty($last_id)){
    //   $db->close();
    //   $data1= array("Status"=>1,"Message"=>"Plan has been purchased.");
    //   echo json_encode($data1);
    //   //createStripePlan($last_id,$plan_type,$plan_amount,$db);
    // }else{
    //   $db->close();
    //   $data1= array("Status"=>0,"Message"=>"Plan did not purchase.");
    //   echo json_encode($data1);
    // }
  }

 

  
}


function getCustomerId($db,$company_id){
  $sql = "SELECT cust_id,email,company_name FROM companies WHERE id='$company_id'";
  $exe = $db->query($sql);
  if($exe->num_rows>0){
    $dataResult = $exe->fetch_all(MYSQLI_ASSOC);
    $cust_id = $dataResult[0]['cust_id'];
    $email = $dataResult[0]['email'];
    $company_name = $dataResult[0]['company_name'];
    if($cust_id!=""){
      return $cust_id;
    }else{
      return createCustomer($db,$company_id,$company_name,$email);
    }
  }
}


function createCustomer($db,$company_id,$name,$email){
  \Stripe\Stripe::setApiKey('sk_test_eQACpuX8Ih8H3aiLk6vEy5If');
  try{
    $result = \Stripe\Customer::create([
      'description' => 'Customer'.$company_id,
      'name' => $name,
      'email' => $email
    ]);

    if(isset($result->id)){
      $custId=$result->id;
      $sql = "UPDATE companies SET cust_id='$custId' WHERE id='$company_id'"; 
      $exe = $db->query($sql);
      if($exe==1){
        return $custId;
      }else{
        return null;
      }
    }else{
      return null;
    }

  }catch (Exception $e){
    return null;
  }
}







function createStripePlan($id,$type,$amount,$db){
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
      $sql = "UPDATE plans SET plan_id='$planId',product_id='$productId',status=1 WHERE id='$id'"; 
      $exe = $db->query($sql);
      if($exe==1){
      	$db->close();
      	$data1= array("Status"=>1,"Message"=>"Plan created.");
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