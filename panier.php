<?php
session_start();
include('inc/function.php');
include('inc/pdo.php');
// echo 'ici';
if(!empty($_GET['status']) && is_numeric($_GET['status']))
{
  // echo 'welcome';
  $sql= "SELECT * FROM movies_full WHERE slug= :slug";
  $query= $pdo->prepare($sql);
  $query->bindValue(':slug', $_GET['slug'],PDO::PARAM_STR);
  $query->execute();
  $movie=$query->fetch();

  $sql = "SELECT * FROM movies_users WHERE user_id= :user_id AND movie_id= :movie_id";
  $query=$pdo->prepare($sql);
  $query->bindValue(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
  $query->bindValue(':movie_id', $movie['id'], PDO::PARAM_INT);
  $query->execute();
  $movies_users=$query->fetch();

  if($_GET['status'] == 1)
  {
    add_to_see($pdo, $_SESSION, $movie, $movies_users);
    // echo 'succes add';
    header('location: detail.php?slug=' . $_GET['slug']);
  }
  elseif ($_GET['status'] == 2)
  {
    dell_to_see($pdo, $_SESSION, $movie);
    // echo 'succes dell';
    header('location: detail.php?slug=' . $_GET['slug']);
  }
  else
  {
    // echo '404';
    header('location: 404.php');
  }
}
else
{
  // echo 'fail 404';
  header('location: 404.php');
}
