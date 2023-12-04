<?php
include "header.php";
$get_current_plan = "";
$company_id = $_SESSION["companyid"];
$db = db_connect();
if ($company_id != "") 
{
    $checkoutsession_id = "";
    $plan_sql ="SELECT checkout_session_id FROM companies WHERE id = " . $company_id;
    $plan_exe = $db->query($plan_sql);
    if ($plan_exe->num_rows > 0) 
    {
        $dataResult = $plan_exe->fetch_all(MYSQLI_ASSOC);
        $checkoutsession_id = $dataResult[0]["checkout_session_id"];
    }
    if ($checkoutsession_id != "") 
    {
        $url = "";
        $result = "";
        $json = "";
        $sub_id = "";
        $url ="https://api.stripe.com/v1/checkout/sessions/" .$checkoutsession_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $headers = [];
        $headers[] = "Accept: application/json";
        $headers[] ="Authorization: Bearer sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) 
        {
            echo "Error:" . curl_error($ch);
        }
        curl_close($ch);
        $json = json_decode($result, true);
        $sub_id = $json["subscription"];
        if ($sub_id != "")
         {
            $url1 = "https://api.stripe.com/v1/subscriptions/" . $sub_id;
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_URL, $url1);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "GET");
            $headers1 = [];
            $headers1[] = "Accept: application/json";
            $headers1[] ="Authorization: Bearer sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm";
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);
            $result1 = curl_exec($ch1);
            if (curl_errno($ch1)) 
            {
                echo "Error:" . curl_error($ch1);
            }
            curl_close($ch1);
            $get_current_plan = "";
            $json1 = json_decode($result1, true);
            $plan_id_value = $json1["items"]["data"][0]["plan"]["id"];
            $plan_sql1 ="SELECT plan_name,plan_id,id FROM plans WHERE plan_id = '" .
                            $plan_id_value ."'";
            $plan_exe1 = $db->query($plan_sql1);
              if($plan_exe1->num_rows > 0) 
                {
                            $dataResult1 = $plan_exe1->fetch_all(MYSQLI_ASSOC);
                            $plan_name = $dataResult1[0]["plan_name"];
                            $plan_id = $dataResult1[0]["plan_id"];
                            $get_current_plan = $dataResult1[0]["id"];
                }
            }
        } 
    else 
    {
      $plan_sql ="SELECT plan_id FROM `company_subscriptions` where company_id=".$company_id." and status=1 ORDER BY `id` DESC limit 1";
        $plan_exe = $db->query($plan_sql);
        if ($plan_exe->num_rows > 0) 
        {
            $dataResult = $plan_exe->fetch_all(MYSQLI_ASSOC);
             $get_current_plan  = $dataResult[0]["plan_id"];
        }
        else
        {
              $get_current_plan = 41;
        }
    }
}

