<?php

session_start();

if (!isset($_SESSION['zalogowany'])) 
{
    header('Location: index.php');
    exit();
}
else if($_SESSION['admin'] != 1)
{
    header('Location: strGlowna.php');
}

require_once "connect.php";

$polaczenie = mysqli_connect($host, $db_user, $db_password, $db_name);
   mysqli_set_charset($polaczenie, "utf8");

   if (!$polaczenie) 
   {
      die("Błąd połączenia " . mysqli_connect_error());
   }
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	  <link href="css/stylGlowny.css" rel="stylesheet">

    <title>Tworzenie</title>
</head>
  
<body>

<div class="container p-3 mx-auto flex-column">
		<?php
    //Wyświetlanie odpowiedniego headera w zależności czy jesteś adminem czy nie
    if($_SESSION['admin'] == 1)
		{
		  require_once "headerAdmin.php";
		}
		else
		{
			require_once "headerUser.php";
		}
    ?>
<!-- =====================Tworzenie użytkownika==================== -->
<form action="TWdodanieUsera.php" method="post"  style="width: 500px; margin:auto;">
    <h3 class="napisInfoStr">Tworzenie użytkownika</h3>
    <div class="mb-3">
      <div>
        <label for="">Typ użykownika</label>
        <select class="custom-select d-block w-100" name="typUsera" id="opcje" onchange="pokazMagazyn()">
          <option value="1">Administrator</option>
          <option value="0">Zwykły użytkownik</option>
        </select>
      </div>
    </div>

  <div id="zwykłyUserOpcja">
  
    <div id="opcja-1">
    <?php
    //Lista rozwijana, czyli lista magazynów do wyboru
    $sql1 = "SELECT * FROM magazyny";
    $result1 = $polaczenie->query($sql1);
    ?>
    <div class="mb-3">
      <div>
      <label for="magazyn">Magazyn</label>
      <select class="custom-select d-block w-100" name="magazyn">
        <?php
        if ($result1->num_rows > 0) 
        {
          while($row = $result1->fetch_assoc()) 
          {
            $nazwaM = $row["nazwa"];
            echo '<option value="'.$row["id_magazyny"].'">'.$row["nazwa"].'</option>';
          }
        }
        else
        {
          echo '<p>Brak magazynów</p>';
        }
        
        echo '</select>
        </div>
      </div>';
      ?>
    </div>
  </div>

    <div class="mb-3">
      <div>
        <label>Email</label>
        <input type="email" class="form-control" name="email">
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="">Hasło</label>
        <input type="password" class="form-control" name="haslo1">
      </div>
      <div class="col-md-6 mb-3">
        <label for="">Powtórz hasło</label>
        <input type="password" class="form-control" name="haslo2">
      </div>
    </div>
    
    <?php
    if(isset($_SESSION['infoTworzenie']))
    {
		  echo $_SESSION['infoTworzenie'];
    }
    ?>

    <div class="d-grid gap-2 col-6 mx-auto">
        <button class="btn btn-lg btn-glowny btn-block" type="submit">Dodaj</button>
    </div>
  </form>

  <br><hr class="mb-2"><br>

<!-- =====================Tworzenie magazynu======================= -->
    <form method="get" style="width: 500px; margin:auto;">
    <h3 class="napisInfoStr">Tworzenie magazynu</h3>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Ile użytkowników</label>
          <input type="number" value="1" class="form-control" min="1" max="15" name="ileUserow">
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
          <button class="btn btn-lg btn-glowny btn-block" type="submit">Zatwierdź</button>
        </div>
      </div>
    </form>

  <form action="TWdodanieMagazynu.php" method="post"  style="width: 500px; margin:auto;">
    <div class="mb-3">
      <div>
        <label><b>Nazwa magazynu</b></label>
        <input type="text" class="form-control" name="newWarehouse">
      </div>
    </div>

    <?php
    
    if(isset($_GET["ileUserow"]))
    {
      $ileUserow = intval($_GET['ileUserow']);
    }
    else
    {
      $ileUserow = 1;
    }

    $_SESSION['ileUserow'] = $ileUserow;

    for($i=1; $i <= $ileUserow; $i++)
    {
      echo '
      <div class="mb-3">
        <div>
          <label>Email użytkownika</label>
          <input type="email" class="form-control" name="email'.$i.'">
        </div>
      </div>';
    }

    if(isset($_SESSION['infoTworzenieMag']))
    {
		  echo $_SESSION['infoTworzenieMag'];
    }
    ?>

    <div class="d-grid gap-2 col-6 mx-auto">
        <button class="btn btn-lg btn-glowny btn-block" type="submit">Dodaj</button>
    </div>

  </form>

  <br><hr class="mb-2"><br>

<!-- =====================Tworzenie artykułu======================= -->
  <form action="TWdodanieArtykułu.php" method="post"  style="width: 500px; margin:auto;">
    <h3 class="napisInfoStr">Tworzenie artykułu</h3>

    <div class="mb-3">
      <div>
        <label>Nazwa artykułu</label>
        <input type="text" class="form-control" name="artykuł">
      </div>
    </div>

    <div class="mb-3">
      <div>
        <label>Nazwa jednostki miary</label>
        <input type="text" class="form-control" name="miara">
      </div>
    </div>

    <?php
    if(isset($_SESSION['infoTworzenieArt']))
    {
		  echo $_SESSION['infoTworzenieArt'];
    }
    ?>

    <div class="d-grid gap-2 col-6 mx-auto">
        <button class="btn btn-lg btn-glowny btn-block" type="submit">Dodaj</button>
    </div>

  </form>
</div>

<?php
    unset($_SESSION['infoTworzenie']);
    unset($_SESSION['infoTworzenieMag']);
    unset($_SESSION['infoTworzenieArt']);
?>

<script>
    //Skrypt ukrywania lub pokazywania magazynu podczas tworzenia użytkownika.
    var opcje = document.getElementById("opcje");
	  var zwykłyUserOpcja = document.getElementById("zwykłyUserOpcja");

    zwykłyUserOpcja.querySelector("#opcja-1").style.display = "none";

		function pokazMagazyn()
    {
			if (opcje.value == "0") 
      {
				zwykłyUserOpcja.querySelector("#opcja-1").style.display = "block";
			} 
      else if (opcje.value == "1") 
      {
				zwykłyUserOpcja.querySelector("#opcja-1").style.display = "none";
			}
		}
</script>

</body>
</html>