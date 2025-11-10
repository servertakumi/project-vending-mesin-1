<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "takumivm";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    echo("koneksi Gagal : ". mysqli_connect_error());
}

session_start();
