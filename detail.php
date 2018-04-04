<?php
include('inc/pdo.php');
include('inc/function.php');

if(!empty($_GET['id']) && is_numeric($_GET['id']))
{
  $sql= "SELECT * FROM movies_full WHERE id= :id";
  $query= $pdo->prepare($sql);
  $query->bindValue(':id', $_GET['id'],PDO::PARAM_INT);
  $query->execute();
  $movie=$query->fetch();
}
else
  header('location: index.php');
 ?>



 <?php
 include('inc/header.php');

 ?>

<div class="affichage">
  <ul>
    <?php foreach ($movie as $value)
    {
      if ($value == $_GET['id'])
        echo '<img src="posters/' .$value. '.jpg" alt="poster de ' .$movie['title']. '"/>';
      else
        echo '<li>' .$value. '</li>';
    } ?>
  </ul>
</div>




 <?php
include('inc/footer.php');
  ?>
