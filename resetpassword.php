<?php
session_start();
if(!empty($_SESSION))
{
  header('location: index.php');
}

include('inc/pdo.php');
include('inc/function.php');
$error = array();
$connexion = false;

if(!empty($_GET['token']) && !empty($_GET['email']))
{
  if(!empty($_POST['send']))
  {
    $token = trim(strip_tags($_GET['token']));
    $cryptomail = trim(strip_tags($_GET['email']));
    $email = urlencode($cryptomail);

    $sql = "SELECT * FROM users WHERE token = :token AND email= :email";
    $query=$pdo->prepare($sql);
    $query->bindValue(':token', $token, PDO::PARAM_STR);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    $password = trim(strip_tags($_POST['password']));
    $pass = trim(strip_tags($_POST['pass']));

    if(!empty($password) && !empty($pass))
    {
      if($password != $pass)
      {
        $error['password'] = 'les mots de passe doivent être indentique.';
      }
      elseif(strlen($password)<3 || strlen($password>255))
      {
        $error['password'] = 'le mot de passe est trop long ou trop court';
      }
    }
    else
    {
        $error['password'] = 'le champ ne doit pas être vide';
    }

    if(count($error) == 0)
    {
      $connexion = true;
    }
    echo $connexion;
    if($connexion == true)
    {
      $token = creatToken();
      $cryptopassword= password_hash($password, PASSWORD_DEFAULT);

      $sql="UPDATE users SET password= :password, token= :token WHERE id= :id";
      $query=$pdo->prepare($sql);
      $query->bindValue(':token', $token, PDO::PARAM_STR);
      $query->bindValue(':password', $cryptopassword, PDO::PARAM_STR);
      $query->bindValue(':id', $user['id'], PDO::PARAM_INT);
      $query->execute();

      header('location: index.php');
    }
  }
}
else
{
  header('location: 404.php');
}
 ?>


 <?php
 include('inc/header.php');
 ?>


<form action="resetpassword.php?token=<?php echo $_GET['token']. '&&email=' .$_GET['email']?>" method="post">

  <label>Nouveau mot de passe</label>
  <input type="text" name="password" value="">
  <span><?php if(!empty($error['password'])) {echo $error['password'];} ?></span>

  <label>Répéter le mot de passe</label>
  <input type="text" name="pass" value="">

  <input type="submit" name="send" value="Envoyer">

</form>

<?php
include('inc/footer.php');
