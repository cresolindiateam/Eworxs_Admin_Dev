<?php

include('header.php');





if($_SESSION['username']==""){

  echo "<script> window.location = 'http://localhost/EworxsAdmin/admin_login.php'</script>";

}



if($_SESSION['role']==1){

  echo "<script> window.location = 'http://localhost/EworxsAdmin/admin_login.php'</script>";

}

$company_id= $_SESSION['companyid'];

  $db=db_connect();



  $sql = "SELECT clientvisites.client_name,clientvisites.visit_date,clientvisites.visit_address,clientvisites.departure_time,clientvisites.arrival_time,clientvisites.duration,clientvisites.pdf_file,clientvisites.created_at,clientvisites.image,employees.first_name as emp_first_name,employees.last_name as emp_last_name,employees.email as emp_email,companyclients.company_name,companyclients.office_address as company_address,companyclients.email as company_email FROM clientvisites JOIN employees ON(clientvisites.employee_id=employees.id) JOIN companyclients ON(clientvisites.company_id=companyclients.id)  where company_id = $company_id  ORDER BY clientvisites.id DESC";

  $exe = $db->query($sql);

  $data = $exe->fetch_all(MYSQLI_ASSOC);



  foreach ($data as $key => $value){

    $data[$key]['client_name']= $value['client_name'];

    $data[$key]['visit_date']= $value['visit_date'];

    $data[$key]['visit_address']= $value['visit_address'];

    $data[$key]['departure_time']= $value['departure_time'];

    $data[$key]['arrival_time']= $value['arrival_time'];

    $data[$key]['duration']= $value['duration'];

    $data[$key]['pdf_file']= $value['pdf_file'];

    $data[$key]['created_at']= $value['created_at'];

    $data[$key]['image']= $value['client_name'];

    $data[$key]['emp_first_name']= $value['emp_first_name'];

    $data[$key]['emp_last_name']= $value['emp_last_name'];

    $data[$key]['emp_email']= $value['emp_email'];

    $data[$key]['company_name']= $value['company_name'];

    $data[$key]['company_address']= $value['company_address'];

    $data[$key]['company_email']= $value['company_email'];

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

  <div class="add_employee_list_modal">

  <div class="modal fade" id="add_employee_list_modal" role="dialog">

    <div class="modal-dialog">

    

      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Create New Employee List</h4>

        </div>

        <div class="modal-body">

          <table class="table table-bordered">

            <tr>

              <th>Employee Name</th>

              <th>Mobile</th>

              <th>Password</th>

              <th>Employee Type</th>

            </tr>

            <tr>

            

              <td><input type="text" class="form-control" id="empName"/></td>

              <td><input type="number" class="form-control" id="empMobile"  /></td>

              <td><input type="text" class="form-control" id="empPassword"/></td>



              <td><select class="form-control" id="empType">

                    <option>Engineer</option>

                    <option>Delivery Boy</option>

                  </select></td>

              

            </tr>

          </table>



        </div>

        <div class="modal-footer">

          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="addNewEmployee();">Create</button>

          <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>

        </div>

      </div>

      

    </div>

  </div>

  </div>





  <div class="edit_user_list_modal">

  <div class="modal fade" id="edit_user_list_modal" role="dialog">

    <div class="modal-dialog">

    

      <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit User List</h4>

          <input type="text" class="form-control" id="editUserId" style="display: none;" />

        </div>

        <div class="modal-body">

          <table class="table table-bordered">

            <tr>

              <th>Employee Name</th>

              <th>Mobile</th>

              <th>Password</th>

              <th>Employee Type</th>

            </tr>

            <tr>

            

              <td><input type="text" class="form-control" id="editempName"/></td>

              <td><input type="number" class="form-control" id="editempMobile"  /></td>

              <td><input type="text" class="form-control" id="editempPassword"/></td>



              <td><select class="form-control" id="editempType">

                    <option>Engineer</option>

                    <option>Delivery Boy</option>

                  </select></td>

              

            </tr>

          </table>



        </div>

        <div class="modal-footer">

          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="editEmployee();">Edit</button>

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

        Client Visits

      </h1>

      <a href="emp_list_csv.php"><button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a>

      

       <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button>

     

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

                  <th>Client Name</th>

                  <th>Visit Date</th>

                  <th>Visit Address</th>

                  <th>departure Time</th>

                  <th>Arrival Time</th>

                  <th>Duration</th>

                  <th>PDF</th>

                  <th>Created At</th>

                  <th>Emp Name</th>

                  <th>Emp Email</th>

                  <th>Company Name</th>

                  <th>Company Address</th>

                  <th>Company Email</th>

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

        echo'<td>'.$value['client_name'].'</td>';

        echo'<td>'.$value['visit_date'].'</td>';

        echo'<td>'.$value['visit_address'].'</td>';

        echo'<td>'.$value['departure_time'].'</td>';

        echo'<td>'.$value['arrival_time'].'</td>';

        echo'<td>'.$value['duration'].'</td>';

        echo'<td>'.$value['pdf_file'].'</td>';

        echo'<td>'.$value['created_at'].'</td>';

        echo'<td>'.$value['client_name'].'</td>';

        echo'<td>'.$value['emp_first_name']." ".$value['emp_last_name'].'</td>';

        echo'<td>'.$value['emp_email'].'</td>';

        echo'<td>'.$value['company_name'].'</td>';

        echo'<td>'.$value['company_address'].'</td>';

        echo'<td>'.$value['company_email'].'</td>';



        $id= $item['id'];

         echo'<td>

         

<button type="button" class="btn open-ClientDialog" data-toggle="modal" data-target="#edit_employee_list_modal" data-id='.$id.' >Edit</button>





         <button type="button" class="btn btn-danger" id="add-employee-list-btn" onclick="deleteCompanyClient('.$item['id'].')">Delete</button></td>';

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



function addNewEmployee(){

  //alert('romil');



  userType=3;

  var emp = document.getElementById('empType').value;



  if(emp=="Engineer"){

    userType=2;

  }





  var name = document.getElementById('empName').value;

  var mobile = document.getElementById('empMobile').value;

  var password = document.getElementById('empPassword').value;







$.ajax({

    url:"CreateEmployee.php",

    data:{EmpName:name,

      UserType:userType,

      EmpMobile:mobile,

      EmpPassword:password},

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





</body>

</html>

