<style>
  body {
    padding: 0px !important;
  }
  .logo-text 
  {
   text-align: center;
    margin-top: -5px;
    display: inline-table;
    font-size: 36px;
    font-weight: bold;
    font-family: 'DM Sans',sans-serif;
    letter-spacing: 2px;
    text-transform: uppercase;
  } 
</style>
<?php 
if(isset($_SESSION['username'])){
  if($_SESSION['username']==""){
    echo "<script> window.location = 'admin_login.php'</script>";
  }
}else{
  echo "<script> window.location = 'admin_login.php'</script>";
}

$classIndex = "treeview";
$classCompanies = "treeview";
$classCompanyClients = "treeview";
$classEmployeeList = "treeview";
$classPlans = "treeview";
$classReports = "treeview";
if($_SERVER['PHP_SELF']=="/EworxsAdmin/index.php"){
  $classIndex="treeview active";
}
else if($_SERVER['PHP_SELF']=="/EworxsAdmin/companies_list.php"){
  $classCompanies="treeview active";
}
else if($_SERVER['PHP_SELF']=="/EworxsAdmin/companies_client_list.php"){
  $classCompanyClients="treeview active";
}
else if($_SERVER['PHP_SELF']=="/EworxsAdmin/employee_list.php"){
  $classEmployeeList="treeview active";
}
else if($_SERVER['PHP_SELF']=="/EworxsAdmin/plans.php"){
  $classPlans="treeview active";
}
else if($_SERVER['PHP_SELF']=="/EworxsAdmin/subscriptions.php"){
  $classSubscriptions="treeview active";
}

else if($_SERVER['PHP_SELF']=="/EworxsAdmin/report.php"){
  $classReports="treeview active";
}

else if($_SERVER['PHP_SELF']=="/EworxsAdmin/profile.php"){
  $classProfile="treeview active";
}

else if($_SERVER['PHP_SELF']=="/EworxsAdmin/quick_book.php"){
  $classQuickBook="treeview active";
}
?>
<div class="container">
</div>
<aside class="main-sidebar">
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image admin-img " style="">
          <!-- <img src="dist/img/mobile.png" /> -->
          <div class="admin-name">
            <a href="companies_client_list.php" aria-current="page" class="logo w-inline-block w--current" style="text-transform: uppercase;"> 
             <div class="logo-text">
               <span class="big-e" style="font-size: inherit;">E</span>
                <span class="small-worxs" style="font-size: 26px;">worxs</span>
             </div>
            </a>
         </div>
        </div>
        <hr/>
        <div>
       </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
  <?php 
    if(($_SESSION['role'] == 2)){?>
        <li class="<?php echo $classProfile; ?>">
          <a href="profile.php">
            <i class="fa fa-user-circle"></i>
            <span>Profile</span>
          </a>
        </li>
  <?php }?>
        <?php if(($_SESSION['role'] == 1)){ ?>
        <li class="<?php echo $classCompanies; ?>">
          <a href="companies_list.php">
            <i class="fa fa-check-circle-o"></i>
            <span>Users</span>
          </a>
        </li>
        <?php }?>
       <?php if(($_SESSION['role'] == 1)){ ?>
        <li class="<?php echo $classPlans; ?>">
          <a href="plans.php">
            <i class="fa fa-check-circle-o"></i>
            <span>Plans</span>
          </a>
        </li>
        <?php }?>
        <?php 
        if(($_SESSION['role'] == 2)){ ?>
        <li class="<?php echo $classCompanyClients; ?> profile_checker">
          <a href="companies_client_list.php">
            <i class="fa fa-cogs"></i>
            <span> Client Companies</span>
          </a>
        </li>
       <li class="<?php echo $classIndex; ?> profile_checker" >
          <a href="index.php">
            <i class="fa fa-mobile mobile-icon"></i>
            <span>Client Visits</span>
          </a>
        </li>
        <li class="<?php echo $classEmployeeList; ?> profile_checker">
          <a href="employee_list.php">
            <i class="fa fa-users"></i>
            <span>Workers List</span>
          </a>
        </li>
        <li class="<?php echo $classReports; ?> profile_checker">
          <a href="report.php">
            <i class="fa fa-file"></i>
            <span>Worker Pay Data</span>
          </a>
        </li>
        <li class="<?php echo $classQuickbook; ?> profile_checker">
          <a href="quick_book.php">
            <i class="fa fa-list"></i>
            <span>QuickBooks Online Invoice Data</span>
          </a>
        </li>
        <?php }?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <script type="text/javascript">
      $(document).ready(function() {
         $("#profile_error_msg").text("");
         $.ajax({
            url: 'check_profile.php', // URL to your PHP script
            method: 'GET',
            dataType: 'text',
            success: function(response) {
               // console.log("hello");
               if (response.trim() === 'incomplete') {
                  $(".profile_checker").hide();
               }
               else
               {
                $(".profile_checker").show();
               }
            },
            error: function() {
               console.error("An error occurred during profile check.");
            }
         });

      });
   </script>