if (isset($_POST["updateplan"])) 
{
    $radioVal = $_POST["fav_language"];
    $quantity=1;
    if(isset($_POST["noofworkers"]) && $_POST["noofworkers"]!="")
    {
    $quantity = $_POST["noofworkers"];
    }


    $company_id = $_SESSION["companyid"];
    $db = db_connect();
    if ($company_id != "") 
    {
        $checkoutsession_id = "";
        $plan_sql ="SELECT checkout_session_id FROM companies WHERE id = " .$company_id;
        $plan_exe = $db->query($plan_sql);
        if ($plan_exe->num_rows > 0) 
        {
            $dataResult = $plan_exe->fetch_all(MYSQLI_ASSOC);
            $checkoutsession_id = $dataResult[0]["checkout_session_id"];
        }
        if ($checkoutsession_id != "") 
        {
            $url = "";
            $result = "";
            $json = "";
            $sub_id = "";
            $url ="https://api.stripe.com/v1/checkout/sessions/" .$checkoutsession_id;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $headers = [];
            $headers[] = "Accept: application/json";
            $headers[] = "Authorization: Bearer sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if (curl_errno($ch)) 
            {
                echo "Error:" . curl_error($ch);
            }
            curl_close($ch);
            $json = json_decode($result, true);
            $sub_id = $json["subscription"];
            if ($sub_id != "") 
            {
                $url1 = "";
                $result1 = "";
                $json1 = "";
                $status = "";
                $plan_id_value = "";
                $sub_start = "";
                $currency = "";
                $interval = "";
                $month = "";
                $plan_name = "";
                $plan_id = "";
                $sub_end = "";
                $duration = "";
                $sub_id_value = "";
                $plan_db_id = "";
                $url1 = "https://api.stripe.com/v1/subscriptions/" . $sub_id;
                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL, $url1);
                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "GET");
                $headers1 = [];
                $headers1[] = "Accept: application/json";
                $headers1[] = "Authorization: Bearer sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm";
                curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);
                $result1 = curl_exec($ch1);
                if (curl_errno($ch1))
                {
                    echo "Error:" . curl_error($ch1);
                }
                curl_close($ch1);
                $json1 = json_decode($result1, true);
                $sub_id_value = $json1["items"]["data"][0]["id"];
                $status = $json1["status"];
                $plan_id_value = $json1["items"]["data"][0]["plan"]["id"];
                $month =$json1["items"]["data"][0]["price"]["recurring"]["interval"];
                $interval =$json1["items"]["data"][0]["price"]["recurring"]["interval_count"];
                $duration = "+" . $interval . " " . $month;
                $sub_start = date("d M Y", $json1["created"]);
                $sub_startstrtotime = strtotime($sub_start);
                $sub_end = date("d M Y",strtotime("+1 month", $sub_startstrtotime)
                );
                $plan_sql1 =
                    "SELECT plan_name,plan_id,id FROM plans WHERE plan_id = '" .
                    $plan_id_value .
                    "'";
                $plan_exe1 = $db->query($plan_sql1);
                if ($plan_exe1->num_rows > 0) {
                    $dataResult1 = $plan_exe1->fetch_all(MYSQLI_ASSOC);
                    $plan_name = $dataResult1[0]["plan_name"];
                    $plan_id = $dataResult1[0]["plan_id"];
                    $plan_db_id = $dataResult1[0]["id"];
                }
                if ($sub_id_value != "" && $radioVal != "") {
                    $data12 = "quantity=".$quantity."&price=" . $radioVal;
                    $url =
                        "https://api.stripe.com/v1/subscription_items/" .
                        $sub_id_value;
                    $ch1734 = curl_init();
                    curl_setopt($ch1734, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch1734, CURLOPT_URL, $url);
                    curl_setopt($ch1734, CURLOPT_POST, 1);
                    curl_setopt($ch1734, CURLOPT_POSTFIELDS, $data12);
                    $headers = [];
                    $headers[] = "Accept: application/json";
                    $headers[] =
                        "Authorization: Bearer sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm";
                    curl_setopt($ch1734, CURLOPT_HTTPHEADER, $headers);

                    $result1734 = curl_exec($ch1734);
                    if (curl_errno($ch1734)) {
                        echo "Error:" . curl_error($ch1734);
                    }
                    $current_plan_id = "";
                    $current_plan_id = $_POST["currentplanid"];

                    if ($result1734 != "") {
                        $sql2222 = "update company_subscriptions set status =0 WHERE company_id='$company_id' and plan_id='$current_plan_id'";
                       /* echo $sql;
                        die();*/
                        $db->query($sql2222);

                        $sql2223 = "update companies  set checkoutsession_id ='' WHERE company_id='$company_id' ";
                       /* echo $sql;
                        die();*/
                        $db->query($sql2223);


                         $sql2224 = "update companies  set no_of_workers =".$quantity." WHERE id='$company_id' ";
                       /* echo $sql;
                        die();*/
                        $db->query($sql2224);


                        $update_active_plan_id = "";
                        $plan_sql1234 =
                            "SELECT id FROM plans WHERE plan_id = '" .
                            $radioVal .
                            "'";
                        $plan_exe1234 = $db->query($plan_sql1234);
                        if ($plan_exe1234->num_rows > 0) {
                            $dataResult1234 = $plan_exe1234->fetch_all(
                                MYSQLI_ASSOC
                            );
                            $update_active_plan_id = $dataResult1234[0]["id"];
                        }
                        // $sql =
                        //     "insert into company_subscriptions(plan_id,company_id,subscription_id,status,created_at) value(" .
                        //     $update_active_plan_id .
                        //     "," .
                        //     $company_id .
                        //     ",'" .
                        //     $result1734->subscription .
                        //     "',1,now())";
                        // $db->query($sql);
                           $sql =
                            "insert into company_subscriptions(plan_id,company_id,subscription_id,no_of_workers,status,created_at) value(" .
                            $update_active_plan_id .
                            "," .
                            $company_id .
                            ",'" .
                            $result1734->subscription .
                            "'," .$quantity .",1,now())";
                        $db->query($sql);


                    }
                }
            }
        } else {

            $url = "https://api.stripe.com/v1/customers";
            $ch1769 = curl_init();
            curl_setopt($ch1769, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch1769, CURLOPT_URL, $url);
            curl_setopt($ch1769, CURLOPT_POST, 1);
            $headers = [];
            $headers[] = "Accept: application/json";
            $headers[] ="Authorization: Bearer sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm";
            curl_setopt($ch1769, CURLOPT_HTTPHEADER, $headers);
            $result1769 = curl_exec($ch1769);
            $json1769 = json_decode($result1769, true);
            if ($json1769 != "") {
                $url = "https://api.stripe.com/v1/payment_methods";
                $ch17961 = curl_init();
                curl_setopt($ch17961, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch17961, CURLOPT_URL, $url);
                curl_setopt($ch17961, CURLOPT_POST, 1);
                curl_setopt($ch17961,CURLOPT_POSTFIELDS,"type=card&card[number]=" .$_POST["card_number"] ."&card[exp_month]=" .$_POST["expiry_month"] ."&card[exp_year]=" .$_POST["expiry_year"] ."&card[cvc]=" .$_POST["cvc"] ."");
                $headers = [];
                $headers[] = "Accept: application/json";
                $headers[] ="Authorization: Bearer sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm";
                curl_setopt($ch17961, CURLOPT_HTTPHEADER, $headers);
                $res17961 = curl_exec($ch17961);
                $data17961 = json_decode($res17961);

                if ($data17961 != "") 
                {
                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL,"https://api.stripe.com/v1/payment_methods/" .$data17961->id ."/attach");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "customer=" . $json1769["id"] . "");
                    curl_setopt($ch,CURLOPT_USERPWD,"sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm" . ":" . "");

                    $headers = [];
                    $headers[] ="Content-Type: application/x-www-form-urlencoded";
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo "Error:" . curl_error($ch);
                    }
                    curl_close($ch);
                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL,"https://api.stripe.com/v1/customers/" .$json1769["id"] ."");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch,CURLOPT_POSTFIELDS,"name=" .$company_id .
                            "&invoice_settings[default_payment_method]=" .$data17961->id
                    );
                    curl_setopt($ch,CURLOPT_USERPWD,"sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm" . ":" . "");
                    $headers = [];
                    $headers[] ="Content-Type: application/x-www-form-urlencoded";
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result7777 = curl_exec($ch);
                    $data7777 = json_decode($result7777);
                    if (curl_errno($ch)) {
                        echo "Error:" . curl_error($ch);
                    }
                    curl_close($ch);

                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL,"https://api.stripe.com/v1/invoices");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch,CURLOPT_POSTFIELDS,"customer=" . $json1769["id"] . "");
                    curl_setopt($ch,CURLOPT_USERPWD,"sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm" . ":" . "");
                    $headers = [];
                    $headers[] ="Content-Type: application/x-www-form-urlencoded";
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo "Error:" . curl_error($ch);
                    }
                    curl_close($ch);
                }

                if ($data7777!= "") 
                {
                    // echo "ajay";

                    // echo $quantity;die;
                    $data1796 ="items[0][quantity]=".$quantity."&items[0][price]=" .$radioVal ."&customer=" .$json1769["id"];
                    $url = "https://api.stripe.com/v1/subscriptions";
                    $ch1796 = curl_init();
                    curl_setopt($ch1796, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch1796, CURLOPT_URL, $url);
                    curl_setopt($ch1796, CURLOPT_POST, 1);
                    curl_setopt($ch1796, CURLOPT_POSTFIELDS, $data1796);
                    $headers = [];
                    $headers[] = "Accept: application/json";
                    $headers[] ="Authorization: Bearer sk_test_k11gZlDKwJ3iUInZzkVlcivP00eWZkWKVm";
                    curl_setopt($ch1796, CURLOPT_HTTPHEADER, $headers);
                    $result1796 = curl_exec($ch1796);
                    if ($result1796 != "") {
                        $sub_id_value = "";
                        $status = "";
                        $plan_id_value = "";
                        $month = "";
                        $interval = "";
                        $duration = "";
                        $sub_start = "";
                        $sub_end = "";
                        $plan_db_id = "";
                        $json1 = json_decode($result1796, true);
                        $sub_id_value = $json1["items"]["data"][0]["id"];
                        $status = $json1["status"];
                        $plan_id_value =
                            $json1["items"]["data"][0]["plan"]["id"];
                        $month =
                            $json1["items"]["data"][0]["price"]["recurring"][
                                "interval"
                            ];
                        $interval =
                            $json1["items"]["data"][0]["price"]["recurring"][
                                "interval_count"
                            ];
                        $duration = "+" . $interval . " " . $month;
                        $sub_start = date("d M Y", $json1["created"]);
                        $sub_startstrtotime = strtotime($sub_start);
                        $sub_end = date(
                            "d M Y",
                            strtotime("+1 month", $sub_startstrtotime)
                        );
                        $plan_sql1 ="SELECT plan_name,plan_id,id FROM plans WHERE plan_id = '" .
                            $plan_id_value ."'";
                          
                        $plan_exe1 = $db->query($plan_sql1);
                        if ($plan_exe1->num_rows > 0) {
                            $dataResult1 = $plan_exe1->fetch_all(MYSQLI_ASSOC);
                            $plan_name = $dataResult1[0]["plan_name"];
                            $plan_id = $dataResult1[0]["plan_id"];
                            $plan_db_id = $dataResult1[0]["id"];
                        }

                          $current_plan_id = "";
                    $current_plan_id = $_POST["currentplanid"];

                        $sql1111 = "update company_subscriptions set status =0 WHERE company_id='$company_id' and plan_id='$current_plan_id'";
                     /* echo $sql;
                        die;*/
                        $db->query($sql1111);
                          $sql1112 = "update companies  set checkoutsession_id ='' WHERE company_id='$company_id' ";
                        //echo $sql;
                        //die();*/
                        $db->query($sql1112);

                          $sql1113 = "update companies  set no_of_workers =".$quantity." WHERE id='$company_id' ";

                        // echo $sql1113;die;
                        $db->query($sql1113);

                        $update_active_plan_id = "";
                        $plan_sql1234 =
                            "SELECT id FROM plans WHERE plan_id = '" .
                            $radioVal .
                            "'";
                        $plan_exe1234 = $db->query($plan_sql1234);
                        if ($plan_exe1234->num_rows > 0) {
                            $dataResult1234 = $plan_exe1234->fetch_all(
                                MYSQLI_ASSOC
                            );
                            $update_active_plan_id = $dataResult1234[0]["id"];
                        }
                        $sql =
                            "insert into company_subscriptions(plan_id,company_id,subscription_id,no_of_workers,status,created_at) value(" .
                            $update_active_plan_id .
                            "," .
                            $company_id .
                            ",'" .
                            $json1["id"] .
                            "'," .$quantity .",1,now())";
                        $db->query($sql);
                      




                    }
                }
            }
        }
    }
}

