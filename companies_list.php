<?php
include('header.php');


if($_SESSION['username']==""){
  echo "<script> window.location = 'admin_login.php'</script>";
}
if($_SESSION['role']==2){
  echo "<script> window.location = 'admin_login.php'</script>";
}
  $db=db_connect();

function getplannamebycompanyid($company_id,$db){
 $sql = "SELECT plans.plan_name FROM companies

left join company_subscriptions on company_subscriptions.company_id=companies.id
left join plans on plans.id=company_subscriptions.plan_id
where companies.role = 2 and company_subscriptions.status = 1 and companies.id =".$company_id."
   ORDER BY companies.id"; 
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);
  return $data[0]['plan_name'];
}


  $sql = "SELECT companies.id as id,companies.company_name,companies.first_name,companies.last_name,companies.email,companies.phone,companies.password,companies.postal_code,companies.status,companies.created_at,companies.logo,companies.last_name FROM companies
left join company_subscriptions on company_subscriptions.company_id=companies.id
-- left join plans on plans.id=company_subscriptions.plan_id

 where companies.role=2 

   ORDER BY companies.id"; 
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);

  foreach ($data as $key => $value){
      $data[$key]['id']=$value['id']; 
      $data[$key]['company_name']=$value['company_name']; 
      $data[$key]['first_name']=$value['first_name']; 
      $data[$key]['last_name']=$value['last_name']; 
      $data[$key]['email']=$value['email']; 
      $data[$key]['phone']=$value['phone']; 
      $data[$key]['password']=$value['password']; 
      $data[$key]['logo']=$value['logo'];  
      $data[$key]['postal_code']=$value['postal_code']; 
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
          <h4 class="modal-title">Create New Company</h4>
        </div>
        <div class="modal-body">
          <div class="user-info-area">
            <form>
            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">User Name</div>
                <input type="text" name="company_name" class="form-control" id="company_name"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">First Name</div>
                <input type="text"  name="first_name" class="form-control" id="first_name"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Last Name</div>
                <input type="text" name="last_name" class="form-control" id="last_name"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Email</div>
                <input type="text" name="email" class="form-control" id="email"/>
              </div>
            </div>
            <hr/>

            <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">Phone</div>
                <input type="text" class="form-control" name="phone" id="phone"/>
              </div>

              

             <!-- <div class="col-md-3">
                <div class="personal-info-label">Password</div>
                <input type="text" class="form-control" name="password" id="password"/>
              </div>-->

              <div class="col-md-3">
                <div class="personal-info-label">Postal Code</div>
                <input type="text" class="form-control" name="postal_code" id="postal_code"/>
              </div>

              <!--  <div class="col-md-3">
                <div class="personal-info-label">Work Rate</div>
                <input type="text" class="form-control" name="work_rate" id="work_rate"/>
              </div> -->
            </div>
            <hr/>

            <div class="row ">
             

              <!-- <div class="col-md-3">
                <div class="personal-info-label">Mileage Rate</div>
                <input type="text" class="form-control" name="mileage_rate" id="mileage_rate"/>
              </div> -->

          <!--     <div class="col-md-3">
                <div class="personal-info-label">Due Date Range</div>
                <input type="text" class="form-control" name="due_date_range" id="due_date_range"/>
              </div> -->

              <div class="col-md-3">
               
              <input type="file" name="file" id="file" />
              </div>

            </div>
</form>
          </div>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewCompany();">Create</button>
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
          <input type="hidden" value="" id="editcid">
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
                <input type="text" class="form-control" disabled id="editemail"/>
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
                  <option value="1">Active</option>
                    <option value="0">Delete</option>
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
  <div class="content-wrapper" style="height:auto;min-height:0px;"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
      <h1 class="make-inline">
        User List
      </h1>
      <!-- add_company_list_modal Add new Company popup here <a href="emp_list_csv.php"><button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a> -->
     
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
            <div class="box-body" style="overflow-x:scroll">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 10px">#</th>
                
                  <th>Company Name</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                <!--   <th>Password</th> -->
                  <th>Logo</th>
                  <th>Postal Code</th>
                  <th>Verification Status</th>
                  <th>Status</th>
                   <th>Plan Type</th>
                  <th>Created At</th>
                   <th>Action</th>
                </tr>
                </thead>
                <tbody>

<?php

// print_r($data);
foreach ($data as $key =>  $item){
  $count=$key+1;
  
        echo'<tr>'; 
        echo'<td>'.$count.'</td>';
        echo'<td>'.$item['company_name'].'</td>';
        echo'<td>'.$item['first_name'].'</td>';
        echo'<td>'.$item['last_name'].'</td>';
        echo'<td>'.$item['email'].'</td>';
        echo'<td>'.$item['phone'].'</td>';
     /*   echo'<td>'.$item['password'].'</td>';*/

        if(!empty($item['logo'])){
        echo'<td><img height="50" width="100" src="'.$item['logo'].'"></img></td>';
      }
      else
      {
        echo'<td><img height="50" width="100" src="company_logo/download.png"></img></td>';
      }



        echo'<td>'.$item['postal_code'].'</td>';

     

  if(!empty($item['verification_status']==0))
        {
         echo'<td style="color:lightgray;font-weight:bold;">Pending</td>';
        }

        else if(!empty($item['verification_status']==1))
        {
          echo'<td style="color:green;font-weight:bold;">Verified</td>';
        }


        if(!empty($item['status']==1))
        {
         echo'<td style="color:green;font-weight:bold;">Active</td>';
        }

        else 
        {
          echo'<td style="color:red;font-weight:bold;">Delete</td>';
        }
        
 if(!empty($item['id']))
        {
          $c_id=$item['id'];
echo'<td>'.getplannamebycompanyid($c_id,$db).'</td>';
}
else
{
 echo'<td>-</td>'; 
}

        echo'<td>'.$item['created_at'].'</td>';
           
$id= $item['id'];
            echo '<td>';
         
echo '<button type="button" class="btn open-ClientDialog"  data-id='.$id.' id="edit_employee_list_modal"  onclick="showCompanyList('.$item['id'].')">Edit</button>';

if(!empty($item['status']==1))
        {
         
         echo '<button type="button" class="btn btn-danger" id="add-employee-list-btn" onclick="deleteCompanyList('.$item['id'].')">Delete</button>';


      }

      if(!empty($item['status']==0))
      {
         echo '<button type="button" class="btn btn-primary" id="add-employee-list-btn" onclick="activeCompanyList('.$item['id'].')">Active</button>';
      }




echo "</td>";
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
  <!--<aside class="control-sidebar control-sidebar-dark">-->
    <!-- Create the tabs -->
    <!--<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <!--<div class="tab-content">
      <!-- Home tab content -->
      <!--<div class="tab-pane" id="control-sidebar-home-tab">
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

        <!--<h3 class="control-sidebar-heading">Tasks Progress</h3>
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

     <!-- </div>-->
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <!--<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
     <!-- <div class="tab-pane" id="control-sidebar-settings-tab">
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

         <!-- <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

         <!-- <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

         <!-- <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

         <!-- <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

         <!-- <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>-->
          <!-- /.form-group -->
       <!-- </form>
      </div>-->
      <!-- /.tab-pane -->
   <!-- </div>
  </aside>-->
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

function addNewCompany(){




 /* var company_name = $('#company_name').val();
  var first_name = $('#first_name').val();
  var last_name = $('#last_name').val();
  var email = $('#email').val();
  var phone = $('#phone').val();
  var password = $('#password').val();
  
  var postal_code = $('#postal_code').val();
  var work_rate = $('#work_rate').val();
  var mileage_rate = $('#mileage_rate').val();
  var due_date_range = $('#due_date_range').val();
*/
var form_data = new FormData(document.querySelector('form'));
if ($('#file').length>1) {
 var name = document.getElementById("file").files[0].name;
 var file_data =  document.getElementById('file').files[0];

 var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
  {
   alert("Invalid Image File");
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 2000000)
  {
   alert("Image File Size is very big");
  }

}
 else if ($('#company_name').val()== '') {
  alert("Please Type Company Name");
 }
else if ($('#email').val()== '') {
  alert("Please Type Email");
 }
 /*else if ($('#phone').val()== '') {
  alert("Please Type Phone");
 }*/


/*  form_data.append("file", document.getElementById('file').files[0]);*/
else{
  $.ajax({
      url:"AjaxCreateCompany.php",
  /*    data:{company_name:company_name,
        first_name:first_name,
        last_name:last_name,
        email:email,
        phone:phone,
        password:password,
        "form_data":file_data,
        postal_code:postal_code,
        work_rate:work_rate,
        mileage_rate:mileage_rate,
        due_date_range:due_date_range},*/

          data:form_data,
      type:'post',
      dataType: 'json',
   
      async: true,
       contentType: false,
    cache: false,
    processData: false,
      success:function(response){
        var status=response['Status'];
        alert(response['Message']);
        if(status==1){
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

function showCompanyList(id)
{
  /*alert(id); */
$('#edit_employee_list_modal').modal('show');
$.ajax({
    url:"AjaxGetComapnyList.php",
    data:{id:id
    },
    type:'post',
    dataType: 'json',
    success:function(response){
     $("#editcompanyName").val(response.company_name);
     $("#editfirstName").val(response.firstName);
     $("#editlastName").val(response.lastName);
     $("#editemail").val(response.email);
     $("#editphone").val(response.phone);
    /* $("#editpassword").val(response.password);*/
     $("#editpostalCode").val(response.postal_code);
     $("#editstatus").val(response.status);
     $("#editcid").val(id);


    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}
});

}


function deleteCompanyList(id)
{

if (confirm('Are you sure you want to delete this?')) {

$.ajax({
    url:"AjaxDeleteComapnyList.php",
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

function activeCompanyList(id)
{

if (confirm('Are you sure you want to active this?')) {

$.ajax({
    url:"AjaxActiveCompanyList.php",
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

      var id  =$("#editcid").val();
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
  /*else if(editphone== '') {
  alert("Please Type Phone");
 }*/

else{
 $.ajax({
    url:"AjaxUpdateDataCompanyList.php",
    data:{"id":id,
          "editfirstName":editfirstName,
          "editlastName":editlastName,
         /* "editemail":editemail,*/
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
