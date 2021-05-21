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
  <title><?php
          echo $_SESSION['user_name'];
          ?> </title>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <link rel="stylesheet" href="css/demo.css" />
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="demo.css" />

  <style>
    section {
    float: left;
    width: 100%;
    padding-bottom: 0em;
}
    section p {
      float: left;
      
    }

    section img {
      float: left;
      width: 250px;
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


    if (array_key_exists('adduser', $_POST)) {
      header("Location: ../registration.php");
    }


    if (array_key_exists('attendance', $_POST)) {
      date_default_timezone_set("Asia/Calcutta");
      $date = date('Y-m-d');
      $time = date('H:i');
      if (!empty($_POST['attendanceselect'])) {
        $selected = $_POST['attendanceselect'];
        if ($selected == "In") {
          $sql_e = "SELECT * FROM attendance WHERE Date='$date' and Type='In' and Email='$email' ";
          $res_e = mysqli_query($conn, $sql_e);
          if (mysqli_num_rows($res_e) > 0) {
            echo '<script>alert("Sorry! you have already checked in")</script>';
          } else {
            $sql = "INSERT INTO attendance VALUES (NULL,'$name','$email','In','$time','$date','$mentor_email')";
            if ($conn->query($sql) === TRUE) {

              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> You successfully checked in<br>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
            } else {
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Please try again<br>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
          }
        }
        if ($selected == "Out") {
          $sql_e = "SELECT * FROM attendance WHERE Date='$date' and Type='Out' and Email='$email'";
          $res_e = mysqli_query($conn, $sql_e);
          if (mysqli_num_rows($res_e) > 0) {
            echo '<script> alert("Sorry! you have already checked Out")</script>';
          } else {
            $sql = "SELECT * FROM attendance WHERE Date='$date' and Type='In' and Email='$email' ";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
              $yes = 0;
              $full_day = 1;
              $row = mysqli_fetch_assoc($res);
              $intime = $row['Time'];
              $outtime = $time;
              $hours = intval($outtime - $intime);
              if ($hours < 9) {
                $full_day = 0;
                echo '<script>alert("Worning! your working hours is less the 9 hours.")</script>';
                $sql = "INSERT INTO attendance VALUES (NULL,'$name','$email','Out','$time','$date','$mentor_email')";
                if ($conn->query($sql) === TRUE) {


                  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You successfully checked out<br>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
                } else {
                  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Please try again<br>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }
              } else {
                $sql = "INSERT INTO attendance VALUES (NULL,'$name','$email','Out','$time','$date','$mentor_email')";
                if ($conn->query($sql) === TRUE) {

                  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> You successfully checked out<br>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
                } else {
                  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Please try again<br>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }
              }
              $sql_r = "INSERT INTO full_attendance VALUES (NULL,'$name','$email','$date','$mentor_email','$full_day', 0)";
              if (!$conn->query($sql_r) === TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
            } else {
              echo '<script>alert("Sorry! You have check in first")</script>';
            }
          }
        }
      } else {
        echo  '<script>alert("Please choose a option")</script>';
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

          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <form method="post">
              <select name="attendanceselect">
                <option value="" disabled selected>Choose option</option>
                <option value="In">Check In</option>
                <option value="Out">Check Out</option>
              </select>
              <button class="btn btn-primary me-md-2" name="attendance" type="submit">Mark Attendance</button>
              <button class="btn btn-primary" name="adduser" type="submit" <?php if ($_SESSION['email'] != 'hiteshgirish@ymail.com') { ?> hidden <?php } ?>>Add User </button>
            </form>
          </div>


          <div class="student-profile py-4">
            <div class="container">
              <div class="row">
                <div class="col-lg-3">
                  <div class="card shadow-sm" id="slider">
                    <div class="card-header bg-transparent border-0">
                      <h3 class="mb-0"><i class="far fa-clone pr-1"></i>New Hires</h3>
                    </div>
                    <figure>
                      <div>
                        <h4> Hitesh Jivnani </h4>
                        <span>
                          <h5> Sofware Engineer</h5>
                        </span> <span>
                          <h5> 40</h5>
                        </span>
                      </div>
                      <div>
                        <h4> Deepika Padukone </h4>
                        <span>
                          <h5> Product Manager</h5>
                        </span> <span>
                          <h5> 41</h5>
                        </span>
                      </div>
                      <div>
                        <h4>  Ranveer Singh  </h4>
                        <span>
                          <h5> Full Stack Developer</h5>
                        </span> <span>
                          <h5> 42</h5>
                        </span>
                      </div>
                    </figure>
                  </div>
                </div>

                <div class="col-lg-8" style="display: inline-block ;">
                  <div class="card shadow-sm">
                    <div class="card-header bg-transparent border-0">
                      <?php $month =  date("M"); ?>
                      <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Leave Requests (<?php echo $month; ?>) </h3>
                    </div>
                    <div class="card-body pt-0">
                      <table class="table table-bordered">
                        <tr>
                          <th scope="col">Full Day</th>
                          <th scope="col">Half Day</th>
                          <th scope="col">Paid</th>
                          <th scope="col">Unpaid</th>
                          <th scope="col">Accepted</th>
                          <th scope="col">Rejected</th>
                          <th scope="col">Pending</th>
                          <th scope="col">Total</th>
                          <th scope="col">Total days</th>
                        </tr>
                        <tr>
                          <td scope="col">1</td>
                          <td scope="col">2</td>
                          <td scope="col">1</td>
                          <td scope="col">1</td>
                          <td scope="col">2</td>
                          <td scope="col">0</td>
                          <td scope="col">2</td>
                          <td scope="col">4</td>
                          <td scope="col">3</td>
                        </tr>

                      </table>
                    </div>
                    <div class="card-header bg-transparent border-0">
                      <?php $month =  date("M"); ?>
                      <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Today's Wish </h3>
                    </div>
                    <div class="card-body pt-0">
                      <div class="card shadow-sm" id="slider">
                        <figure>
                          <div>
                            <section>
                              <img src="images/person_4.jpg" width="500px" height="200px">
                              <p>
                               
                              <h3 style="padding-top: 50px;"> Hitesh Jivnani </h3>
                              <h4> One Year Work aniversary</h4>
                              <h5> Email@gmail.com</h5>
                              </p>
                            </section>
                          </div>
                          <div>
                            <section>
                              <img src="images/person_2.jpg" width="500px" height="200px">
                              <p>
                              <h3 style="padding-top: 50px;"> Ankit Chaturvedy </h3>
                              <h4> Birthday </h4>
                              <h5> Email@gmail.com</h5>
                              </p>
                            </section>
                          </div>
                          <div>
                            <section>
                              <img src="images/person_3.jpg" width="500px" height="200px">
                              <p>
                              <h3 style="padding-top: 50px;"> Harish Sharma </h3>
                              <h4> Birthday </h4>
                              <h5> Email@gmail.com</h5>
                              </p>
                            </section>
                          </div>



                        </figure>
                      </div>
                    </div>
                  </div>

                  <div style="height: 26px"></div>


                  <div class="card shadow-sm" style="width: 300px;">
                    <div class="card-header bg-transparent border-0">
                      <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Announcements</h3>
                    </div>
                    <div class="card-body pt-0">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                  </div>

                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>

</body>

</html>