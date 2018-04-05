<?php
include('pdo.php');

function is_login_ok($login)
{
  if(!empty($login))
  {
    if(strlen($login)<5)
    {
      return 'Identifient trop court';

    }
    elseif(strlen($login)>50)
    {
      return 'Identifient trop court';
    }
  }
  else
  {
    return 'Veuillez entrer un Identifient';
  }
}


function is_mail_ok($mail)
{
  if(!empty($mail))
  {
    if(strlen($mail)<5)
    {
      return 'Email trop court';
    }
    elseif(strlen($mail)>100)
    {
      return 'Email trop long';
    }
    elseif(!filter_var($value, FILTER_VALIDATE_EMAIL))
    {
      return 'Veuillez renseigner une adresse email valide';
    }
  }
  else
  {
      return 'Veuillez entrer un Email';
  }
}

function is_password_ok($password, $pass)
{
  if(!empty($password))
  {
    if (strlen($password<5))
    {
      return 'Password trop court';
    }
    elseif (strlen($password>100))
    {
      return 'Password trop long';
    }
    elseif($password != $pass)
    {
      return 'Password doit êtes identique';
    }
  }
  else
  {
    return 'Veuillez saisir un password';
  }
}

function creatToken()
{
  $char = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $mot_de_passe = str_shuffle($char);
  $mot_de_passe = substr($mot_de_passe ,0, 50);
  return $mot_de_passe;
}

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

function islog($var, $pdo)
{
  if(!empty($var['user']['id']))
  {
    $sql = "SELECT * FROM users WHERE id= :id";
    $query=$pdo->prepare($sql);
    $query->bindValue(':id', $var['user']['id'], PDO::PARAM_INT);
    $query->execute();
    $user=$query->fetch();

    if($var['user']['user_ip'] == getUserIP() && !empty($user))
    {
      return true;
    }
  }
  else
  {
  return false;
  }
}

function add_to_see($pdo, $user, $movie, $movies_users)
{
  echo 'ajouté';
  if(!empty($movies_users))
  {
    $sql = "UPDATE movies_users SET status=1 WHERE user_id= :user AND movie_id= :movie_id";
    $query=$pdo->prepare($sql);
    $query->bindValue(':user', $user['user']['id'], PDO::PARAM_INT);
    $query->bindValue(':movie_id', $movie['id'], PDO::PARAM_INT);
    $query->execute();
  }
  else
  {
    $sql = "INSERT INTO movies_users(user_id, movie_id, status) VALUES (:user,:movie_id, 1)";
    $query=$pdo->prepare($sql);
    $query->bindValue(':user', $user['user']['id'], PDO::PARAM_INT);
    $query->bindValue(':movie_id', $movie['id'], PDO::PARAM_INT);
    $query->execute();
  }
}

function dell_to_see($pdo, $user, $movie)
{
  echo 'supprimer';
  $sql = "UPDATE movies_users SET status=0 WHERE user_id= :user AND movie_id= :movie_id";
  $query=$pdo->prepare($sql);
  $query->bindValue(':user', $user['user']['id'], PDO::PARAM_INT);
  $query->bindValue(':movie_id', $movie['id'], PDO::PARAM_INT);
  $query->execute();
}
