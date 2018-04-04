<?php
include('inc/pdo.php');
include('inc/function.php');

$error =array();
$connection = false;

if(!empty($_POST['send']))
{
  $pseudo = trim(strip_tags($_POST['pseudo']));
  $email = trim(strip_tags($_POST['email']));
  $password = trim(strip_tags($_POST['password']));
  $pass = trim(strip_tags($_POST['pass']));

  $sql = "SELECT pseudo FROM `users` WHERE pseudo= :pseudo";
  $query = $pdo->prepare($sql);
  $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
  $query-> execute();
  $user_login = $query->fetch();
  if(!empty($user_login))
    $error['pseudo'] = 'nom de compte deja existant';
  else
    $error['pseudo'] = is_login_ok($pseudo);

  $sql = "SELECT email FROM `users` WHERE pseudo= :mail";
  $query = $pdo->prepare($sql);
  $query->bindValue(':mail', $email, PDO::PARAM_STR);
  $query-> execute();
  $user_mail = $query->fetch();
  if(!empty($user_mail))
    $error['email'] = 'Email deja existant';
  else
    $error['email'] = is_mail_ok($email);
  $error['password'] = is_password_ok($password, $pass);

  if (count($error == 0))
    $connection = true;
  if($connection == true)
  {
    $token = creatToken();
    $cryptopass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users(`pseudo`, `email`, `password`, `token`) VALUES (:pseudo, :email, :password, :token)";
    $query = $pdo->prepare($sql);
    $query-> bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $query-> bindValue(':email', $email, PDO::PARAM_STR);
    $query-> bindValue(':password', $cryptopass, PDO::PARAM_STR);
    $query-> bindValue(':token', $token, PDO::PARAM_STR);
    $query-> execute();

    header('location: index.php');
  }

}


 ?>



 <?php
 include('inc/header.php');
 ?>


<form action="inscription.php" method="post">

    <label>Pseudo</label>
    <input type="text" name="pseudo" value="">
    <span><?php if(!empty($error['psedo'])) echo $error['pseudo']; ?></span>

    <label>Email</label>
    <input type="text" name="email" value="">
    <span><?php if(!empty($error['psedo'])) echo $error['email']; ?></span>

    <label>Password</label>
    <input type="text" name="password" value="">
    <span><?php if(!empty($error['psedo'])) echo $error['password']; ?></span>

    <label>Confim password</label>
    <input type="text" name="pass" value="">

    <input type="submit" name="send" value="inscription">
</form>



 <?php
include('inc/footer.php');
  ?>
