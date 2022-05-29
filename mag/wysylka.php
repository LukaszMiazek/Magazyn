<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style_wysylka.css"/>
    <title>Wysyłka</title>
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
session_start();

echo '<div class="logo">';
echo '<i class="fa-solid fa-coins"></i>';
echo '<h2>magazyn/wysyłka</h2>';
echo '</div>';
echo '<div class="nav_panel">';
	echo '<m1>Zalogowany jest ';
	echo $_SESSION['stanowisko'];
	echo ' ';
	echo $_SESSION['login'];
	echo '</m1>';
	
?>	
<form action="index.php" method="post">

	<input type="hidden" name="wlog"	required>
	<button type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj </button>
	</div>
</form>	
<?php
		echo '</div>';

	

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
	
	$w = R::dispense( 'wysylki' );
	$w->id_zam = $_POST['wys'];
	$w->id_prac = $_SESSION['idprac'];
	$w->data = R::isoDateTime();
	$id = R::store( $w );
}
else if (isset ($_POST['numzam']) )
{
	$zamis = R::findOne('zamowienie',' kosz = ? ', [$_POST['numzam']] );
	
	if($zamis['status'] != 3)
	{
		echo '<div class="info">';
		echo '<h2>To zamówienie NIE jest kompletne!</h2>';
		echo '<a href="wysylka.php"> Powrót </a>';
		echo '</div>';
	}
	else
	{
		echo '<div class="panel">';
		?>
		<h1>Dane do wysyłki</h1>
		
	<label>Miejscowość:</label> <?php echo $zamis['miejscowosc']; ?> 
		<label>Kod Pocztowy:</label> <?php echo $zamis['kod_pocztowy']; ?> 
		<label>Ulica:</label> <?php echo $zamis['ulica']; ?>
		<label>Numer domu:</label> <?php echo $zamis['numer_domu']; ?> 
		
		<form action="" method="post">
			<input type="hidden" name="wys" value="<?php echo $zamis['id']; ?>" required>
			<input type="submit" value="Zapakuj">
		</form>
		
		<a href="wysylka.php"> Powrót </a>
		<?php
		echo '</div>';
	}
}
else 
{
	echo '<div class="info">';
	?>	
	<form action="" method="post">
	<label>Numer kosza:</label>
	<div class="info_number">
	<input type="number" name="numzam" required>
	</div>
	<div class="info_button">
	<input type="submit" value="Zapakuj">
		</div>
	</form>
	<?php
	echo '</div>';
}



	
?>
</div>
</body>
</html>



