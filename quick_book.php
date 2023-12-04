<?php 
include('header.php'); 
if($_SESSION['username']==""){
echo "<script> window.location = 'admin_login.php';</script>";
}
if($_SESSION['role']==1){
  echo "<script> window.location = 'admin_login.php';</script>";
}
$company_id= $_SESSION['companyid'];

define("start_date_default", date("Y-m-d", strtotime("-6 months")));
define("end_date_default", date("Y-m-d"));


$db=db_connect(); 
//status
$sql .= "SELECT client_visits.id as clientvisitesid,client_visits.client_work_rate AS client_work_rate,client_visits.client_mileage_rate AS client_mileage_rate,company_clients.client_company_name,client_visits.duration,client_visits.client_name,client_visits.return_mileage_status as return_mileage,company_clients.due_date_range,client_visits.distance,

workers.work_rate AS emp_work_rate,workers.mileage_rate AS emp_mileage_rate,company_clients.work_rate AS client_work_rate1,company_clients.mileage_rate AS client_mileage_rate1,company_clients.email AS client_email,
company_clients.mileage_rate,company_clients.postal_code AS ca_postal, workers.postal_code AS ic_postal,

client_visits.visit_date,client_visits.mileage_status FROM client_visits JOIN workers ON(client_visits.worker_id=workers.id) JOIN company_clients ON(client_visits.company_client_id=company_clients.id)

JOIN companies ON(companies.id=company_clients.company_id)


 where company_clients.company_id = ". $company_id;


$startdate='';
$enddate='';

$userInputstart='';
$userInputend='';
$startdate= start_date_default;
$enddate= end_date_default;

 if (isset($_GET["start_date"])) {
            // Retrieve the submitted value
            $userInputstart = $_GET["start_date"];
        }
         if (isset($_GET["end_date"])) {
            // Retrieve the submitted value
            $userInputend = $_GET["end_date"];
        }



if(isset($_POST['action']))
{

   if (isset($_POST["start_date"])) {
            // Retrieve the submitted value
            $userInputstart = $_POST["start_date"];
        }
         if (isset($_POST["end_date"])) {
            // Retrieve the submitted value
            $userInputend = $_POST["end_date"];
        }
   $startdate = $_POST['start_date'];
  $enddate = $_POST['end_date'];

$sql .= " AND client_visits.visit_date  BETWEEN '".$startdate."' AND '".$enddate."'";
}
else
{
  $sql .= " AND client_visits.visit_date  BETWEEN '".$startdate."' AND '".$enddate."'";
}
 
 $sql .=" ORDER BY client_visits.id DESC ";

// echo $sql;

$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);

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

