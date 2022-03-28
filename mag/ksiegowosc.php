<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Ksiegowosc</title>
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>


<?php
require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );

if (isset ($_POST['nazwa']))
{
$tow = R::dispense( 'towar' );
$tow->nazwa = $_POST['nazwa'];
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
$t->cena = $_POST['cenae'];
$t->opis = $_POST['opise'];
R::store( $t ); 
}

echo '<table>';
echo '<form action="ksiegowosc.php" method="post">';
$tw = R::findAll('towar');
foreach ($tw as $towar){
	echo '<tr>';
	echo '<td>';
    echo $towar->nazwa.' ';
	echo $towar->cena.' ';
	$idt=$towar->id;
	echo '</td>';
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
$cena = $t['cena'];
$opis = $t['opis'];
?>
	<form action="ksiegowosc.php" method="post">
	Nazwa:
		<br>
		<input type="text" name="nazwae" value=<?php echo $nazwa ?> required>
		<br>
		Cena:
		<br>
		<input type="number" name="cenae" value=<?php echo $cena ?> required>
		<br>
		Opis:
		<br>
		<input type="text" name="opise" value="<?php echo $opis ?>" required>
		<input type="hidden" name="ide" value=<?php echo $id ?> required>
		<br>
		<input type="submit" value="edytuj">
	</form>
	<br>
	<form action="ksiegowosc.php" method="post">
	<input type="hidden" name="idd" value=<?php echo $id ?> required>
	<input type="submit" value="usun">
	</form>
	<a href="ksiegowosc.php">(Anuluj)</a>
<?php
}
else
{
?>
<form action="ksiegowosc.php" method="post">
<br>
		Nazwa:
		<br>
		<input type="text" name="nazwa" required>
		<br>
		Cena:
		<br>
		<input type="number" name="cena" required>
		<br>
		Opis:
		<br>
		<input type="text" name="opis" required>
		<br>
		<input type="submit" value="dodaj">
</form>
<?php
}
?>
</body>
</html>