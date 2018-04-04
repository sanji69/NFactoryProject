<?php
session_start();
include('inc/pdo.php');
include('inc/function.php');

$error = array();
$connexion = false;

if(!empty($_POST['send']))
{
  $login = trim(strip_tags($_POST['pseudo']));
  $password = trim(strip_tags($_POST['password']));


  if(!empty($login) && !empty($password))
  {
    $cryptopass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM `users` WHERE pseudo= :pseudo";
    $query = $pdo->prepare($sql);
    $query->bindValue(':pseudo', $login, PDO::PARAM_STR);
    $query-> execute();
    $user = $query->fetch();
    if(!empty($user))
    {
      $connectionstatus = password_verify($password, $user['password']);
      if($user['pseudo'] != $login)
        $error['pseudo'] = 'identifant incorrect';
      elseif($connectionstatus == false)
        $error['password'] = 'mot de passe incorrect';
    }
    else
      $error['pseudo'] = 'identifiant incorrect';
  }
  else
    $error['pseudo'] = 'identifiant incorrect';
  if(count($error) == 0)
    $connexion = true;
  if($connexion == true)
  {

    $user_ip = getUserIP();
    $_SESSION['user'] = array(
      'login' => $login,
      'user_ip' => $user_ip
    );
    header('location: index.php');
  }
}

 ?>



 <?php
 include('inc/header.php');
 ?>


<form action="connexion.php" method="post">

  <label>Pseudo</label>
  <input type="text" name="pseudo" value="">
  <span><?php if(!empty($error['psedo'])) echo $error['pseudo']; ?></span>

  <label>Password</label>
  <input type="text" name="password" value="">
  <span><?php if(!empty($error['psedo'])) echo $error['password']; ?></span>

  <input type="submit" name="send" value="Connexion">

</form>



 <?php
include('inc/footer.php');
  ?>
