<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mercado";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$id_comercio = $_POST['id_comercio'];
$acao = $_POST['acao'];

if ($acao === 'aprovar') {
    $status = 'ativo';
} elseif ($acao === 'recusar') {
    $status = 'inativo';
} else {
    die("Ação inválida.");
}

$sql = "UPDATE comercio SET status_funcionamento = ? WHERE id_comercio = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id_comercio);

if ($stmt->execute()) {
    if ($status === 'ativo') {
        $sql_comercio = "SELECT id_comerciante FROM comercio WHERE id_comercio = ?";
        $stmt_comercio = $conn->prepare($sql_comercio);
        $stmt_comercio->bind_param("i", $id_comercio);
        $stmt_comercio->execute();
        $stmt_comercio->bind_result($id_comerciante);
        $stmt_comercio->fetch();
        $stmt_comercio->close();

        if ($id_comerciante) {
            $sql_usuario = "UPDATE usuario SET tipo_usuario = 'comerciante' WHERE id = ?";
            $stmt_usuario = $conn->prepare($sql_usuario);
            $stmt_usuario->bind_param("i", $id_comerciante);
            $stmt_usuario->execute();
            $stmt_usuario->close();
        }
    }

    header("Location: admin_solicitacoes.php");
    exit();
} else {
    echo "Erro ao atualizar status.";
}

$stmt->close();
$conn->close();
?>
