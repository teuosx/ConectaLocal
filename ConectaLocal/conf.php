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
$sql_comercio = "SELECT * FROM comercio WHERE id_comerciante = $user_id";
$result_comercio = $conn->query($sql_comercio);
$comercio = null;
if ($result_comercio->num_rows > 0) {
    $comercio = $result_comercio->fetch_assoc();
} else {
    echo "Nenhum comércio encontrado!";
    exit();
}

$sql_encartes = "SELECT * FROM encartes WHERE id_comercio = " . $comercio['id_comercio'];
$result_encartes = $conn->query($sql_encartes);

$sql_ofertas = "SELECT * FROM ofertas WHERE id_comercio = " . $comercio['id_comercio'];
$result_ofertas = $conn->query($sql_ofertas);

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
    <title>Perfil do Mercado</title>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            background-color: #243a69;
            color: white;
        }

        main {
            padding: 20px;
        }

        .perfil-mercado, .encartes, .ofertas {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .perfil-info {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .perfil-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 16px;
        }

        .perfil-info .text-info {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .perfil-info .text-info label {
            font-weight: 500;
            color: #555;
        }

        .perfil-info .text-info input {
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 100%;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            background-color: #4098D0;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 12px;
        }

        button:hover {
            background-color: #327bb3;
        }

        .delete-btn {
            background-color: #D04545;
        }

        .delete-btn:hover {
            background-color: #b03b3b;
        }

        .delete-icon {
            width: 30px; 
            height: 30px; 
            background: red;
            border-radius: 20%;
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }

        .delete-icon img {
            width: 10px; 
            height: 10px; 
            object-fit: contain; 
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h4 {
            margin-bottom: 20px;
            color: #333;
        }

        .modal-content button {
            margin: 0 10px;
        }
        .modal-content button:nth-child(1) {
            background-color: #D04545;
            color: white;
        }

        .modal-content button:nth-child(1):hover {
            background-color: #b03b3b;
        }

        .encarte-item img {
            width: 250px;
            height: 250px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .encarte-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .encarte-item a {
            margin-top: 5px;
        }
    </style>
    <script>
        function abrirModal() {
            document.getElementById("modal-excluir").style.display = "flex";
        }

        function fecharModal() {
            document.getElementById("modal-excluir").style.display = "none";
        }

        function confirmarExclusao() {
            window.location.href = "excluir_comercio.php";
        }
    </script>
</head>
<body>

<header>
    <a href="telaincial_comerciante.php"><img src="casa.svg" alt="Home"></a>
</header>

<main>
    <div class="perfil-mercado">
        <h3>Meu Mercado</h3>
        <form method="POST" action="atualizar_mercado.php" enctype="multipart/form-data">
            <div class="perfil-info">
                <img src="<?php echo $comercio['imagem_perfil']; ?>" alt="Imagem do perfil">
                <div class="text-info">
                    <label for="nome_fantasia">Nome do Mercado:</label>
                    <input type="text" name="nome_fantasia" value="<?php echo $comercio['nome_fantasia']; ?>" required>
                    
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" value="<?php echo $comercio['endereco']; ?>" required>
                    
                    <label for="telefone_comercio">Telefone:</label>
                    <input type="text" name="telefone_comercio" value="<?php echo $comercio['telefone_comercio']; ?>" required>
                    
                    <label for="horario_abertura">Horário de Abertura:</label>
                    <input type="time" name="horario_abertura" value="<?php echo $comercio['horario_abertura']; ?>" required>
                    
                    <label for="horario_fechamento">Horário de Fechamento:</label>
                    <input type="time" name="horario_fechamento" value="<?php echo $comercio['horario_fechamento']; ?>" required>
                </div>
            </div>
            <button type="submit">Salvar Alterações</button>
        </form>
        <button class="delete-btn" onclick="abrirModal()">Excluir Comércio</button>
    </div>

    <div class="encartes">
        <h3>Encarte(s)</h3>
        <div class="adicionar-botoes">
            <button onclick="window.location.href='attencarte.html'">Adicionar Encarte</button>
        </div>
        <?php if ($result_encartes->num_rows > 0): ?>
            <?php while ($encarte = $result_encartes->fetch_assoc()): ?>
                <div class="encarte-item">
                    <img src="<?php echo $encarte['imagem_encarte']; ?>" alt="Encarte">
                    <a href="excluir_encarte.php?id=<?php echo $encarte['id_encarte']; ?>" class="delete-icon">
                        <img src="delete.svg" alt="Excluir" style="width: 20px; height: 20px; align-items: center;">
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Não há encartes cadastrados.</p>
        <?php endif; ?>
    </div>

    <div class="ofertas">
        <h3>Oferta(s)</h3>
        <div class="adicionar-botoes">
            <button onclick="window.location.href='attoferta.html'">Adicionar Oferta</button>
        </div>
        <?php if ($result_ofertas->num_rows > 0): ?>
            <?php while ($oferta = $result_ofertas->fetch_assoc()): ?>
                <div class="encarte-item">
                    <img src="<?php echo $oferta['imagem_oferta']; ?>" alt="Oferta">
                    <a href="excluir_oferta.php?id=<?php echo $oferta['id_oferta']; ?>" class="delete-icon">
                        <img src="delete.svg" alt="Excluir" style="width: 20px; height: 20px;">
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Não há ofertas cadastradas.</p>
        <?php endif; ?>
    </div>
</main>

<div class="modal" id="modal-excluir">
    <div class="modal-content">
        <h4>Tem certeza que deseja excluir seu comércio? Você perderá também sua conta de comerciante.</h4>
        <button onclick="confirmarExclusao()">Confirmar</button>
        <button onclick="fecharModal()">Cancelar</button>
    </div>
</div>

</body>
</html>