$company_id = $_SESSION["companyid"];
if ($_SESSION["role"] == 1) {
    echo "<script> window.location = 'admin_login.php'</script>";
}
$db = db_connect();
$sql = "SELECT id,company_id,first_name,last_name,email,phone,password,local_address,permanent_address,postal_code,status,created_at,work_rate,mileage_rate FROM workers where company_id = $company_id and status=1 ORDER BY id";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
foreach ($data as $key => $value) {
    $data[$key]["id"] = $value["id"];
    $data[$key]["company_id"] = $value["company_id"];
    $data[$key]["first_name"] = $value["first_name"];
    $data[$key]["last_name"] = $value["last_name"];
    $data[$key]["email"] = $value["email"];
    $data[$key]["phone"] = $value["phone"];
    $data[$key]["password"] = $value["password"];
    $data[$key]["local_address"] = $value["local_address"];
    $data[$key]["permanent_address"] = $value["permanent_address"];
    $data[$key]["postal_code"] = $value["postal_code"];
    $data[$key]["status"] = $value["status"];
    $data[$key]["created_at"] = $value["created_at"];
    $data[$key]["work_rate"] = $value["work_rate"];
    $data[$key]["mileage_rate"] = $value["mileage_rate"];
}
?>  
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>EWORXS | Automatically Track Your Mileage</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>



</head>

<style>.pac-container {
        z-index: 10000 !important;
    }
  body{
    padding: 0px !important;
  }
.scrollbar{
    height: 65px;
    width: auto;
    overflow-x: unset!important;
    overflow-y: overlay;
  }
.force-overflow{
    min-height: 0px;
  }
  #exampleModalLabel
  {
    background: #3e276d;
    font-weight: bold;
  }
/*#wrapper{
    text-align: center;
    width: 500px;
    margin: auto;
  }*/
#style-2::-webkit-scrollbar-track{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 10px;
  }
#style-2::-webkit-scrollbar{
    width: 6px;
  }

