<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = ""; // Ajuste conforme sua configuração
$dbname = "mercado";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function getInitialPage() {
    if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'comerciante') {
        return 'telaincial_comerciante.php';
    } else {
        return 'telaincial_user.php';
    }
}

// Consulta para buscar os mercados ativos
$sql = "SELECT nome_fantasia, endereco, imagem_perfil, telefone_comercio, horario_abertura, horario_fechamento FROM comercio WHERE status_funcionamento = 'ativo'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
  <title>Mercados Ativos</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px;
      background-color: #243a69;
      color: white;
    }

    .header a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      margin: 0 12px;
    }

    .header a:hover {
      text-decoration: underline;
    }

    .header-search {
      flex-grow: 1;
      display: flex;
      align-items: center;
      background-color: #3F5A96;
      border-radius: 12px;
      padding: 8px;
      margin: 0 20px;
    }

    .header-search input {
      flex-grow: 1;
      border: none;
      outline: none;
      background: transparent;
      color: white;
      padding-left: 8px;
    }

    .header-search input::placeholder {
      color: #D3D3D3;
    }

    .market-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      padding: 20px;
      justify-content: flex-start; /* Alinha ao início da tela */
    }

    .market-card {
      width: 100%;
      max-width: 320px;
      background-color: #f8f8f8;
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      padding: 15px;
      text-align: left;
      margin-bottom: 20px;
      border: 1px solid #ddd; /* Divisão visível entre as divs */
    }

    .market-card img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 15px;
    }

    .market-info {
      flex-grow: 1;
    }

    .market-card h3 {
      font-size: 18px;
      margin: 0;
      color: #243a69;
    }

    .market-card p {
      font-size: 14px;
      margin: 5px 0;
      color: #666;
    }

    .status {
      display: inline-block;
      padding: 5px 10px;
      font-weight: bold;
      border-radius: 4px;
    }

    .aberto {
      background-color: #28a745; /* Verde */
      color: white;
    }

    .fechado {
      background-color: #dc3545; /* Vermelho */
      color: white;
    }

    @media (max-width: 768px) {
      .header-search {
        margin: 10px;
      }

      .header a {
        font-size: 16px;
        margin: 0 8px;
      }

      .market-card {
        width: 100%;
        margin: 0 auto;
      }
    }
  </style>
</head>
<body>
  <header class="header">
  <a href="<?= getInitialPage($conn); ?>"><img src="casa.svg" alt="Home"></a>
  </header>

  <main>
    <h2 style="text-align:center; color: #243a69; margin: 20px 0;">Mercados Ativos</h2>
    <div class="market-container">
      <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $imagem = !empty($row['imagem_perfil']) ? htmlspecialchars($row['imagem_perfil']) : "default.jpg";

              $hora_atual = date('H:i');
              $hora_abertura = $row['horario_abertura'];
              $hora_fechamento = $row['horario_fechamento'];

              // Determinar status de funcionamento
              if ($hora_atual >= $hora_abertura && $hora_atual <= $hora_fechamento) {
                  $statusClasse = 'aberto';
                  $statusTexto = 'Aberto';
              } else {
                  $statusClasse = 'fechado';
                  $statusTexto = 'Fechado';
              }
              ?>
              <div class="market-card">
                <img src="<?= htmlspecialchars($imagem) ?>" alt="Imagem do Mercado">
                <div class="market-info">
                  <h3><?= htmlspecialchars($row['nome_fantasia']) ?></h3>
                  <p>Endereço: <?= htmlspecialchars($row['endereco']) ?></p>
                  <p>Telefone: <?= htmlspecialchars($row['telefone_comercio']) ?></p>
                  <p class="status <?= $statusClasse ?>"><?= $statusTexto ?></p>
                </div>
              </div>
              <?php
          }
      } else {
          echo "<p style='text-align:center; color: #666;'>Nenhum mercado ativo encontrado.</p>";
      }
      $conn->close();
      ?>
    </div>
  </main>
</body>
</html>
