<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"/>
</head>
<body>
<?php
session_start();	
if (isset ($_POST['wlog']))
{
		unset($_POST['wlog']);
		session_destroy();
}
?>
	<header>
		<nav>
			<ul>
				<li><a href=index.php>Pracownik</a></li>
				<li><a href=klient.php>Klient</a></li>
			</ul>
		</nav>
	</header>
		<div class="form">
            <div class="profile-img">
                <i class="fa-solid fa-cubes"></i>
            </div>
			<div class="tab-content">
				<div class="tab-body active">
                    <form class="login-form" action="logowanie.php" method="post">
                        <div class="form-element">
                             <input type="login" placeholder="Identyfikator" name="login">
                        </div>
                        <div class="form-element">
                            <input type="password" placeholder="Hasło" name="haslo">
                        </div>
                        <div class="form-element">
                            <button type="submit">Dalej</button>
                         </div>
                </form>
				</div>
			</div>
		</div>
	<script src="app.js"></script>
</body>
</html>
