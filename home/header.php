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

    <title></title>
  </head>
  <body>

<?php
  if (array_key_exists('logout', $_POST)) {
    session_unset();
    // destroy the session
    session_destroy();
    header("Location: ../index.php");
      }

?>

  <nav class="navbar navbar-expand-lg navbar-light bg-lightz">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li>
        <img src="logo.png" width="150" height="50">
      </li>
      </ul>
      <a class="btn btn-primary btn-sm" href="empdtls.php" role="button">Find People</a>&nbsp;&nbsp;
      <form class="d-flex" method="POST">
        <button class="btn btn-outline-success" name="logout" type="submit">Logout</button>
      </form>
    </div>
  </div>
</nav>
 
  </body>
</html>