#style-2::-webkit-scrollbar-thumb{
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
  }
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include('left_side_bar.php');?>
  <!-- Trigger the modal with a button -->
  <!-- Modal -->
  <div class="edit_user_list_modal">
  <div class="modal fade" id="edit_employee_list_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="test"></p>
          <h4 class="modal-title">Edit Worker </h4>
          <input type="text" class="form-control" id="editUserId" style="display: none;" />
        </div>
        <div class="modal-body">
          <div class="user-info-area">
            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">First Name</div>
                <input type="text" class="form-control" id="editfirstName"/>
              </div>
              <div class="col-md-3">
                <div class="personal-info-label">Last Name</div>
                <input type="text" class="form-control" id="editlastName"/>
              </div>
              <div class="col-md-3">
                <div class="personal-info-label">Email</div>
                <input type="text" class="form-control" id="editemail"/>
              </div>
              <div class="col-md-3">
                <div class="personal-info-label">Phone</div>
                <input type="text" class="form-control" id="editphone"/>
              </div>
            </div>
            <hr/>
            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">Password</div>
                <input type="text" class="form-control" id="editpassword"/>
              </div>
              <div class="col-md-3">
                <div class="personal-info-label">Local Address</div>
                <input type="text" class="form-control" id="edit_local_address"/>
              </div>
              <div class="col-md-3">
                <div class="personal-info-label">Home Address</div>
                <input type="text" class="form-control" id="edit_permanent_address"/>
              </div>
              <div class="col-md-3">
                <div class="personal-info-label">Postal Code</div>
                <input type="text" class="form-control" id="editpostalCode"/>
              </div>
            </div>
            <hr/>

            <div class="row ">
             <!--  <div class="col-md-3">
                <div class="personal-info-label">Company</div>
                <select class="form-control" id="editcompany">
                  <?php //foreach($dataComp as $key => $value){ ?>
                  <option value="<?php //echo $value['id']; ?>"><?php //echo $value['company_name']; ?></option>
                  <? //} ?>
                </select>
              </div> -->

             <?php  $company_id = $_SESSION['companyid']; ?>
              <input id="editcompany" type="hidden" value="<?php echo $company_id;?>">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="editEmployee2();">Update</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 class="make-inline">Workers List</h1> 
          
          <a href="workers_list_csv.php">
            <button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a>
<?php 

$data_worker_count=0;
$noofworkerallowedinteambasic=0;
if($_SESSION['role']==2)
{
 $sql18 = "SELECT plan_id FROM  company_subscriptions where company_id =".$_SESSION['companyid']."  and company_subscriptions.status=1 order by id desc limit 1"; 
  $exe181 = $db->query($sql18);
  $data181 = $exe181->fetch_all(MYSQLI_ASSOC);
       if($data181[0]['plan_id']==40)
        {
         $sql = "SELECT count(workers.id) as worker_count FROM workers left join company_subscriptions on company_subscriptions.company_id=workers.company_id
         where workers.company_id =".$_SESSION['companyid']." and  company_subscriptions.plan_id= 40 and company_subscriptions.status=1"; 
           $sql1 = "SELECT no_of_workers as worker_count_limit FROM companies where id =".$_SESSION['companyid']; 

                       $exe1711 = $db->query($sql1);
              $data1711 = $exe1711->fetch_all(MYSQLI_ASSOC);

            if(!empty($data1711)){
            foreach ($data1711 as $key => $value1711){
                  $noofworkerallowedinteambasic=$value1711['worker_count_limit']; 
              }}
 
        }   

        if($data181[0]['plan_id']==41)
        {
         $sql = "SELECT count(workers.id) as worker_count FROM workers left join company_subscriptions on company_subscriptions.company_id=workers.company_id where workers.company_id =".$_SESSION['companyid']." and  company_subscriptions.plan_id= 41 and company_subscriptions.status=1"; 
        }

 if($data181[0]['plan_id']==42)
        {
         $sql = "SELECT count(workers.id) as worker_count FROM workers left join company_subscriptions on company_subscriptions.company_id=workers.company_id where workers.company_id =".$_SESSION['companyid']." and  company_subscriptions.plan_id= 42 and company_subscriptions.status=1"; 
        }


        if($data181[0]['plan_id']==43)
        {
         $sql = "SELECT count(workers.id) as worker_count FROM workers left join company_subscriptions on company_subscriptions.company_id=workers.company_id where workers.company_id =".$_SESSION['companyid']." and  company_subscriptions.plan_id= 43 and company_subscriptions.status=1"; 
        }

         if($data181[0]['plan_id']==44)
        {
         $sql = "SELECT count(workers.id) as worker_count FROM workers left join company_subscriptions on company_subscriptions.company_id=workers.company_id where workers.company_id =".$_SESSION['companyid']." and  company_subscriptions.plan_id= 44 and company_subscriptions.status=1"; 
        }

         if($data181[0]['plan_id']==71)
        {
         $sql = "SELECT count(workers.id) as worker_count FROM workers left join company_subscriptions on company_subscriptions.company_id=workers.company_id where workers.company_id =".$_SESSION['companyid']." and  company_subscriptions.plan_id= 71 and company_subscriptions.status=1"; 
        }

          if($data181[0]['plan_id']==72)
        {
         $sql = "SELECT count(workers.id) as worker_count FROM workers left join company_subscriptions on company_subscriptions.company_id=workers.company_id where workers.company_id =".$_SESSION['companyid']." and  company_subscriptions.plan_id= 72 and company_subscriptions.status=1"; 
        }

  $exe171 = $db->query($sql);
  $data171 = $exe171->fetch_all(MYSQLI_ASSOC);
          if(!empty($data171)){
          foreach ($data171 as $key => $value171){
              $data_worker_count=$value171['worker_count']; 
          }
        }

}
?>



<?php 

// echo $data181[0]['plan_id'];
// echo "ajdd";
// echo $data_worker_count;
// echo "djkndjnjd";
if($data181[0]['plan_id']==41 && $data_worker_count<1)
{?>
        <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button>
<?php } 

else if($data181[0]['plan_id']==42 && $data_worker_count<1)
{?>
        <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button>
<?php } 

else if($data181[0]['plan_id']==43 && $data_worker_count<1)
{?>
        <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button>
<?php }


else if($data181[0]['plan_id']==40 && $data_worker_count<$noofworkerallowedinteambasic)
{?>
        <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New  <i class="fa fa-plus-circle"></i></button>
<?php }

