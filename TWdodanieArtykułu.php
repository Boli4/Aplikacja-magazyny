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

$artykuł = $_POST["artykuł"];
$miara = $_POST["miara"];

  $sql = "SELECT * FROM artykuły WHERE nazwa = '$artykuł'";
  $result = $polaczenie->query($sql);

  $sql2 = "SELECT * FROM jednostki_miary WHERE nazwa = '$miara'";
  $result2 = $polaczenie->query($sql2);

//Sprawdzanie nazwy artykułu
  if ($artykuł == null) 
  {
      $_SESSION['infoTworzenieArt'] = '<p style="color:red">Nie podano nazwy artykułu.</p>';
      header('Location: tworzenie.php');
  } 
  else if ($result->num_rows > 0) 
  {
      $_SESSION['infoTworzenieArt'] = '<p style="color:red">Podany artykuł istnieje.</p>';
      header('Location: tworzenie.php');
  }
//Sprawdzanie nazwy artykułu
  else if ($miara == null) 
  {
      $_SESSION['infoTworzenieArt'] = '<p style="color:red">Nie podano nazwy miary.</p>';
      header('Location: tworzenie.php');
  } 
  else if ($result2->num_rows > 0) 
  {
      $_SESSION['infoTworzenieArt'] = '<p style="color:red">Podana miara istnieje.</p>';
      header('Location: tworzenie.php');
  }
  else
  {
        //Dodanie artykułu
        $sql = "INSERT INTO artykuły VALUES (NULL, '$artykuł')";   
        if ($polaczenie->query($sql) === TRUE) 
        {
          //Dodanie miary
          $sql = "INSERT INTO jednostki_miary VALUES (NULL, '$miara')";   
          if ($polaczenie->query($sql) === TRUE) 
          {
            $_SESSION['infoTworzenieArt'] = '<p>Artykuł i jednoska miary dodana pomyślnie.</p>';
            header('Location: tworzenie.php');
          }   
        } 
        else
        {
          echo "Błąd: " . $sql . "<br>" . $polaczenie->error;
        }
  }

$polaczenie->close();
?>