<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "magazyn");

if (mysqli_connect_errno()) {
 echo "Błąd połączenia nr: " . mysqli_connect_errno();
 echo "Opis błędu: " . mysqli_connect_error();
 exit();
}

mysqli_query($conn, 'SET NAMES utf8');
mysqli_query($conn, 'SET CHARACTER SET utf8');
mysqli_query($conn, "SET collation_connection = utf8_polish_ci"); 

	echo 'Zalogowno jako '.$_SESSION['login'];

mysqli_close($conn);
?>



