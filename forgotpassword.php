<?php
include('inc/pdo.php');
include('inc/function.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once('vendor/autoload.php');

if(!empty($_SESSION))
{
  header('location: index.php');
}

$error = array();

if(!empty($_POST['send']))
{
  $email = trim(strip_tags($_POST['email']));

  if(!empty($email))
  {
    $sql= "SELECT * FROM users WHERE email= :email";
    $query=$pdo->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    if(!empty($user))
    {
        $cryptoemail = urlencode($email);
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; // or 587
        $mail->IsHTML(true);
        $mail->Username = 'axel.aubry69@gmail.com';
        $mail->Password = "jtflcyxkhajkymwc";
        $mail->SetFrom("axel.aubry69@gmail.com");
        $mail->Subject = "Réinitialisation du mot de passe";
        $mail->Body = 'Lien de récupération du mot de passe : http://localhost/projetGroup/NFactoryProject/resetpassword.php?token=' .$user['token']. ' &&email= ' .$cryptoemail;
        $mail->AddAddress($email);

         if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
         } else {
            echo "Message has been sent";
         }
      	$mail->SmtpClose();
      	unset($mail);
        header('location: index.php');
    }
    else
    {
      $error['email'] = 'cette adresse email n\'existe pas.';
    }
  }
  else
  {
    $error['email'] = 'ce champ ne peux être vide';
  }
}


 ?>

 <?php
include('inc/header.php');
  ?>



<form action="forgotpassword.php" method="post">
  <label>Entrez vôtre adresse email ici</label>
  <input type="text" name="email" value="">
  <span><?php if(!empty($error['email'])) { echo $error['email']; } ?></span>

  <input type="submit" name="send" value="Envoyer">
</form>



  <?php
  include('inc/footer.php');
