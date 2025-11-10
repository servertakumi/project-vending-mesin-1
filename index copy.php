<?php include('./config/db.php'); ?>
<!-- file header -->
<?php include('./layouts/header.php'); ?>

<!-- file navbar -->
<?php include('./layouts/navbar.php'); ?>
<!-- include adalah sebuah fungsi untuk memanggil file dan menempelkannya di file lainnya -->

<!-- feature -->

<?php

if (isset($_GET['page'])){
    $page = $_GET['page']; // $_Get adalah super global untuk mengambil data dari url bentuk array
}else{
    $page ='home';
}
if (isset($_GET['view'])){
    $view = $_GET['view'];
}else {
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


<!-- file footer -->
<?php include('./layouts/footer.php'); ?>