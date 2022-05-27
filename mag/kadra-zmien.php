<?php
ini_set( 'display_errors', 'Off' ); 
?>
<br>
<br>
<b class="nag"></b>
<br>
<br>
<?php
session_start();
//print_r($_POST);

$conn = mysqli_connect("localhost", "root", "", "magazyn");

if (mysqli_connect_errno()) {
 echo "Błąd połączenia nr: " . mysqli_connect_errno();
 echo "Opis błędu: " . mysqli_connect_error();
 exit();
}

mysqli_query($conn, 'SET NAMES utf8');
mysqli_query($conn, 'SET CHARACTER SET utf8');
mysqli_query($conn, "SET collation_connection = utf8_polish_ci");

$idu = $_POST['idu'];

if (isset ($_POST['upr']))
{
	echo 'x';
	if ($_POST['upr']==1) $result = mysqli_query($conn, "UPDATE `pracownik` SET `STANOWISKO` = 'Magazynier' WHERE `ID_PRACOWNIKA` = ".$idu);
	else if ($_POST['upr']==2) $result = mysqli_query($conn, "UPDATE `pracownik` SET `STANOWISKO` = 'KSIEGOWY' WHERE `ID_PRACOWNIKA` = ".$idu);
	else if ($_POST['upr']==3) $result = mysqli_query($conn, "UPDATE `pracownik` SET `STANOWISKO` = 'Kompleter' WHERE `ID_PRACOWNIKA` = ".$idu);
	else if ($_POST['upr']==4) $result = mysqli_query($conn, "UPDATE `pracownik` SET `STANOWISKO` = 'Pakowacz' WHERE `ID_PRACOWNIKA` = ".$idu);
}

if (isset ($_POST['blok']))
{
	$blok=$_POST['blok'];
	
	echo $blok;
	echo '<br>';
	echo $idu;
	
	if($blok == 0) 
	{
		$result = mysqli_query($conn, "UPDATE `pracownik` SET `BLOKADA` = '1' WHERE `ID_PRACOWNIKA` = ".$idu);
		
		echo "UPDATE pracownik SET BLOKADA = '1' WHERE 'ID_PRACOWNIKA' = ".$idu;
	}
	else 
	{
	$result = mysqli_query($conn, "UPDATE pracownik SET `BLOKADA` = '0' WHERE `ID_PRACOWNIKA` = ".$idu);
	
	echo "UPDATE pracownik SET BLOKADA = '0' WHERE 'ID_PRACOWNIKA' = ".$idu;
	}
}

	header ('location:kadra.php?edit='.$usr);
	exit;
?>

