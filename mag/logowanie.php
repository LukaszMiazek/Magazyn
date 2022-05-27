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


	$lo=$_POST['login'];
	$ha=$_POST['haslo'];
	//$ha=md5($ha);
	
	$result = mysqli_query($conn, "SELECT * FROM pracownik WHERE LOGIN = '$lo' AND HASLO = '$ha' AND BLOKADA = 0");
	$row = mysqli_fetch_assoc($result);
	if ($row != 0)
	{
	
		$_SESSION['login'] = $row['LOGIN'];
		$_SESSION['stanowisko'] = $row['STANOWISKO'];
		$_SESSION['idprac'] = $row['ID_PRACOWNIKA'];
		
		
		echo '<b>Udało się zalogować! </b>';
		if ($row['STANOWISKO'] == 'Administrator')
		{
			header ('location:kadra.php?edit=');
			exit;
		}
		else if ($row['STANOWISKO'] == 'KSIEGOWY')
		{
			header ('location:ksiegowosc.php');
			exit;
		}
		else if ($row['STANOWISKO'] == 'Magazynier')
		{
			header ('location:uzupelnienia.php?stan=n');
			exit;
		}
		else if ($row['STANOWISKO'] == 'Kompleter')
		{
			header ('location:kompletacja.php?stan=n');
			exit;
		}
		else if ($row['STANOWISKO'] == 'Pakowacz')
		{
			header ('location:wysylka.php');
			exit;
		}

		
	}
	else header ('location:index.php?fail=1');
	//else echo '<b>NIE udało się zalogować! </b>';
	//echo $lo;
	//echo $ha;
	//echo $row['haslo'];

mysqli_close($conn);
?>



