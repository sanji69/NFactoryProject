<?php
session_start();
include('inc/pdo.php');
include('inc/function.php');

$error= array();

if(!empty($_GET['slug']))
{
  $slug = trim(strip_tags($_GET['slug']));
  $sql= "SELECT * FROM movies_full WHERE slug= :slug";
  $query= $pdo->prepare($sql);
  $query->bindValue(':slug', $slug,PDO::PARAM_STR);
  $query->execute();
  $movie=$query->fetch();
  if (empty($movie))
  {
    header('location: 404.php');
  }
  if(!empty($_POST['send']))
  {
    $note = trim(strip_tags($_POST['note']));
    $user_id = $_SESSION['user']['id'];
    $movie_id = $movie['id'];
    if($note > 100 || $note <0)
    {
      $error['note']= 'ne peux être inférieur a 0 ou supperieur a 100';
    }
    if(count($error) == 0)
    {
      $sql= "SELECT * FROM movies_users WHERE user_id= :user AND movie_id= :movie";
      $query=$pdo->prepare($sql);
      $query->bindValue(':user', $user_id,PDO::PARAM_INT);
      $query->bindValue(':movie', $movie_id,PDO::PARAM_INT);
      $query->execute();
      $movie_user=$query->fetch();
      if(!empty($movie_user))
      {
        $sql = "UPDATE `movies_users` SET `note`= :note WHERE user_id= :user AND movie_id= :movie";
        $query= $pdo->prepare($sql);
        $query->bindValue(':user', $user_id,PDO::PARAM_INT);
        $query->bindValue(':movie', $movie_id,PDO::PARAM_INT);
        $query->bindValue(':note', $note,PDO::PARAM_INT);
        $query->execute();
        // echo 'noté update succes';
      }
      else
      {
        $sql= "INSERT INTO `movies_users`(`user_id`, `movie_id`, `note`) VALUES (:user_id, :movie_id, :note)";
        $query= $pdo->prepare($sql);
        $query->bindValue(':user_id', $user_id,PDO::PARAM_INT);
        $query->bindValue(':movie_id', $movie_id,PDO::PARAM_INT);
        $query->bindValue(':note', $note,PDO::PARAM_INT);
        $query->execute();
        // echo 'noté avec succes';
      }
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

<div class="affichage">
  <ul>
    <?php
        echo '<img src="posters/' .$movie['id']. '.jpg" alt="poster de ' .$movie['title']. '"/>';
        echo '<li> Titre : ' .$movie['title']. '</li>';
        echo '<li> Année de sortie : ' .$movie['year']. '</li>';
        echo '<li> Genre : ' .$movie['genres']. '</li>';
        echo '<li> Synopsis : ' .$movie['plot']. '</li>';
        echo '<li> Producteurs : ' .$movie['directors']. '</li>';
        echo '<li> Acteur : ' .$movie['cast']. '</li>';
        echo '<li> Durée : ' .$movie['runtime']. '</li>';
        echo '<li> MPAA :' .$movie['mpaa']. '</li>';
        echo '<li> Note : ' .$movie['rating']. '</li>';
        echo '<li> Popularité : ' .$movie['popularity']. '</li>';

     ?>
  </ul>
</div>

<div class="note">

<?php
  if(islog($_SESSION) == true)
  {
    $sql = "SELECT * FROM movies_users WHERE user_id= :user_id AND movie_id= :movie_id";
    $query=$pdo->prepare($sql);
    $query->bindValue(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
    $query->bindValue(':movie_id', $movie['id'], PDO::PARAM_INT);
    $query->execute();
    $movies_users=$query->fetch();

    // echo 'connection BDD movies_users succes';

    if(!empty($movies_users) && $movies_users['status'] == 1)
    {
      echo '<a href="panier.php?status=2&&slug='. $_GET['slug']. '"><input type="submit" value="Retirer"></a>';
    }
    else
    {
      echo '<a href="panier.php?status=1&&slug='. $_GET['slug'].'"><input type="submit" value="Ajouter"></a>';
    }
    if(empty($movies_users['note']))
    {
      echo '<form action="detail.php?slug=' . $_GET['slug']. '" method="post">
        <label>Note</label>
        <input type="number" name="note" value="">
        <input type="submit" name="send" value="Noter" min="0" max="100">';
      echo  '<span>';
      if(!empty($error))
      {
        echo $error['note'];
      }
      echo '</span>';
      echo '</form>';
    }
  }
 ?>
</div>



 <?php
include('inc/footer.php');
