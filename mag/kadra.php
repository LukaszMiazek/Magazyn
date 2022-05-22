<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Zasoby Ludzkie</title>
	<link rel="stylesheet" type="text/css" href="style_kadra.css"> 
	<meta name="viewport"  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"/> 
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">

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

<div class="nav">
			<div class="logo">
				<i class="fa-solid fa-coins"></i>
				<h2>magazyn/kadra</h2>
			</div>

	<div class="nav_panel">

	<form action="klient.php" method="post">
		<input type="hidden" name="wlog"	required>
			<button type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj </button>
		</form>
	</div>
</div>

<div class="dodawanie">
	<form action="kadra-dodaj.php" method="post">
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
			<option>Magazynier</option>
			<option>KSIEGOWY</option>
			<option>Kompleter</option>
			</select>
			<button type="submit" value="Dodaj pracownika">Dodaj pracownika</button>	
	</form>
</div>


<div class="panel">
	<table class="tab">
	<tr>
	<td><b>ID</b></td>
	<td><b>Login</b></td>
	<td><b>Imie</b></td>
	<td><b>Nazwisko</b></td>
	<td><b>Stanowisko</b></td>
	<td><b>Blokada</b></td>
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
			echo '"><i class="fa-solid fa-pen-to-square"></i></a>';
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
			<button type="submit" name="upr" value="3">KOMPLETER</button>
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
	echo '</div>';
	?>
</div>
</body>
</html>
