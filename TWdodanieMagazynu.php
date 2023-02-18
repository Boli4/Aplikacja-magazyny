<?php

session_start();

if (!isset($_SESSION['zalogowany'])) 
{
    header('Location: index.php');
    exit();
}

if($_SESSION['admin'] != 1)
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

$nowyMag = $_POST["newWarehouse"];
$ileUserow = $_SESSION['ileUserow'];

//Sprawdzanie nazwy magazynu
  $sql = "SELECT * FROM magazyny WHERE nazwa = '$nowyMag'";
  $result = $polaczenie->query($sql);
  if ($nowyMag == null) 
  {
      $_SESSION['infoTworzenieMag'] = '<p style="color:red">Nie podano nazwy magazynu.</p>';
      header('Location: tworzenie.php');
  } 
  else if ($result->num_rows > 0) 
  {
      $_SESSION['infoTworzenieMag'] = '<p style="color:red">Podany magazyn istnieje.</p>';
      header('Location: tworzenie.php');
  }
  else
  {
    //Sprawdzanie nazwy użytkowników
    for($i=1; $i <= $ileUserow; $i++)
    {
      $email = $_POST["email".$i.""];
      $sql = "SELECT * FROM uzytkownicy WHERE email = '$email'";
      $result = $polaczenie->query($sql);
      if ($result->num_rows == 0) 
      {
        $_SESSION['infoTworzenieMag'] = '<p style="color:red">Któryś z podanych użytkowników nie istnieje.</p>';
        header('Location: tworzenie.php');
      }
      else
      {
        //Dodanie magazynu
        $sql = "INSERT INTO magazyny VALUES (NULL, '$nowyMag')";   
        if ($polaczenie->query($sql) === TRUE) 
        {
          $sql2 = "SELECT * FROM magazyny ORDER BY id_magazyny DESC LIMIT 1";
          $result = mysqli_query($polaczenie, $sql2);
          $row = mysqli_fetch_array($result);
          $idMagazynu = $row['id_magazyny'];

          for($i=1; $i <= $ileUserow; $i++)
          {
            $email = $_POST["email".$i.""];
            $sql3 = "SELECT * FROM uzytkownicy WHERE email = '$email'";
            $result = mysqli_query($polaczenie, $sql3);
            $row = mysqli_fetch_array($result);
            $idUsera = $row['id_uzytkownicy'];
    
            $sql4 = "INSERT INTO magazyny_user VALUES (NULL, '$idUsera', '$idMagazynu')";
            mysqli_query($polaczenie, $sql4);
          }
    
          $_SESSION['infoTworzenieMag'] = '<p>Magazyn i przypisani użytkownicy dodani pomyślnie.</p>';
          header('Location: tworzenie.php');
    
        } 
        else
        {
          echo "Błąd: " . $sql . "<br>" . $polaczenie->error;
        }
      }
    }
  }

$polaczenie->close();
?>