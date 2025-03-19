<?php
$host = 'localhost';
$db = 'mercado'; 
$user = 'root'; 
$password = ''; 

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];


    if ($senha !== $confirmar_senha) {
        echo "As senhas não coincidem.";
        exit;
    }

    $senha_hash = password_hash($senha, PASSWORD_BCRYPT); 


    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        echo "Este e-mail já está registrado. Tente outro.";
        exit;
    }


    $sql = "INSERT INTO usuario (nome, email, senha, tipo_usuario) VALUES ('$nome', '$email', '$senha_hash', 'user')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.html"); 
        exit;
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }
}

$conn->close();
?>
