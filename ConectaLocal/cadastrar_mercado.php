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

function validar_cnpj($cnpj) {
    $cnpj = preg_replace('/\D/', '', $cnpj);
    if (strlen($cnpj) != 14) {
        return false;
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_fantasia = $_POST['nome_fantasia'];
    $cnpj = $_POST['cnpj'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $horario_abertura = $_POST['horario_abertura'];
    $horario_fechamento = $_POST['horario_fechamento'];

    if (!isset($_SESSION['user_id'])) {
        die("Erro: Você precisa estar logado para cadastrar um comércio.");
    }
    $id_usuario = $_SESSION['user_id'];  
    $status_funcionamento = "pendente";

    if (empty($nome_fantasia) || empty($endereco) || empty($telefone) || empty($horario_abertura) || empty($horario_fechamento)) {
        die("Erro: Todos os campos são obrigatórios.");
    }

    if (!validar_cnpj($cnpj)) {
        die("Erro: CNPJ inválido.");
    }

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem_nome = $_FILES['imagem']['name'];
        $imagem_tmp = $_FILES['imagem']['tmp_name'];
        $imagem_destino = "uploads/" . $imagem_nome;

        $imagem_tipo = mime_content_type($imagem_tmp);
        if (strpos($imagem_tipo, 'image') === false) {
            die("Erro: O arquivo enviado não é uma imagem.");
        }

        if ($_FILES['imagem']['size'] > 5 * 1024 * 1024) {
            die("Erro: O arquivo é muito grande. O tamanho máximo permitido é 5MB.");
        }

        if (!move_uploaded_file($imagem_tmp, $imagem_destino)) {
            die("Erro: Não foi possível mover a imagem.");
        }
    } else {
        die("Erro: Nenhuma imagem foi enviada.");
    }

    // Inserção no banco de dados
    $sql = "INSERT INTO comercio (nome_fantasia, endereco, telefone_comercio, cnpj, status_funcionamento, id_comerciante, imagem_perfil, horario_abertura, horario_fechamento) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssss", $nome_fantasia, $endereco, $telefone, $cnpj, $status_funcionamento, $id_usuario, $imagem_destino, $horario_abertura, $horario_fechamento);

        if ($stmt->execute()) {
            // Atualizando o tipo de usuário para 'comerciante'
            $sql_usuario = "UPDATE usuario SET tipo_usuario = 'comerciante' WHERE id = ?";
            if ($stmt_usuario = $conn->prepare($sql_usuario)) {
                $stmt_usuario->bind_param("i", $id_usuario);
                if (!$stmt_usuario->execute()) {
                    die("Erro ao atualizar tipo de usuário: " . $stmt_usuario->error);
                }
                $stmt_usuario->close();
            }

            header("Location: telaincial_user.php");
            exit();
        } else {
            die("Erro ao inserir no banco de dados: " . $stmt->error);
        }

        $stmt->close();
    } else {
        die("Erro na preparação da consulta: " . $conn->error);
    }
}

$conn->close();
?>
