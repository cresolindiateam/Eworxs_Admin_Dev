<?php
include('header.php');
$company_id= $_SESSION['companyid'];
if($_SESSION['role']==1){
  echo "<script> window.location = 'admin_login.php'</script>";
}
  $db=db_connect();
  $sql = "SELECT id,company_id,first_name,last_name,email,phone,password,local_address,permanent_address,postal_code,status,created_at,work_rate,mileage_rate FROM workers where company_id = $company_id ORDER BY id";
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);
  foreach ($data as $key => $value){
      $data[$key]['id']=$value['id']; 
      $data[$key]['company_id']=$value['company_id']; 
      $data[$key]['first_name']=$value['first_name']; 
      $data[$key]['last_name']=$value['last_name']; 
      $data[$key]['email']=$value['email']; 
      $data[$key]['phone']=$value['phone']; 
      $data[$key]['password']=$value['password']; 
      $data[$key]['local_address']=$value['local_address']; 
      $data[$key]['permanent_address']=$value['permanent_address']; 
      $data[$key]['postal_code']=$value['postal_code']; 
      $data[$key]['status']=$value['status']; 
      $data[$key]['created_at']=$value['created_at']; 
      $data[$key]['work_rate']=$value['work_rate']; 
      $data[$key]['mileage_rate']=$value['mileage_rate'];
    }
 /* $sqlComp = "SELECT id,cust_id, card_added,company_name,first_name,last_name,email,phone ,logo,password, postal_code, mileage_rate,work_rate, due_date_range,clock_setting,role, status , created_at, no_of_users FROM companies";
  $exeComp = $db->query($sqlComp);
  $dataComp = $exeComp->fetch_all(MYSQLI_ASSOC);*/
  $sql = "SELECT id, company_id,first_name,last_name,email,phone,password,local_address,permanent_address,postal_code,status,created_at,work_rate,mileage_rate,latitude, longitude FROM workers where id=".$_REQUEST['worker_id'];
  $exeWorker = $db->query($sql);
  $dataWorker = $exeWorker->fetch_all(MYSQLI_ASSOC);

?> 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Eworxs</title>
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
  body{
    padding: 0px !important;
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
    </div>
  </div>
  </div>


  <div class="edit_user_list_modal">
  <div class="modal fade" id="edit_employee_list_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         <!--  <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <p class="test"></p>
          <h4 class="modal-title">Edit Workers </h4>
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
              <!--<div class="col-md-3">
                <div class="personal-info-label">Local Address</div>
                <input type="text" class="form-control" id="edit_local_address"/>
              </div>-->
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
    <!-- Main content -->

    <section class="content-header" style="margin-bottom: 20px;">
      <a href="employee_list.php">
      <button class="btn btn-warning pull-left" style="margin-top: 6px;margin-right: 6px;">
        <i class="fa fa-arrow-left"></i>GO BACK&nbsp;&nbsp;
      </button>
    </a>
    </section>

 <section class="content"> 
   <section class="content">
      <div class="row">
        <div class=""> 
          <div class="box"> 
            <!-- /.box-header -->
      <div class="box-body" >  
      <div class="modal-content">
        <div class="modal-header">
         <!--  <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            <h4 class="modal-title">Edit Workers</h4>
        </div>
        <div class="modal-body">
          <div class="user-info-area">
            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">First Name</div>
                <input type="text" class="form-control" id="first_name"  value="<?php echo $dataWorker[0]['first_name'];?>"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Last Name</div>
                <input type="text" class="form-control" id="last_name"  value="<?php echo $dataWorker[0]['last_name'];?>"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Email</div>
                <input type="text" class="form-control" id="email"  value="<?php echo $dataWorker[0]['email'];?>"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Phone</div>
                <input type="text" class="form-control" id="phone"  value="<?php echo $dataWorker[0]['phone'];?>"/>
              </div>
            </div>
            <hr/>

            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">Password</div>
                <input type="text" class="form-control" id="password"  value="<?php //echo $dataWorker[0]['password'];?>"/>
              </div>

              <!--<div class="col-md-3">
                <div class="personal-info-label">Local Address</div>
                <input type="text" class="form-control" id="local_address"/>
              </div>-->

              <div class="col-md-6">
                <div class="personal-info-label">Home Address</div>
                <!-- <input type="text" class="form-control" id="permanent_address"/> -->
                <input type="text" name="autocomplete" id="autocomplete"  value="<?php echo $dataWorker[0]['permanent_address'];?>" class="form-control" placeholder="Select Location">
               
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
                <input type="text" class="form-control" id="postal_code"  value="<?php echo $dataWorker[0]['postal_code'];?>"/>
              </div>
				
				   <div class="col-md-3">
                <div class="personal-info-label">Hourly Rate</div>
                <input type="text" class="form-control" id="workRate"  value="<?php echo $dataWorker[0]['work_rate'];?>"/>
              </div>
            </div>
            <hr/>

            <div class="row "> 
             <div class="col-md-3">
                <div class="personal-info-label">MIleage Rate</div>
                <input type="number" min="0" step="1"  class="form-control" id="mileageRate"  value="<?php echo $dataWorker[0]['mileage_rate'];?>"/>
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
            <input type="hidden" id="worker_id" value="<?php echo $dataWorker[0]['id'];?>">
          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="addNewEmployee();">Update</button>
         <!--  <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button> -->
        </div>
      </div>
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

   function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}

function addNewEmployee(){
  //alert('romil');
  var id = $('#worker_id').val();
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
if(phone== '') {
  alert("Please Type Phone");
  return false;
 }

 // if(password== '') {
 //  alert("Please Type Password");
 //  return false;
 // }

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
    url:"AjaxUpdateDataEmp.php",
    data:{"id":id,
          "editfirstName":first_name,
          "editlastName":last_name,
          "editemail":email,
          "editphone":phone,
          "editpassword":password,
          "editcompanyName":'',
          "workRate":workRate,
          "editpostalCode":postal_code,
          "edit_local_address":'',
          "edit_permanent_address":permanent_address,
          "editdateRange":'',
          "editcompany":company, 
          "mileageRate":mileageRate,
            "latitude":latitude,
            "longitude":longitude
        },
     
    type:'post',
    dataType: 'json',
    async: true,
    success:function(response){
      var status=response.Status; 
      if(status==1){
        alert(response.Message);
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
 
</script> 
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCwpns7FoF40IUPN4ianDrtxsOY9zR0RwE&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script src="address.js"></script>
</body>
</html>
