<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mercado"; // Nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão com o banco de dados foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Excluir o usuário
$sql = "DELETE FROM usuario WHERE id = $user_id";

if ($conn->query($sql) === TRUE) {
    // Destruir a sessão após a exclusão
    session_destroy();

    // Redirecionar para index.html após a exclusão
    header("Location: index.html");
    exit();
} else {
    echo "Erro ao excluir usuário: " . $conn->error;
}

$conn->close();
?>
