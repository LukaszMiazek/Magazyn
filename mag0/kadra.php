<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Zasoby Ludzkie</title>
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>


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

?>

<form action="kadra-dodaj.php" method="post">
<br>
		Login:
		<br>
		<input type="text" name="login" required>
		<br>
		Hasło:
		<br>
		<input type="password" name="haslo"	required>
		<br>
		Imie:
		<br>
		<input type="text" name="imie" required>
		<br>
		Nazwisko:
		<br>
		<input type="text" name="nazwisko" required>
		<br>
		Stanowisko:
		<br>
		<select name="stanowisko" required>
		<option>MAGAZYNIER</option>
		<option>KSIEGOWY</option>
		</select>
		<br>
		<input type="submit" value="Dodaj pracownika">
</form>

<br>
<br>
<table class="tab">
<tr>
<td><b>ID</b></td>
<td><b>Login</b></td>
<td><b>Imie</b></td>
<td><b>Nazwisko</b></td>
<td><b>Stanowisko</b></td>
<td><b>BLOKADA</b></td>
<td><b>Zarządzaj</b></td>
</tr>
<?php
$ed=0;
	$result = mysqli_query($conn, "SELECT * FROM PRACOWNIK where STANOWISKO != 'Administrator'");
	while($row = mysqli_fetch_assoc($result))
	{
		$stan=$row['STANOWISKO'];
		$idu=$row['ID_PRACOWNIKA'];
		$log=$row['LOGIN'];
		$akt=$row['BLOKADA'];
		$im=$row['IMIE'];
		$naz=$row['NAZWISKO'];
		
		echo '<tr>';
		echo '<td>';
		echo $idu;
		echo '</td>';
		echo '<td>';
		echo $log;
		echo '</td>';
		echo '<td>';
		echo $im;
		echo '</td>';
		echo '<td>';
		echo $naz;
		echo '</td>';
		echo '<td>';
		echo $stan;
		echo '</td>';
		echo '<td>';
		echo $akt;
		echo '</td>';
		echo '<td>';
		if($_GET['edit'] == $idu)
		{
		echo '<a href="kadra.php?edit="';
		echo $idu;
		echo '"> (Anuluj)</a>';
		$ed=1;
		}
		else
		{
		echo '<a href="kadra.php?edit=';
		echo $idu;
		echo '">Edytuj</a>';
		}
		echo '</td>';
		if($_GET['edit']==$idu)
		{
		?>
		<td>
		<b class="nag2">Zmiana stanowiska</b>
		<br>
		<br>
		<form action="kadra-zmien.php" method="post">
		<input type="hidden" name="idu" value="<?php echo $idu; ?>">
		<button type="submit" name="upr" value="1">MAGAZYNIER</button>
		<button type="submit" name="upr" value="2">KSIEGOWY</button>
		</form>
		<br>
		<form action="kadra-zmien.php" method="post">
		<input type="hidden" name="idu" value="<?php echo $idu; ?>">
		<?php
		if ($akt == 0) echo '<button type="submit" name="blok" value="0">Zablokuj</button>';
		else echo '<button type="submit" name="blok" value="1">Odblokuj</button>';
		echo '</form>';
		
	}
	}
mysqli_close($conn);
?>

</body>
</html>