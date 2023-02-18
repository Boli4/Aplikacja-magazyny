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

    <title>Strona główna</title>
</head>
  
<body>

<div class="container p-3 mx-auto flex-column">
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
<?php
  //=============Lista rozwijana, czyli lista magazynów do wyboru===============
  $idU = $_SESSION['id_uzytkownicy'];
  $sql1 = "SELECT * FROM magazyny m inner join magazyny_user u on (m.id_magazyny = u.id_magazyn) WHERE id_user = $idU";
  if($_SESSION['admin'] == 1)
	{
		  $sql1 = "SELECT * FROM magazyny";
	}
  $result1 = $polaczenie->query($sql1);
  ?>
  <form method="POST" action="">
    <label for="ID">Wybierz magazyn:</label>
    <select name="ID" id="ID">
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
    <button type="submit" name="submit">Pokaż magazyn</button>
  </form>
<?php

if(isset($_POST['ID']))
{
  $id = $_POST['ID'];

  //==========Wyświetlanie nazwy magazynu który jest wybrany===============
  $sql2 = "SELECT * FROM magazyny WHERE id_magazyny = $id";
  $result2 = $polaczenie->query($sql2);
  if ($result2->num_rows > 0) 
  {
    while($row = $result2->fetch_assoc()) 
    {
      echo '<h3 class="text-center">'.$row["nazwa"].'</h3>';
    }
  } 
  else 
  {
    echo '<h3 class="text-center">Nie znaleziono magazynów.</h3>';
  }

//===========Wyświetlanie tabeli============
  echo '
  <table class="table table-striped table-dark">
      <thead>
         <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa artykułu</th>
            <th scope="col">Ilość</th>
            <th scope="col">Miara</th>
            <th scope="col">VAT</th>
            <th scope="col">Cena jednostkowa</th>
            <th scope="col">Plik</th>
         </tr>
      </thead>';

  $zap = "SELECT * FROM magazyny m inner join przyjęcie p on (m.id_magazyny = p.id_magazyn) WHERE id_magazyny = $id";
  $wynik = mysqli_query($polaczenie, $zap);
  $i = 0;

  if(mysqli_num_rows($wynik)>0)
  {
     echo '<tbody>';
     while($rekord = mysqli_fetch_assoc($wynik))
     {
        ?>      
         <tr>
               <th scope="row">
               <?php
               $i = $i + 1;
               echo $i
               ?></th>
               <td><?php echo $rekord['nazwa'];?></td>
               <td><?php echo $rekord['ilość'];?></td>
               <td><?php echo $rekord['miara'];?></td>
               <td><?php echo $rekord['VAT'];?></td>
               <td><?php echo $rekord['cena'];?></td>
               <td>
                  <?php 
                  echo '<a class="btn btn btn-glowny btn-block" href="pobieraniePliku.php?file='.$rekord['plikSciezka'].'">Pobierz</a>';
                  ?>
               </td>
         </tr>
        
        <?php
     }
     echo '</tbody>';
  }
}
   mysqli_close($polaczenie);

?>
</table>

</div>

</body>
</html>