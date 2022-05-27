<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css"/>
    <title>Wysyłka</title>
</head>
<body>
<?php
session_start();

	echo '<m1>Zalogowany jest ';
	echo $_SESSION['stanowisko'];
	echo ' ';
	echo $_SESSION['login'];
	echo '</m1>';
	
?>	
<form action="index.php" method="post">

	<input type="hidden" name="wlog"	required>
	<button type="submit">Wyloguj się</button>
	</div>
</form>	
<?php

require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );

if (isset ($_POST['wys']) )
{
	$r = R::load( 'zamowienie', $_POST['wys']);
	$r->status = 5;
	$r->kosz = null;
	R::store( $r ); 
	
	echo '<div class="info">';
	echo 'Wysłano';
	echo '<a href="wysylka.php"> Powrót </a>';
	echo '</div>';
}
else if (isset ($_POST['numzam']) )
{
	$zamis = R::findOne('zamowienie',' kosz = ? ', [$_POST['numzam']] );
	
	if($zamis['status'] != 3)
	{
		echo '<div class="info">';
		echo 'To zamówienie NIE jest kompletne!';
		echo '<a href="wysylka.php"> Powrót </a>';
		echo '</div>';
	}
	else
	{
		?>
		dane do wysyłki:
		<br>
		Miejscowość: <?php echo $zamis['miejscowosc']; ?> <br>
		Kod Pocztowy: <?php echo $zamis['kod_pocztowy']; ?> <br>
		Ulica: <?php echo $zamis['ulica']; ?> <br>
		Numer domu: <?php echo $zamis['numer_domu']; ?> <br> <br>
		
		<form action="" method="post">
			<input type="hidden" name="wys" value="<?php echo $zamis['id']; ?>" required>
			<input type="submit" value="Zapakuj">
		</form>
		
		<a href="wysylka.php"> Powrót </a>
		<?php
	}
}
else 
{
	echo '<br>';
	echo '<div class="info">';
	?>	
	<form action="" method="post">
	Numer kosza:
		<input type="number" name="numzam" required>
		<input type="submit" value="Zapakuj">
	</form>
	<?php
	echo '</div>';
}



	
?>
</body>
</html>



