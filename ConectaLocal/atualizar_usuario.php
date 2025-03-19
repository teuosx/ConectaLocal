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

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

if (!empty($senha)) {
    $senha = password_hash($senha, PASSWORD_DEFAULT); 
} else {
    $sql_usuario = "SELECT senha FROM usuario WHERE id = $user_id";
    $result_usuario = $conn->query($sql_usuario);
    if ($result_usuario->num_rows > 0) {
        $usuario = $result_usuario->fetch_assoc();
        $senha = $usuario['senha']; 
    }
}

$sql_atualizar = "UPDATE usuario SET nome = ?, email = ?, senha = ? WHERE id = ?";
$stmt = $conn->prepare($sql_atualizar);
$stmt->bind_param("sssi", $nome, $email, $senha, $user_id);

if ($stmt->execute()) {
    header("Location: conf_user.php");
    exit(); 
} else {
    echo "Erro ao atualizar os dados: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
