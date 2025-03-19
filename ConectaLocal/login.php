<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mercado";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id, nome, senha, tipo_usuario FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome, $senhaHash, $tipo_usuario);
        $stmt->fetch();

        if (password_verify($senha, $senhaHash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $nome;
            $_SESSION['tipo_usuario'] = $tipo_usuario;

            if ($tipo_usuario === 'admin') {
                $_SESSION['user_id'] = $id;
                header("Location: admin_solicitacoes.php");
            } elseif ($tipo_usuario === 'user') {
                $_SESSION['user_id'] = $id;
                header("Location: telaincial_user.php");
            } else {
                $_SESSION['user_id'] = $id;
                header("Location: telaincial_comerciante.php");
            }
            exit();
        } else {
            $error = "Senha incorreta.";
        }
    } else {
        $error = "E-mail não encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>
