<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>sklep</title>
	<link rel="stylesheet" type="text/css" href="style_sklep.css"> 
	<meta name="viewport"  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"/> 
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">

</head>
<body>
<div class="container">
	
			<div class="nav">
					<?php
					session_start();
					echo '<br>';
					echo '<br>';
					echo '<br>';
					echo '<br>';

					echo '<div class="wyloguj">';
					echo 'Zalogowno jako '.$_SESSION['login'].' ';
					

				



					?>
					
					<form action="klient.php" method="post">

						<input type="hidden" name="wlog"	required>
						<button type="submit">Wyloguj się</button>

					</form>
					</div>


					<?php
						echo '<div class="koszyk">';
						echo '<a href="koszyk.php"><i class="fa-solid fa-cart-shopping"></i> Koszyk</a>';
						echo '</div>';
					

						require 'rb-mysql.php';
						R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );
			echo'</div>';
					
			echo'<div class="tag">';
				//echo '<a class="guzik2" href="sklep.php">Wszystko </a>';
				$kt = R::getAll( 'SELECT * FROM kategoria' );
				foreach ($kt as $kat)
				{
					echo '<a class="guzik2" href="sklep.php?kat=';
					echo $kat['id'];
					echo '">';
					echo $kat['nazwa'];
					echo ' </a>';
				}
				?>
			</div>
			<div class="search">
				<form action="sklep.php" method="get">
				<?php
				if (isset ($_GET['kat']))
				{
					echo '<input type="hidden" name="kat" value=';
					echo $_GET['kat'];
					echo '>';
				}
				?>
				<div class="col_big">
				<input type="text" placeholder="Szukaj" name="naz">
				</div>
				<div class="col">
				<button type="submit" class="fa-solid fa-magnifying-glass" value="Szukaj"></button>
				</div>
				</form>
			</div>

		<?php

		echo '<div class="tabela">';
		echo '<h1>Produkty</h1>';
		echo '<table>';
		if (isset ($_GET['kat'])) $wkat= '%'.$_GET['kat'].'%';
		else $wkat='%%';
		if (isset ($_GET['naz'])) $wnaz= '%'.$_GET['naz'].'%';
		else $wnaz='%%';

		if (!isset ($_GET['kat']) && !isset ($_GET['naz'])) 
		{
			$wkat='%/@%';
			$wnaz='%/@%';
		}

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
			
			
			echo '<img src = "Zdjecia/';
			echo $towar->id; 
			echo '.png " width="150" height="150" alt=" " ></a>'; //.jpg !
			echo '<br>';
			
			echo '<div class="produktinfo">';
		
			echo '<div class="produktnaz">';
			echo $towar->nazwa;
			echo'</div>';
			echo '<div class="produktcena">';
			echo ' '.$towar->cena; echo ' zł';
			echo'</div>';
			echo '</div>';
			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '</div>';
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
			
			echo '<div class="produkt">';
			echo '<div class="nazwa">';
			echo '<h1>Produkt</h1>';
			echo $towar->nazwa;
			echo '</div>';
			
			echo '<div class="obraz">';
			echo '<img src = "Zdjecia/';
			echo $id; 
			echo '.png " width="200" height="200" alt=" " ></a>';
			echo '</div>';

			echo '<div class="opis">';
			echo $towar->opis;
			echo '</div>';
			
			echo '<div class="cena">';
			echo $towar->cena;
			echo ' zł';
			echo '</div>';


			echo '<br>';
			
			$sum=0;
			$mg = R::find('magazyn', ' id_tow = ?', [$id] );
			foreach ($mg as $mag)
			{ 
				$sum = $sum + $mag->ilosc; 
			}
			
			if($sum>0)
			{
			echo '<div class="ilosc">';
			echo 'Dostępnych sztuk: ';
			echo $sum;
			echo '</div>';
			?>
			<div class="kup">
				<form action="" method="post">
				<input type="hidden" name="tid" value="<?php echo $towar->id ?>"required>
				<div class="kup_a">
				<input type="number" name="tile" min="1" max="<?php echo $sum; ?>"value="1" required>
				</div>
				<div class="kup_b">
				<button type="submit" value="Kup"><i class="fa-solid fa-cart-shopping"></i> Dodaj do koszyka</button>
				</div>
				</form>
			</div>
				<?php
			}
			else
			{
				echo '<div class="ilosc">';
				echo 'Brak Produktu w magazynie';
				echo '</div>';
			}
			echo '</div>';
		}
		?>

		</form>
	</div>
</body>
</html>