<?php

session_start();

if (!isset($_SESSION['zalogowany'])) 
{
    header('Location: index.php');
    exit();
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

    <title>Przyjęcie towaru</title>
</head>
  
<body>

<div class="container-sm p-3 mx-auto flex-column">
	<?php
    //============Wyświetlanie odpowiedniego headera w zależności czy jesteś adminem czy nie==============
    if($_SESSION['admin'] == 1)
		{
		  require_once "headerAdmin.php";
		}
		else
		{
			require_once "headerUser.php";
		}
    ?>

<h3 class="text-center">Przyjmij artykuł</h3>
<?php
	if(isset($_SESSION['infoPrzyjecie']))
    {
		echo $_SESSION['infoPrzyjecie'];
    }
?>
<form action="przyjecieSkrypt.php" method="post" enctype="multipart/form-data">
    <table class="table table-striped table-dark">
    <thead>
        <tr>
        <th scope="col">Nazwa artykułu</th>
        <th scope="col">Ilość</th>
        <th scope="col">Miara</th>
        <th scope="col">VAT</th>
        <th scope="col">Cena jednostkowa</th>
        <th scope="col">Plik</th>
        <th scope="col">Magazyn</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td>
            <select name="arytkuły" id="arytkuły">
            <?php
            //========Lista artykułów do wyboru============
            $sqlNazwa = "SELECT * FROM artykuły";
            $resultNazwa = $polaczenie->query($sqlNazwa);
            if ($resultNazwa->num_rows > 0) 
            {
                while($row = $resultNazwa->fetch_assoc()) 
                {
                echo '<option value="'.$row["nazwa"].'">'.$row["nazwa"].'</option>';
                }
            }
            else
            {
                echo '<p>Brak artykułów</p>';
            }
            ?>
            </select>
        </td>
        <td>
            <input type="number" name="ilosc" size="6" value="0">
        </td>
        <td>
            <select name="miara" id="miara">
            <?php
            //===========Lista miar do wyboru=============
            $sqlMiara = "SELECT * FROM jednostki_miary";
            $resultMiara = $polaczenie->query($sqlMiara);
            if ($resultMiara->num_rows > 0) 
            {
                while($row = $resultMiara->fetch_assoc()) 
                {
                echo '<option value="'.$row["nazwa"].'">'.$row["nazwa"].'</option>';
                }
            }
            else
            {
                echo '<p>Brak miar</p>';
            }
            ?>
            </select>
        </td>
        <td>
            <input type="number" name="VAT" size="6" value="0">
        </td>
        <td>
            <input type="number" name="CJ" size="6" value="0">
        </td>
        <td>
            <input type="file" name="fileToUpload" id="fileToUploa">
        </td>

        <?php
        //============Lista magazynów do wyboru==============
            echo '<td>';
            $idU = $_SESSION['id_uzytkownicy'];
            $sql1 = "SELECT * FROM magazyny m inner join magazyny_user u on (m.id_magazyny = u.id_magazyn) WHERE id_user = $idU";
            if($_SESSION['admin'] == 1)
            {
                $sql1 = "SELECT * FROM magazyny";
            }
            $result1 = $polaczenie->query($sql1);
            ?>
              <select name="magazyn" id="ID">
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
                ?>
              </select>
            </td>
            <?php 
        ?>

        </tr>
    </tbody>
    </table>
    <div class="d-grid gap-2 col-6 mx-auto">
        <button class="btn btn-lg btn-glowny btn-block" type="submit">Dodaj</button>
    </div>
</form>
</table>

<?php
    unset($_SESSION['infoPrzyjecie']);
?>

</div>

</body>
</html>