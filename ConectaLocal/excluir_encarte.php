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

// Verificar se o parâmetro 'id' foi passado
if (isset($_GET['id'])) {
    $id_encarte = $_GET['id'];

    // Verificar se o encarte pertence ao comerciante
    $user_id = $_SESSION['user_id'];
    $sql_comercio = "SELECT id_comercio FROM comercio WHERE id_comerciante = $user_id";
    $result_comercio = $conn->query($sql_comercio);
    if ($result_comercio->num_rows > 0) {
        $comercio = $result_comercio->fetch_assoc();
        $id_comercio = $comercio['id_comercio'];

        // Excluir o encarte
        $sql = "DELETE FROM encartes WHERE id_encarte = ? AND id_comercio = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_encarte, $id_comercio);
        if ($stmt->execute()) {
            // Redirecionar para a página de confirmação
            header("Location: conf.php");
            exit();
        } else {
            echo "Erro ao excluir encarte!";
        }
    } else {
        echo "Comércio não encontrado!";
    }
} else {
    echo "ID do encarte não especificado!";
}

$conn->close();
?>
