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
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet">

</head>

<body background='bg.jpeg'>
    <style>
        .error {
            color: red;
            font-size: 10px;
        }

        body {
    background-image: url('bg.jpeg');
    background-size:  100%;
    background-repeat: no-repeat;
    background-position: left top;
}
input[type="text"]
{
    background: transparent;
    border: none;
}
        .cpc {
            background-color: paleturquoise;
            text-shadow: palevioletred;
            font-size: 20px;
            text-align: center;


        }
 
    </style>







    <?php

    $cap = range('A', 'Z');
    $sml = range('a', 'b');
    $dig = range(0, 9);
    $cpcha = $dig[array_rand($dig)] . '' . $cap[array_rand($cap)] . '' . $dig[array_rand($dig)] . '' . $sml[array_rand($sml)] . '' . $cap[array_rand($cap)] . '' . $dig[array_rand($dig)];
    if (array_key_exists('refresh', $_POST)) {
        refresh();
    }
    function refresh()
    {
        $GLOBALS['cpcha'] = $GLOBALS['dig'][array_rand($GLOBALS['dig'])] . '' . $GLOBALS['cap'][array_rand($GLOBALS['cap'])] . '' . $GLOBALS['dig'][array_rand($GLOBALS['dig'])] . '' . $GLOBALS['sml'][array_rand($GLOBALS['sml'])] . '' . $GLOBALS['cap'][array_rand($GLOBALS['cap'])] . '' . $GLOBALS['dig'][array_rand($GLOBALS['dig'])];
    }
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header("Location: home/home.php");
    }else{
    if (array_key_exists('final', $_POST)) {
        $servername = "localhost";
        $username = "root";
        $password = "bigstep";
        $dbname = "emp";
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        //String Validation
        global  $cpcha;
        $oldcapcha = '';
        $entercpcha = '';
        $email = '';
        $pass = '';
        $ermsg = '';
        $email = input_data($_POST["loginemail"]);
        $pass = input_data($_POST["lognpass"]);
        $entercpcha = input_data($_POST["capcha"]);
        $oldcapcha = input_data($_POST["oldcapcha"]);
        // check if name only contains letters and whitespace  
        if ($entercpcha == $oldcapcha) {
           

            $sqlpass = "SELECT * from emp_dtls WHERE Email = '$email'";
            $result = mysqli_query($conn, $sqlpass);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['user']=$row;
                $passd = $row["Passward"];
                if (password_verify($pass, $passd)) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email']=$row["Email"];
                    $_SESSION['user_name'] = "Welcome ".$row["First_Name"];
                    header("Location: home/home.php");
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Please enter correct passward....
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';                }
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Please enter correct Email and passward....
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        } else {
            $ermsg = "Please enter the correct security code";
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

    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Sign In</h5>
                        <form class="form-signin"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-label-group">
                                <input type="email" id="inputEmail" class="form-control" name="loginemail" placeholder="Email address">
                                <label for="inputEmail">Email address</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" name="lognpass" id="inputPassword" class="form-control" placeholder="Password">
                                <label for="inputPassword">Password</label>
                            </div>

                            <!-- code here -->
                            <div class="cls">
                                <span><input type="hidden" name="oldcapcha" value="<?php echo $cpcha; ?>"></span><span class="cpc"><?php echo "Code : " . $cpcha ?></span> <span><input type="text" name="capcha" placeholder="Write hear security code"></span>
                                <span class="error"> <?php echo $ermsg; ?> </span>
                               <br><br> <span><button type="submit" class="btn btn-dark" name="refresh" onclick="refresh()">Refresh</button></span>
                            </div>
                            <br>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" name = "final" type="submit">Sign in</button>
                            

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>