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

$sql_usuario = "SELECT * FROM usuario WHERE id = $user_id";
$result_usuario = $conn->query($sql_usuario);

$usuario = null;
if ($result_usuario->num_rows > 0) {
    $usuario = $result_usuario->fetch_assoc();
} else {
    echo "Usuário não encontrado!";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;500;700&display=swap" rel="stylesheet">
    <title>Perfil do Usuário</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            width: 100%;
            padding: 16px 32px;
            background-color: #243a69;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
        }

        header a {
            color: white;
            font-size: 22px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        header a img {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }

        .perfil-usuario {
            background: #ffffff;
            color: #333;
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: left;
            margin-top: 100px;
        }

        h3 {
            margin-bottom: 30px;
            font-size: 30px;
            text-align: center;
            color: #243a69;
        }

        .perfil-info {
            margin-bottom: 24px;
        }

        .text-info label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .text-info input {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 18px;
            background-color: #f9f9f9;
            color: #333;
            font-size: 16px;
        }

        button {
            padding: 16px 24px;
            background-color: #4098D0;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            margin-top: 12px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #327bb3;
        }

        .btn-excluir {
            background-color: #f44336;
            margin-top: 20px;
        }

        .btn-excluir:hover {
            background-color: #e53935;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }

        .popup button {
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
        }

        .popup button.confirm {
            background-color: #f44336;
            color: white;
        }

        .popup button.cancel {
            background-color: #4098D0;
            color: white;
        }

        @media (max-width: 768px) {
            .perfil-usuario {
                padding: 28px;
                max-width: 400px;
            }

            h3 {
                font-size: 26px;
            }

            .text-info input {
                font-size: 14px;
                padding: 12px;
            }

            button {
                font-size: 16px;
                padding: 14px 22px;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 10px 20px;
            }

            header a {
                font-size: 20px;
            }

            .perfil-usuario {
                padding: 20px;
                max-width: 350px;
            }

            h3 {
                font-size: 22px;
            }

            .text-info input {
                font-size: 12px;
                padding: 10px;
            }

            button {
                font-size: 14px;
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>

<header>
    <a href="telaincial_user.php"><img src="casa.svg" alt="Home"></a>
</header>

<main style="display: flex; justify-content: center; align-items: center; flex-direction: column; width: 100%;">
    <div class="perfil-usuario">
        <h3>Meu Perfil</h3>
        <form method="POST" action="atualizar_usuario.php">
            <div class="perfil-info">
                <div class="text-info">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" required>
                    
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>
                    
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" placeholder="Digite a nova senha">
                </div>
            </div>
            <button type="submit">Salvar Alterações</button>
        </form>

        <button class="btn-excluir" onclick="exibirPopUp()">Excluir Conta</button>
    </div>
</main>

<div class="popup" id="popup">
    <div class="popup-content">
        <p>Tem certeza de que deseja excluir sua conta? Essa ação não pode ser desfeita.</p>
        <button class="confirm" onclick="excluirUsuario()">Confirmar</button>
        <button class="cancel" onclick="fecharPopUp()">Cancelar</button>
    </div>
</div>

<script>
    function exibirPopUp() {
        document.getElementById('popup').style.display = 'flex';
    }

    function fecharPopUp() {
        document.getElementById('popup').style.display = 'none';
    }

    function excluirUsuario() {
        window.location.href = "excluir_usuario.php";
    }
</script>

</body>
</html>
