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

$admin = $_POST["typUsera"];
$email = $_POST["email"];
$haslo = $_POST["haslo1"];
$haslo2 = $_POST["haslo2"];

if($_POST["typUsera"] == 0)
{
    $magazyn = $_POST["magazyn"];
}
else
{
    $magazyn = 0;
}

$sql = "SELECT * FROM uzytkownicy WHERE email = '$email'";
$result = $polaczenie->query($sql);
if ($email == null || $haslo == null) 
{
    $_SESSION['infoTworzenie'] = '<p style="color:red">Dane nie zostały podane prawidłowo.</p>';
    header('Location: tworzenie.php');
} 
else if ($result->num_rows > 0) 
{
    $_SESSION['infoTworzenie'] = '<p style="color:red">Użytkownik o podanym loginie lub emailu już istnieje.</p>';
    header('Location: tworzenie.php');
} 
else 
{
  // sprawdzenie, czy podane hasła są identyczne
  if ($haslo != $haslo2) 
  {
    $_SESSION['infoTworzenie'] = '<p style="color:red">Podane hasła nie są identyczne.</p>';
    header('Location: tworzenie.php');
  } 
  else 
  {
    $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

    //Zapytanie tworzące użytkownika
    $sql = "INSERT INTO uzytkownicy VALUES (NULL, '$email', '$haslo_hash', '$admin')";   
    if ($polaczenie->query($sql) === TRUE) 
    {
      if($_POST["typUsera"] == 0) //Jeśli jest zwykłym userem.
      {
        //Zapytanie wyciągające id właśnie dodanego użytkownika (zwykłego).
        $sql2 = "SELECT * FROM uzytkownicy ORDER BY id_uzytkownicy DESC LIMIT 1";
        $result = mysqli_query($polaczenie, $sql2);
        $row = mysqli_fetch_array($result);
        $idUsera = $row['id_uzytkownicy'];

        //Dodanie informacji pod jaki magazyn jest przypisany zwykły user.
        $sql3 = "INSERT INTO magazyny_user VALUES ('$idUsera', '$magazyn')";
        if ($polaczenie->query($sql3) === TRUE) 
        {
            $_SESSION['infoTworzenie'] = '<p>Użytkownik zarejestrowany pomyślnie.</p>';
            header('Location: tworzenie.php');
        } 
        else
        {
          echo "Błąd: " . $sql3 . "<br>" . $polaczenie->error;
        }
      }
      else //Dla powstałego usera admina
      {
        $_SESSION['infoTworzenie'] = '<p>Użytkownik zarejestrowany pomyślnie.</p>';
        header('Location: tworzenie.php');
      }
    } 
    else
    {
      echo "Błąd: " . $sql . "<br>" . $polaczenie->error;
    }
  }
}

$polaczenie->close();
?>