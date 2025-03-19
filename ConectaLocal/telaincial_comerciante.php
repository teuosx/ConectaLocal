<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
  <title>teste</title>
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
  padding: 16px 16px;
  background-color: #243a69;
  color: white;
}

.cabecalho-menu {
  cursor: pointer;
  display: none;
  flex-direction: column;
  gap: 5px;
}

.cabecalho-menu span {
  width: 25px;
  height: 3px;
  background-color: white;
  display: block;
}

.header-icones {
  display: flex;
  gap: 48px;
  padding-left: 88px;
  padding-right: 56px;
}

.header-icones a {
  color: white;
  text-decoration: none;
  font-size: 18px;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: all 0.3s ease;
  padding: 6px;
  border-radius: 8px;
}

.header-icones a img.icon {
  width: 28px;
  height: 28px;
}

.header-icones a:hover,
.header-icones a:focus {
  background-color: #4098D0;
}

.header-search {
  display: flex;
  align-items: center;
  background-color: #3F5A96;
  border-radius: 12px;
  padding: 10px 10px;
  flex-grow: 1;
  margin: 0 20px;
  color: white;
}

.header-search input {
  flex-grow: 1;
  border: none;
  outline: none;
  background: transparent;
  color: #D3D3D3;
  padding-left: 8px;
}

.header-search input::placeholder {
  color: #D3D3D3;
}

.header-search img {
  width: 20px;
  height: 20px;
}

.perfil-grupo {
  margin-left: 72px;
  margin-right: 72px;
  display: flex;
  align-items: center;
  cursor: pointer;
  position: relative;
}

.perfil-grupo img {
  width: 28px;
  height: 28px;
  margin-right: 2px;
}

.rodape-menu {
  display: none;
  position: absolute;
  top: 100%;
  right: 0;
  background-color: #E8E8E8;
  border-radius: 8px;
  width: 140px;
  margin-top: 10px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
  z-index: 2000;
}

.rodape-menu a {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 16px;
  color: #4F4F4F;
  text-decoration: none;
  font-size: 16px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.rodape-menu a img {
  width: 20px;
  height: 20px;
}

.rodape-menu a:hover {
  background-color: #d3d1d1;
  border-radius: 10px;
}

.barra_pesquisa {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 80px;
  background-color: #243a69;
  transform: translateX(-100%);
  transition: transform 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 60px;
  z-index: 1000;
}

.barra_pesquisa a {
  color: white;
  text-decoration: none;
  font-size: 18px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  padding: 10px 0;
  transition: all 0.3s ease;
}

.barra_pesquisa a img.icon {
  width: 28px;
  height: 28px;
}

.barra_pesquisa a:hover,
.barra_pesquisa a:focus {
  background-color: #4098D0;
  border-radius: 8px;
}

.barra_pesquisa.open {
  transform: translateX(0);
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: none;
  z-index: 999;
}

.overlay.show {
  display: block;
}

.carousel-container {
  width: 100%;
  overflow: hidden;
  position: relative;
  margin-bottom: 20px;
  padding: 0 16px; /* Adiciona o espaço de 8px nas laterais */
}

.carousel-item {
  width: 250px; /* Ajuste o tamanho do item para imagens um pouco maiores */
  height: 300px; /* Ajuste a altura para dar mais espaço às imagens */
  flex-shrink: 0;
  display: flex;
  flex-direction: column; /* Alinha verticalmente */
  justify-content: center;
  align-items: center;
  font-size: 16px;
  color: #333;
  border-radius: 8px;
  overflow: hidden;
}

.carousel-track {
  display: flex;
  justify-content: flex-start; /* Alinha as imagens à esquerda */
  gap: 20px; /* Aumenta o espaço entre as imagens */
  transition: transform 0.4s ease-in-out;
}

.carousel-track img {
  width: 100%; /* Garantir que a imagem ocupe toda a largura do item */
  height: 180px; /* Define uma altura fixa para as imagens */
  object-fit: cover; /* A imagem vai preencher o espaço mantendo a proporção */
  border-radius: 8px;
}

.carousel-button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(0, 0, 0, 0.5);
  border: none;
  color: white;
  font-size: 18px;
  width: 40px;
  height: 40px;
  border-radius: 16px;
  cursor: pointer;
  z-index: 10; /* Garantir que o botão fique acima do carrossel */
}

