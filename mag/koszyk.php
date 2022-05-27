<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Koszyk</title>
	<link rel="stylesheet" type="text/css" href="style_koszyk.css">
	<meta name="viewport"  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"/> 
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
 
</head>
<body>
<div class="container">
	<div class="nav">
		<?php
			echo '<div class="logo">';
				echo '<i class="fa-solid fa-coins"></i>';
				echo '<h2>magazyn/koszyk</h2>';
			echo '</div>';
		session_start();
			echo '<div class="nav_panel">';

				echo 'Zalogowno jako '.$_SESSION['login'];
				?>
					<form action="klient.php" method="post">

						<input type="hidden" name="wlog"	required>
						<div class="wyloguj">
							<button type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj </button>
						</div>
					</form>
			
					<?php
							
				echo '<a href="Sklep.php"><i class="fa-solid fa-shop"></i> Sklep</a>';
			echo '</div>';
	echo '</div>';








require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );

if (isset ($_POST['zloz']))
{
	if ( !preg_match('/^[0-9]{2}-?[0-9]{3}$/Du', $_POST['zloz']) ) 
	{
		?>
		<script>
			alert("Niepoprawny kod pocztowy")
		</script>
		<?php
	}
	else
	{
	$t = R::load( 'zamowienie', $_POST['zloz']);
	$t->status = 1;
	$t->miejscowosc = $_POST['mie'];
	$t->kod_pocztowy = $_POST['kod'];
	$t->ulica= $_POST['ul'];
	$t->numer_domu = $_POST['nr'];
	$t->data = date("Y-m-d");
	R::store( $t ); 
	}
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
echo '<div class="panel">';
if (empty($zamis)) 
{
	echo '<h1>Koszyk jest pusty</h1>	';
}
else
{
	echo '<h1>Zawartość koszyka </h1>';
	echo '<br>';
	$tw = R::find('sklad', ' id_zam = ?', [$zamis->id] );
	$suma=0;
	foreach ($tw as $towar){
		//echo $towar->towar;
		
		echo '<div class="towar">';
		$t = R::findOne( 'towar', 'id=?', [$towar->towar] );
			
		echo '<img src = "Zdjecia/';
		echo $t->id; 
		echo '.png " width="50" height="50" alt=" " ></a>';

		echo'<h2>';
		echo $t['nazwa'];
		echo'</h2>';
		echo'<h3>';
		echo $towar->ilosc;
		echo'</h3>';
		echo'<h3>';
		echo $t['cena'];
		echo ' zł';
		echo'</h3>';
		
		
		?>
		<form action="" method="post">
		<input type="hidden" name="zid" value="<?php echo $zamis->id?>"required>
		<input type="hidden" name="tid" value="<?php echo $towar->towar?>"required>
		<button type="submit" class="fa-solid fa-xmark">
		</form>
		<?php
		
		
		$suma=$suma+$t['cena']*$towar->ilosc;
		echo'</div>';
	}
	echo '<br>';
	echo '<div class="suma">';
	echo '<div class="suma_suma">';
	echo '<h2>Suma </h2>';
	echo number_format($suma, 2);
	echo ' zł';
	echo '</div>';
	
	?>
		<form action="" method="post">
		<br>Miejscowość
		<input type="text" name="mie" required>
		<br>Kod Pocztowy
		<input type="text" name="kod" required>
		<br>Ulica
		<input type="text" name="ul" required>
		<br>Numer domu
		<input type="text" name="nr" required>
		<br><br>
		<input type="hidden" name="zloz" value="<?php echo $zamis->id; ?>" required>
		<input type="submit" value="Złóż zamówienie">
		</form>
</div>
</div>
	<?php
}

echo '<br>';
echo '<br>';

	
echo '<div class="podsumowanie">';

$zaakt= R::findAll('zamowienie', 'id_klienta = ? AND status != 0', [$_SESSION['id']]);
//echo $zamis->id;
if (empty($zaakt)) 
{
	echo 'Nie masz żadnych aktywnych zamówień';
}
else
{
	echo '<h1>Historia zamówień</h1>';
	
	foreach ($zaakt as $zam)
	{
		echo '<div class="historia">';
		echo '<h3>';
		echo 'Zamówienie numer: ';
		echo $zam->id;
		echo '</h3>';
		echo 'Data złożenia zamówienia: ';
		echo $zam->data;
		echo '<br>';
		echo 'Miejscowość: ';
		echo $zam->miejscowosc;
		echo ' (';
		echo $zam->kod_pocztowy;
		echo ')';
		echo '<br>';
		echo 'Addes: ';
		echo $zam->ulica;
		echo ' ';
		echo $zam->numer_domu;
		echo '<br>';
		echo 'Status zamówienia: ';
		
		switch ($zam->status) {

    case 1:
        echo "Przyjęte";
        break;
    case 2:
        echo "W trakcie realizacji";
	case 3:
        echo "Skompletowane";
	case 4:
        echo "W trakcie realizacji";
	case 5:
        echo "Wysłane";
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
		echo '<h3>';
		echo 'Suma: ';
		echo number_format($suma, 2);
		echo ' zł';
		echo '</h3>';
		echo '<br>';
		echo '</div>';
	}
}
	echo '</div>';

?>
</div>
</body>
</html>
