<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>sklep</title>
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
<?php
session_start();
echo 'Zalogowno jako '.$_SESSION['login'];
?>
<form action="klient.php" method="post">

	<input type="hidden" name="wlog"	required>
	<button type="submit">Wyloguj się</button>

</form>
<?php
echo '<br><br>';
echo '<a href="Sklep.php">Sklep</a>';
echo '<br>';
echo '<br>';

require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );

if (isset ($_POST['zloz']))
{
	$t = R::load( 'zamowienie', $_POST['zloz']);
	$t->status = 1;
	$t->data = date("Y-m-d");
	R::store( $t ); 
}

if (isset ($_POST['zid']))
{
	$zamid=$_POST ['zid'];
	$towid=$_POST ['tid'];
	$t = R::findOne( 'sklad', "id_zam = ? AND towar = ?", [ $zamid , $towid ] );
	R::trash($t);

	$ti = R::findOne( 'sklad', "id_zam = ? ", [ $zamid ] );
	if (empty($ti))
	{
		$kill = R::findOne( 'zamowienie', "id = ?", [ $zamid ] );
		R::trash($kill);
	}
}

$zamis = R::findOne('zamowienie', 'id_klienta = ? AND status = 0', [$_SESSION['id']]);

//echo $zamis->id;

if (empty($zamis)) 
{
	echo 'Koszyk jest pusty';
}
else
{
	echo 'Zawartość koszyka: ';
	echo '<br>';
	
	$tw = R::find('sklad', ' id_zam = ?', [$zamis->id] );
	$suma=0;
	foreach ($tw as $towar){
		//echo $towar->towar;
		
		$t = R::findOne( 'towar', 'id=?', [$towar->towar] );

		echo $towar->ilosc;
		echo 'x ';
		echo $t['nazwa'];
		echo ' ';
		echo $t['cena'];
		
		?>
		<form action="" method="post">
		<input type="hidden" name="zid" value="<?php echo $zamis->id?>"required>
		<input type="hidden" name="tid" value="<?php echo $towar->towar?>"required>
		<input type="submit" value="Usuń">
		</form>
		<?php
		
		
		$suma=$suma+$t['cena']*$towar->ilosc;
	}
	
	echo '<br>';
	echo 'Suma: ';
	echo number_format($suma, 2);
	
	?>
		<form action="" method="post">
		<input type="hidden" name="zloz" value="<?php echo $zamis->id; ?>" required>
		<input type="submit" value="Złóż zamówienie">
		</form>
	<?php
}

echo '<br>';
echo '<br>';

$zaakt= R::findAll('zamowienie', 'id_klienta = ? AND status != 0', [$_SESSION['id']]);
//echo $zamis->id;
if (empty($zaakt)) 
{
	echo 'Nie masz żadnych aktywnych zamówień';
}
else
{
	echo 'Twoje zamówienia:';
	echo '<br>';
	echo '<br>';
	
	foreach ($zaakt as $zam)
	{
		echo 'Zamówienie numer: ';
		echo $zam->id;
		echo '<br>';
		echo 'Data złożenia zamówienia: ';
		echo $zam->data;
		echo '<br>';
		echo 'Status zamówienia: ';
		
		switch ($zam->status) {

    case 1:
        echo "Przyjęte";
        break;
    case 2:
        echo "W trakcie realizacji";
	case 3:
        echo "Zakończone";
}
	echo '<br>';
	echo '<br>';
		
		//echo $zam->status;
		
		echo 'Skład zamówienia: ';
		echo '<br>';
		
		$zam = R::find('sklad', ' id_zam = ?', [$zam->id] );
		$suma=0;
		foreach ($zam as $towar){
			
			$t = R::findOne( 'towar', 'id=?', [$towar->towar] );

			echo $towar->ilosc;
			echo 'x ';
			echo $t['nazwa'];
			echo ' ';
			echo $t['cena'];
			echo '<br>';
			
			$suma=$suma+$t['cena']*$towar->ilosc;
		}
		
		echo '<br>';
		echo 'Suma: ';
		echo number_format($suma, 2);
		echo '<br>';
		echo '<br>';
		
	}
}

?>
</body>
</html>