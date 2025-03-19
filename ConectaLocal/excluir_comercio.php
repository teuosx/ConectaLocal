<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mercado";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$sql_excluir_comercio = "DELETE FROM comercio WHERE id_comerciante = ?";
$stmt_comercio = $conn->prepare($sql_excluir_comercio);
$stmt_comercio->bind_param("i", $user_id);
$stmt_comercio->execute();

$sql_excluir_usuario = "DELETE FROM usuario WHERE id = ?";
$stmt_usuario = $conn->prepare($sql_excluir_usuario);
$stmt_usuario->bind_param("i", $user_id);
$stmt_usuario->execute();

$stmt_comercio->close();
$stmt_usuario->close();
$conn->close();

session_destroy();

header("Location: index.html");
exit();
?>
