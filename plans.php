<?php
include('header.php');


if($_SESSION['username']==""){
  echo "<script> window.location = 'admin_login.php'</script>";
}
if($_SESSION['role']==2){
  echo "<script> window.location = 'admin_login.php'</script>";
}
  $db=db_connect();

  $sql = "SELECT id, plan_name ,amount,duration_type,plan_type ,num_of_workers,status,created_at FROM plans ORDER BY id DESC";
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);

  foreach ($data as $key => $value){
      $data[$key]['id']=$value['id']; 
      $data[$key]['plan_name']=$value['plan_name']; 
      $data[$key]['amount']=$value['amount']; 
      $data[$key]['type']=$value['duration_type']; 
      $data[$key]['plan_type']=$value['plan_type']; 
      $data[$key]['num_of_workers']=$value['num_of_workers'];  
      $data[$key]['status']=$value['status']; 
      $data[$key]['created_at']=$value['created_at'];
    }

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
  <div class="add_company_list_modal">
  <div class="modal fade" id="add_company_list_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create New Plan</h4>
        </div>
        <div class="modal-body">
          <div class="user-info-area">
            <div class="row">
              <div class="col-md-3">
                <div class="personal-info-label">Plan Name</div>
                <input type="text" name="plan_name" class="form-control" id="plan_name"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Plan Amount</div>
                <input type="text"  name="plan_amount" class="form-control" id="plan_amount"/>
              </div>

             
              <div class="col-md-3">
                <div class="personal-info-label">Plan Type</div>
                <select name="plan_type" class="form-control" id="plan_type">
                  <option value="0">Select</option> 
                  <option value="1">Selt</option>
                  <option value="2">Business</option>
                </select>
              </div>
              <div class="col-md-3">
                <div class="personal-info-label">Plan Duration</div>
                <select name="plan_duration" class="form-control" id="plan_duration">
                  <option value="0">Select</option>
                  <option value="1">Monthly</option>
                  <option value="2">Yearly</option>
                  <option value="3">Free</option>
                </select>
              </div>

              <div class="col-md-3" >
                <div class="personal-info-label">Max Employees</div>
                <input type="text" name="num_of_workers" class="form-control" id="num_of_workers"/>
              </div>
            </div>
            <hr/>
          </div>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewPlan();">Create</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
        </div>
      </div>
      
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
          <p class="test" value="" ></p>
          <h4 class="modal-title">Edit Company </h4>
          <input type="text" class="form-control" id="editUserId" style="display: none;" />
        </div>






         <div class="modal-body">
          <div class="user-info-area">
            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">Company Name</div>
                <input type="text" class="form-control" id="editcompanyName"/>
              </div>

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
            </div>

            <hr/>

            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">Phone</div>
                <input type="text" class="form-control" id="editphone"/>
              </div>

             
              <div class="col-md-3">
                <div class="personal-info-label">Password</div>
                <input type="text" class="form-control" id="editpassword"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Postal Code</div>
                <input type="text" class="form-control" id="editpostalCode"/>
              </div>
                 <div class="col-md-3">
                <div class="personal-info-label">Status</div>
                <select class="form-control" id="editstatus">
                  <option value="1">1</option>
                    <option value="2">2</option>
                </select>
              </div>
            </div>
          

            <hr/>

       <!--      <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">Work Rate</div>
                <input type="text" class="form-control" id="editworkRate"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Mileage Rate</div>
                <input type="text" class="form-control" id="editmileageRate"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Due Date Range</div>
                <input type="text" class="form-control" id="editdateRange"/>
              </div>

            </div> -->

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="editComapny();">Update</button>
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
        
      <h1 class="make-inline">
        Plan List
      </h1>
      <!-- <a href="emp_list_csv.php"><button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a> -->
      
       <!-- <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_company_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button>-->
     
    </section>



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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Plan Name</th>
                  <th>Amount</th>
                  <th>Duration</th>
                  <th>No.of Workers</th>
                  <th>Plan type</th>
                  <th>Status</th>
                  <th>Created At</th>
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
        echo'<td>'.$item['plan_name'].'</td>';
        echo'<td>'.$item['amount'].'</td>';
        if($item['type']==1){
          echo'<td>Monthly</td>';
        }else if($item['type']==2){
          echo'<td>Yearly</td>';
        }else{
          echo'<td>Free</td>';
        }
        echo'<td>'.$item['num_of_workers'].'</td>';

        if($item['plan_type']==1)
        echo'<td>Self</td>'; 
        else if($item['plan_type']==2)
        echo'<td>Business</td>';
      else if($item['plan_type']==3)
        echo'<td>Ace</td>';
        else 
        echo'<td>-</td>';

        if($item['status']==1){
          echo'<td>Active</td>';
        }else{
          echo'<td>Deactive</td>';
        }
        echo'<td>'.$item['created_at'].'</td>';

        if($item['status']==1){
          echo'<td><button type="button" class="btn btn-danger" id="add-employee-list-btn" onclick="deactivatePlan('.$item['id'].',0)">Deactivate</button></td>';
        }else{
          echo'<td><button type="button" class="btn theme-btn" id="add-employee-list-btn" onclick="deactivatePlan('.$item['id'].',1)">Activate</button></td>';
        }

        echo'</tr>';


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

