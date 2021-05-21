<?php
// Start the session
session_start();
?>

<?php
//Set no caching
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Style -->
  <link rel="stylesheet" href="css/style.css">
  <title>HR-One</title>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  

  <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable2').DataTable();
    });
    $(document).ready(function() {
      $('#myTable').DataTable();
    });

  </script>
  <style>
    .my-custom-scrollbar {
      position: relative;
      height: 200px;
      overflow: auto;
    }

    .table-wrapper-scroll-y {
      display: block;
    }
  </style>

</head>

<body>
  <?php include 'header.php';  ?>

  <?php
  if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)){
    header("Location: ../index.php");
  }
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $servername = "localhost";
    $username = "root";
    $password = "bigstep";
    $dbname = "emp";

    $userimg = "../image/";
    $img = "";
    $name = "";
    $role = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $email = $_SESSION['email'];

    $sqlpass = "SELECT * from emp_dtls WHERE Email = '$email'";
    $result = mysqli_query($conn, $sqlpass);
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $img = $row['Pimg'];
      $name = $row['First_Name'] . ' ' . $row['Last_Name'];
      $role = $row['Role'];
      $userimg = $userimg . $img;
    }
    if (array_key_exists('aprvleave', $_POST)){

      if(!empty($_POST['rl_id'])){
        foreach($_POST['rl_id'] as $value){
          $sql="UPDATE leverequest SET Approved=1 WHERE Request_id='$value'";
          if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Success! Approved.....")</script>';
          }
          else{
          
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }
      }
      else{
        echo '<script>alert("Error! Select some rows")</script>';
      }
    }
    if (array_key_exists('rejectleave', $_POST)){

      if(!empty($_POST['rl_id'])){
        foreach($_POST['rl_id'] as $value){
          $sql="UPDATE leverequest SET Approved=2 WHERE Request_id='$value'";
          if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Success! Rejected.....")</script>';
          }
          else{
          
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }
      }
      else{
        echo '<script>alert("Error! Select some rows")</script>';
      }
    }



    if (array_key_exists('applyleave', $_POST)) {
      $leavetype = $_POST['leave-type'];
      $startdate = $_POST['datepickerstart'];
      $enddate = $_POST['datepickerend'];
      $reason = $_POST['reason'];
      $var1 = $_POST['halfday1'];
      $var2 = $_POST['halfday2'];
      $username = $_SESSION['user']['First_name'] . ' ' . $_SESSION['user']['Last_name'];
      $halfday = 0;
      if (isset($var1)) {
        $halfday = 1;
      }
      if (isset($var2)) {
        $halfday = 2;
      }
      $mentor_email = $_SESSION['user']['Menter_email'];
      $sql = "INSERT INTO leverequest VALUES (NULL,'$email','$username','$leavetype','$startdate','$enddate','$reason','$mentor_email','$halfday',0)";

      if ($conn->query($sql) === TRUE) {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your Request has been submitted.....<br>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  } else {
    header("Location: ../index.php");
  }
  ?>

  <aside class="sidebar">
    <div class="toggle">
      <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
        <span></span>
      </a>
    </div>
    <div class="side-inner">

      <div class="profile">
        <img src="<?php echo $userimg; ?>" alt="Image" class="img-fluid">
        <h3 class="name"><?php echo $name; ?></h3>
        <span class="country"><?php echo $role; ?></span>
      </div>

      <div class="nav-menu">
        <ul>
          <li><a href="home.php"><span class=""></span>HOME</a></li>
          <li class="accordion">
            <a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsible">
              <span class=""></span>APPROVAL
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
              <div>
                <ul>
                  <li><a href="leaveappoval.php">Leave</a></li>
                  <li><a href="attendanceapproval.php">Attendance</a></li>
                  <li><a href="#">Settlement</a></li>
                  <li><a href="#">Confirmation</a></li>
                  <li><a href="#">Workforce</a></li>
                </ul>
              </div>
            </div>
          </li>
          <li class="accordion">
            <a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="collapsible">
              <span class=""></span>Request
            </a>

            <div id="collapseTwo" class="collapse" aria-labelledby="headingOne">
              <div>
                <ul>
                  <li><a href="leaverequest.php">Leave</a></li>
                  <li><a href="#">WorkForce</a></li>
                  <li><a href="attendancerequest.php">Attendance</a></li>
                  <li><a href="#">Investmnt Declaration</a></li>
                </ul>
              </div>
            </div>

          </li>
          <li><a href="team.php"><span class=""></span>TEAM</a></li>

          <li class="accordion">
            <a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="collapsible">
              <span class=""></span>PERFORMANCE
            </a>

            <div id="collapseTwo" class="collapse" aria-labelledby="headingOne">
              <div>
                <ul>
                  <li><a href="objective.php">Objective</a></li>
                  <li><a href="review.php">review</a></li>
                </ul>
              </div>
            </div>

          </li>


        </ul>
      </div>
    </div>

  </aside>

  <main>


    <div class="site-section">


      <div class="container">

        <div class="row justify-content-center">
          <!-- write here  -->
  
          <p>
          <h3>Leave History</h3>
          </p>
          <div class="table-wrapper-scroll-y my-custom-scrollbar">
            <table class=" table table-striped table-success table-hover" id="myTable2">
              <thead>
                <tr>
                  <th scope="col">Sr.</th>
                  <th scope="col">Leave type</th>
                  <th scope="col">From</th>
                  <th scope="col">To</th>
                  <th scope="col">Reason</th>
                  <th scope="col">Half day</th>
                  <th scope="col">Approved</th>


                </tr>
              </thead>
              <tbody>
                <?php

                $sql = "SELECT * FROM leverequest WHERE User_email='$email' order by Start_date desc";
                $result = mysqli_query($conn, $sql);
                $i = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                  $i++;
                  $apvd = "No";
                  if ($row["Approved"]==1) {
                    $apvd = "Yes";
                  }
                  if ($row["Approved"]==2) {
                    $apvd = "Rejected";
                  }
                  echo "<tr>
                <th scope=row>" . $i . "</th>
                <th scope=row>" . $row['Leave_type'] . "</th>
                <th scope=row>" . $row['Start_date'] . "</th>
                <th scope=row>" . $row['End_date'] . "</th>
                <th scope=row>" . $row['Reason'] . "</th>
                <th scope=row>" . $row['Half_day'] . "</th>
                <th scope=row>" . $apvd . "</th>
                
            </tr>";
                }

                ?>



              </tbody>
            </table>
          </div>
        </div>






      </div>

    </div>

   
  </main>

</body>

</html>