<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_kompletacja.css"/>
    <title>Komplementacja</title>
</head>
<body>
	<div class="container">
	<div class="nav">
<?php
session_start();
echo '<div class="wyloguj">';
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
echo '</div>';
require 'rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );

if (isset ($_POST['cankom']) )//                           PRZY ANULACJI KOMPETACJI ZAKŁADAMY NARAZIE żE NASTĘPNA OSOBA KOMPETUJĄCA TO ZAMÓWIENIE PODNIESIE TO SAMO PÓDEŁKO trzeba poprawić, ale to na następny tydzień
{
		$r = R::load( 'zamowienie', $_POST['cankom']);
		$r->status = 1;
		$r->akt_komp = 0;
		R::store( $r ); 
}

if (isset ($_POST['konkom']) )
{
		$r = R::load( 'zamowienie', $_POST['konkom']);
		$r->status = 3;
		$r->akt_komp = 0;
		R::store( $r );
}

if (isset ($_POST['towbrak']) )
{
		$r = R::load( 'sklad', $_POST['sklbrak']);
		$r->status = 3;
		R::store( $r ); 
}

if (isset ($_POST['skla']) )
{
		$r = R::load( 'sklad', $_POST['skla']);
	
		$r->jest = $r->jest + 1;
		
		if($r->jest == $r->ilosc) $r->status = 2;

		R::store( $r ); 
		
		$m = R::load( 'magazyn', $_POST['mag']);
		
		if( $m->ilosc > 1 )
		{
			$m->ilosc = $m->ilosc - 1;
			R::store( $m );
		}
		else
		{
			R::trash($m);
		}
}

if (!isset ($_POST['konkom']) )
{
	if (isset ($_GET['stan']) )
	{
		echo '<br>';
		echo '<div class="info">';
		echo '<a href="kompletacja.php"> Rozpocznij kompletacje </a>';
		echo '</div>';
	}
	else 
	{
		$zamis = R::findOne('zamowienie', 'akt_komp = ?', [$_SESSION['idprac']]);
		if (empty($zamis)) 
		{
			$zamis = R::findOne('zamowienie', 'status = 1');
		}
		
		//$zamis = R::findOne('zamowienie', 'status = 999', [$_SESSION['id']]); //               DO TESTÓW GDY NIE MA ZAMÓWIEŃ
		
		if (empty($zamis)) 
		{
			echo'<div class="info">';
		echo 'Nie masz żadnych zamówień do kompletacji';
		echo'</div>';
		}
		else
		{
			$skl = R::find('sklad', ' id_zam = ? and status = 1', [$zamis['id']] );
			
			if (empty($skl))
			{
				?>
				<form action="kompletacja.php" method="post" id="sub">
				<input type="hidden" value= <?php echo $zamis['id'] ?> name="konkom"><br>
				</form>
				
				<script type="text/javascript">
				document.forms['sub'].submit()
				</script>
				<?php
			}
			else
			{
				$r = R::load( 'zamowienie', $zamis['id']);
				$r->status = 2;
				$r->akt_komp = $_SESSION['idprac'];
				R::store( $r ); 
				
				foreach ($skl as $lok)
				{
					$t = R::findOne( 'magazyn', 'id_tow = ?', [$lok->towar] );
					if (empty($t))
					{
						echo '<div class="info">';
						echo 'BRAK TOWARU W MAGAZYNIE';//                                             NIEPRZEWIDIANY PRZYPADEK, trzeba uwzględnić zgłaszanie i co się dzieje z zamówieniem którego nie można skompletować
						?>
						<form action="" method="post">
						<input type="hidden" name="towbrak" value="<?php echo $lok->towar; ?>" required>
						<input type="hidden" name="sklbrak" value="<?php echo $lok->id; ?>" required>
						<input type="submit" value="POMIŃ">
						</form>
					</div>
						<?php
						
						break;
					}
					else
					{
					$kom = R::dispense( 'kompletacje' );
						$kom->id_zam = $zamis['id'];
						$kom->id_poz = $t['id'];
						$kom->id_tow = $t['id_tow'];
						$kom->id_prac = $_SESSION['idprac'];
						$kom->ilosc = 1;
						$kom->data = R::isoDateTime();
						$kom->status = 1;
						$id = R::store( $kom );
						
						$dane = R::findOne( 'towar', 'id = ?', [$lok->towar] );
					?>
					<div class="kompletacja">
					sektor: <?php echo $t['sektor']; ?> <br>
					Alejka: <?php echo $t['alejka']; ?> <br>
					Półka: <?php echo $t['polka']; ?> <br>
					Box: <?php echo $t['box']; ?> <br>

					
					Do zebrania:
					<?php echo $lok->ilosc - $lok->jest ?>
					<br>
					<br>
					Nazwa: <?php echo $dane['nazwa']; ?> <br>
					Opis: <?php echo $dane['opis']; ?> <br>
					</div>
					<br>
					<div class="button_container1">
					<form action="" method="post">
					<input type="hidden" name="mag" value="<?php echo $t['id']; ?>" required>
					<input type="hidden" name="skla" value="<?php echo $lok->id; ?>" required>
					<input type="submit" value="Dalej">
					</form>
					</div>
					
					<?php
					break;// tylko jeden narazie
					}
				}
				
			}
		}
		?>
		<br>
		<br>
		<div class="button_container2">
		<form action="kompletacja.php?stan=n" method="post">
			<input type="hidden" name="cankom" value="<?php echo $zamis['id']; ?>" required>
				<input type="submit" value="Anuluj kompetacje">
			</form>
		</div>
		<?php
	}
}
else
{
	echo '<div class="info">';	
	echo 'Kompletacja zakończona';
	echo '<br>';
	echo '<a href="kompletacja.php"> Następna kompletacja </a>';
	echo '</div>';	
}
?>
</div>
</body>
</html>