function addNewPlan(){
  var plan_name = $('#plan_name').val();
  var plan_amount = $('#plan_amount').val();
  var plan_type = $('#plan_type').val();
  var plan_duration = $('#plan_duration').val();
  var num_of_workers = $('#num_of_workers').val();

  if(plan_name=='') {
    alert("Please Enter Plan Name");
    return false;
  }else if(plan_amount=='') {
    alert("Please Enter Plan Amount");
    return false;
  }else if(plan_type=='0') {
    alert("Please Select Plan Type");
    return false;
  }else if(plan_duration=='0') {
    alert("Please Select Plan Duration");
    return false;
  }else if(num_of_workers=='') {
    alert("Please Enter Max Employees");
    return false;
  }
  
  $.ajax({
      url:"AjaxCreatePlan.php",
      data:{plan_name:plan_name,
        plan_amount:plan_amount,
        plan_type:plan_type,
        num_of_workers:num_of_workers,
        plan_duration:plan_duration},
      type:'post',
      dataType: 'json',
      async: true,
      success:function(response){
        console.log(response);
        var status=response['Status'];
        alert(response['Message']);
        if(status==1){
         // location.reload();
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
  });

}




function deactivatePlan(id,status){
$.ajax({
  url:"AjaxDeactivatePlan.php",
  data:{id:id,status:status},
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


function showCaseDetail(id){
  //alert(id);

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


function editComapny(){

      var id  =$(".test").text();
      var editfirstName =$("#editfirstName").val();
      var editlastName=   $("#editlastName").val();
      var editemail=    $("#editemail").val();
      var editphone=     $("#editphone").val();
      var editpassword=     $("#editpassword").val();
      var editcompanyName =      $("#editcompanyName").val();
      var editofficeAddress=       $("#editofficeAddress").val();
      var editpostalCode=        $("#editpostalCode").val();
      /*var editworkRate=        $("#editworkRate").val();
      var editmileageRate=      $("#editmileageRate").val();
      var editdateRange=      $("#editdateRange").val();*/
      var editcompany=  $("#editcompany").val();
      var editstatus=        $("#editstatus").val();

 if(editcompanyName== '') {
  alert("Please Type Company Name");
 }

 else if(editemail== '') {
  alert("Please Type email");
 }
  else if(editphone== '') {
  alert("Please Type Phone");
 }

else{
 $.ajax({
    url:"AjaxUpdateDataCompanyList.php",
    data:{"id":id,
          "editfirstName":editfirstName,
          "editlastName":editlastName,
          "editemail":editemail,
          "editphone":editphone,
          "editpassword":editpassword,
          "editcompanyName":editcompanyName,
          "editofficeAddress":editofficeAddress,
          "editpostalCode":editpostalCode,
          /*"editworkRate":editworkRate,
          "editmileageRate":editmileageRate,
          "editdateRange":editdateRange,*/
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
  //alert('romil');

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
    data:{EmpName:name,
      UserType:userType,
      EmpMobile:mobile,
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
   url:"AjaxUpdateComapnyList.php",
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
 $("#editcompany").val(response.company_id);
            $("#editstatus").val(response.status);
            
    


    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });




        });
    });


  
</script>



</body>
</html>
