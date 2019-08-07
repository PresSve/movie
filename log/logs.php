<?php
session_start();
require_once 'movie/config/db.php';
require_once 'movie/config/tables.php';

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
             `password`
             FROM `".TABLE_USERS."`
             WHERE `email` = '".mysqli_real_escape_string($conn , $_POST['email'])."'
             ";
        if ($result = mysqli_query($conn, $log)){
          $user = mysqli_fetch_assoc($result);
        
        } 
        if (is_array($user) && count($user)){
             if (password_verify($password, $user['password'])) {
                $_SESSION['user']=$user;
                header('Location: profil.php');
                showArray($user);
             } else {
                 $errors[]= "WRONG PASSWORD";
             }
        }

    }
}

?>
<html>
  <head>
  </head>
     <body>
       <form action ="" method="post">
       <p>email:</p>
        <input type="text" name="email" value="<?=$email?>"/>
        <p>password:</p>
        <input type="password" name="password" value="<?=$password?>" />
        <br/>
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
    </body>

</html>