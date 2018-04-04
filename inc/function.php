<?php

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
