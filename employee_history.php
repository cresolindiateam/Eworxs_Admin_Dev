<?php
include('header.php');
$emp_id= $_REQUEST['emp_id'];
if($_SESSION['role']==1){
  echo "<script> window.location = 'admin_login.php'</script>";
}
  $db=db_connect();
  $sql = "SELECT client_visits.id as clientvisitesid,client_visits.worker_work_rate as emp_work_rate,client_visits.worker_mileage_rate as emp_mileage_rate,client_visits.client_name,client_visits.company_id,client_visits.visit_date,client_visits.visit_address,client_visits.departure_time,client_visits.arrival_time,client_visits.duration,client_visits.distance,client_visits.pdf_file,client_visits.created_at,client_visits.image,workers.first_name as emp_first_name,workers.last_name as emp_last_name,workers.email as emp_email,workers.work_rate AS emp_work_rate1,workers.mileage_rate AS emp_mileage_rate1,client_visits.return_mileage_status as return_mileage,company_clients.client_company_name,company_clients.office_address as company_address,company_clients.email as company_email,company_clients.work_rate AS client_work_rate,company_clients.mileage_rate AS client_mileage_rate,company_clients.due_date_range,client_visits.mileage_status FROM client_visits JOIN workers ON(client_visits.worker_id=workers.id) JOIN company_clients ON(client_visits.company_client_id=company_clients.id) JOIN companies ON(workers.company_id=companies.id) where client_visits.worker_id = $emp_id ORDER BY client_visits.id DESC";

  // echo $sql;die;
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);

  foreach ($data as $key => $value){
    $data[$key]['client_name']= $value['client_name'];
    $data[$key]['visit_date']= $value['visit_date'];
    $data[$key]['visit_address']= $value['visit_address'];
    $data[$key]['departure_time']= $value['departure_time'];
    $data[$key]['arrival_time']= $value['arrival_time'];
    $data[$key]['duration']= $value['duration'];
    $data[$key]['distance']= $value['distance'];
    $data[$key]['pdf_file']= $value['pdf_file'];
    $data[$key]['created_at']= $value['created_at'];
    $data[$key]['image']= $value['image'];
    $data[$key]['emp_first_name']= $value['emp_first_name'];
    $data[$key]['emp_last_name']= $value['emp_last_name'];
    $data[$key]['emp_email']= $value['emp_email'];
    $data[$key]['emp_work_rate']= $value['emp_work_rate'];
    $data[$key]['emp_mileage_rate']= $value['emp_mileage_rate'];
    $data[$key]['client_company_name']= $value['client_company_name'];
    $data[$key]['company_address']= $value['company_address'];
    $data[$key]['company_email']= $value['company_email'];
    $data[$key]['client_work_rate']= $value['client_work_rate'];
    $data[$key]['client_mileage_rate']= $value['client_mileage_rate'];
    $data[$key]['due_date_range']= $value['due_date_range'];
     $data[$key]['mileage_status']= $value['mileage_status'];
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
      .scrollbar{
          height: 70px;
          width: 145px;
          overflow-x: unset!important;
          overflow-y: overlay;
      }

      .force-overflow{
          min-height: 0px;
      }

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
  <div class="add_employee_list_modal">
  <div class="modal fade" id="add_employee_list_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create New Employee</h4>
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

              <div class="col-md-3">
                <div class="personal-info-label">Local Address</div>
                <input type="text" class="form-control" id="local_address"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Permanent Address</div>
                <input type="text" class="form-control" id="permanent_address"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Postal Code</div>
                <input type="text" class="form-control" id="postal_code"/>
              </div>
            </div>
            <hr/>

            <div class="row">
               <div class="col-md-3">
                <div class="personal-info-label">Work Rate</div>
                <input type="text" class="form-control" id="workRate"/>
              </div>
         
             <div class="col-md-3">
                <div class="personal-info-label">MIleage Rate</div>
                <input type="text" class="form-control" id="mileageRate"/>
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
          <h4 class="modal-title">Edit Employee </h4>
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
                <div class="personal-info-label">Permanent Address</div>
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
    <section class="content-header">
      <a href="employee_list.php">
      <button class="btn btn-warning pull-left" style="margin-top: 6px;margin-right: 6px;">
        <i class="fa fa-arrow-left"></i>GO BACK&nbsp;&nbsp;
      </button>
    </a>
      <h1 class="make-inline">Worker's History</h1>
      <a href="emp_history_csv.php?emp_id=<?php echo $emp_id; ?>"><button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a>
       <!-- <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button> -->
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
                    <th style="width: 10px">#</th>
                    <th>Worker Name</th>
                    <th>Worker Email</th>
                    <th>Worker Work Rate</th>
                  

                  <?php //foreach (array_unique($data) as $key => $value) { ?>
                     <?php //if ($value['mileage_status'] == 1) { ?>
                     <th>Worker Mileage Rate</th>
                          <?php //} ?>
                        <?php //} ?>
                    <th>Duration</th>
                       
                  <?php //foreach (array_unique($data) as $key => $value) { ?>
                     <?php //if ($value['mileage_status'] == 1) { ?>
                     <th>Distance</th>
                          <?php //} ?>
                        <?php //} ?>
                         <?php //foreach (array_unique($data) as $key => $value) { ?>
                     <?php //if ($value['mileage_status'] == 1) { ?>
                    <th>Return Milegae</th>
                     <?php //} ?>
                        <?php //} ?>
                    <th><!-- Amount -->Worker's pay</th>
                    <th>Client Name</th>
                    <th>Client Company Name</th>
                    <th>Visit Date</th>
                    <th>Visit Address</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php 
                      
                      foreach ($data as $key =>  $value){
                        $count=$key+1;
                        $id= $value['clientvisitesid'];

                        if($value['mileage_status'] == 1)
                        {
                           
                        if($value['return_mileage']==0)
                        {
                         $distance=(float)$value['distance'];
                        }
                        else
                         {
                          $distance=(float)$value['distance']*2;
                         }
                       }
                       else
                       {
                         
                         if($value['return_mileage']==0)
                        {
                         $distance=0;
                        }
                        else
                         {
                          $distance=0;
                         }
                       }

                        $amount=$distance*(float)$value['client_mileage_rate'];
                        $client_due_bal = (float)$amount+(float)$value['client_work_rate'];
                        $amount=$distance*(float)$value['emp_mileage_rate'];
                        $emp_due_bal = (float)$amount+(float)$value['emp_work_rate']*(float)$value['duration'];
                        $due_days = $value['due_date_range'];
                        $due_date = $value['visit_date'];
                          if($due_days>0){
                            $due_days = "+".$due_days." day";
                            $due_date = strtotime($due_days, strtotime($due_date));
                            $due_date = date("Y-m-d", $due_date);
                          }
                                echo'<tr>'; 
                              echo'<td>'.$count.'</td>';
                              echo'<td>'.$value['emp_first_name']." ".$value['emp_last_name'].'</td>';
                              echo'<td>'.$value['emp_email'].'</td>';
                              echo'<td>'.$value['emp_work_rate'].'</td>';
                              

                 
                      if ($value['mileage_status'] == 1) 
                      { 
                        echo'<td>'.$value['emp_mileage_rate'].'</td>';
                       }
                       else
                       {
                         echo'<td>-</td>';
                       }
                         

                              echo'<td>'.$value['duration'].'</td>';
                              if ($value['mileage_status'] == 1) 
                       
                      { 
                        echo'<td>'.$distance.'</td>';
                       }
                      else
                      {
                        echo'<td>-</td>';
                      }


                                   if ($value['mileage_status'] == 1) 
                      { 
                              if($value['return_mileage']==0)
                              {
                               echo'<td style="color:red">No</td>';
                              }
                              else
                              {
                                echo'<td style="color:green">Yes</td>'; 
                              }
                            }  
                              else
                              {
                                 echo'<td style="color:red">-</td>'; 
                              }


                              echo'<td>'.$emp_due_bal.'</td>';
                              echo'<td>'.$value['client_name'].'</td>';
                              echo'<td>'.$value['client_company_name'].'</td>';
                              echo'<td>'.$value['visit_date'].'</td>';
                              echo'<td><div class="scrollbar" id="style-2">
                            <div class="force-overflow">'.$value['visit_address'].'</div></div></td>';
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

var first_name = $('#first_name').val();
var last_name = $('#last_name').val();
var email = $('#email').val();
var phone = $('#phone').val();
var password = $('#password').val();
var local_address = $('#local_address').val();
var permanent_address = $('#permanent_address').val();
var postal_code = $('#postal_code').val();
var company = $('#company').val();
var workRate = $('#workRate').val();
var mileageRate = $('#mileageRate').val();

 if ($('#company').val()== '') {
  alert("Please Select Company");
 }
else if ($('#email').val()== '') {
  alert("Please Type Email");
 }
 else if ($('#phone').val()== '') {
  alert("Please Type Phone");
 }

else{
$.ajax({
    url:"AjaxCreateEmployee.php",
    data:{first_name:first_name,last_name:last_name,email:email,phone:phone,password:password,local_address:local_address,permanent_address:permanent_address,postal_code:postal_code,company:company,workRate:workRate,mileageRate:mileageRate },
    type:'post',
    dataType: 'json',
    async: true,
    success:function(response){
      var status=response.Status;
      alert(response.Message);
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
   var id= $(".test").text();
   var editfirstName= $("#editfirstName").val();
   var editlastName= $("#editlastName").val();
   var editemail= $("#editemail").val();
   var editphone= $("#editphone").val();
   var editpassword= $("#editpassword").val();
   var editcompanyName= $("#editcompanyName").val();
   var editofficeAddress= $("#editofficeAddress").val();
   var editpostalCode= $("#editpostalCode").val();
   var edit_local_address= $("#edit_local_address").val();
   var edit_permanent_address= $("#edit_permanent_address").val();
   var editdateRange= $("#editdateRange").val();
   var editcompany= $("#editcompany").val();
   var editstatus= $("#editstatus").val();

   if (editcompanyName== '') {
    alert("Please Select Company");
   }
  else if(editemail== '') {
    alert("Please Type Email");
   }
   else if(editphone== '') {
    alert("Please Type Phone");
   }
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

</script>
<script type="text/javascript">
$(function() {
  $("#example1").parent().css('overflow-x','scroll');
$("#example1_wrapper").parent().css('overflow','unset');

});
</script>
<?php include "checkcompanystatus.php"; ?>
</body>
</html>
