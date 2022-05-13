<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css"/>
    <title>1</title>
</head>
<body>
<?php
session_start();

	echo '<m1>Zalogowany jest ';
	echo $_SESSION['stanowisko'];
	echo ' ';
	echo $_SESSION['login'];
	echo '</m1>';

require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );

	$tow = R::dispense( 'towar' );
	$tow->nazwa = "nazwa";
	$tow->kategoria = 1;
	$tow->cena = 222;
	$tow->opis = "TAK";
	$tow->kod = "???";
	$id = R::store( $tow );
	
	$tow = R::load( 'towar', $id);
	$kat = R::load( 'kategoria', $tow->kategoria);
	
	if(!empty($kat))
	{
	
	echo "<br>";
	echo "kat: ";
	echo $kat->id;
	
	$kod=substr($kat->nazwa,0,3);
	
	echo "<br>";
	
	echo "kod: ";
	echo $kod; 
	echo "<br>";
	
	echo "kod2: ";
	$kod = $kod.strval($tow->id);
	echo $kod;
	
	$tow->kod = $kod;
	
	R::store( $tow );
	}
	else
	{
		echo "Nie działa";
	}

	
?>
</body>
</html>



