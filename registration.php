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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Emplyee Resitration</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet" id="bootstrap-css">

</head>

<body>

    <style>
        .error {
            color: red;
            font-size: 10px;
        }
    </style>
    <?php
    if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)){
        header("Location: ../index.php");
      }
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    $servername = "localhost";
    $username = "root";
    $password = "bigstep";
    $dbname = "emp";
    }else{
        header("Location: index.php");
    }
    // Create connection

    ?>

    <?php
    // define variables to empty values  
    $mobilenoErr = $passErr = $menterErr = "";
    $fname = $lname = $email = $mobileno = $gender = $role = $menter = $pass1 = $menteremail="";

    //Input fields validation  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $fname = input_data($_POST["firstname"]);
        $lname = input_data($_POST["lastname"]);
        $role = input_data($_POST["role"]);
        $email = input_data($_POST["email"]);
        $menteremail = input_data($_POST["menteremail"]);
        $mobileno = input_data($_POST["txtEmpPhone"]);
        // check if mobile no is well-formed  
        if (!preg_match("/^[0-9]*$/", $mobileno)) {
            $mobilenoErr = "Only numeric value is allowed.";
        }
        //check mobile no length should not be less and greator than 10  
        if (strlen($mobileno) != 10) {
            $mobilenoErr = "Mobile no must contain 10 digits.";
        }
        $menter = input_data($_POST["menter"]);
        $gender = input_data($_POST["gender"]);
        $pass1 = $_POST["pass1"];
        if ($_POST['pass1'] != $_POST['pass2']) {
            $passErr = "passward is not maching";
        } else {
            $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);
            if ($fnameErr == "" && $passErr == "" && $emailErr == "" && $menterErr == "" && $lnameErr == "" && $mobilenoErr == "" && $genderErr == "" && $roleErr == "") {
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql_e = "SELECT * FROM emp_dtls WHERE Email='$email'";
                $res_e = mysqli_query($conn, $sql_e);
                if (mysqli_num_rows($res_e) > 0) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error!</strong> Email Already taken...<br>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    $msg = "";
                    $filename = $_FILES["uploadfile"]["name"];
                    $tempname = $_FILES["uploadfile"]["tmp_name"];    
                    $folder = "image/".$filename;
                    $sql = "INSERT INTO emp_dtls VALUES (NULL,'$fname', '$lname','$email','$mobileno','$menter','$menteremail','$role','$hashed_password','$gender','$filename')";

                    if ($conn->query($sql) === TRUE) {
                        if (move_uploaded_file($tempname, $folder))  {
                            echo "Image uploaded successfully";
                        }else{
                           echo "Failed to upload image";
                      }
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> Your registration is successfully please login.....<br>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                   
                        header("Location: index.php");
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                $conn->close();
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Please fill form correct....
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        }
    }
    function input_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>














    <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> -->
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!------ Include the above in your HEAD tag ---------->

    <div class="container register">
        <div class="row">
            <div class="col-md-9 register-right">
                <form method="POST" enctype="multipart/form-data">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <h3 class="register-heading">Registration as a Employee</h3>
                            <div class="row register-form">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="firstname" placeholder="First Name *" value="<?php echo $fname; ?>" required />

                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="lastname" class="form-control" placeholder="Last Name *" value="<?php echo $lname; ?>" required />

                                    </div>
                                    <div class="form-group">
                                        <input type="password" name='pass1' class="form-control" placeholder="Password *" value="" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="pass2" class="form-control" placeholder="Confirm Password *" value="" required />
                                        <span class="error"> <?php echo $passErr ?> </span>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="menteremail" class="form-control" placeholder="Mentor Email" value="" required />
                                        <span class="error"> <?php echo $passErr ?> </span>
                                    </div>
                                    <div class="form-group">
                                        <div class="maxl">
                                            <label class="radio inline">
                                                <input type="radio" name="gender" value="male" checked>
                                                <span> Male </span>
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" name="gender" value="female">
                                                <span>Female </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email *" value="" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" minlength="10" maxlength="10" name="txtEmpPhone" class="form-control" placeholder="Your Phone *" value="<?php echo $mobileno; ?>" required />
                                        <span class="error"> <?php echo $mobilenoErr ?> </span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text"  name="menter" class="form-control" placeholder="Menter Name" value="<?php echo $menter; ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="role" placeholder="Role" value="<?php echo $role; ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="uploadfile" placeholder="Profile Piture"  required />
                                    </div>

                                    <input type="submit" class="btnRegister" name="submit" value="Register" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <hr>
</body>

</html>