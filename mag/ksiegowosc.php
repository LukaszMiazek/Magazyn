<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Ksiegowosc</title>
	<link rel="stylesheet" type="text/css" href="style_ksiegowosc.css">
	<meta name="viewport"  content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"/> 
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<div class="container">
			<div class="div3">
				<div class="logo">
					<i class="fa-solid fa-coins"></i>
					<h2>magazyn/księgowość</h2>
				</div>

					<?php
					session_start();
					require 'rb-mysql.php';
					R::setup( 'mysql:host=localhost;dbname=magazyn','root', '' );
					echo  '<div class="nav_panel">';
						echo 'Zalogowno jako '.$_SESSION['login'];
						?>
						<form action="index.php" method="post">

							<input type="hidden" name="wlog"	required>
							<button type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Wyloguj </button>
						</form>
					</div>
			</div>

			<div class="div2">
				<div class="scrolling">
					<label>Kategorie</label>
				<?php
				
				echo '<table>';
				echo '<form action="" method="post">';
				$kt = R::find('kategoria');
					foreach ($kt as $kat){
						echo '<tr>';
						echo '<td>';
						echo $kat->nazwa.' ';
						echo '</td>';
						echo '<td>';
						$idk=$kat->id;
						echo '<button type="submit" class="fa-solid fa-pen-to-square" name="editk" value=';
						echo $idk;
						echo '></button>';
						echo '</td>';
						echo '</tr>';
					}
				echo '</table>';
				echo '</form>';
				echo '</div>';
				if (isset ($_POST['editk']))
				{
				$kt = R::findOne('kategoria',' WHERE id = ? ',[$_POST['editk']]);
				?>
			<form action="" method="post">
				<div class="container_kategoria">
					<div class="kategoria1-3">
						<label>Nazwa:</label>
					</div>
					<div class="kategoria2-3">
						<input type="hidden" name="idk" value=<?php echo $_POST['editk'] ?> required>
						<input type="text" name="nazwake" value = "<?php echo $kt['nazwa']; ?>" required >
					</div>
					<div class="kategoria3-3">
						<div class="button_align">
							<button type="submit" value="dodaj">Edytuj</button>
						</div>
					</div>
				</form>
				<form action="" method="post">
					<div class="container_kategoria2">	
						<input type="hidden" name="iddk" value=<?php echo $_POST['editk'] ?> required>
								<button type="submit" class="fa-solid fa-trash-can" value="Usuń"></button>
								<a class="guzik" href="">Anuluj</a>
					</div>
				</div>
					</form>
			<?php
			}
			else
			{
			?>
			<form action="" method="post">
				 <div class="container_kategoria">
					 <div class="kategoria1-3">
						<label>Nazwa:</label>
					</div>
					<div class="kategoria2-3">
						<input type="text" name="nazwak" required>
					</div>
					<div class="kategoria3-3">
						<div class="button_align">
							<button type="submit" class="fa-solid fa-plus" value="dodaj">	</button>
						</div>
					</div>
			</div>
			</form>
			
			<?php
			}
			?>
		</div>

<div class="tag">	
	<?php
	//echo '<a class="guzik2" >Wszystko </a>';
	$kt = R::getAll( 'SELECT * FROM kategoria' );
	foreach ($kt as $kat)
	{
		echo '<a class="guzik2" href="ksiegowosc.php?kat=';
		echo $kat['id'];
		echo '">';
		echo $kat['nazwa'];
		echo ' </a>';
	}
	?>
</div>
<div class="wyszukiwarka">	
	<form action="" method="get">
	<?php
	if (isset ($_GET['kat']))
	{
		echo '<input type="hidden" name="kat" value=';
		echo $_GET['kat'];
		echo '>';
	}
	?>
	<div class="formHolder">
		<div class="col_big">
			<input type="search" name="naz">
		</div>
		<div class="col">
			<button type="submit" class="fa-solid fa-magnifying-glass" value="Szukaj"></button>
		</div>

	</div>

	</form>
</div>

