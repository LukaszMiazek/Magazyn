<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>klient</title>
	<link rel="stylesheet" type="text/css" href="style.css"> 
</head>
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
<body>
	<header>
		<nav>
			<ul>
				<li><a href=index.html>Pracownik</a></li>
				<li><a href=klient.php>Klient</a></li>
			</ul>
		</nav>
	</header>
		<div class="form">
				<div class="tab-header">
					<div class="active"> Zaloguj się </div>	
					<div class> Zarejestruj się </div>
					
				</div>

			<div class="tab-content">

				<div class="tab-body active">
							<form action="klient.php" method="post">
										<div class="form-element">
											<input type="text" placeholder="Login" name="log" required>
										</div>											<div class="form-element">
											<input type="password" placeholder="Hasło" name="has"	required>
										</div>
										<div class="form-element">
											<button type="submit" value="Zaloguj się">Dalej</button>
										</div>
							</form>
				</div>

				<div class="tab-body">
						<form action="klient.php" method="post">
							
											<div class="form-element">
												<input type="text" placeholder="Login" name="login" required>
											</div>
											<div class="form-element">
												<input type="password" placeholder="Hasło" name="haslo"	required>
											</div>
											<div class="form-element">
												<input type="text" placeholder="Imię" name="imie" required>
											</div>
											<div class="form-element">
												<input type="text" placeholder="Nazwisko" name="nazwisko" required>
											</div>
											<div class="form-element">
												<button type="submit" value="Utwórz konto">Utwórz konto</button>
											</div>
								
							</form>
					</div>

			</div>
		</div>
	<script src="app.js"></script>
</body>

<?php
require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );

if (isset ($_POST['login']))
{
$lo=$_POST ['login'];
$ha=$_POST ['haslo'];
$im=$_POST ['imie'];
$na=$_POST ['nazwisko'];

$klient = R::dispense( 'klient' );
$klient->login=$lo;
$klient->haslo=$ha;
$klient->imie=$im;
$klient->nazwisko=$na;
$id = R::store( $klient );   
}

if (isset ($_POST['log']))
{
$log=$_POST ['log'];
$has=$_POST ['has'];

	$result = mysqli_query($conn, "SELECT * FROM klient WHERE LOGIN = '$log' AND HASLO = '$has'");//zaktualizować do ORMa
	$row = mysqli_fetch_assoc($result);
	if ($row != 0)
	{
		$_SESSION['login'] = $row['login'];
		header ('location:sklep.php');
		exit;
	}
}

?>

</html>