.carousel-button.left {
  left: 10px;
}

.carousel-button.right {
  right: 10px;
}

h2 {
  text-align: center; /* Centraliza o texto horizontalmente */
  color: #243a69;
  font-size: 24px;
  margin: 36px 0;
}

.carousel-track {
  justify-content: flex-start; /* Remove a centralização */
}

@media (max-width: 864px) {
  .header-icones {
    display: none;
  }

  .cabecalho-menu {
    display: flex;
  }

  .header-search {
    max-width: 80%;
    margin: 0 auto;
  }

  .perfil-grupo {
    display: none;
  }

  .barra_pesquisa {
    width: 80px;
  }

  .barra_pesquisa a {
    padding: 10px 10px;
    margin-bottom: 32px;
    transition: background-color 0.2s linear;
    border-radius: 12px;
  }

  .barra_pesquisa a img[src="cmercado.svg"] {
    filter: brightness(0) invert(1);
  }

  .barra_pesquisa a img[src="porta.svg"],
  .barra_pesquisa a img[src="conf.svg"] {
    filter: brightness(0) invert(1);
  }

  .barra_pesquisa a:last-child {
    margin-top: auto;
    margin-bottom: 24px;
  }
}

@media (max-width: 500px) {
  .carousel-item {
    width: 100%; /* Ajusta a largura para 100% */
    height: auto; /* Ajuste a altura conforme necessário */
  }

  .carousel-track {
    gap: 0; /* Remove o espaço entre os itens */
  }

  .carousel-button {
    font-size: 24px; /* Aumenta o tamanho do botão */
  }
}

/* Estilo para as imagens do carrossel e as informações do mercado */
.mercado-info {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 10px;
}

.mercado-info img.imagem-perfil {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-bottom: 8px; /* Distância entre a imagem e o nome */
}

.mercado-info p {
  font-weight: bold;
  margin-bottom: 4px;
}

.no-offer-message {
    text-align: center;
    color: #e74c3c;
    font-size: 18px;
    margin-top: 20px;
    font-weight: bold;
}


</style>

</head>
<body>
  <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

  <header class="header">
    <div class="cabecalho-menu" id="menu-btn" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>
   
    <div class="header-icones">
      <a href="telaincial_comerciante.php"><img src="casa.svg" alt="Home" class="icon"></a>
      <a href="mercados_ativos.php"><img src="mercado.svg" alt="Mercado" class="icon"></a>
    </div>
   
    <div class="header-search">
      <input type="text" id="input-pesquisa" placeholder="Pesquisar">
      <img src="lupa.svg" alt="Buscar" class="search-icon">
    </div>
   
    <div class="perfil-grupo" onclick="toggleDropdown()">
      <img src="usu.svg" alt="Perfil" class="perfil-icon">
      <span>Perfil</span>
      <img src="seta.svg" alt="Seta" class="seta-iconseta">
      
      <div class="rodape-menu" id="rodape-menu">
        <a href="conf.php"><img src="conf.svg" alt="Opções"> Opções</a>
        <a href="index.html"><img src="porta.svg" alt="Sair"> Sair</a>
      </div>
    </div>
  </header>

  <h2 class="carousel-title">Ofertas</h2>
  <div class="carousel-container" id="carousel1">
    <button class="carousel-button left" onclick="moveCarousel('carousel1', -1)">❮</button>
    <div class="carousel-track">
    <?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "mercado");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter ofertas e dados do mercado
$sql_ofertas = "
    SELECT 
        ofertas.imagem_oferta, 
        comercio.nome_fantasia, 
        comercio.imagem_perfil -- Caminho da imagem de perfil
    FROM 
        ofertas 
    INNER JOIN 
        comercio ON ofertas.id_comercio = comercio.id_comercio
    WHERE 
        ofertas.imagem_oferta IS NOT NULL
";
$result_ofertas = $conn->query($sql_ofertas);

