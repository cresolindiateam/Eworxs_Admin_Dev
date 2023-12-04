<?php 
include('header.php');
$company_id= $_SESSION['companyid'];
$db=db_connect(); 
$sql = "SELECT id, company_id,first_name,last_name,email , phone , client_company_name , office_address,postal_code,created_at,work_rate, mileage_rate,due_date_range,clock_setting,return_mileage   FROM company_clients where company_id = $company_id and status=1 ORDER BY id DESC";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);

  foreach ($data as $key => $value){
      $data[$key]['id']=$value['id']; 
      $data[$key]['company_id']=$value['company_id']; 
      $data[$key]['first_name']=$value['first_name']; 
      $data[$key]['last_name']=$value['last_name']; 
      $data[$key]['email']=$value['email']; 
      $data[$key]['phone']=$value['phone']; 
      $data[$key]['client_company_name']=$value['client_company_name']; 
      $data[$key]['office_address']=$value['office_address']; 
      $data[$key]['postal_code']=$value['postal_code']; 
      $data[$key]['created_at']=$value['created_at']; 
      $data[$key]['work_rate']=$value['work_rate']; 
      $data[$key]['mileage_rate']=$value['mileage_rate'];
      $data[$key]['due_date_range']=$value['due_date_range'];
      $data[$key]['clock_setting']=$value['clock_setting'];
      
    }
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>EWORXS | Automatically Track Your Mileage</title>
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="description" content="Mileage Tracking,Work Hour Tracking,Document Capturing, Automated Invoicing &much more!">
    <meta name="keywords" content="Eworxs,Client Invoicing,Field Worker Managemnet,Automatic Mileage Tracking">
    <meta name="author" content="Eworxs Support">
    <meta property="og:image" content="http://eworxs.app/img/banner1.jpg">
    <meta property="og:image:secure" content="https://eworxs.app/img/banner1.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1344">
    <meta property="og:image:height" content="840">
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
   body {
      padding: 0px !important;
   }

   .addclient input {
      width: unset !important;
   }

   .profile_error {
      font-size: 14px;
      color: red;
      margin-right: 10px;
      line-height: 2.3;
   }

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
      transform: translate(-122%, 91%);
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
      <div class="add_employee_list_modal">
         <div class="modal fade" id="add_employee_list_modal" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">×</button>
                     <h4 class="modal-title">Create New Client </h4>
                  </div>
                  <div class="modal-body addclient">
                     <div class="user-info-area">
                        <div class="row ">
                           <div class="col-md-3">
                              <div class="personal-info-label">First Name</div>
                              <input type="text" value="" class="form-control" id="firstName" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Last Name</div>
                              <input type="text" class="form-control" id="lastName" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Email</div>
                              <input type="email" pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" class="form-control" id="email" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Phone</div>
                              <input type="text" class="form-control" id="phone" />
                           </div>
                        </div>
                        <hr />

                        <div class="row ">
                           <div class="col-md-3">
                              <div class="personal-info-label">Client Company Name</div>
                              <input type="text" class="form-control" id="companyName" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Office Address</div>
                              <input type="text" class="form-control" id="officeAddress" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Postal Code</div>
                              <input type="text" class="form-control" id="postalCode" />
                           </div>
                           <div class="col-md-3">
                              <div class="personal-info-label">Hourly Rate</div>
                              <input type="text" class="form-control" id="workRate" />
                           </div>
                        </div>
                        <hr />

                        <div class="row ">
                           <div class="col-md-3">
                              <div class="personal-info-label">MIleage Rate</div>
                              <input type="number" min="0" step="1" oninput="validity.valid||(value='');" class="form-control" id="mileageRate" />
                           </div>
                           <div class="col-md-3">
                              <div class="personal-info-label">Due Date
                                 <span class="tooltip1 pull-right">
                                    <span style="background-color: lightgrey;color: #333;border-radius: 50%;font-size: 21px;height: 21px;width: 100px;font-weight: bold;display: inline-block;width: 22px;height: 22px;margin-right: 10px;">
                                       <span style="margin: 1px 8px;font-size:16px;display: inline-block;">?</span>
                                    </span>
                                    <span class="tooltiptext">
                                       <ul style="list-style: none;margin: 0;padding: 5px 10px;text-align: left;">
                                          <li> this determines when payment is due from your client N15 means Net 15 and so forth.</li>
                                       </ul>
                                    </span>
                                 </span>
                              </div>
                              <!--<input type="text" class="form-control" id="dateRange"/>-->
                              <select id="dateRange" class="form-control">
                                 <option value="0"> Due on receipt</option>
                                 <option value="15"> Net 15</option>
                                 <option value="30"> Net 30</option>
                                 <option value="45"> Net 45</option>
                                 <option value="60"> Net 60</option>
                                 <option value="90"> Net 90</option>
                              </select>
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Return Mileage
                                 <span class="tooltip1 pull-right">
                                    <span style="background-color: lightgrey;color: #333;border-radius: 50%;font-size: 21px;height: 21px;width: 100px;font-weight: bold;display: inline-block;width: 22px;height: 22px;margin-right: 10px;">
                                       <span style="margin: 1px 8px;font-size:16px;display: inline-block;">?</span>
                                    </span>
                                    <span class="tooltiptext">
                                       <ul style="list-style: none;margin: 0;padding: 5px 10px;text-align: left;">
                                          <li> pick yes, if your client pays for return mileage.</li>
                                       </ul>
                                    </span>
                                 </span>
                              </div>
                              <!--<input type="text" class="form-control" id="dateRange"/>-->
                              <select id="returnMileage" class="form-control">
                                 <option value="0"> No</option>
                                 <option value="1"> Yes</option>
                              </select>
                           </div>
                           <?php  $company_id = $_SESSION['companyid']; ?>
                           <input id="company" type="hidden" value="<?php echo $company_id;?>">
                        </div>
                        <hr />
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn theme-btn" id="add-employee-list-btn" onclick="addNewCompanyClient()">Create</button>
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
                     <button type="button" class="close" data-dismiss="modal">×</button>
                     <p class="test" value=""></p>
                     <h4 class="modal-title">Edit Client </h4>
                  </div>
                  <div class="modal-body">
                     <div class="user-info-area">
                        <div class="row ">
                           <div class="col-md-3">
                              <div class="personal-info-label">First Name</div>
                              <input type="text" class="form-control" id="editfirstName" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Last Name</div>
                              <input type="text" class="form-control" id="editlastName" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Email</div>
                              <input type="text" class="form-control" id="editemail" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Phone</div>
                              <input type="text" class="form-control" id="editphone" />
                           </div>
                        </div>
                        <hr />
                        <div class="row ">
                           <div class="col-md-3">
                              <div class="personal-info-label">Company Client Name</div>
                              <input type="text" class="form-control" id="editcompanyName" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Office Address</div>
                              <input type="text" class="form-control" id="editofficeAddress" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Postal Code</div>
                              <input type="text" class="form-control" id="editpostalCode" />
                           </div>

                           <div class="col-md-3">
                              <div class="personal-info-label">Hourly Rate</div>
                              <input type="text" class="form-control" id="editworkRate" />
                           </div>
                        </div>
                        <hr />

                        <div class="row ">
                           <div class="col-md-3">
                              <div class="personal-info-label">MIleage Rate</div>
                              <input type="text" class="form-control" id="editmileageRate" />
                           </div>
                           <div class="col-md-3">
                              <div class="personal-info-label">Due Date</div>
                              <select id="editdateRange" class="form-control">
                                 <option value="0"> Due upon Receipt</option>
                                 <option value="15"> N15</option>
                                 <option value="30"> N30</option>
                                 <option value="45"> N45</option>
                                 <option value="60"> N60</option>
                                 <option value="90"> N90</option>
                              </select>
                       </div>
                           <div class="col-md-3">
                              <div class="personal-info-label">Return Mileage</div>
                              <select id="editreturnMileage" class="form-control">
                                 <option value="0"> No</option>
                                 <option value="1"> Yes</option>
                              </select>
                           </div>
                           <input type="text" class="form-control" id="editdateRange" />
                        </div>
                        <hr />
                        <div class="row ">
                           <?php  $company_id = $_SESSION['companyid']; ?>
                           <input id="editcompany" type="hidden" value="<?php echo $company_id;?>">
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn theme-btn" id="add-employee-list-btn" onclick="updateNewCompanyClient()">Update</button>
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <section class="content-header">
            <h1 class="make-inline">Client List </h1>
            <a href="companies_client_list_csv.php"><button class="btn btn-warning pull-right">Export  <i class="fa fa-file-excel-o"></i></button></a>
            <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button>
            <div class="profile_error  pull-right" id="profile_error_msg"></div>

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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Client Company Name</th>
                                    <th>Office Address</th>
                                    <th>Postal Code</th>
                                    <th>Created At</th>
                                    <th>Hourly Rate</th>
                                    <th>Mileage Rate</th>
                                    <th>Return Mileage</th>
                                    <th>Due Date Range</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
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
                $count=$key+1;
                      echo'<tr>'; 
                      echo'<td>'.$count.'</td>';
                      echo'<td>'.$item['first_name'].'</td>';
                      echo'<td>'.$item['last_name'].'</td>';
                      echo'<td>'.$item['email'].'</td>';
                      echo'<td>'.$item['phone'].'</td>';
                      echo'<td>'.$item['client_company_name'].'</td>';
                      echo'<td>'.$item['office_address'].'</td>';
                      echo'<td>'.$item['postal_code'].'</td>';
                      echo'<td>'.$item['created_at'].'</td>';
                      echo'<td>'.$item['work_rate'].'</td>';
                      echo'<td>'.$item['mileage_rate'].'</td>';
                     if($item['return_mileage']==0)
                     {
                      echo'<td style="color:red">No</td>';
                      }
                      else
                      {
                        echo'<td style="color:green">Yes</td>';
                      }
                      echo'<td>'.$due_date_range_prefix.'</td>';
                       $id= $item['id'];
                       echo'<td><button type="button" class="btn open-ClientDialog" data-toggle="modal" data-target="#edit_employee_list_modal" data-id='.$id.' >Edit</button>
                       <button type="button" class="btn btn-danger" id="add-employee-list-btn" onclick="deleteCompanyClient('.$item['id'].')">Delete</button></td>';
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
      <div class="control-sidebar-bg"></div>
   </div>
   <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
   <script src="plugins/jQuery/jquery-ui.min.js"></script>
   <script>
      $.widget.bridge('uibutton', $.ui.button);
   </script>
   <script src="bootstrap/js/bootstrap.min.js"></script>
   <script src="plugins/jQuery/raphael-min.js"></script>
   <script src="plugins/jQuery/moment.min.js"></script>
   <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
   <script src="dist/js/app.min.js"></script>
   <script src="dist/js/pages/dashboard.js"></script>
   <script src="dist/js/demo.js"></script>
   <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
   <script src="bootstrap/js/bootstrap.min.js"></script>
   <script src="plugins/datatables/jquery.dataTables.min.js"></script>
   <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
   <script src="dist/js/app.min.js"></script>
   <script src="dist/js/demo.js"></script>
   <script type="text/javascript">
      $(document).ready(function() {
         $("#profile_error_msg").text("");
         $.ajax({
            url: 'check_profile.php', // URL to your PHP script
            method: 'GET',
            dataType: 'text',
            success: function(response) {
               console.log("hello");
               if (response.trim() === 'incomplete') {
                  $("#profile_error_msg").text("* You Must Complete the Profile");
               }
            },
            error: function() {
               console.error("An error occurred during profile check.");
            }
         });

      });
   </script>
   <script type="text/javascript">
      $(function() {
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

      $('#empMobile').keydown(function() {
         if (this.value.length > 9) {
            this.value = "";
            alert("value should not be more than 10 or less than 10.");
            return false;
         }
      });
   </script>
   <script type="text/javascript">
      $(function() {
         $(".open-ClientDialog").click(function() {
            var id = $(this).data('id');
            $(".test").text(id);
            $.ajax({
               url: "AjaxUpdateComapnyClient.php",
               data: {
                  editclientid: id
               },
               type: 'post',
               dataType: 'json',
               success: function(response) {
                  console.log(response);
                  $("#editfirstName").val(response.firstName);
                  $("#editlastName").val(response.lastName);
                  $("#editemail").val(response.email);
                  $("#editphone").val(response.phone);
                  $("#editcompanyName").val(response.client_company_name);
                  $("#editofficeAddress").val(response.office_address);
                  $("#editpostalCode").val(response.postal_code);
                  $("#editworkRate").val(response.work_rate);
                  $("#editmileageRate").val(response.mileage_rate);
                  $("#editdateRange").val(response.date_range);
                  console.log(response.clock_setting);
                  $("#editclock").val(response.clock_setting);
                  $("#editcompany").val(response.company_id);
                  $("#editreturnMileage").val(parseInt(response.return_mileage));
               },
               error: function(xhr, status, error) {
                  var err = eval("(" + xhr.responseText + ")");
                  alert(err.Message);
               }
            });
         });
      });
   </script>
   <script>
      function updateNewCompanyClient() {
         var id = $(".test").text();
         var editfirstName = $("#editfirstName").val();
         var editlastName = $("#editlastName").val();
         var editemail = $("#editemail").val();
         var editphone = $("#editphone").val();
         var editpassword = $("#editpassword").val();
         var editcompanyName = $("#editcompanyName").val();
         var editofficeAddress = $("#editofficeAddress").val();
         var editpostalCode = $("#editpostalCode").val();
         var editworkRate = $("#editworkRate").val();
         var editmileageRate = $("#editmileageRate").val();
         var editdateRange = $("#editdateRange").val();
         var editreturnMileage = $("#editreturnMileage").val();
         var editcompany = $("#editcompany").val();
         var editclock = $("#editclock").val()
         if (editcompanyName == '') {
            alert("Please Select Company");
            return false;
         } else if (editemail == '') {
            alert("Please Type Email");
            return false;
         }
         if (IsEmail(editemail) == false) {
            alert("Please Type Valid Email");
            return false;
         } else {
            $.ajax({
               url: "AjaxUpdateDataCompanyClient.php",
               data: {
                  "id": id,
                  "editfirstName": editfirstName,
                  "editlastName": editlastName,
                  "editemail": editemail,
                  "editphone": editphone,
                  "editpassword": editpassword,
                  "editcompanyName": editcompanyName,
                  "editofficeAddress": editofficeAddress,
                  "editpostalCode": editpostalCode,
                  "editworkRate": editworkRate,
                  "editmileageRate": editmileageRate,
                  "editdateRange": editdateRange,
                  "editcompany": editcompany,
                  "editclock": editclock /*"editstatus":editstatus*/ ,
                  "editreturnMileage": editreturnMileage
               },
               type: 'post',
               dataType: 'json',
               success: function(response) {
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
      function deleteCompanyClient(id) {
         if (confirm("Are you sure you want to delete this?")) {
            $.ajax({
               url: "AjaxDeleteComapnyClient.php",
               data: {
                  id: id
               },
               type: 'post',
               dataType: 'json',
               success: function(response) {
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
         if (!regex.test(email)) {
            return false;
         } else {
            return true;
         }
      }

      function addNewCompanyClient() {
         var companyName = document.getElementById('companyName').value;
         var firstName = document.getElementById('firstName').value;
         var last_name = document.getElementById('lastName').value;
         var email = document.getElementById('email').value;
         var phone = document.getElementById('phone').value;
         var postal_code = document.getElementById('postalCode').value;
         var work_rate = document.getElementById('workRate').value;
         var mileage_rate = document.getElementById('mileageRate').value;
         var due_date_range = document.getElementById('dateRange').value;
         var returnMileage = document.getElementById('returnMileage').value;
         var company = document.getElementById('company').value;
         var clock = 1;
         var officeAddress = document.getElementById('officeAddress').value;

         if (companyName == '') {
            alert("Please Type Company");
            return false;
         } else if (email == '') {
            alert("Please Type Email");
            return false;
         }
         if (IsEmail(email) == false) {
            alert("Please Type Valid Email");
            return false;
         } else {
            $.ajax({
               url: "AjaxCreateCompanyClient.php",
               data: {
                  company_name: companyName,
                  first_name: firstName,
                  last_name: last_name,
                  email: email,
                  phone: phone,
                  postal_code: postal_code,
                  work_rate: work_rate,
                  mileage_rate: mileage_rate,
                  due_date_range: due_date_range,
                  company: company,
                  clock: clock,
                  office_address: officeAddress,
                  return_mileage: returnMileage
               },
               type: 'post',
               dataType: 'json',
               success: function(response) {
                  alert(response.Message);
                  if (response.Status == 1) {
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
   <script type="text/javascript">
      $(function() {
         $("#example1").parent().css('overflow-x', 'scroll');
         $("#example1_wrapper").parent().css('overflow', 'unset');

      });
   </script>
   <?php include "checkcompanystatus.php"; ?>
</body>
</html>