<style>
     .filter-form {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-group label {
            width: 100px;
            text-align: right;
            margin-right: 10px;
            font-weight: bold;
        }

        .form-group input[type="date"] {
            width: 200px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-group input[type="submit"] {
            padding: 5px 10px;
            background-color: #3e276d;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
  body{
    padding: 0px !important;
  }
    /* Style for the tooltip */
    .tooltip1 {
        position: relative;
        display: inline-block;
    }
    
    .tooltip1 .tooltiptext {
        visibility: hidden;
        width: 300px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 100%;
        left: 125%;
        transform: translate(-122%,91%);
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .tooltip1:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include('left_side_bar.php');?>
  <!-- Trigger the modal with a button -->
  <!-- Modal -->
  <div class="add_employee_list_modal">
  <div class="modal fade" id="add_employee_list_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create New Client </h4>
        </div>
        <div class="modal-body">
           <div class="user-info-area">
            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">First Name</div>
                <input type="text" value="" class="form-control" id="firstName"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Last Name</div>
                <input type="text" class="form-control" id="lastName"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Email</div>
                <input type="email" pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" class="form-control" id="email"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Phone</div>
                <input type="text" class="form-control" id="phone"/>
              </div>
            </div>
           <hr/>

            <div class="row ">
             <!-- <div class="col-md-3">
                <div class="personal-info-label">Password</div>
                <input type="text" class="form-control" id="password"/>
              </div>-->

               <div class="col-md-3">
                <div class="personal-info-label">Company Name</div>
                <input type="text" class="form-control" id="companyName"/>
              </div> 

              <div class="col-md-3">
                <div class="personal-info-label">Office Address</div>
                <input type="text" class="form-control" id="officeAddress"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Postal Code</div>
                <input type="text" class="form-control" id="postalCode"/>
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
             <div class="col-md-3">
                <div class="personal-info-label">Due Date</div>
                <!--<input type="text" class="form-control" id="dateRange"/>-->
                <select id="dateRange" class="form-control">
                    <option value="DueuponReceipt"> Due upon Receipt</option>
                    <option value="N15"> N15</option>
                    <option value="N30"> N30</option>
                    <option value="N45"> N45</option>
                    <option value="N60"> N60</option>
                    <option value="N90"> N90</option>
                   </select> 
              </div>
            <!--    <div class="col-md-3">
                <div class="personal-info-label">Company</div>
                <select class="form-control" id="company">
                  <?php //foreach($dataComp as $key => $value){ ?>
                  <option value="<?php //echo $value['id']; ?>"><?php //echo $value['company_name']; ?></option>
                  <? //} ?>
                </select>
              </div> -->
               <?php  $company_id = $_SESSION['companyid']; ?>
              <input id="company" type="hidden" value="<?php echo $company_id;?>">
             <div class="col-md-3">
                <div class="personal-info-label">Clock Setting </div>
                <!--<input type="text" class="form-control" id="clock"/>-->
                <select id="clock" class="form-control">
                    <option value="0">0</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                   </select> 
              </div>
            </div>
            <hr/>
          </div>
        <!--   <table class="table table-bordered">
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone</th>
               <th>Password</th>
               <th>Company Name</th>
              <th>Office Address</th>
              <th>Postal Code</th>
              <th>Status</th>
              <th>Work Rate</th>
              <th>MIleage Rate</th>
              <th>Due Date Range</th>
              <th>Company</th>
            </tr>
            <tr>
              <td><input type="text" class="form-control" id="officeAddress"/></td>
              <td><input type="text" class="form-control" id="postalCode"/></td>
              <td><select class="form-control" id="status">
                  </select></td>
              <td><input type="text" class="form-control" id="workRate"  /></td>
              <td><input type="text" class="form-control" id="mileageRate"/></td>
              <td><input type="number" class="form-control" id="dateRange"/></td>
               <td><select class="form-control" id="company">
                  <?php //foreach($dataComp as $key => $value){ ?>
                  <option value="<?php //echo $value['id']; ?>"><?php //echo $value['company_name']; ?></option>
                  <? //} ?>
                </select>
              </td>
            </tr>
          </table> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onclick="addNewCompanyClient()">Create</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <div class="edit_employee_list_modal">
  <div class="modal fade" id="edit_employee_list_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="test" value="" ></p>
          <h4 class="modal-title">Edit Client </h4>
        </div>
        <div class="modal-body">
        <div class="user-info-area">
            <div class="row ">
              <div class="col-md-3">
               <div class="personal-info-label">First Name</div>
                <input type="text"  class="form-control" id="editfirstName"/>
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
              <!--<div class="col-md-3">
                <div class="personal-info-label">Password</div>
                <input type="text" class="form-control" id="editpassword"/>
              </div>-->

               <div class="col-md-3">
                <div class="personal-info-label">Company Name</div>
                <input type="text" class="form-control" id="editcompanyName"/>
              </div> 

              <div class="col-md-3">
                <div class="personal-info-label">Office Address</div>
                <input type="text" class="form-control" id="editofficeAddress"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Postal Code</div>
                <input type="text" class="form-control" id="editpostalCode"/>
              </div>
				
				  <div class="col-md-3">
                <div class="personal-info-label">Hourly Rate</div>
                <input type="text" class="form-control" id="editworkRate"/>
              </div>
            </div>
        <hr/>
         
     <div class="row ">
             <div class="col-md-3">
                <div class="personal-info-label">MIleage Rate</div>
                <input type="text" class="form-control" id="editmileageRate"/>
              </div>
             <div class="col-md-3"> 
                <div class="personal-info-label">Due Date</div>
                  <select id="editdateRange" class="form-control">
                    <option value="DueuponReceipt"> Due upon Receipt</option>
                    <option value="N15"> N15</option>
                    <option value="N30"> N30</option>
                    <option value="N45"> N45</option>
                    <option value="N60"> N60</option>
                    <option value="N90"> N90</option>
                   </select> 
                
                <!--<input type="text" class="form-control" id="editdateRange"/>-->
              </div>
                   <div class="col-md-3"> 
                <div class="personal-info-label">Clock Setting</div>
                  <select id="editclock" class="form-control">
                    <option value="0">0</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                   </select> 
                <!--<input type="text" class="form-control" id="editdateRange"/>-->
              </div>
              <!--  <div class="col-md-3">
                <div class="personal-info-label">Status</div>
                <select class="form-control" id="editstatus">
                  <option value="1">1</option>
                    <option value="2">2</option>
                </select>
              </div>-->
            </div>
            <hr/>

            <div class="row ">
           <!--    <div class="col-md-3">
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
          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onclick="updateNewCompanyClient()">Update</button>
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
        <form method="post" class="filter-form">
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required value="<?php if (isset($userInputstart) && $userInputstart!=''){echo $userInputstart;} else{ echo start_date_default; } ?>" min="<?php echo start_date_default;?>" max="<?php echo end_date_default;?>">
        </div>

        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required value="<?php if (isset($userInputend) && $userInputend!='' ){ echo $userInputend;} else{ echo end_date_default; } ?>" min="<?php echo start_date_default;?>" max="<?php echo end_date_default;?>">
        </div>

        <div class="form-group">
            <input type="submit" value="Filter" name="action" style="margin-left:20px">
        </div>
        <div class="form-group">
            <input type="button" value="Reset" onclick="myFunction()" style="margin-left:10px;">
        </div>
    </form>
      <h1 class="make-inline">List</h1>


      <!--  <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button> -->
      <?php 
      $start_date= start_date_default;
if(isset($_GET['start_date']))
{
  $start_date=$_GET['start_date'];
}
  $end_date=end_date_default;
if(isset($_GET['end_date']))
{
  $end_date=$_GET['end_date'];
}

      ?>
       <a href="quick_book_csv.php?action=filterexport&start_date=<?php echo $start_date?>&end_date=<?php echo $end_date;?>">


        <button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a>
     <a href="../QBO_online_export_instructions.pdf" style="color: red;">
      <span class="tooltip1 pull-right">
        <span style="background-color: lightgrey;color: #333;border-radius: 50%;font-size: 21px;height: 21px;width: 100px;font-weight: bold;display: inline-block;width: 35px;height: 35px;margin-right: 10px;">
          <span style="margin: 4px 12px;
        display: inline-block;">?
        </span>
       </span>
    <span class="tooltiptext" style="display: none"><ul style="list-style: none;
    margin: 0;
    padding: 5px 10px;
    text-align: left;"><!-- 
                            <li>All data in this file is for sample purposes only.</li>
                                  <li>* Required column</li> -->
                                  <li> NOTE: You must turn on "Custom transaction numbers" in Accounts and Settings or your invoice numbers will be replaced by standard QuickBooks invoice numbers.</li></ul></span>
</span>
</a>
    </section>
    <!-- Main content -->
    <section class="content">
      <section class="content">
            <div class="row">
              <div class="">
                <div class="box">
                  <!-- /.box-header -->
                  <div class="box-body" style="overflow:scroll">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="display:none">id</th>
                        <th>Invoice No.</th>
                        <th>Customers</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Terms</th>
                        <th>Location</th>
                        <th>Memo</th>
                        <th>Item(Product/Service)</th>
                        <th>ItemDescription</th>
                        <th>ItemQuantity</th>
                        <th>ItemRate</th>
                        <th>ItemAmount</th>
                         <th>ServiceDate</th>
                          <th>Client Company's Email</th>
                      </tr>
                      </thead>
                      <tbody>

              <?php
              $count=1000;

$due_date_range_prefix='';
              foreach ($data as $key =>  $item){

 if($item['due_date_range']>0)
                   {
                    $due_date_range_prefix='Net '.$item['due_date_range'];
                   }
                   else
                   {
                    $due_date_range_prefix='Due on receipt';
                    
                   }

               $id= $item['clientvisitesid'];

          if($item['mileage_status']==1){
               if($item['return_mileage']==0)
               {
                $distance=(float)$item['distance'];
                }
                else
                {
                 $distance=(float)$item['distance']*2; 
                }
              }
              else
              {
                   if($item['return_mileage']==0)
               {
                $distance=0;
                }
                else
                {
                 $distance=0; 
                }
              }

                 $amount=$distance*(float)$item['client_mileage_rate'];

                    $client_due_bal = (float)$amount+(float)$item['client_work_rate']*$item['duration'];
                

                 $due_days = $item['due_date_range'];
                    $due_date = $item['visit_date'];
                    if($due_days>0){
                      $due_days = "+".$due_days." day";
                      $due_date = strtotime($due_days, strtotime($due_date));
                      $due_date = date("Y-m-d", $due_date);
                    }

                $count=$count+1;
                      echo'<tr>'; 
                      echo'<td style="display:none">'.$id.'</td>';
               
                      echo'<td>'.$count.'</td>';
                      echo'<td>'.$item['client_company_name'].'</td>';
                      echo'<td>'.$item['visit_date'].'</td>';
                      echo'<td>'.$due_date.'</td>';
                      echo'<td>'.$due_date_range_prefix.'</td>';
                    echo'<td>-</td>';
                    echo'<td>-</td>';
                      echo'<td>Field Service<br>Travel time</td>';
                      echo'<td>'.$item['visit_date'].'-'.$item['client_name'].'<br>'.$item["ic_postal"] ." TO " .$item["ca_postal"].'</td>';

                       if($item['mileage_status']==1){   
                      echo'<td>'.$item['duration'].'<br>'.$distance.'</td>';
                    }else
                    {
                        echo'<td>'.$item['duration'].'<br></td>';
                    }
                  
                  if($item['mileage_status']==1){    
                      echo'<td>'.(float)$item['client_work_rate'].'<br>'.(float)$item['client_mileage_rate'].'</td>';
                    }
                    else
                    {
                      echo'<td>'.(float)$item['client_work_rate'].'<br></td>';

                    }


                      echo'<td>'.$client_due_bal.'</td>';
                      echo'<td>'.$item['visit_date'].'</td>';
                       echo'<td>'.$item['client_email'].'</td>';
                     
                     
                       $id= $item['id'];
                      
                    }

              ?>

              </tbody>
              </table>
<!-- <div>
  <p>
All data in this file is for sample purposes only.</p>
<p>* Required column</p>
<p>NOTE: You must turn on "Custom transaction numbers" in Accounts and Settings or your invoice numbers will be replaced by standard QuickBooks invoice numbers.</p>
</div> -->

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
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

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
         console.log(response.Data);
        //alert(response);
       // location.reload();
      },
      error: function(xhr, status, error) {
    var err = eval("(" + xhr.responseText + ")");
    alert(err.Message);
      }
     });
});

