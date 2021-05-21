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
      $('#myTable1').DataTable();
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
    if (array_key_exists('aprvleave', $_POST)) {

      if (!empty($_POST['rl_id'])) {
        foreach ($_POST['rl_id'] as $value) {
          $sql = "UPDATE full_attendance SET Approved = 1 WHERE A_id='$value'";
          if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Success! Approved.....")</script>';
          } else {

            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
      } else {
        echo '<script>alert("Error! Select some rows")</script>';
      }
    }
    if (array_key_exists('rejectleave', $_POST)) {

      if (!empty($_POST['rl_id'])) {
        foreach ($_POST['rl_id'] as $value) {
          $sql = "UPDATE full_attendance SET Approved=2 WHERE A_id='$value'";
          if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Success! Rejected.....")</script>';
          } else {

            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
      } else {
        echo '<script>alert("Error! Select some rows")</script>';
      }
    }

    //correction leave
    if (array_key_exists('aprvcorrectionleave', $_POST)) {

      if (!empty($_POST['rl_id'])) {
        foreach ($_POST['rl_id'] as $value) {
          $sql = "SELECT * FROM attendance_request WHERE AR_ID='$value'";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          $d=$row['Date'];
          $h=$row['Half_day'];
          $m=$row['User_email'];
          $hh=1;
          if($h ){
            $hh=0;
          }
          $sql = "UPDATE full_attendance SET Approved = 1, Full_day='$hh' WHERE User_email='$m' and Date ='$d'";
         $sql_m="UPDATE attendance_request SET Approved = 1 WHERE AR_ID='$value'";
        if (!$conn->query($sql_m) === TRUE){
          echo "Error: " . $sql_m . "<br>" . $conn->error;
         }
          if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Success! Approved.....")</script>';
          } else {

            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
      } else {
        echo '<script>alert("Error! Select some rows")</script>';
      }
    }

    if (array_key_exists('rejectcorectionleave', $_POST)) {

      if (!empty($_POST['rl_id'])) {
        foreach ($_POST['rl_id'] as $value) {
         $sql_m="UPDATE attendance_request SET Approved = 2 WHERE AR_ID='$value'";
        if ($conn->query($sql_m) === TRUE){
          echo '<script>alert("SUCCESS! ")</script>';
        }else {

            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
      } else {
        echo '<script>alert("Error! Select some rows")</script>';
      }
    }



    if (array_key_exists('applattendanc', $_POST)) {
      $reason = $_POST['Reason'];
      $date = $_POST['date'];
      $pin = $_POST['pin'];
      $pout = $_POST['pout'];
      $remark = $_POST['remark'];
      $username = $_SESSION['user']['First_Name'] . ' ' . $_SESSION['user']['Last_Name'];
      $mentor=$_SESSION['user']['Menter_email'];
      $halfday = 0;
      if (($pout-$pin)<9) {
        $halfday = 1;
      }
      $sql = "INSERT INTO attendance_request VALUES (NULL,'$username','$email','$reason','$remark','$date','$pin','$pout','$mentor','$halfday',0)";

      if ($conn->query($sql) === TRUE) {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your Request has been submitted.....<br>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
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

          <div class="page-content">
            <!-- Apply Leave Form -->
            <p>
            <h3> Attendance Correction </h3>
            </p>
            <div class="card pmd-card single-col-form">
              <form id="apply-leave" method="post">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group pmd-textfield pmd-textfield-floating-label ">
                        <span> <h3>Reason</h3>
                        <label class="radio inline">
                          <input type="radio" name="Reason" value="Forgot checkin" checked>
                          <span> Forgot to check in </span>
                        </label>
                        <label class="radio inline">
                          <input type="radio" name="Reason" value="forgot checkout">
                          <span>Forgot to check out </span>
                        </label>
                        <label class="radio inline">
                          <input type="radio" name="Reason" value="Forgot both">
                          <span>Forgot both </span>
                        </label>
                      </div>
                    </div>
                    <div class="col-md-6"><span>
                      <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label class="" for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required placeholder="dd-mm-yyyy" value=""
        min="1997-01-01" max="2030-31-12">
                      </div></span>
                      <div class="form-group pmd-textfield pmd-textfield-floating-label">
                      <span><label for="in">Punch in</label>
                        <input type="time" id="in" name="pin"></span>
                        <span><label for="out">Punch out</label>
                        <input type="time" id="out" name="pout"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                     
                    </div>
                    <div class="col-12">
                      <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label>Remark</label>
                        <textarea class="form-control" maxlength="300" id="reason" name="remark" required></textarea>
                      </div>
                    </div>
                   
                  </div>
                </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary pmd-ripple-effect pmd-btn-raised" name="applattendanc" value="Submit">Submit</button> <a href="home.php" class="btn btn-outline-secondary pmd-ripple-effect">Cancel</a>
            </div>
            </form>
          </div>


          <p>
          <h3>Attendance Request</h3>

          </p>
          <form method="POST">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
              <table class=" table table-striped table-success table-hover" id="myTable">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Date</th>
                    <th scope="col">Day</th>




                  </tr>
                </thead>
                <tbody>
                  <?php

                  $sql = "SELECT * FROM full_attendance WHERE Mentor_email='$email' and Approved=0 order by Date desc";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($result)) {
                    $day = "Half";
                    if ($row['Full_day']) {
                      $day = "Full";
                    }
                    $i++;
                    echo "<tr>
                  <th scope=row><input type='checkbox' name=rl_id[] value='$row[A_id]'/></th>
                <th scope=row>" . $row['User_name'] . "</th>
                <th scope=row>" . $row['User_email'] . "</th>
                <th scope=row>" . $row['Date'] . "</th>
                <th scope=row>" . $day . "</th>
              
                
                
            </tr>";
                  }

                  ?>
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <span><button type="submit" class="btn btn-primary pmd-ripple-effect pmd-btn-raised" name="aprvleave" value="Approve">Approve</button></span><span> <button type="submit" class="btn btn-danger pmd-ripple-effect pmd-btn-raised" name="rejectleave" value="Reject">Reject</button> </span>
            </div>
          </form>


          <p>
          <h3>Attendance correction Request</h3>

          </p>
          <form method="POST">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
              <table class=" table table-striped table-success table-hover" id="myTable1">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Remark</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Day</th>
       




                  </tr>
                </thead>
                <tbody>
                  <?php

                  $sql = "SELECT * FROM attendance_request WHERE Mentor_email='$email' and Approved=0 order by Date desc";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($result)) {
                    $day = "Full";
                    if ($row['Half_day']) {
                      $day = "Half";
                    }
                    $i++;
                    echo "<tr>
                  <th scope=row><input type='checkbox' name=rl_id[] value='$row[AR_ID]'/></th>
                <th scope=row>" . $row['User_name'] . "</th>
                <th scope=row>" . $row['User_email'] . "</th>
                <th scope=row>" . $row['Reason'] . "</th>
                <th scope=row>" . $row['Remark'] . "</th>
                <th scope=row>" . $row['Date'] . "</th>
                <th scope=row>" . $row['Punch-in'] .' to '. $row['Punch-out']."</th>
                <th scope=row>" . $day . "</th>
              
                
                
            </tr>";
                  }

                  ?>
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <span><button type="submit" class="btn btn-primary pmd-ripple-effect pmd-btn-raised" name="aprvcorrectionleave" value="Approve">Approve</button></span><span> <button type="submit" class="btn btn-danger pmd-ripple-effect pmd-btn-raised" name="rejectcorectionleave" value="Reject">Reject</button> </span>
            </div>
          </form>
        </div>

      </div>

    </div>


  </main>

</body>

</html>