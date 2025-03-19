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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_fantasia = $_POST['nome_fantasia'];
    $endereco = $_POST['endereco'];
    $telefone_comercio = $_POST['telefone_comercio'];
    $horario_abertura = $_POST['horario_abertura'];
    $horario_fechamento = $_POST['horario_fechamento'];
    
    $imagem_perfil = $comercio['imagem_perfil'];
    if (isset($_FILES['imagem_perfil']) && $_FILES['imagem_perfil']['error'] == 0) {
        $extensao = pathinfo($_FILES['imagem_perfil']['name'], PATHINFO_EXTENSION);
        $imagem_perfil = 'uploads/' . uniqid() . '.' . $extensao;
        move_uploaded_file($_FILES['imagem_perfil']['tmp_name'], $imagem_perfil);
    }

    $sql_update = "UPDATE comercio SET nome_fantasia = ?, endereco = ?, telefone_comercio = ?, horario_abertura = ?, horario_fechamento = ?, imagem_perfil = ? WHERE id_comercio = ?";
    
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssssi", $nome_fantasia, $endereco, $telefone_comercio, $horario_abertura, $horario_fechamento, $imagem_perfil, $user_id);
    
    if ($stmt->execute()) {
        header("Location: conf.php");
        exit();
    } else {
        echo "Erro ao atualizar os dados do comércio.";
    }

    $stmt->close();
}

$conn->close();
?>