if ($result_ofertas->num_rows > 0) {
    while ($row_ofertas = $result_ofertas->fetch_assoc()) {
        echo '<div class="carousel-item">';
        echo '<img src="' . $row_ofertas["imagem_oferta"] . '" alt="Oferta">';
        echo '<div class="mercado-info">'; // Container para nome e imagem do mercado
        echo '<img src="' . $row_ofertas["imagem_perfil"] . '" alt="Perfil do Mercado" class="imagem-perfil">';
        echo '<p>' . htmlspecialchars($row_ofertas["nome_fantasia"]) . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "Nenhuma oferta disponível.";
}

$conn->close();
?>
</div>
<button class="carousel-button right" onclick="moveCarousel('carousel1', 1)">❯</button>
</div>

<h2 class="carousel-title">Encartes</h2>
<div class="carousel-container" id="carousel2">
<button class="carousel-button left" onclick="moveCarousel('carousel2', -1)">❮</button>
<div class="carousel-track">
<?php
// Nova conexão para encartes
$conn = new mysqli("localhost", "root", "", "mercado");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter encartes e dados do mercado
$sql_encartes = "
    SELECT 
        encartes.imagem_encarte, 
        comercio.nome_fantasia, 
        comercio.imagem_perfil -- Caminho da imagem de perfil
    FROM 
        encartes 
    INNER JOIN 
        comercio ON encartes.id_comercio = comercio.id_comercio
";
$result_encartes = $conn->query($sql_encartes);

if ($result_encartes->num_rows > 0) {
    while ($row_encartes = $result_encartes->fetch_assoc()) {
        echo '<div class="carousel-box encartes">';
        echo '<img src="' . $row_encartes["imagem_encarte"] . '" alt="Encarte">';
        echo '<div class="mercado-info">'; // Container para nome e imagem do mercado
        echo '<img src="' . $row_encartes["imagem_perfil"] . '" alt="Perfil do Mercado" class="imagem-perfil">';
        echo '<p>' . htmlspecialchars($row_encartes["nome_fantasia"]) . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "Nenhum encarte disponível.";
}

$conn->close();
?>
</div>
<button class="carousel-button right" onclick="moveCarousel('carousel2', 1)">❯</button>
</div>


  <nav class="barra_pesquisa" id="barra_pesquisa">
    <a href="telaincial_comerciante.php"><img src="casa.svg" alt="Home" class="icon"></a>
    <a href="mercados_ativos.php"><img src="mercado.svg" alt="Mercado" class="icon"></a>
    <a href="conf.php"><img src="conf.svg" alt="Configurações" class="icon"></a>
    <a href="index.html"><img src="porta.svg" alt="Sair" class="icon"></a>
  </nav>
  <script>
        function toggleMenu() {
      const barra_pesquisa = document.getElementById('barra_pesquisa');
      const overlay = document.getElementById('overlay');
      barra_pesquisa.classList.toggle('open');
      overlay.classList.toggle('show');
    }

    function toggleDropdown() {
      const rodape = document.getElementById('rodape-menu');
      rodape.style.display = rodape.style.display === 'block' ? 'none' : 'block';
    }

    function moveCarousel(carouselId, direction) {
      const carousel = document.getElementById(carouselId);
      const track = carousel.querySelector('.carousel-track');
      const items = Array.from(track.children);
      const leftButton = carousel.querySelector('.carousel-button.left');
      const rightButton = carousel.querySelector('.carousel-button.right');

      let currentIndex = parseInt(track.dataset.currentIndex || '0', 10);  // Índice atual armazenado
      const itemWidth = getItemWidth(items);  // Calcula a largura do item
      const containerWidth = carousel.offsetWidth;
      const visibleItems = Math.floor(containerWidth / itemWidth);  // Itens visíveis no carrossel
      const totalItems = items.length;
      const maxIndex = totalItems - visibleItems;  // Índice máximo para o loop

      // Atualiza o índice com o movimento (direção)
      currentIndex += direction;

      // Loop do carrossel: se o índice for menor que 0, vai para o último item
      if (currentIndex < 0) {
        currentIndex = maxIndex;
      }

      // Se o índice for maior que o máximo, vai para o primeiro item
      if (currentIndex > maxIndex) {
        currentIndex = 0;
      }

      // Atualiza a posição do carrossel
      track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;

      // Atualiza o índice armazenado
      track.dataset.currentIndex = currentIndex;

      // Atualiza a visibilidade dos botões
      updateButtons(carousel, leftButton, rightButton, currentIndex, maxIndex);
    }

    // Função para calcular a largura do item
    function getItemWidth(items) {
      const item = items[0];  // Pega o primeiro item do carrossel
      const computedStyle = window.getComputedStyle(item);
      const itemWidth = item.offsetWidth + parseFloat(computedStyle.marginRight);  // Inclui a margem direita
      return itemWidth;
    }

    function updateButtons(carousel, leftButton, rightButton, currentIndex, maxIndex) {
      // O botão esquerdo deve estar sempre visível
      leftButton.style.visibility = 'visible';

      // O botão direito deve estar visível se o índice for menor que o máximo
      if (currentIndex < maxIndex) {
        rightButton.style.visibility = 'visible';
      } else {
        // Quando o índice atingir o máximo, ele deve continuar visível para navegar de volta ao início
        rightButton.style.visibility = 'visible';
      }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputPesquisa = document.querySelector('#input-pesquisa'); // Campo de pesquisa
        const carrosselTrack = document.querySelector('.carousel-track'); // Div das ofertas
        let ofertasOriginais = []; // Para armazenar as ofertas originais

        // Função para renderizar ofertas
        function renderizarOfertas(ofertas) {
            carrosselTrack.innerHTML = ''; // Limpa o carrossel

            if (ofertas.length === 0) {
                // Exibe mensagem de "Oferta inexistente"
                const noOfferMessage = document.createElement('div');
                noOfferMessage.classList.add('no-offer-message');
                noOfferMessage.textContent = 'Oferta inexistente';
                carrosselTrack.appendChild(noOfferMessage);
            } else {
                // Adiciona as ofertas ao carrossel
                ofertas.forEach(oferta => {
                    const ofertaItem = document.createElement('div');
                    ofertaItem.classList.add('carousel-item');
                    ofertaItem.innerHTML = `
                        <img src="${oferta.imagem_oferta}" alt="Oferta">
                        <div class="mercado-info">
                            <img src="${oferta.imagem_perfil}" alt="Perfil do Mercado" class="imagem-perfil">
                            <p>${oferta.nome_fantasia}</p>
                        </div>
                    `;
                    carrosselTrack.appendChild(ofertaItem);
                });
            }
        }

        // Função para buscar ofertas originais ao carregar a página
        function carregarOfertasOriginais() {
            fetch('buscar_ofertas.php') // Endpoint para buscar todas as ofertas
                .then(response => response.json())
                .then(data => {
                    ofertasOriginais = data; // Armazena as ofertas originais
                    renderizarOfertas(ofertasOriginais);
                })
                .catch(error => console.error('Erro ao carregar ofertas originais:', error));
        }

        // Função para alternar o menu de perfil
        function togglePerfilMenu() {
            const perfilMenu = document.getElementById('perfil-menu'); // ID do menu de perfil
            perfilMenu.classList.toggle('show'); // Exibe/oculta o menu
        }

        // Evento para o botão de perfil (aqui estou assumindo que há um botão com id "btn-perfil")
        const btnPerfil = document.querySelector('#btn-perfil');
        if (btnPerfil) {
            btnPerfil.addEventListener('click', togglePerfilMenu); // Associando o evento de clique
        }

        // Evento ao campo de pesquisa
        inputPesquisa.addEventListener('input', function () {
            const nomeOferta = inputPesquisa.value.trim();

            if (!nomeOferta) {
                // Restaura as ofertas originais quando o campo de pesquisa está vazio
                renderizarOfertas(ofertasOriginais);
                return;
            }

            // Faz a busca filtrada
            fetch(`buscar_ofertas.php?nome_oferta=${encodeURIComponent(nomeOferta)}`)
                .then(response => response.json())
                .then(data => {
                    renderizarOfertas(data);
                })
                .catch(error => console.error('Erro ao buscar ofertas:', error));
        });

        // Carrega as ofertas originais ao iniciar
        carregarOfertasOriginais();
    });
</script>


</body>
</html>
