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


/*  $sqlComp = "SELECT id,cust_id, card_added,company_name,first_name,last_name,email,phone ,logo,password, postal_code, mileage_rate,work_rate, due_date_range,clock_setting,role, status , created_at, no_of_users FROM companies";
  $exeComp = $db->query($sqlComp);
  $dataComp = $exeComp->fetch_all(MYSQLI_ASSOC);*/

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
          <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                  <?php foreach($dataComp as $key => $value){ ?>
                  <option value="<?php echo $value['id']; ?>"><?php echo $value['company_name']; ?></option>
                  <? } ?>
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
 <section class="content"> 
    <div class="user-info-modal">
      <div class="container">
  <div class="modal fade" id="user-info-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Information</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-user"></i></div>
          <div class="col-md-9"><span>Shubham Shrivastava</span></div>
        </div>
        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-phone"></i></div>
          <div class="col-md-9"><span>9528584788</span></div>
        </div>
        <hr/>
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal">Okay</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>




<div class="case-list-modal">
      <div class="container">
  <div class="modal fade" id="case-list-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Case List</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">

         <ul id="case_list">
         
         </ul>

        </div>
        </div>

         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal">Okay</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>






<div class="case-detail-modal">
      <div class="container">
  <div class="modal fade" id="case-detail-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Case Detail</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-mobile"></i></div>
          <div class="col-md-9">
          <div class="personal-info-label">Brand Name</div>
          <div class="personal-info-answer" id="brand1"></div>
          </div>
        </div>
        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-mobile"></i></div>
          <div class="col-md-9">
              <div class="personal-info-label">Modal Name</div>
          <div class="personal-info-answer" id="model1"></div>
          </div>
        </div>
        <hr/>
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-mobile"></i></div>
          <div class="col-md-9">
              <div class="personal-info-label">Problem</div>
          <div class="personal-info-answer" id="problem1"></div>
          </div>
        </div>
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal">Okay</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>










<section class="content">
      <div class="row">
        <div class=""> 
          <div class="box"> 
            <!-- /.box-header -->
      <div class="box-body" style="overflow:scroll">  
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

              <!--<div class="col-md-3">
                <div class="personal-info-label">Local Address</div>
                <input type="text" class="form-control" id="local_address"/>
              </div>-->

              <div class="col-md-6">
                <div class="personal-info-label">Home Address</div>
                <!-- <input type="text" class="form-control" id="permanent_address"/> -->
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
                  <?php foreach($dataComp as $key => $value){ ?>
                  <option value="<?php echo $value['id']; ?>"><?php echo $value['company_name']; ?></option>
                  <? } ?>
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
  
 
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
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

  else{
$.ajax({
    url:"AjaxCreateEmployee.php",
    data:{first_name:first_name , 
        last_name:last_name,
      email:email,
      phone:phone,
      password:password,
      local_address:'',
      permanent_address:permanent_address,
      postal_code:postal_code, 
      company:company,
      workRate:workRate,
      mileageRate:mileageRate,
      latitude:latitude,
      longitude:longitude },
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
  

  
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCwpns7FoF40IUPN4ianDrtxsOY9zR0RwE&libraries=places&callback=initAutocomplete"   type="text/javascript"></script>

<script src="address.js"></script>


</body>
</html>
