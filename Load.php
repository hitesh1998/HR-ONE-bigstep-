<?php
// Start the session
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <title> <?php
    echo $_SESSION['user_name'];
    ?> </title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script  src="https://code.jquery.com/jquery-3.6.0.js"  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
   

    
</head>

<body>
<?php include 'header.php'; ?>


    <?php


    $servername = "localhost";
    $username = "root";
    $password = "bigstep";
    $dbname = "emp";



    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }




    ?>

    <table class=" table table-striped table-success table-hover" id="myTable">
        <thead>
            <tr>
                <th scope="col">Sr.</th>
                <th scope="col">FirstName</th>
                <th scope="col">LastName</th>
                <th scope="col">Email</th>
                <th scope="col">Profile image</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql = "SELECT * FROM emp_dtls ";
            $result = mysqli_query($conn, $sql);
            $i=0;
            while ($row = mysqli_fetch_assoc($result)) {
                $im='image/'.$row['Pimg'];
                $i++;
                echo "<tr>
                <th scope=row>" . $i . "</th>
                <th scope=row>" . $row['First_Name'] . "</th>
                <th scope=row>" . $row['Last_Name'] . "</th>
                <th scope=row>" . $row['Email'] . "</th>
                
                <th scope=row><img src='$im' width='100' height='100'/> </th>
            </tr>";
            }

            ?>



        </tbody>
    </table>

</body>

</html>