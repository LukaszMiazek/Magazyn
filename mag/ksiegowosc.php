<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Ksiegowosc</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
<header>
<?php
session_start();
require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );

echo 'Zalogowno jako '.$_SESSION['login'];
echo '<br>';
?>
<form action="index.php" method="post">

	<input type="hidden" name="wlog"	required>
	<button type="submit">Wyloguj się</button>

</form>
</header>
<div class="form3">
<div class="tab-content">
<?php

echo '<a class="guzik2" href="ksiegowosc.php">Wszystko </a>';
$kt = R::getAll( 'SELECT DISTINCT kategoria FROM towar' );
foreach ($kt as $kat)
{
	echo '<a class="guzik2" href="ksiegowosc.php?kat=';
	echo $kat['kategoria'];
	echo '">';
    echo $kat['kategoria'];
	echo ' </a>';
}
?>

<form action="ksiegowosc.php" method="get">
  <?php
  if (isset ($_GET['kat']))
  {
	echo '<input type="hidden" name="kat" value=';
	echo $_GET['kat'];
	echo '>';
  }
  ?>
  <input type="text" name="naz">
  <button type="submit" value="Szukaj">Szukaj</button>
</form>
</div>
</div>

<div class="form2">
<div class="tab-content">
<?php

if (isset ($_POST['nazwa']))
{
$tow = R::dispense( 'towar' );
$tow->nazwa = $_POST['nazwa'];
$tow->kategoria = $_POST['kategoria'];
$tow->cena = $_POST['cena'];
$tow->opis = $_POST['opis'];
$id = R::store( $tow ); 
}

if (isset ($_POST['idd']))
{
$id=$_POST ['idd'];
$t = R::findOne( 'towar', 'id=?',array($id));
R::trash($t);
}

if (isset ($_POST['nazwae']))
{
$ide=$_POST ['ide'];
$t = R::load( 'towar', $ide);
$t->nazwa = $_POST['nazwae'];
$t->kategoria = $_POST['kategoriae'];
$t->cena = $_POST['cenae'];
$t->opis = $_POST['opise'];
R::store( $t ); 
}

echo '<table class="tablee" width="400">';
echo '<form action="ksiegowosc.php" method="post">';

if (isset ($_GET['kat'])) $wkat= '%'.$_GET['kat'].'%';
else $wkat='%%';
if (isset ($_GET['naz'])) $wnaz= '%'.$_GET['naz'].'%';
else $wnaz='%%';


$tw = R::find('towar', ' kategoria LIKE ? AND nazwa like ?', [$wkat,$wnaz] );
	echo '<thead>';
	echo '<tr>';
	echo '<td>';
	echo 'Nazwa';
	echo '</td>';
	echo '<td>';
	echo 'Cena';
	echo '</td>';
	echo '</tr>';
	echo '</thead>';
	foreach ($tw as $towar){
		echo '<tr>';
		echo '<td>';
		echo $towar->nazwa.' ';
		echo '</td>';
		echo '<td>';
		echo $towar->cena.' ';
		echo '</td>';
		$idt=$towar->id;
		
		echo '<td>';
		echo '<button type="submit" name="edit" value=';
		echo $idt;
		echo '>Edytuj</button>';
		echo '</td>';
		echo '</tr>';
}
echo '</table>';
echo '</form>';

if (isset ($_POST['edit']))
{
$e=$_POST ['edit'];
$t = R::findOne( 'towar', 'id=?',array($e));
$id = $e;
$nazwa = $t['nazwa'];
$kategoria = $t['kategoria'];
$cena = $t['cena'];
$opis = $t['opis'];
?>

</div>
	<form action="ksiegowosc.php" method="post">
	<div class="tab-content">
		<h1>Nazwa:</h1>
			<input type="text" name="nazwae" value=<?php echo $nazwa ?> required>
		<h1>Kategoria:</h1>
			<input type="text" name="kategoriae" value=<?php echo $kategoria ?> required>
		<h1>Cena:</h1>
			<input type="number" name="cenae" value=<?php echo $cena ?> required>
		<h1>Opis:</h1>
			<input type="text" name="opise" value="<?php echo $opis ?>" required>
			<input type="hidden" name="ide" value=<?php echo $id ?> required>
			<button type="submit" value="Edytuj">Edytuj</button>
		</form>

		<br>
		<form action="ksiegowosc.php" method="post">
		<input type="hidden" name="idd" value=<?php echo $id ?> required>
		<div class="czerwony">
		<button type="submit" value="Usuń">Usuń</button>
		</div>
		</form>
		<a class="guzik" href="ksiegowosc.php">Anuluj</a>
	</div>
<?php
}
else
{
?>

<div class="tab-content">
<form action="ksiegowosc.php" method="post">
		<h1>Nazwa:</h1>
		<input type="text" name="nazwa" required>
		<h1>Kategoria:</h1>
		<input type="text" name="kategoria" required>
		<h1>Cena:</h1>
		<input type="number" name="cena" required>

		<h1>Opis:</h1>
		<input type="text" name="opis" required>
		<button type="submit" value="dodaj">Dodaj</button>
</form>
</div>
<?php
}
?>

</body>
</html>