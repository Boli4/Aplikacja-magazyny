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
    if($_SESSION['admin'] == 1)
    {
        $magazyn = $_POST['magazyn'];
    }
    else
    {
        $magazyn = $_SESSION['magazyn'];
    }

    if($ilosc == 0)
    {
        $_SESSION['infoPrzyjecie'] = '<p style="color:red">Ilość wynosi 0.</p>';
        header('Location: wydanie.php');
    } 
    else 
    {
        $_SESSION['infoPrzyjecie'] = '<p>Wydano artykuł</p>';
        $zap = "INSERT INTO wydanie VALUES (NULL, '$artykuly', '$ilosc')";
        mysqli_query($polaczenie, $zap);
        header('Location: wydanie.php');
    }

   mysqli_close($polaczenie);
?>