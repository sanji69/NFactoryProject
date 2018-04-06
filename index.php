<?php
session_start();
include('inc/pdo.php');
include('inc/function.php');


$sql = "SELECT * FROM movies_full WHERE 1 LIMIT 16";
$query=$pdo->prepare($sql);
$query->execute();
$movies=$query->fetchALL();
?>

<?php
include('inc/header.php');
?>
<!-- <div class="container-fluid">
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-40" src="posters/13286.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-40" src="posters/13288.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-40" src="posters/13296.jpg" alt="Third slide">
    </div>
  </div>
</div>
</div> -->
<div class="container-fluid">
 <div class="container-fluide">
</div>
  <?php foreach ($movies as $movie)
  {
    echo '<a href="detail.php?slug=' .$movie['slug']. '"><img src="posters/' .$movie['id']. '.jpg" alt="' .$movie['title']. '"/></a>';
  } ?>
</div>
  <div class="container">

</img>
</div>
<div class="footer">
<button class="btn btn-danger"type="button" class="submit"> + de Films! </button>
  </div>

  <script language="JavaScript">Images_Aleatoire();</script>


  <?php
  include('inc/footer.php');