else if($data181[0]['plan_id']==44 && $data_worker_count<$noofworkerallowedinteambasic)
{?>
        <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New  <i class="fa fa-plus-circle"></i></button>
<?php }


else if($data181[0]['plan_id']==71)
{?>
        <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New  <i class="fa fa-plus-circle"></i></button>
<?php }

else if($data181[0]['plan_id']==72)
{?>
        <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New  <i class="fa fa-plus-circle"></i></button>
<?php }?>



<button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#upgrad" style="margin-right: 10px;">Upgrade Plan <i class="fa fa-plus-circle"></i></button>


    </section>
    <!-- Main content -->
    <section class="content">
<?php include("upgrademodal.php"); ?>


<section class="content">
      <div class="row">
        <div class="">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body" style="overflow:scroll">
                
                 <div class="edit_user_list_modal">
  <div class="modal fade" id="add_employee_list_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
     <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create New Workers</h4>
        </div>
        <div class="modal-body">
          <div class="user-info-area">
            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">First Name</div>
                <input type="text" class="form-control" id="first_name"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Last Name</div>
                <input type="text" class="form-control" id="last_name"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Email</div>
                <input type="text" class="form-control" id="email"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Phone</div>
                <input type="text" class="form-control" id="phone"/>
              </div>
            </div>
            <hr/>

            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">Password</div>
                <input type="text" class="form-control" id="password"/>
              </div>

             <div class="col-md-6">
                <div class="personal-info-label">Home Address</div> 
                <input type="text" name="autocomplete" id="autocomplete" class="form-control" placeholder="Select Location">
               
              </div>

           <div class="col-md-3">
            <div class="form-group" id="lat_area" >
              <label for="latitude"> Latitude </label>
              <input type="text"  id="latitude" class="form-control" disabled>
            </div>
            </div> 
            <div class="col-md-3">
            <div class="form-group" id="long_area" >
              <label for="latitude"> Longitude </label>
              <input type="text"  id="longitude" class="form-control" disabled>
            </div>
            </div>

              <div class="col-md-3">
                <div class="personal-info-label">Postal Code</div>
                <input type="text" class="form-control" id="postal_code"/>
              </div>
              
				   <div class="col-md-3">
                <div class="personal-info-label">Hourly Rate</div>
                <input type="text" class="form-control" id="workRate"/>
              </div>
            </div>
            <hr/>

           <div class="row ">
             <div class="col-md-3">
                <div class="personal-info-label">MIleage Rate</div>
                <input type="number" min="0" step="1" oninput="validity.valid||(value='');" class="form-control" id="mileageRate"/>
              </div>
           <?php  $company_id = $_SESSION['companyid']; ?>
             <!--  <div class="col-md-3">
                <div class="personal-info-label">Company</div>
                <select class="form-control" id="company">
                  <?php //foreach($dataComp as $key => $value){ ?>
                  <option value="<?php //echo $value['id']; ?>"><?php //echo $value['company_name']; ?></option>
                  <? //} ?>
                </select>
              </div> -->
              <input id="company" type="hidden" value="<?php echo $company_id;?>">
            </div>
          </div>
        </div>
       <div class="modal-footer">
          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="addNewEmployee();">Create</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
        </div>
      </div>
    </div>
  </div>
  </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <!-- <th>Id</th> -->
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <!-- <th>Password</th> -->
                  <!--<th>Local Address</th>-->
                  <th>Home Address</th>
                  <th>Postal Code</th>
                  <!-- <th>Status</th> -->
                  <th>Created At</th>
                  <th>Hourly Rate</th>
                  <th>Mileage Rate</th>
                  <th>History</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
<?php

// print_r($data);
foreach ($data as $key =>  $item){
  $count=$key+1;
  $id= $item['id'];

        echo'<tr>'; 
        echo'<td>'.$count.'</td>';
       /* echo'<td>'.$item['id'].'</td>';*/
        echo'<td>'.$item['first_name'].'</td>';
        echo'<td>'.$item['last_name'].'</td>';
        echo'<td>'.$item['email'].'</td>';
        echo'<td>'.$item['phone'].'</td>';
        /*echo'<td>'.$item['password'].'</td>';*/
        //echo'<td>'.$item['local_address'].'</td>';
        echo'<td><div class="scrollbar" id="style-2">
      <div class="force-overflow"></div>
    '.$item['permanent_address'].'</div></td>';
        echo'<td>'.$item['postal_code'].'</td>';
        // echo'<td>'.$item['status'].'</td>';
        echo'<td>'.$item['created_at'].'</td>';
        echo'<td>'.$item['work_rate'].'</td>';
        echo'<td>'.$item['mileage_rate'].'</td>';
        echo'<td><a href="employee_history.php?emp_id='.$item['id'].'" target="_blank"><button type="button" class="btn theme-btn">History</button></a></td>';
        echo'<td> <a href="worker_edit.php?worker_id='.$item['id'].'" target="_blank"> <button type="button" class="btn open-ClientDialog" data-toggle="modal" data-target="#edit_employee_list_modal" data-id='.$id.' >Edit</button></a>
       <button type="button" class="btn btn-danger" id="add-employee-list-btn" onclick="deleteEmp('.$item['id'].')">Delete</button></td>';
      } 
  ?>
              </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    </section>

  </div>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jQuery/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="plugins/jQuery/raphael-min.js"></script>
<!-- daterangepicker -->
<script src="plugins/jQuery/moment.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<!-- <script src="plugins/datatables/jquery.dataTables.min.js"></script> -->
<!-- <script src="plugins/datatables/dataTables.bootstrap.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/buttons.html5.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!--<script src="https://maps.google.com/maps/api/js?key=AIzaSyCwpns7FoF40IUPN4ianDrtxsOY9zR0RwE&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script src="address.js"></script>-->
<script type="text/javascript">
$('#password_submit').click(function(){
var old_pass = $('#old_password').val();
var new_pass = $('#new_password').val();
var new_pass_confirm = $('#new_password_confirm').val();
$.ajax({
    url:"ChangeAdminPassword.php",
    data:{OldPAss:old_pass,
    NewPAss:new_pass,
    NewPAssConfirm:new_pass_confirm},
    type:'post',
    success:function(response){
      alert(response);
      location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
    }
   });
});


