<?php
session_start();
require_once '../config/db.php';
require_once '../config/tables.php';

function showArray($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

$email= '';
$password = '';
$errors= [];
$log=[];
$user=[];

if(isset($_POST['submit'])) {
    if(!mb_strlen($_POST['email'])) {
        $errors[]= 'No email';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[]='WRONG EMAIL';
    } else {
        $email = trim($_POST['email']);
       
    }
    if(!mb_strlen($_POST['password'])) {
    $errors[]= 'No password' ;
    } else if (mb_strlen($_POST['password']) < 8 ) {
      $errors[]=' password  short than 8 symbols';
    } else {
        $password = trim($_POST['password']);
    }
    if (!count($errors)) {
        $log="SELECT 
             `id`,
             `name`,
             `email`,
             `password`,
             `type`
             FROM `".TABLE_USERS."`
             WHERE `email` = '".mysqli_real_escape_string($conn , $_POST['email'])."' AND `type` = 'admin'
             ";
        if ($result = mysqli_query($conn, $log)){
          $user = mysqli_fetch_assoc($result);
        
        } 
        if (is_array($user) && count($user)){
             if (password_verify($password, $user['password'])) {
                $_SESSION['user']=$user;
                header('Location: index.php');
                showArray($user);
             } else {
                 $errors[]= "WRONG PASSWORD";
             }
        } else {
          $errors[] = 'Unauthorized';
        }
      
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action ="" method="post">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus" name="email" value="<?=$email?>"/> 
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required" name="password" value="<?=$password?>" />
              <label for="inputPassword">Password</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
          <button type="submit" name="submit"> SEND</button>
          <div>
        <ul>
         <?php if (isset($errors) && count($errors)) : ?>
            <?php for($i=0; $i < count($errors); $i++) : ?>
              <li><?=$errors[$i];?></li>
                <?php endfor ?> 
              <?php endif?>
        </ul>
        </div>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.html">Register an Account</a>
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
