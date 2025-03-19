<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['tipo_usuario'] != 'comerciante') {
    // Se o usuário não estiver logado ou não for comerciante, redireciona para o login
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome_oferta']) && !empty(trim($_POST['nome_oferta']))) {
        $nome_oferta = $conn->real_escape_string(trim($_POST['nome_oferta']));

        if (isset($_FILES['imagem_oferta']) && $_FILES['imagem_oferta']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['imagem_oferta']['tmp_name'];
            $fileName = $_FILES['imagem_oferta']['name'];
            $newFileName = uniqid('oferta_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $uploadDir = 'uploads/produtos/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadFilePath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                // Recupera o id_comercio do usuário logado
                $id_comerciante = $_SESSION['user_id'];
                $sqlComercio = "SELECT id_comercio FROM comercio WHERE id_comerciante = $id_comerciante";
                $result = $conn->query($sqlComercio);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $id_comercio = $row['id_comercio'];

                    $data_encerramento = $conn->real_escape_string($_POST['data_encerramento']);

                    $sql = "INSERT INTO ofertas (id_comercio, nome_oferta, data_encerramento, imagem_oferta) 
                            VALUES ($id_comercio, '$nome_oferta', '$data_encerramento', '$uploadFilePath')";

                    if ($conn->query($sql) === TRUE) {
                        header("Location: conf.php");
                        exit();
                    } else {
                        echo "Erro ao cadastrar oferta: " . $conn->error;
                    }
                } else {
                    echo "Erro: Comerciante não possui um comércio registrado.";
                }

                $conn->close();
            } else {
                echo "Erro ao mover o arquivo para o diretório de uploads.";
            }
        } else {
            echo "Erro no upload do arquivo. Código de erro: " . $_FILES['imagem_oferta']['error'];
        }
    } else {
        echo "Erro: O nome da oferta é obrigatório.";
    }
}
?>
