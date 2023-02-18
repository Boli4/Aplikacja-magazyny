<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: strGlowna.php');
		exit();
	}

?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">	
	<link href="css/logowanie.css" rel="stylesheet">
	<link href="css/stylGlowny.css" rel="stylesheet">

    <title>Logowanie</title>
</head>
  
<body class="text-center">
	<form action="zaloguj.php" method="post" class="form-signin">
		<h3 class="napisInfoStr">Zaloguj się</h3>
	  
		<input type="email" name="email" class="form-control" placeholder="Email">
    		<div class="mb-2"></div>
		<input type="password" name="password" class="form-control" placeholder="Hasło">
		
		<div class="custom-control custom-checkbox">
			<?php
				if(isset($_SESSION['blad']))
					echo $_SESSION['blad'];
			?>
		</div>
	  
		<button class="btn btn-lg btn-glowny btn-block" type="submit">Zaloguj</button>
		<hr class="mb-2">
		<div class="footerText">Copyright © 2023</div>
	</form>
	
</body>
</html>
