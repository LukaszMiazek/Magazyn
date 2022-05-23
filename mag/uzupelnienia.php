<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_uzupelnienia.css">
    <title>Rozmieszczanie</title>
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

if (isset ($_POST['sektor']))
{
	$sek = $_POST['sektor'];
	$ale = $_POST['alejka'];
	$pol = $_POST['polka'];
	$box = $_POST['box'];
	$tow = $_POST['idp'];
	
	$towar = R::findOne('towar', 'kod = ?', [$_POST['idp']]);
	
	if(empty($towar))
	{
		?>
			<script>
			alert("Zły kod towaru")
			</script>
		<?php 
	}
	else
	{
		$tow = $towar['id'];
		
		$mag = R::findOne('magazyn', 'sektor = ? AND alejka = ? AND polka = ? AND box = ?', [$sek,$ale,$pol,$box]);
		
		if($_POST['zm'] == 'add')
		{
			if (empty($mag)) 
			{
				$m = R::dispense( 'magazyn' );
				$m->sektor= $sek;
				$m->alejka= $ale;
				$m->polka= $pol;
				$m->box= $box;
				
				$m->id_tow = $tow;
				$m->ilosc= 1;
				
				$id = R::store( $m );
				
				$dos = R::dispense( 'dostawy' );
				$dos->id_poz = $id;
				$dos->id_tow = $tow;
				$dos->id_prac = $_SESSION['idprac'];;
				$dos->ilosc = 1;
				$dos->data = R::isoDateTime();
				$id = R::store( $dos ); 
			}
			else
			{
				$idm = $mag['id'];
				$t = R::load( 'magazyn', $idm);
				
				if($tow != $t->id_tow)
				{
					?>
					<script>
					alert("Na tym miejscu znajduje się inny towar")
					</script>
					<?php 
				}
				else
				{
					$t->ilosc = $t->ilosc + 1;
					R::store( $t );
					
					$roz = R::findOne('dostawy', 'id_tow = ? AND id_prac = ? AND id_poz = ? AND DATE_ADD(data, INTERVAL 10 MINUTE) > ?', [$tow,$_SESSION['idprac'],$t->id,R::isoDateTime()]);
					
					if (empty($roz)) 
					{
						$dos = R::dispense( 'dostawy' );
						$dos->id_poz = $t->id;
						$dos->id_tow = $tow;
						$dos->id_prac = $_SESSION['idprac'];;
						$dos->ilosc = 1;
						$dos->data = R::isoDateTime();
						$id = R::store( $dos );
					}
					else
					{
						$idr = $roz['id'];
						$t = R::load( 'dostawy', $idr);
						$t->data = R::isoDateTime();
						$t->ilosc = $t->ilosc + 1;
						R::store( $t );
					}
					
				}
			}
		}
		else if($_POST['zm'] == 'sub' )
		{
			if ( !empty($mag))
			{
				$idm = $mag['id'];
				$t = R::load( 'magazyn', $idm);
				
				if($tow != $t->id_tow)
				{
					?>
					<script>
					alert("Na tym miejscu znajduje się inny towar")
					</script>
					<?php 
				}
				else
				{
					if( $t->ilosc > 1 )
					{
						$t->ilosc = $t->ilosc - 1;
						R::store( $t );
						
						$roz = R::findOne('dostawy', 'id_tow = ? AND id_prac = ? AND id_poz = ? AND DATE_ADD(data, INTERVAL 10 MINUTE) > ?', [$tow,$_SESSION['idprac'],$t->id,R::isoDateTime()]);
						//$roz = R::findOne('dostawy', 'id_tow = ? AND id_prac = ? AND id_poz = ? ', [$tow,$_SESSION['idprac'],$t->id]);
					
						if (empty($roz)) 
						{
							$dos = R::dispense( 'dostawy' );
							$dos->id_poz = $t->id;
							$dos->id_tow = $tow;
							$dos->id_prac = $_SESSION['idprac'];;
							$dos->ilosc = 1;
							$dos->data = R::isoDateTime();
							$id = R::store( $dos );
						}
						else
						{
							$idr = $roz['id'];
							$t = R::load( 'dostawy', $idr);
							$t->data = R::isoDateTime();
							$t->ilosc = $t->ilosc - 1;
							R::store( $t );
						}
						
					}
					else
					{
						R::trash($t);
					}
				}
			}
			else
			{
				?>
				<script>
				alert("To miejsce jest puste!")
				</script>
				<?php 
			}
		}
	}
}
	


