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

$lo=$_POST ['login'];
$ha=$_POST ['haslo'];
$im=$_POST ['imie'];
$na=$_POST ['nazwisko'];
$st=$_POST ['stanowisko'];

mysqli_query($conn, "INSERT INTO `pracownik` (`ID_PRACOWNIKA`, `IMIE`, `NAZWISKO`, `STANOWISKO`, `DATA_ZATRUDNIENIA`, `HASLO`, `LOGIN`, `BLOKADA`) 
VALUES (NULL, '$im', '$na', '$st' , now(), '$ha', '$lo', '0')");

echo "INSERT INTO `pracownik` (`ID_PRACOWNIKA`, `IMIE`, `NAZWISKO`, `STANOWISKO`, `DATA_ZATRUDNIENIA`, `HASLO`, `LOGIN`, `BLOKADA`) 
VALUES (NULL, $im, $na, $st , now(), $ha, $lo, '0')";

header ('location:kadra.php?edit='.$usr);
exit;
?>