$(function () {
    // $("#example1").DataTable();

   var dataTablesVersion = $.fn.dataTable.version;
            console.log("DataTables Version: " + dataTablesVersion);
  var table = $('#example1').DataTable({
                "dom": 'Bfrtip', // Show the export button
                // "buttons": [
                //     {
                //         "extend": 'csv', // Export to CSV
                //         "text": 'Export', // Button text
                //         "exportOptions": {
                         

                //              "columns": ':visible:not(:last-child):not(:nth-last-child(2))'
                //         }
                        
                //     }
                // ]
            });










    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });

$('#empMobile').keydown(function(){
  //alert(this.value);
  //$("#myField").val(this.value.match(/[0-9]*/));
  if( this.value.length>9){
     this.value="";
     alert("value should not be more than 10 or less than 10.");
    return false;
  }
});
function showCaseDetail(id){
  var brand = $("#brand"+id).val();
  var model = $("#model"+id).val();
  var description = $("#description"+id).val();
  document.getElementById("brand1").innerHTML=brand;
  document.getElementById("model1").innerHTML=model;
  document.getElementById("problem1").innerHTML=description;
}
function deleteEmp(id)
{
 if(confirm("Are you sure you want to delete this?")){
    $.ajax({
        url:"AjaxDeleteEmp.php",
        data:{id:id
        },
        type:'post',
        dataType: 'json',
        success:function(response){
           console.log(response.Message);
          alert(response.Message);
          location.reload();
        },
        error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      alert(err.Message);
    }
       });
}
}

function deleteUser(id){
$.ajax({
    url:"deleteUser.php",
    data:{UserId:id},
    type:'post',
    success:function(response){
      alert(response);
      location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }
   });
  }

function editEmp(id){
  var name = $("#name"+id).val();
  var mobile = $("#mobile"+id).val();
  var userType = $("#userType"+id).val();
   $("#editempName").val(name);
   $("#editempMobile").val(mobile);
   $("#editempPassword").val("xxxxxxx");
   $("#editUserId").val(id);
   if(userType==2){
      $("#editempType").val("Engineer");
   }else{
      $("#editempType").val("Delivery Boy");
   }
}

function editEmployee2()
{
  var id  =         $(".test").text();
     var editfirstName= $("#editfirstName").val();
    var editlastName=   $("#editlastName").val();
    var editemail=    $("#editemail").val();
    var editphone=     $("#editphone").val();
     var editpassword=     $("#editpassword").val();
      var editcompanyName=      $("#editcompanyName").val();
      var editofficeAddress=       $("#editofficeAddress").val();
      var editpostalCode=        $("#editpostalCode").val();
      var edit_local_address=        $("#edit_local_address").val();
       var edit_permanent_address=      $("#edit_permanent_address").val();
        var editdateRange=      $("#editdateRange").val();
 var editcompany=  $("#editcompany").val();
     var editstatus=        $("#editstatus").val();

 if (editcompanyName== '') {
  alert("Please Select Company");
 }
else if(editemail== '') {
  alert("Please Type Email");
 }
 /*else if(editphone== '') {
  alert("Please Type Phone");
 }*/
else
{

 $.ajax({
    url:"AjaxUpdateDataEmp.php",
    data:{"id":id,
          "editfirstName":editfirstName,
          "editlastName":editlastName,
          "editemail":editemail,
          "editphone":editphone,
          "editpassword":editpassword,
          "editcompanyName":editcompanyName,
          "editofficeAddress":editofficeAddress,
          "editpostalCode":editpostalCode,
          "edit_local_address":edit_local_address,
          "edit_permanent_address":edit_permanent_address,
          "editdateRange":editdateRange,
          "editcompany":editcompany,
          "editstatus":editstatus
        },
    type:'post',
    dataType: 'json',
    success:function(response){
      alert(response.Message);
      location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}
   });
}
}

function editEmployee(){
 userType=3;
  var emp = document.getElementById('editempType').value;
  if(emp=="Engineer"){
    userType=2;
  }
  var name = document.getElementById('editfirstName').value;
  var last_name = document.getElementById('editlastName').value;
  var email = document.getElementById('editemail').value;
  var mobile = document.getElementById('editempMobile').value;
  var password = document.getElementById('editempPassword').value;
  var userId = document.getElementById('editUserId').value;
    $.ajax({
        url:"EditEmployee.php",
        data:{EmpFirstName:name,EmpLastName:last_name,
          UserType:userType,
          EmpMobile:mobile,
          EmpEmail:email,
          EmpPassword:password,
          EmpId:userId},
        type:'post',
        success:function(response){
          alert(response);
          location.reload();
        },
        error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      alert(err.Message);
    }
       });
}

function showCaseList(array1){
$("#case_list").html('');
  array1.forEach(function(element) {
    console.log(element);
    $("#case_list").append('<li>'+element+'</li>');
});
}
</script>