<div class="div1">
<div class="scrolling">
	<?php
	
	if (isset ($_POST['nazwa']))
	{
	$tow = R::dispense( 'towar' );
	$tow->nazwa = $_POST['nazwa'];
	$tow->kategoria = $_POST['kategoria'];
	$tow->cena = $_POST['cena'];
	$tow->opis = $_POST['opis'];
	$tow->kod = "???";
	$id = R::store( $tow );
	
	$tow = R::load( 'towar', $id);
	$kat = R::load( 'kategoria', $tow->kategoria);
	$kod=substr($kat->nazwa,0,3);
	$kod = $kod.strval($tow->id);
	$tow->kod = $kod;
	R::store( $tow );

		if(is_uploaded_file($_FILES['zdj']['tmp_name']))
		{
			$lokalizacja = 'Zdjecia/'.$id.'.png';
			move_uploaded_file($_FILES['zdj']['tmp_name'], $lokalizacja);
		}
				
	}

	if (isset ($_POST['nazwae']))
	{
	$ide=$_POST ['ide'];
	$t = R::load( 'towar', $ide);
	$t->nazwa = $_POST['nazwae'];
	$t->kategoria = $_POST['kategoriae'];
	$t->cena = $_POST['cenae'];
	$t->opis = $_POST['opise'];
	$t->kod = $_POST['kode'];
	R::store( $t );
	
		if(is_uploaded_file($_FILES['zdje']['tmp_name']))
		{
			//$dir = @opendir("/tmp");
			$lokalizacja = 'Zdjecia/'.$ide.'.png';
			
			if (file_exists ($lokalizacja))
			{
				unlink($lokalizacja);
			}
			
			move_uploaded_file($_FILES['zdje']['tmp_name'], $lokalizacja);
		}
	
	}

	if (isset ($_POST['idd']))
	{
	$id=$_POST ['idd'];
	$t = R::findOne( 'towar', 'id=?',array($id));
	R::trash($t);
	
	$lokalizacja = 'Zdjecia/'.$id.'.png';
			
	if (file_exists ($lokalizacja))
	{
		unlink($lokalizacja);
	}
	
	}

	if (isset ($_POST['nazwak']))
	{
	$kat = R::dispense( 'kategoria' );
	$kat->nazwa = $_POST['nazwak'];
	$id = R::store( $kat ); 
	}

	if (isset ($_POST['nazwake']))
	{
	$idk=$_POST ['idk'];
	$k = R::load( 'kategoria', $idk);
	$k->nazwa = $_POST['nazwake'];
	R::store( $k ); 
	}

	if (isset ($_POST['iddk']))
	{
	$id=$_POST ['iddk'];
	$t = R::findOne( 'kategoria', 'id = ?',array($id));
	R::trash($t);
	}

	if (isset ($_POST['idm']))
	{
	$m = R::dispense( 'magazyn' );
	$m->id_tow = $_POST['idm'];
	$m->sektor= $_POST['sektor'];
	$m->alejka= $_POST['alejka'];
	$m->polka= $_POST['polka'];
	$m->box= $_POST['box'];
	$m->ilosc= $_POST['ilosc'];
	$id = R::store( $m ); 
	}

	if (isset ($_POST['idme'])) //aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
	{
	$idme=$_POST ['idme'];
	$m = R::load( 'magazyn', $idme);
	$m->sektor= $_POST['sektore'];
	$m->alejka= $_POST['alejkae'];
	$m->polka= $_POST['polkae'];
	$m->box= $_POST['boxe'];
	$m->ilosc= $_POST['ilosce'];
	$id = R::store( $m );  
	}

	if (isset ($_POST['idmd']))
	{
	$id=$_POST ['idmd'];
	$t = R::findOne( 'magazyn', 'id = ?',array($id));
	R::trash($t);
	}
	
			?>
				<form action="" method="get">
				<?php
				if (isset ($_GET['kat']))
				{
					echo '<input type="hidden" name="kat" value=';
					echo $_GET['kat'];
					echo '>';
				}
				if (isset ($_GET['naz']))
				{
					echo '<input type="hidden" name="naz" value=';
					echo $_GET['naz'];
					echo '>';
				}
				?>
				<div class="button_sort_sec">
					<button type="submit" class="fa-solid fa-arrow-down-a-z" name="sort" value="nazasc">  </button>
					<button type="submit" class="fa-solid fa-arrow-down-z-a" name="sort" value="nazdesc">  </button>
					<button type="submit" class="fa-solid fa-arrow-down-1-9" value="cenasc"> </button>
					<button type="submit" class="fa-solid fa-arrow-down-9-1" name="sort" value="cendesc"> </button>
				</div>
				</form>
				
			<?php
	

		echo '<table class="table">';
		echo '<form action="" method="post">';

		if (isset ($_GET['kat'])) $wkat= '%'.$_GET['kat'].'%';
		else $wkat='%%';
		if (isset ($_GET['naz'])) $wnaz= '%'.$_GET['naz'].'%';
		else $wnaz='%%';
		
		if (!isset ($_GET['kat']) && !isset ($_GET['naz'])) 
		{
			$wkat='%/@%';
			$wnaz='%/@%';
		}

		if(isset ($_GET['sort']))
		{
			if( $_GET['sort'] == "nazasc" ) $tw = R::find('towar', ' kategoria LIKE ? AND nazwa like ?', [$wkat,$wnaz], ' ORDER BY nazwa ASC' ); // ' ORDER BY title LIMIT 2 '
			if( $_GET['sort'] == "nazdesc" ) $tw = R::find('towar', ' kategoria LIKE ? AND nazwa like ?', [$wkat,$wnaz], ' ORDER BY nazwa DESC' );
			if( $_GET['sort'] == "cenasc" ) $tw = R::find('towar', ' kategoria LIKE ? AND nazwa like ?', [$wkat,$wnaz], ' ORDER BY cena ASC' );
			if( $_GET['sort'] == "cendesc" ) $tw = R::find('towar', ' kategoria LIKE ? AND nazwa like ?', [$wkat,$wnaz], ' ORDER BY cena DESC' );
		}
		else $tw = R::find('towar', ' kategoria LIKE ? AND nazwa like ?', [$wkat,$wnaz] );
		
				echo '<thead>';
				echo '<tr>';
				echo '<th>';
				echo 'Nazwa';
				echo '</th>';
				echo '<th>';
				echo 'Cena';
				echo '</th>';
				echo '<th>';
				echo 'Zdjęcie';
				echo '</th>';
				echo '<th>';
				echo '</th>';
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
				echo '<img src = "Zdjecia/'.$idt.'.png" width="100" height="100" alt=" " ></a>';
				echo '</td>';
				echo '<td>';
				echo '<button type="submit" class="fa-solid fa-pen-to-square" name="edit" value=';
				echo $idt;
				echo '></button>';
				echo '</td>';
				echo '</tr>';
				
				
		}
		echo '</table>';
		echo '</form>';
		echo '</div>';	
		echo '</div>';	

		if (isset ($_POST['edit']))
		{
		$e=$_POST ['edit'];
		$t = R::findOne( 'towar', 'id=?',array($e));
		$id = $e;
		$nazwa = $t['nazwa'];
		$kategoria = $t['kategoria'];
		$cena = $t['cena'];
		$opis = $t['opis'];
		$kod = $t['kod'];
		?>


<div class="div4">
	<form action="" enctype="multipart/form-data" method="post">
	<label>Nazwa:</label>
		<div class="container_input">
			<input type="text" name="nazwae" autocomplete="off" 	value=<?php echo $nazwa ?> required>
		</div>
			<label>Kategoria:</label>
		<div class="container_input">
			<select name="kategoriae" required>
			<?php
			$kt = R::getAll( 'SELECT * FROM kategoria' );
			foreach ($kt as $kat)
			{
				echo '<option value="';
				echo $kat['id'];
				echo '"';
				if($kategoria == $kat['id']) echo 'selected="selected"';
				echo '>';
				echo $kat['nazwa'];
				echo '</option>';
			}
			?>
			</select>
		</div>
			
			<label>Cena:</label>
		<div class="container_input">
			<input type="number" name="cenae" min="0" step="0.01" value=<?php echo $cena ?> required>
		</div>
			<label>Opis:</label>
		<div class="container_input">
			<input type="text" name="opise" autocomplete="off" value="<?php echo $opis ?>" required>
		</div>
			<label>Kod:</label>
		<div class="container_input">
			<input type="text" name="kode" autocomplete="off" value="<?php echo $kod ?>" required>
		</div>
		
		<label for="img">Select image:</label>
		
		<img src = "Zdjecia/<?php echo $id; ?>.png " width="100" height="100" alt=" " ></a>
		
		<div class="container_input_img">
  			<input type="file" name="zdje" accept="image/png">
		</div>

			<input type="hidden" name="ide" value=<?php echo $id ?> required>

			<div class="button_align0">
					<button type="submit" class="fa-solid fa-check" value="Edytuj"></button>
					</div>

	
	</form>
		<div class="div4buttons">
				<form action="" method="post">
					<input type="hidden" name="idd" value=<?php echo $id ?> required>
					<div class="button_align1">
						<button type="submit" class="fa-solid fa-trash-can" value="Usuń"></button>
					</div>
					<div class="button_align2">
						<a class="fa-solid fa-xmark" href=""></a>
					</div>
		</div>
				</form>
</div>

<div class="div5">
<div class="scrolling">
<?php
echo '<table>';
echo '<form action="" method="post">';
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
		$idm=$mag->id;
		echo '<td>';
		
		echo '<input type="hidden" name="edit" value="';
		echo $id;
		echo '"required>';
		
		echo '<button type="submit" class="fa-solid fa-pen-to-square" name="editm" value=';
		echo $idm;
		echo '></button>';
		echo '</td>';
		echo '</tr>';
}
echo '</table>';
echo '</form>';
echo '</div>';
if (isset ($_POST['editm']))
{
$e=$_POST ['editm'];
$m = R::findOne( 'magazyn', 'id=?',array($e));
$idtow = $m['id_tow'];
$sektor = $m['sektor'];
$alejka = $m['alejka'];
$polka = $m['polka'];
$box = $m['box'];
$ilosc = $m['ilosc'];
?>
		
		<form action="" method="post">
		<div class="container_input">
			<input type="text" maxlength="1" name="sektore" value=<?php echo $sektor ?> required>
			<input type="number" name="alejkae" value=<?php echo $alejka ?> required>
			<input type="number" name="polkae" value=<?php echo $polka?> required>
			<input type="text" maxlength="1" name="boxe" value=<?php echo $box ?> required>
			<input type="number" name="ilosce" value=<?php echo $ilosc ?> required>
			
			<input type="hidden" name="idme" value=<?php echo $e ?> required>
			<input type="hidden" name="edit" value=<?php echo $idtow ?> required>
		</div>
			<button type="submit" value="Edytuj">Edytuj</button>
			
		</form>
		<br>
		<form action="" method="post">
		<input type="hidden" name="edit" value=<?php echo $idtow ?> required>
		<input type="hidden" name="idmd" value=<?php echo $id ?> required>
		
		<button type="submit" value="Usuń">Usuń</button>
		</form>

<?php
}
else
{
	?>
	<form action="" method="post">
		<div class="container_input">
			<input type="text" maxlength="1" name="sektor" required>
			<input type="number" name="alejka" required>
			<input type="number" name="polka"  required>
			<input type="text" maxlength="1" name="box" required>
			<input type="number" name="ilosc" required>
			<input type="hidden" name="edit" value=<?php echo $id ?> required>
			<input type="hidden" name="idm" value=<?php echo $id ?> required>
			<div class="button_align">
				<button type="submit">Dodaj</button>
			</div>
		</div>
		</form>
</div>
	<?php
}

}
else //dodawanie
{
?>
						<div class="div4">
						<form action="" enctype="multipart/form-data" method="post">
								<label>Nazwa:</label>
								<div class="container_input">
									<input type="text" name="nazwa" autocomplete="off" required>
								</div>
								<label>Kategoria:</label>
								<div class="container_input">
									<select name="kategoria" required>
									<?php
									$kt = R::getAll( 'SELECT * FROM kategoria' );
									foreach ($kt as $kat)
									{
										echo '<option value="';
										echo $kat['id'];
										echo '">';
										echo $kat['nazwa'];
										echo '</option>';
									}
									?>
									</select>
								</div>
								<label>Cena:</label>
								<div class="container_input">
									<input type="number" min="0" step="0.01" name="cena" required>
								</div>
									<label>Opis:</label>
								<div class="container_input">
									<input type="text" name="opis" autocomplete="off" required>
								</div>
								<label for="img">Select image:</label>
		
								<div class="container_input_img">
									<input type="file" name="zdj" accept="image/png">
								</div>
									
								<div class="button_align">
									<button type="submit" value="dodaj">Dodaj</button>
								</div>
							</form>
						</div>
				
<?php
}
?>
<script src="app2.js"></script>
</div>
</body>
</html>
