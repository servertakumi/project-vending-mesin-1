<?php include('./config/db.php'); ?>

<?php if (!isset($_SESSION['admin'])){
  header('Location: login');  
  exit;}
?>

<!-- file header -->
<?php include('./layouts/header.php'); ?>

<!-- [ Pre-loader ] End -->
<!-- [ Sidebar Menu ] start -->
<!-- file navbar -->
<?php include('./layouts/navbar.php'); ?>




    
    <!-- End Navbar -->
          <?php

          if (isset($_GET['page'])) {
          $page = $_GET['page']; // $_Get adalah super global untuk mengambil data dari url bentuk array
          } else {
          $page = 'home';
          }
          if (isset($_GET['view'])) {
          $view = $_GET['view'];
          } else {
          $view = 'index';
          }
          $feature = "./features/$page/$view.php";

          // cek file nya beneran ada apa tidak
          if (file_exists($feature)) { // file exists itu untuk mengecek apakah path dan file beneran ada apa tidak
          include($feature);
          } else {
          include('./404.php');
          }

          ?>

        
  <!-- content-wrapper ends -->
  <!-- partial:../../partials/_footer.html -->




  <!-- [ Sidebar Menu ] end -->
  <!-- [ Header Topbar ] start -->

  <!-- partial:../../partials/_navbar.html -->

  <!-- partial -->

  <!-- content-wrapper ends -->
  <!-- partial:../../partials/_footer.html -->




  <?php include('./layouts/footer.php'); ?>


  <!-- [] -->