<script type="text/javascript">
    $(function () {
        $(".open-ClientDialog").click(function () {
           var id  = $(this).data('id');
            $(".test").text(id);
            $.ajax({
               url:"AjaxUpdateEmp.php",
                data:{editclientid:id
                },
                type:'post',
                dataType: 'json',
                success:function(response){
                      $("#editfirstName").val(response.firstName);
                      $("#editlastName").val(response.lastName);
                      $("#editemail").val(response.email);
                      $("#editphone").val(response.phone);
                     /* $("#editpassword").val(response.password);*/
                      $("#editcompanyName").val(response.company_name);
                      $("#editofficeAddress").val(response.office_address);
                      $("#editpostalCode").val(response.postal_code);
                      $("#editworkRate").val(response.work_rate);
                      $("#editmileageRate").val(response.mileage_rate);
                      $("#editdateRange").val(response.date_range);
                      $("#editcompany").val(response.company_id);
                      $("#edit_local_address").val(response.local_address);
                      $("#edit_permanent_address").val(response.permanent_address);
                },
                error: function(xhr, status, error) {
                  var err = eval("(" + xhr.responseText + ")");
                  alert(err.Message);
                }
               });
        });
    }); 
    
     function IsEmail(email) {
      var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if(!regex.test(email)) {
        return false;
      }else{
        return true;
      }
    }
    function addNewEmployee(){
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var password = $('#password').val();
        //var local_address = $('#local_address').val();
        var permanent_address = $('#autocomplete').val();
        var postal_code = $('#postal_code').val();
        var company = $('#company').val();
        var workRate = $('#workRate').val();
        var mileageRate = $('#mileageRate').val(); 
        var latitude = $('#latitude').val();
        var longitude = $('#longitude').val();
        /* if ($('#company').val()== '') {
          alert("Please Select Company");
         }*/

         
         if (first_name== '') {
          alert("Please Type First Name");
          return false;
         }
         if (last_name== '') {
          alert("Please Type Last Name");
          return false;
         }




         if (email== '') {
          alert("Please Type Email");
          return false;
         }
         if(IsEmail(email)==false){
           alert("Please Type Valid Email");
            return false;
         }
         if(phone== ''){
           alert("Please Type Phone");
             return false;
         }

          if(password== ''){
           alert("Please Type Password");
             return false;
         }

          if(permanent_address== ''){
           alert("Please Type Home Address");
             return false;
         }

          if(postal_code== ''){
           alert("Please Type Postal Code");
             return false;
         }
          if(workRate== ''){
           alert("Please Type Hourly Rate");
             return false;
         }

          if(mileageRate== ''){
           alert("Please Type Mileage Rate");
             return false;
         }


      else{
            $.ajax({
                url:"AjaxCreateEmployee.php",
                data:{first_name:first_name,last_name:last_name,email:email,phone:phone,
                  password:password,local_address:'',permanent_address:permanent_address,postal_code:postal_code,company:company,workRate:workRate,mileageRate:mileageRate,latitude:latitude,longitude:longitude },
                type:'post',
                dataType: 'json',
                async: true,
                success:function(response){
                  var status=response.Status;
                  //alert(response.Message);
                  if(status==1){
                       alert(response.Message);
                       location.reload();
                  }
                  else if(status==0)
                  {
                     alert(response.Message);
                  }
                },
                error: function(xhr, status, error) {
                  var err = eval("(" + xhr.responseText + ")");
                  alert(err.Message);
                }
            });
    }
} 
</script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCwpns7FoF40IUPN4ianDrtxsOY9zR0RwE&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script src="address.js"></script>
<script src="creditcard.js"></script>
<script>
  function cardFormValidate(){
    var cardValid = 0;
    //card number validation
    $('#card_number').validateCreditCard(function(result){
        if(result.valid){
            $("#card_number").removeClass('required');
            cardValid = 1;
        }else{
            $("#card_number").addClass('required');
            cardValid = 0;
        }
    });
    //card details validation
   /* var cardName = $("#name_on_card").val();*/
    var expMonth = $("#expiry_month").val();
    var expYear = $("#expiry_year").val();
    var cvv = $("#cvv").val();
    var regName = /^[a-z ,.'-]+$/i;
    var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
    var regYear = /^2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
    var regCVV = /^[0-9]{3,3}$/;
    if (cardValid == 0) {
        $("#card_number").addClass('required');
        $("#card_number").focus();
        return false;
    }else if (!regMonth.test(expMonth)) {
        $("#card_number").removeClass('required');
        $("#expiry_month").addClass('required');
        $("#expiry_month").focus();
        return false;
    }else if (!regYear.test(expYear)) {
        $("#card_number").removeClass('required');
        $("#expiry_month").removeClass('required');
        $("#expiry_year").addClass('required');
        $("#expiry_year").focus();
        return false;
    }else if (!regCVV.test(cvv)) {
        $("#card_number").removeClass('required');
        $("#expiry_month").removeClass('required');
        $("#expiry_year").removeClass('required');
        $("#cvv").addClass('required');
        $("#cvv").focus();
        return false;
    }else{
        $("#card_number").removeClass('required');
        $("#expiry_month").removeClass('required');
        $("#expiry_year").removeClass('required');
        $("#cvv").removeClass('required');
      /*  $("#name_on_card").removeClass('required');*/
        return true;
    }
}
$(document).ready(function() {
    //card validation on input fields
    $('#paymentForm input[type=text]').on('keyup',function(){
        cardFormValidate();
    });
    $('#updateplan').on('click',function(){
      if(cardFormValidate()){
    $('#paymentForm').submit();
    }
    });
});
</script>
<script type="text/javascript">
$(function() {
$("#example1").parent().css('overflow-x','scroll');
$("#example1_wrapper").parent().css('overflow','unset');
});
</script>


<script>
$(document).ready(function() {
  var inputBox = $("#worker_section");
  var radioButton3 = $("#selfpaidyear");
  var radioButton6 = $("#selfpaid");
  var radioButton2 = $("#businessyearly");
  var radioButton = $("#businessmonthly");
   var radioButton5 = $("#businessaceyearly");
  var radioButton4 = $("#businessacemonthly");

var newValue121 = '';
 $('#no_of_workers').on('keyup', function() {
         newValue121 = $.trim($('#no_of_workers').val());
           
        alert(newValue121);
        
        if(newValue121 === '')
        {
            newValue121=1;
        }
        var defaultValue = $("#total_charge_default").val();
        var totalchargeValue = $("#total_charge").text();
        // alert(totalchargeValue);
        // Do something with the new value
        if(newValue121 === '' )
        {  
            console.log("hello");
        console.log(defaultValue);
         $('#total_charge').text(defaultValue*newValue121);
        }
        else
        {
            console.log("hello1");
          $('#total_charge').text(defaultValue*newValue121); 
        } 

    });
  inputBox.hide(); // Initially hide the input box

  // Add a click event handler to the radio button
  radioButton3.click(function() {
    if (radioButton3.is(":checked")) {
      // Show the input box
       var selectedValue = $(this).val();
        
        // Make an AJAX call based on the selected value
        $.ajax({
            url: 'getplanprice.php', // Replace with your actual AJAX endpoint URL
            type: 'POST', // or 'GET' depending on your server-side implementation
            data: { option: selectedValue }, // Pass data to the server
            success: function(response) {
                // alert(response);
                // alert("hello");
                // Update the result div with the AJAX response
                $('#total_charge').text(response);
                 $('#total_charge_default').val(response);
            },
            error: function(xhr, status, error) {
                // Handle errors if the AJAX call fails
                console.error(xhr.responseText);
            }
        });
        inputBox.hide();
      
    } else {
      // Hide the input box
      
    }
  });

    radioButton6.click(function() {
    if (radioButton6.is(":checked")) {
      // Show the input box
       var selectedValue = $(this).val();
        
        // Make an AJAX call based on the selected value
        $.ajax({
            url: 'getplanprice.php', // Replace with your actual AJAX endpoint URL
            type: 'POST', // or 'GET' depending on your server-side implementation
            data: { option: selectedValue }, // Pass data to the server
            success: function(response) {
                // alert(response);
                // alert("hello");
                // Update the result div with the AJAX response
                $('#total_charge').text(response);
                 $('#total_charge_default').val(response);
            },
            error: function(xhr, status, error) {
                // Handle errors if the AJAX call fails
                console.error(xhr.responseText);
            }
        });
        inputBox.hide();
      
    } else {
      // Hide the input box
      
    }
  });


   
    
   radioButton2.click(function() {
    
    if (radioButton2.is(":checked")) {

 $("#no_of_workers").val(''); 
        // Get the selected radio button's value
        var selectedValue = $(this).val();
        
        // Make an AJAX call based on the selected value
        $.ajax({
            url: 'getplanprice.php', // Replace with your actual AJAX endpoint URL
            type: 'POST', // or 'GET' depending on your server-side implementation
            data: { option: selectedValue }, // Pass data to the server
            success: function(response) {
                // alert(response);
                // alert("hello");
                // Update the result div with the AJAX response
                $('#total_charge').text(response);
                $('#total_charge_default').val(response);
            },
            error: function(xhr, status, error) {
                // Handle errors if the AJAX call fails
                console.error(xhr.responseText);
            }
        });

     inputBox.show();
    } else {
      // Hide the input box
      inputBox.hide();
    }
});

          radioButton4.click(function() {
    
    if (radioButton4.is(":checked")) {

 $("#no_of_workers").val(''); 
        // Get the selected radio button's value
        var selectedValue = $(this).val();
        
        // Make an AJAX call based on the selected value
        $.ajax({
            url: 'getplanprice.php', // Replace with your actual AJAX endpoint URL
            type: 'POST', // or 'GET' depending on your server-side implementation
            data: { option: selectedValue }, // Pass data to the server
            success: function(response) {
                // alert(response);
                // alert("hello");
                // Update the result div with the AJAX response
                $('#total_charge').text(response);
                    $('#total_charge_default').val(response);
            },
            error: function(xhr, status, error) {
                // Handle errors if the AJAX call fails
                console.error(xhr.responseText);
            }
        });

  inputBox.show();
    } else {
      // Hide the input box
      inputBox.hide();
    }

    });

         radioButton5.click(function() {
    
    if (radioButton5.is(":checked")) {

 $("#no_of_workers").val(''); 
        // Get the selected radio button's value
        var selectedValue = $(this).val();
        
        // Make an AJAX call based on the selected value
        $.ajax({
            url: 'getplanprice.php', // Replace with your actual AJAX endpoint URL
            type: 'POST', // or 'GET' depending on your server-side implementation
            data: { option: selectedValue }, // Pass data to the server
            success: function(response) {
                // alert(response);
                // alert("hello");
                // Update the result div with the AJAX response
                $('#total_charge').text(response);
                    $('#total_charge_default').val(response);
            },
            error: function(xhr, status, error) {
                // Handle errors if the AJAX call fails
                console.error(xhr.responseText);
            }
        });

      // Show the input box
      inputBox.show();
    } else {
      // Hide the input box
      inputBox.hide();
    }
  });

     radioButton.click(function() {
    if (radioButton.is(":checked")) {
      // Show the input box
       // alert("hello");
        // Get the selected radio button's value
        $("#no_of_workers").val('');
        var selectedValue = $(this).val();
        
        // Make an AJAX call based on the selected value
        $.ajax({
            url: 'getplanprice.php', // Replace with your actual AJAX endpoint URL
            type: 'POST', // or 'GET' depending on your server-side implementation
            data: { option: selectedValue }, // Pass data to the server
            success: function(response) {
                // Update the result div with the AJAX response
                $('#total_charge').text(response);
                    $('#total_charge_default').val(response);
            },
            error: function(xhr, status, error) {
                // Handle errors if the AJAX call fails
                console.error(xhr.responseText);
            }
        });
      inputBox.show();
    } else {
      // Hide the input box
      inputBox.hide();
    }
  });
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
    // Attach a change event listener to the radio buttons
    // $('input[type=radio][name=fav_language]').click(function() {
    //     alert("hello");
    //     // Get the selected radio button's value
    //     var selectedValue = $(this).val();
        
    //     // Make an AJAX call based on the selected value
    //     $.ajax({
    //         url: 'getplanprice.php', // Replace with your actual AJAX endpoint URL
    //         type: 'POST', // or 'GET' depending on your server-side implementation
    //         data: { option: selectedValue }, // Pass data to the server
    //         success: function(response) {
    //             // Update the result div with the AJAX response
    //             $('#total_charge').text(response);
    //         },
    //         error: function(xhr, status, error) {
    //             // Handle errors if the AJAX call fails
    //             console.error(xhr.responseText);
    //         }
    //     });
    // });

    
    // Attach an input event listener to the input field
    // $('#no_of_workers').on('input', function() {
    //     var newValue = $(this).val();
    //     var totalchargeValue = $(#total_charge).text();
    //     // Do something with the new value
    //     $('#total_charge').text(totalchargeValue*newValue);
    // });


});

</script>
<?php include "checkcompanystatus.php"; ?>
</body>
</html>
