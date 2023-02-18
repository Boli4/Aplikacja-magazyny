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

    $artykuly = $_POST['arytkuły'];
    $ilosc = $_POST['ilosc'];
    $miara = $_POST['miara'];
    $vat = $_POST['VAT'];
    $cenaJednostkowa = $_POST['CJ'];
    if($_SESSION['admin'] == 1)
    {
        $magazyn = $_POST['magazyn'];
    }
    else
    {
        $magazyn = $_SESSION['magazyn'];
    }


    $uploadOk = 1; //Zmienna wskazująca czy można wykonać zapytanie

    if($ilosc == 0 || $vat == 0 || $cenaJednostkowa == 0)
    {
        $_SESSION['infoPrzyjecie'] = '<p style="color:red">Ilość, VAT lub cena wynosi 0.</p>';
        $uploadOk = 0;
        header('Location: przyjecie.php');
    }
    /*else
    {
        $zap = "INSERT INTO przyjęcie VALUES (NULL, '$artykuly', '$ilosc', '$miara', '$vat', '$cenaJednostkowa', '$target_file', '$magazyn')";
        mysqli_query($polaczenie, $zap);

        $_SESSION['infoPrzyjecie'] = '<p>Artykuł został dodany.</p>';
        header('Location: przyjecie.php');
    }*/

    //=============Skrypt przesłania pliku do katalogu uploads================
      $target_dir = "uploads/";
      $nazwaPliku = basename($_FILES["fileToUpload"]["name"]);
      $target_file = $target_dir . $nazwaPliku;
      $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
      //Sprawdzenie, czy plik jest w formacie PDF lub XML
      if($FileType != "pdf" && $FileType != "xml") 
      {
        $_SESSION['infoPrzyjecie'] = '<p style="color:red">Tylko pliki PDF i XML są dozwolone.</p>';
        header('Location: przyjecie.php');
          $uploadOk = 0;
      }
  
      //Sprawdzenie, czy liczba plików jest mniejsza niż 4
      if (count(glob("uploads/*.{pdf,xml}")) >= 4) 
      {
        $_SESSION['infoPrzyjecie'] = '<p style="color:red">Możesz wybrać maksymalnie 4 pliki.</p>';
        header('Location: przyjecie.php');
          $uploadOk = 0;
      }
  
      //Sprawdzenie, czy plik istnieje
      if (file_exists($target_file)) 
      {
        $_SESSION['infoPrzyjecie'] = '<p style="color:red">Plik już istnieje.</p>';
        header('Location: przyjecie.php');
          $uploadOk = 0;
      }
  
      //Sprawdzenie, czy $uploadOk jest równe 0
      if ($uploadOk == 0)
      {
        $_SESSION['infoPrzyjecie'] = '<p style="color:red">Artykuł nie został dodany.</p>';
        header('Location: przyjecie.php');
      } 
      else 
      {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
          {
                //$_SESSION['infoPrzyjecie'] = "Plik ". basename( $_FILES["fileToUpload"]["name"]). " został wysłany.";
                $_SESSION['infoPrzyjecie'] = '<p>Dodano artykuł</p>';
                $zap = "INSERT INTO przyjęcie VALUES (NULL, '$artykuly', '$ilosc', '$miara', '$vat', '$cenaJednostkowa', '$nazwaPliku', '$magazyn')";
                mysqli_query($polaczenie, $zap);
                header('Location: przyjecie.php');
          } 
          else 
          {
                $_SESSION['infoPrzyjecie'] = '<p style="color:red">Wystąpił błąd podczas wysyłania pliku.</p>';
                header('Location: przyjecie.php');
          }
      }

   mysqli_close($polaczenie);
?>