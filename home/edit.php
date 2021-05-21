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

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>

  <!--Only for demo purpose - no need to add.-->
  <link rel="stylesheet" href="css/demo.css" />

  <link rel="stylesheet" href="css/style1.css">

  <title>
          HR-One
           </title>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

  <style>
    .left {
      float: left;
    }

    .right {
      float: left;
      padding-left: 50px;
      padding-top: 80px;
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
    $mentor_email = $_SESSION['user']['Menter_email'];

    $sqlpass = "SELECT * from emp_dtls WHERE Email = '$email'";
    $result = mysqli_query($conn, $sqlpass);
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $img = $row['Pimg'];
      $name = $row['First_Name'] . ' ' . $row['Last_Name'];
      $role = $row['Role'];
      $userimg = $userimg . $img;
    }
    $empid = $_POST['edit'];
    $sql = "SELECT * from emp_dtls WHERE Id = '$empid'";
    $result = mysqli_query($conn, $sql);
    $rowd = '';
    if (mysqli_num_rows($result) > 0) {
      $rowd = mysqli_fetch_assoc($result);
    }
    $im = '../image/' . $rowd['Pimg'];



    if (array_key_exists('update', $_POST)) {
      $empid = $_POST['update'];
      $empname = $_POST['name'];
      $empname = explode(" ", $empname);
      $empfirstname = $empname[0];
      $emplastname = $empname[1];
      $empemail = $_POST['email'];
      $empmobnu = $_POST['mobile'];
      $emprol = $_POST['role'];
      $empmentorname = $_POST['mentorname'];
      $empmentoremail = $_POST['mentoremail'];
      $empgender = $_POST['gender'];

      $msg = "";
      $filename = $_FILES["uploadfile"]["name"];
      $tempname = $_FILES["uploadfile"]["tmp_name"];
      $folder = "../image/" . $filename;
      if ($filename) {
        $sql = "UPDATE emp_dtls SET First_Name='$empfirstname', Last_Name='$emplastname', Email='$empemail',PhoneNu='$empmobnu',Mentor='$empmentorname',Menter_email='$empmentoremail',Role='$emprol',Gender='$empgender', Pimg='$filename' WHERE Id='$empid'";
        if ($conn->query($sql) === TRUE) {
          if (move_uploaded_file($tempname, $folder)) {
            echo '<script>alert("Success!")</script>';
          } else {
            echo "Failed to upload image";
          }


          header("Location: empdtls.php");
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else {
        $sql = "UPDATE emp_dtls SET First_Name='$empfirstname', Last_Name='$emplastname', Email='$empemail',PhoneNu='$empmobnu',Mentor='$empmentorname',Menter_email='$empmentoremail',Role='$emprol',Gender='$empgender' WHERE Id='$empid'";
        if ($conn->query($sql) === TRUE) {

          echo '<script>alert("Success!")</script>';
          header("Location: empdtls.php");
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
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
          <!-- write code here -->


          <section>
            <div class="rt-container">
              <div class="col-rt-12">
                <div class="Scriptcontent">

                  <!-- Student Profile -->
                  <div class="student-profile py-4">
                    <div class="container">
                      <form method="POST" enctype="multipart/form-data">

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="card shadow-sm">
                              <div class="card-header bg-transparent text-center">
                                <img class="profile_img" src="<?php echo $im; ?>" alt="employee dp">
                                <h3> <input type="text" name="name" value="<?php echo $rowd['First_Name'] . ' ' . $rowd['Last_Name']; ?>" required></h3>
                              </div>
                              <div class="card-body">
                                <p class="mb-0"><strong class="pr-1">Employee ID :</strong><?php echo $rowd['Id']; ?></p>
                                <p class="mb-0"><strong class="pr-1">Email :</strong><input type='email' value='<?php echo $rowd['Email']; ?>' name='email' required></p>
                                <br>

                                <p style="text-align: center;"><button class="btn btn-dark btn-sm" name="update" value='<?php echo $rowd['Id'] ?>' type="submit" <?php if ($_SESSION['email'] != 'hiteshgirish@ymail.com') { ?> hidden <?php } ?>>Update</button></p>

                              </div>
                            </div>
                          </div>
                          <div class="col-lg-8">
                            <div class="card shadow-sm">
                              <div class="card-header bg-transparent border-0">
                                <h3 class="mb-0"><i class="far fa-clone pr-1"></i>General Information</h3>
                              </div>
                              <div class="card-body pt-0">
                                <table class="table table-bordered">
                                  <tr>
                                    <th width="30%">Phone Number</th>
                                    <td width="2%">:</td>
                                    <td> <input type="number" maxlength="10" minlength="10" value="<?php echo $rowd['PhoneNu']; ?>" name="mobile" required> </td>
                                  </tr>
                                  <tr>
                                    <th width="30%">Mentor Name </th>
                                    <td width="2%">:</td>
                                    <td><input type="text" value="<?php echo $rowd['Mentor']; ?>" name="mentorname" required></td>
                                  </tr>
                                  <tr>
                                    <th width="30%">Mentor Email</th>
                                    <td width="2%">:</td>
                                    <td><input type="email" value="<?php echo $rowd['Menter_email']; ?>" name="mentoremail" required></td>
                                  </tr>
                                  <tr>
                                    <th width="30%">Role</th>
                                    <td width="2%">:</td>
                                    <td> <input type="text" value="<?php echo $rowd['Role']; ?>" name="role" required> </td>
                                  </tr>
                                  <tr>
                                    <th width="30%">Gender</th>
                                    <td width="2%">:</td>
                                    <td> <input type="text" value="<?php echo $rowd['Gender']; ?>" name="gender" required> </td>
                                  </tr>
                                  <tr>
                                    <th width="30%">Profile Image</th>
                                    <td width="2%">:</td>
                                    <td><input type="file" name="uploadfile"></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <div style="height: 26px"></div>
                            <div class="card shadow-sm">
                              <div class="card-header bg-transparent border-0">
                                <h3 class="mb-0"><i class="far fa-clone pr-1"></i>About Employee</h3>
                              </div>
                              <div class="card-body pt-0">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- partial -->

                </div>
              </div>
            </div>
          </section>

        </div>
      </div>
    </div>
  </main>

</body>

</html>