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
  </head>
  <body>
  <?php 
  if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)){
    header("Location: ../index.php");
  }
  $servername = "localhost";
    $username = "root";
    $password = "bigstep";
    $dbname = "emp";

  $userimg="../image/";
  $img="";
  $name="";
  $role="";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $email=$_SESSION['email'];

    $sqlpass = "SELECT * from emp_dtls WHERE Email = '$email'";
            $result = mysqli_query($conn, $sqlpass);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $img=$row['Pimg'];
                $name=$row['First_Name'].' '.$row['Last_Name'];
                $role=$row['Role'];
                $userimg=$userimg.$img;
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
          <img src="<?php echo $userimg;?>" alt="Image" class="img-fluid">
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
    <?php            include 'header.php';                             ?>

      <div class="site-section">
        <div class="container">
          <div class="row justify-content-center">
          <!-- write here  -->

          </div>
        </div>
      </div>  
    </main>
  
  </body>
</html>