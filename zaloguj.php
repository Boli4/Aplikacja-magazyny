<?php

session_start();

if (!isset($_POST['email']) || !isset($_POST['password'])) 
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";

try 
{
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
} 
catch (PDOException $e) 
{
    echo "Error: " . $e->getMessage();
}

$login = $_POST['email'];
$haslo = $_POST['password'];

$login = htmlentities($login, ENT_QUOTES, "UTF-8");

$stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE email = :login");
$stmt->bindParam(':login', $login, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) 
{
    if (password_verify($haslo, $user['haslo'])) 
	{
        $_SESSION['zalogowany'] = true;
        $_SESSION['id_uzytkownicy'] = $user['id_uzytkownicy'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['admin'] = $user['admin'];

        unset($_SESSION['blad']);
        header('Location: strGlowna.php');
    } 
	else 
	{
        $_SESSION['blad'] = '<p style="color:red">Nieprawidłowy login lub hasło!</p>';
        header('Location: index.php');
    }
} 
else 
{
    $_SESSION['blad'] = '<p style="color:red">Nieprawidłowy login lub hasło!</p>';
    header('Location: index.php');
}

$pdo = null;

?>