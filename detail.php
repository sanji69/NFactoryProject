<?php
session_start();
include('inc/pdo.php');
include('inc/function.php');

if(!empty($_GET['id']) && is_numeric($_GET['id']))
{
  $sql= "SELECT * FROM movies_full WHERE id= :id";
  $query= $pdo->prepare($sql);
  $query->bindValue(':id', $_GET['id'],PDO::PARAM_INT);
  $query->execute();
  $movie=$query->fetch();
  if (empty($movie))
  {
    header('location: 404.php');
  }
}
else
  header('location: 404.php');
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




 <?php
include('inc/footer.php');
