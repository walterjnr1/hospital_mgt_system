<?php
error_reporting(0);
include './config/connection.php';
$message = '';
if(isset($_POST["btnsubmit"]))
{
 sleep(5);
 
 $fullname = $_POST['txtfullname'];
 $userName = $_POST['txtusername'];
 $password = $_POST['txtpassword'];
 //$encryptedPassword = md5($password);
 $sex = $_POST['cmdsex'];
 $dept = $_POST['cmddept'];
 $email = $_POST['txtemail'];
 $phone = $_POST['txtphone'];
 $hireddate = $_POST['txthireddate'];


//$targetDir = "user_images/";
$baseName = basename($_FILES["profile_picture"]["name"]);
$targetFile =  time().$baseName;
 $status = move_uploaded_file($_FILES["profile_picture"]["tmp_name"],'user_images/'.$targetFile);

///check if username already exist
$stmt = $con->prepare("SELECT * FROM users WHERE user_name=? ");
$stmt->execute([$userName]); 
$users = $stmt->fetch();

if ($users) {

  ?>
  <script>
  alert('Username Already Exist..');
  
  </script>
  <?php

} else {

		
 $query = " INSERT INTO users (display_name,
 user_name, password,sex,email, phone, hired_date,dept, profile_picture) VALUES (:display_name,:user_name, :password,:sex,:email,:phone,:hired_date,:dept,:profile_picture)";
 
 $user_data = array(
  ':display_name'  => $fullname,
  ':user_name'   => $userName,
  ':password'   => $password,
  ':sex'   => $sex,
  ':email'   => $email,
   ':phone'  => $phone,
   ':hired_date'  => $hireddate,
  ':dept'  => $dept,
  ':profile_picture'  => $targetFile
  );
  
 $statement = $con->prepare($query);
 if($statement->execute($user_data)) {


  
  ?>
  <script>
  alert('Staff Added successfully');
  
  </script>
  <?php
  } else {
 
    ?>
    <script>
    alert('Problem Occured , Try Again');
    
    </script>
    <?php
     }
}
}


$queryUsers = "select * from `users` 
order by `id` desc;";
$stmtUsers = '';

try {
    $stmtUsers = $con->prepare($queryUsers);
    $stmtUsers->execute();

} catch(PDOException $ex) {
      echo $ex->getTraceAsString();
      echo $ex->getMessage();
      exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
 <?php include './config/site_css_links.php';?>

 
 <?php include './config/data_tables_css.php';?>
 <title>Users - DESIGN AND DEVELOPMENT OF A WEB BASED HOSPITAL MANAGEMENT SYSTEM FOR ARTHUR JARVIS UNIVERSITY</title>
 <link rel="icon" type="image/png" sizes="16x16" href="dist/img/logo.png">
 <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 <style>
  .user-img{
    width:3em;
    width:3em;
    object-fit:cover;
    object-position:center center;
  }
 </style>
</head>
<body class="hold-transition sidebar-mini dark-mode layout-fixed layout-navbar-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php include './config/header.php';
include './config/sidebar.php';?>  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Users</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="card card-outline card-primary rounded-0 shadow">
          <div class="card-header">
            <h3 class="card-title">Add Staff/User</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            <p> <h4 ><?php echo $message; ?></h4> </p></div>
          </div>
          <div class="card-body">
            <form method="post" enctype="multipart/form-data">
             <div class="row">

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Full Name</label>
                <input type="text" id="display_name" name="txtfullname" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Username</label>
                <input type="text" id="user_name" name="txtusername" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Password</label>
                <input type="password" id="password" 
                name="txtpassword" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Gender</label>
                <select name="cmdsex" class="form-control" id="cmdsex" >
          <option value="">Select your Sex</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
    

          
        </select>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Email</label>
                <input type="email" id="user_name" name="txtemail" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Phone Number</label>
                <input type="tel" id="password" 
                name="txtphone" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Hired Date</label>
                <input type="Date" id="display_name" name="txthireddate" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Department</label>
                <select name="cmddept" class="form-control" id="cmddept" >
          <option value="">Select your Department</option>
          <option value="Emergency Unit">Emergency Unit</option>
          <option value="Accident">Accident</option>
          <option value="Maternity">Maternity</option>
          <option value="Pharmacy">Pharmacy</option>
          <option value="Radiology">Radiology</option>
          <option value="Dietary">Dietary</option>
          <option value="Dental">Dental</option>
          <option value="Infectious Disease">Infectious Disease</option>

          
        </select>
              </div>

          
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Picture</label>
                <input type="file" id="profile_picture" 
                name="profile_picture" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                <label>&nbsp;</label>
                <button type="submit" id="save_medicine" 
                name="btnsubmit" class="btn btn-primary btn-sm btn-flat btn-block">Save</button>
              </div>
            </div>
          </form>
        </div>

      </div>
      <!-- /.card -->
    </section>
    <br/>
     <br/>
     <br/>
    <section class="content">
      <!-- Default box -->
      <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
          <h3 class="card-title">Total Staff</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            
          </div>
        </div>
        <div class="card-body">
            <div class="row table-responsive">
              <table id="all_patients" 
              class="table table-striped dataTable table-bordered dtr-inline" 
               role="grid" aria-describedby="all_patients_info">
              
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Picture</th>
                    <th>Fullname</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Hired Date</th>
                    <th>Action</th>


                  </tr>
                </thead>

                <tbody>
                  <?php 
                  $count = 0;
                  while($row =$stmtUsers->fetch(PDO::FETCH_ASSOC)){
                    $count++;
                  ?>
                  <tr>
                    <td><?php echo $count; ?></td>
                    <td>
               <img class = "img-thumbnail rounded-circle p-0 border user-img" src="user_images/<?php echo $row['profile_picture'];?>">
             </td>
                    <td><?php echo $row['display_name'];?></td>
                    <td><?php echo $row['user_name'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['phone'];?></td>
                    <td><?php echo $row['hired_date'];?></td>
                    <td>


                      <a href="update_user.php?user_id=<?php echo $row['id'];?>" class = "btn btn-primary btn-sm btn-flat">
                      <i class="fa fa-edit"></i>
                      </a>
                    </td>
                   
                  </tr>
                <?php
                }
                ?>
                </tbody>
              </table>
            </div>
        </div>
     
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

   
    </section>
  </div>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->
<?php 
 include './config/footer.php';

  $message = '';
  if(isset($_GET['message'])) {
    $message = $_GET['message'];
  }
?>  
  <!-- /.control-sidebar -->


<?php include './config/site_js_links.php'; ?>
<?php include './config/data_tables_js.php'; ?>


<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


</body>
</html>