$(function () {
    $("#example1").DataTable();
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
</script>
<script type="text/javascript">
    $(function () {
        $(".open-ClientDialog").click(function () {
           var id  = $(this).data('id');
              $(".test").text(id);
              $.ajax({
                 url:"AjaxUpdateComapnyClient.php",
                  data:{editclientid:id
                  },
                  type:'post',
                  dataType: 'json',
                  success:function(response){
                    console.log(response);
                    $("#editfirstName").val(response.firstName);
                    $("#editlastName").val(response.lastName);
                    $("#editemail").val(response.email);
                    $("#editphone").val(response.phone);
                    /*$("#editpassword").val(response.password);*/
                    $("#editcompanyName").val(response.company_name);
                    $("#editofficeAddress").val(response.office_address);
                    $("#editpostalCode").val(response.postal_code);
                    $("#editworkRate").val(response.work_rate);
                    $("#editmileageRate").val(response.mileage_rate);
                    $("#editdateRange").val(response.date_range);
                    console.log(response.clock_setting);
                    $("#editclock").val(response.clock_setting);
                    $("#editcompany").val(response.company_id);
                    /* $("#editstatus").val(response.status);*/
                  },
                  error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
              }
                 });

/*
          $.ajax({
    url:"AjaxUpdateComapnyClient.php",
    data:{editclientid:id},
    type:'post',
    dataType: 'json',
    async: true,
    success:function(response){
      console.log(response);
      alert("hello");
      var id  = $(this).data('id');
      var first_name= response['firstName'];
      $("#editfirstName").val(first_name);
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}
   });
*/
        });
    });
</script>
<script>

function updateNewCompanyClient()
{
        var id= $(".test").text();
        var editfirstName= $("#editfirstName").val();
        var editlastName= $("#editlastName").val();
        var editemail= $("#editemail").val();
        var editphone= $("#editphone").val();
        var editpassword= $("#editpassword").val();
        var editcompanyName= $("#editcompanyName").val();
        var editofficeAddress= $("#editofficeAddress").val();
        var editpostalCode= $("#editpostalCode").val();
        var editworkRate= $("#editworkRate").val();
        var editmileageRate= $("#editmileageRate").val();
        var editdateRange= $("#editdateRange").val();
        var editcompany= $("#editcompany").val();
        var editclock= $("#editclock").val();
        /*var editstatus= $("#editstatus").val();*/
         if (editcompanyName== '') {
          alert("Please Select Company");
          return false;
         }
        else if(editemail== '') {
          alert("Please Type Email");
          return false;
         }
         if(IsEmail(editemail)==false){
                  alert("Please Type Valid Email");
                  return false;
                }
                
        /*if(editphone== '') {
          alert("Please Type Phone");
          return false;
         }
        */
         /*else if(editphone== '') {
          alert("Please Type Phone");
         }*/
        else
        {
           $.ajax({
              url:"AjaxUpdateDataCompanyClient.php",
              data:{"id":id,"editfirstName":editfirstName,"editlastName":editlastName,"editemail":editemail,"editphone":editphone,"editpassword":editpassword,"editcompanyName":editcompanyName,"editofficeAddress":editofficeAddress,"editpostalCode":editpostalCode,"editworkRate":editworkRate,"editmileageRate":editmileageRate,"editdateRange":editdateRange,"editcompany":editcompany,"editclock":editclock/*"editstatus":editstatus*/
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

</script>
<script>

  function myFunction()
  {
    window.location.href='https://eworxs.app/EworxsAdmin/quick_book.php';
  }
function deleteCompanyClient(id)
{
 if(confirm("Are you sure you want to delete this?")){
    $.ajax({
        url:"AjaxDeleteComapnyClient.php",
        data:{id:id
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

 function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}

function addNewCompanyClient(){
    var companyName = document.getElementById('companyName').value;
    var firstName = document.getElementById('firstName').value;
    var last_name = document.getElementById('lastName').value;  
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    //var password = document.getElementById('password').value;
    var postal_code = document.getElementById('postalCode').value;
    var work_rate = document.getElementById('workRate').value;
    var mileage_rate = document.getElementById('mileageRate').value;
    var due_date_range = document.getElementById('dateRange').value;
    var company = document.getElementById('company').value;
    var clock = document.getElementById('clock').value;
	  var officeAddress = document.getElementById('officeAddress').value;
   
     if (companyName== '') {
      alert("Please Type Company");
      return false;
     } 
     else if(email== '') {
      alert("Please Type Email");
      return false;
     }
      if(IsEmail(email)==false){
              alert("Please Type Valid Email");
              return false;
            }
      /*if(phone== '') {
        alert("Please Type Phone");
        return false;
       }
      */
       /*else if(phone== '') {
        alert("Please Type Phone");
       }*/
        else
        {
          $.ajax({
              url:"AjaxCreateCompanyClient.php",
              data:{company_name:companyName,first_name:firstName,last_name:last_name,email:email,phone:phone,postal_code:postal_code,work_rate:work_rate,mileage_rate:mileage_rate,due_date_range:due_date_range,company:company,clock:clock,office_address:officeAddress
              },
              type:'post',
               dataType: 'json',
              success:function(response){
                alert(response.Message);
               if(response.Status==1){
                    location.reload();
                  }
              },
              error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
          }
             });
        }
}

function showCaseDetail(id){
  var brand = $("#brand"+id).val();
  var model = $("#model"+id).val();
  var description = $("#description"+id).val();
  document.getElementById("brand1").innerHTML=brand;
  document.getElementById("model1").innerHTML=model;
  document.getElementById("problem1").innerHTML=description;
}

function deleteUser(id){
    //alert(id);
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

function editEmployee(){
  userType=3;
  var emp = document.getElementById('editempType').value;
  if(emp=="Engineer"){
    userType=2;
  }
  var name = document.getElementById('editempName').value;
  var mobile = document.getElementById('editempMobile').value;
  var password = document.getElementById('editempPassword').value;
  var userId = document.getElementById('editUserId').value;
  $.ajax({
      url:"EditEmployee.php",
      data:{EmpName:name,UserType:userType,EmpMobile:mobile,EmpPassword:password,EmpId:userId},
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
$(function() {
  $("#example1").parent().css('overflow-x','scroll');
$("#example1_wrapper").parent().css('overflow','unset');

});
</script>

<!-- <script>
        var startinputValue='';
         var endinputValue='';
        $("#start_date").on("input", function() 
        {
            var startinputValue = $(this).val();
          });

              $("#end_date").on("input", function() 
           {
            var endinputValue = $(this).val();
            });

            $.ajax({
                type: "POST",
                // url: "update_value.php", // Replace with your PHP script URL
                data: {start_value: startinputValue,end_value:endinputValue,"action":"senddata"},
                success: function(response) {
                    console.log(response);
                }
            });
       


      </script> -->


<script>
        const inputElement = document.getElementById("start_date");

        inputElement.addEventListener("input", function () {
            const inputValue = inputElement.value;
            const currentURL = new URL(window.location.href);

            // Update the query parameter with the input value
            currentURL.searchParams.set("start_date", inputValue);

            // Replace the current URL without reloading the page
            window.history.replaceState({}, "", currentURL);

            // You can also see the updated URL in the browser's address bar
            window.location.href=currentURL.href;
        });

 const inputElement1 = document.getElementById("end_date");
 inputElement1.addEventListener("input", function () {
            const inputValue = inputElement1.value;
            const currentURL = new URL(window.location.href);

            // Update the query parameter with the input value
            currentURL.searchParams.set("end_date", inputValue);

            // Replace the current URL without reloading the page
            window.history.replaceState({}, "", currentURL);

            // You can also see the updated URL in the browser's address bar
            window.location.href=currentURL.href;
        });
  
        // Listen for form submission
        // $(".filter-form").submit(function (event) {
        //     // Prevent the default form submission
        //     event.preventDefault();

        //     // Serialize the form data into a URL-encoded string
        //     var formData = $(this).serialize();

        //     // Send the AJAX request
        //     $.ajax({
        //         type: "POST", // or "GET" depending on your server-side code
        //         url: "quick_book_csv.php", // Replace with your server-side script URL
        //         data: formData,
        //         success: function (response) {
        //             // Handle the success response here
        //             console.log(response);
        //         },
        //         error: function (xhr, status, error) {
        //             // Handle any errors here
        //             console.error(xhr.responseText);
        //         }
        //     });
        // });

</script>

<?php include "checkcompanystatus.php"; ?>
</body>
</html>