if (isset ($_GET['stan']) )
{
	echo '<br>';
	echo '<div class="potwierdzenie">';
	echo '<a href="uzupelnienia.php"> Rozpocznij uzupelnianie </a>';
	echo '</div>';
}
else 
{
	?>
	<div class="uzupelnienia">
	<form action="" method="post">
	
	<?php if( !isset($_POST['sektor']) ) { ?>
	
			Sektor
			<input type="text" maxlength="1" name="sektor" id="s" required>
			<br>Alejka
			<input type="number" name="alejka" id="a" required>
			<br>Półka
			<input type="number" name="polka"  id="p" required>
			<br>Box
			<input type="text" maxlength="1" name="box" id="b" required>
			<br>Kod Produktu
			<input type="text" name="idp" required>
			<br>
	<?php 
	} 
	else
	{
	?>	
		Sektor
			<input type="text" maxlength="1" name="sektor" value = <?php echo $_POST['sektor'] ?> id="s" required>
			<br>Alejka
			<input type="number" name="alejka" value = <?php echo $_POST['alejka'] ?> id="a" required>
			<br>Półka
			<input type="number" name="polka"  value = <?php echo $_POST['polka'] ?> id="p" required>
			<br>Box
			<input type="text" maxlength="1" name="box" value = <?php echo $_POST['box'] ?> id="b" required>
			<br>Kod Produktu
			<input type="text" name="idp" value= <?php echo $_POST['idp'] ?> required>
			<br>
	
	<?php
	}
	?>
		</div>
			<br>
			<div class="button_container">
			<button type="submit" name="zm" value="add">Umieść</button>
			<button type="submit" name="zm" value="sub">Wyjmij / Cofnij</button>
			
			<a href="">Wyczyść</a>
			</div>
	</form>
	<?php
	echo '<br>';
	echo '<div class="potwierdzenie">';
	echo '<a href="uzupelnienia.php?stan=">Zakończ uzupelnianie</a>';
	echo '</div>';
}
?>


<div class="szukaj">
<form action="" method="post">
Szukaj towaru
	<input type="text" name="skod" 
	<?php 
	if( isset($_POST['skod']) )
	{
		echo "value =".$_POST['skod'];
	} 
	?>
	required>
	<br>
	<button type="submit">Szukaj</button>
</form>

<div class="scrolling">
<?php

if(isset($_POST['skod']))
{
	$towar = R::findOne('towar', 'kod = ?', [$_POST['skod']]);
	if(empty($towar))
	{
		echo "Nie znaleziono";
	}
	else
	{
		?>
		<script>

		function wpisz (s,a,p,b){
		document.getElementById('s').value = s;
		document.getElementById('a').value = a;
		document.getElementById('p').value = p;
		document.getElementById('b').value = b;
		}

		</script>
		<?php
		
		$id = $towar['id'];
		echo '<table>';
		$mg = R::find('magazyn', ' id_tow = ?', [$id] );
			echo '<thead>';
			echo '<tr>';
			echo '<td>';
			echo 'Sektor';
			echo '</td>';
			echo '<td>';
			echo 'Alejka';
			echo '</td>';
			echo '<td>';
			echo 'Półka';
			echo '</td>';
			echo '<td>';
			echo 'Box';
			echo '</td>';
			echo '<td>';
			echo 'Ile';
			echo '</td>';
			echo '<td>';
			echo '</td>';
			echo '</tr>';
			echo '</thead>';
			foreach ($mg as $mag){
				echo '<tr>';
				echo '<td>';
				echo $mag->sektor.' ';
				echo '</td>';
				echo '<td>';
				echo $mag->alejka.' ';
				echo '</td>';
				echo '<td>';
				echo $mag->polka.' ';
				echo '</td>';
				echo '<td>';
				echo $mag->box.' ';
				echo '</td>';
				echo '<td>';
				echo $mag->ilosc.' ';
				echo '</td>';
				echo '<td>';
				$idm=$mag->id;
				echo '</td>';
				echo '<td>';
				?><button type="button" onClick="wpisz('<?php echo $mag->sektor ?>',<?php echo $mag->alejka ?>,<?php echo $mag->polka ?>,'<?php echo $mag->box ?>')">Wpisz</button><?php
				echo '</td>';
				echo '</tr>';
		}
		echo '</table>';
	}
}
echo '</div>';
echo '</div>';
?>

</div>
</body>
</html>



