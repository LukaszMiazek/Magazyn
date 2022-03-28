<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>klient</title>
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
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
?>

<form action="klient.php" method="post">
<br>
		ZAREJESTRUJ SIĘ!
		<br>
		Login:
		<br>
		<input type="text" name="login" required>
		<br>
		Hasło:
		<br>
		<input type="password" name="haslo"	required>
		<br>
		Imie:
		<br>
		<input type="text" name="imie" required>
		<br>
		Nazwisko:
		<br>
		<input type="text" name="nazwisko" required>
		<br>
		<input type="submit" value="Utwórz konto">
</form>


<form action="klient.php" method="post">
<br>
		LOGOWANIE
		<br>
		Login:
		<br>
		<input type="text" name="log" required>
		<br>
		Hasło:
		<br>
		<input type="password" name="has"	required>
		<br>
		<input type="submit" value="Zaloguj się">
</form>

<?php
require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );

if (isset ($_POST['login']))
{
$lo=$_POST ['login'];
$ha=$_POST ['haslo'];
$im=$_POST ['imie'];
$na=$_POST ['nazwisko'];

$klient = R::dispense( 'klient' );
$klient->login=$lo;
$klient->haslo=$ha;
$klient->imie=$im;
$klient->nazwisko=$na;
$id = R::store( $klient );   
}

if (isset ($_POST['log']))
{
$log=$_POST ['log'];
$has=$_POST ['has'];

	$result = mysqli_query($conn, "SELECT * FROM klient WHERE LOGIN = '$log' AND HASLO = '$has'");
	$row = mysqli_fetch_assoc($result);
	if ($row != 0)
	{
		$_SESSION['login'] = $row['login'];
		header ('location:sklep.php');
		exit;
	}
}

?>

</body>
</html>