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

echo 'Zalogowno jako '.$_SESSION['login'].' ';
echo '<br>';


?>
<form action="klient.php" method="post">

	<input type="hidden" name="wlog"	required>
	<button type="submit">Wyloguj się</button>

</form>
<?php
echo '<br>';
echo '<a href="koszyk.php">Koszyk</a>';
echo '<br>';
echo '<br>';

require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );


echo '<a href="sklep.php">Wszystko </a>';
$kt = R::getAll( 'SELECT DISTINCT kategoria FROM towar' );
foreach ($kt as $kat)
{
	echo '<a href="sklep.php?kat=';
	echo $kat['kategoria'];
	echo '">';
    echo $kat['kategoria'];
	echo ' </a>';
}
?>

<form action="sklep.php" method="get">
  <?php
  if (isset ($_GET['kat']))
  {
	echo '<input type="hidden" name="kat" value=';
	echo $_GET['kat'];
	echo '>';
  }
  ?>
  <input type="text" name="naz">
  <input type="submit" value="Szukaj">
</form>

<?php

echo '<table>';

if (isset ($_GET['kat'])) $wkat= '%'.$_GET['kat'].'%';
else $wkat='%%';
if (isset ($_GET['naz'])) $wnaz= '%'.$_GET['naz'].'%';
else $wnaz='%%';


$tw = R::find('towar', ' kategoria LIKE ? AND nazwa like ?', [$wkat,$wnaz] );
foreach ($tw as $towar){
	echo '<tr>';
	echo '<td>';
    //echo $towar->nazwa.' ';
	echo '<a href="sklep.php?tow=';
	echo $towar->id;
	if (isset ($_GET['kat']))
	{
		echo '&kat=';
		echo $_GET['kat'];
	}
	if (isset ($_GET['naz']))
	{
		echo '&naz=';
		echo $_GET['naz'];
	}
	echo '">';
	echo $towar->nazwa;
	echo '</a>';
	echo ' '.$towar->cena;
	echo '</td>';
	echo '</tr>';
}
echo '</table>';

echo '<br><br>';

if (isset ($_POST['tid']))
{
	$zamis = R::findOne('zamowienie', 'id_klienta = ? AND status = 0', [$_SESSION['id']]);
	if (empty($zamis)) 
	{
		$zam = R::dispense( 'zamowienie' );
		$zam->id_klienta = $_SESSION['id'];
		$zam->status = 0;
		$id = R::store( $zam ); 
		
		$zamis = R::findOne('zamowienie', 'id_klienta = ? AND status = 0', [$_SESSION['id']]);
    } 
	 
	$idzam = $zamis->id; 
	
	$sklad = R::dispense( 'sklad' );
	$sklad->id_zam = $idzam;
	$sklad->towar = $_POST['tid'];
	$sklad->ilosc = $_POST['tile'];
	R::store( $sklad ); 
	
}

if (isset ($_GET['tow']))
{
	$id= $_GET['tow'];
	$towar = R::findONE('towar', 'id=?', [$id]);
	
	echo $towar->nazwa;
	echo '<br>';
	echo $towar->cena;
	echo '<br>';
	echo $towar->opis;
	echo '<br>';
	?>
	
		<form action="" method="post">
		<input type="hidden" name="tid" value="<?php echo $towar->id ?>"required>
		<input type="number" name="tile" value="1" required>
		<input type="submit" value="Kup">
		</form>
	
	<?php
}
?>

</form>
</body>
</html>