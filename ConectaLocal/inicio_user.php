<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="cssindex.css">
  <title>Menu Responsivo com Dropdown e Carrossel</title>
  <style>
    /* Estilos básicos */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .header, .carousel-container, .sidebar, .dropdown-menu, .overlay {
      /* Estilização do header, menu, carrossel e overlay */
    }
    /* Estilos do carrossel */
    .carousel-container {
      position: relative;
      width: 100%;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .carousel-track {
      display: flex;
      transition: transform 0.3s ease;
    }
    .carousel-box {
      min-width: 250px;
      margin: 0 10px;
    }
    .carousel-box img {
      width: 100%;
      height: 250px;
      border-radius: 8px;
      object-fit: cover;
    }
    .nav-btn {
      background-color: #243a69;
      color: white;
      border: none;
      padding: 10px;
      cursor: pointer;
      font-size: 24px;
    }
    /* Responsividade */
    @media (max-width: 1024px) {
      .carousel-box {
        min-width: 200px;
      }
      .carousel-box img {
        height: 200px;
      }
    }
    @media (max-width: 768px) {
      .carousel-box {
        min-width: 150px;
      }
      .carousel-box img {
        height: 150px;
      }
    }
    @media (max-width: 480px) {
      .carousel-container {
        padding: 0 10px;
      }
      .carousel-box {
        min-width: 120px;
        margin: 0 5px;
      }
      .carousel-box img {
        height: 120px;
      }
      .nav-btn {
        font-size: 18px;
        padding: 8px;
      }
    }
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      right: 0;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      width: 200px;
      padding: 10px;
      z-index: 10;
    }

    .dropdown-menu a {
      display: flex;
      align-items: center;
      padding: 10px;
      font-size: 1rem;
      color: #333;
      text-decoration: none;
      border-radius: 8px;
      margin-bottom: 5px;
    }

    .dropdown-menu a:hover {
      background-color: #1e3264;
      color: #fff;
    }

    .seja-comerciante {
      color: #1e3264;
    }

    .seja-comerciante:hover {
      background-color: #f4f4f4;
    }

    .dropdown-icon {
      width: 20px;
      height: 20px;
      margin-right: 10px;
    }

  </style>
</head>
<body>
  <div class="overlay" id="overlay" onclick="toggleMenu()"></div>
  <header class="header">
    <div class="hamburger-menu" id="menu-btn" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <div class="header-icons">
      <a href="#"><img src="casa.svg" alt="Home" class="icon"></a>
      <a href="#"><img src="mercado.svg" alt="Mercado" class="icon"></a>
      <a href="#"><img src="pao.svg" alt="Pão" class="icon"></a>
    </div>
    <div class="header-search">
      <input type="text" placeholder="Pesquisar">
      <img src="lupa.svg" alt="Buscar" class="search-icon">
    </div>
    <div class="profile-group" onclick="toggleDropdown(event)">
      <img src="usu.svg" alt="Perfil" class="profile-icon">
      <span>Perfil</span>
      <img src="seta.svg" alt="Seta" class="seta-icon">
      <div class="dropdown-menu" id="dropdown-menu">
        <a href="cadastro_mercado.html" class="seja-comerciante">
          <img src="conf.svg" alt="Opções" class="dropdown-icon"> Seja comerciante!
        </a>
        <a href="index.html">
          <img src="porta.svg" alt="Sair" class="dropdown-icon"> Sair
        </a>
      </div>
    </div>
  </header>
  <nav class="sidebar" id="sidebar">
    <a href="#"><img src="casa.svg" alt="Home" class="icon"></a>
    <a href="#"><img src="mercado.svg" alt="Mercado" class="icon"></a>
    <a href="#"><img src="pao.svg" alt="Pão" class="icon"></a>
    <a href="#"><img src="conf.svg" alt="Configurações" class="icon"></a>
    <a href="#"><img src="porta.svg" alt="Sair" class="icon"></a>
  </nav>
  <section class="ofertas">
    <h2 class="section-title">Ofertas</h2>
    <div class="carousel-container ofertas">
      <button class="nav-btn left" onclick="scrollCarousel('oferta', -1)">&lt;</button>
      <div class="carousel-track ofertas" id="carousel-ofertas">
      <?php 
        $conn = new mysqli("localhost", "root", "", "mercado"); 
        if ($conn->connect_error) { 
          die("Conexão falhou: " . $conn->connect_error); 
        } 

        $sql = "SELECT imagem_produto FROM ofertas WHERE imagem_produto IS NOT NULL"; 
        $result = $conn->query($sql); 
        
        if ($result->num_rows > 0) { 
          while ($row = $result->fetch_assoc()) { 
            echo '<div class="carousel-box ofertas"><img src="' . $row["imagem_produto"] . '" alt="Oferta"></div>'; } 
            } else { 
              echo "Nenhuma oferta disponível."; 
              } 
        $conn->close(); 
      ?>
      </div>
      <button class="nav-btn right" onclick="scrollCarousel('oferta', 1)">&gt;</button>
    </div>
  </section>
  <section class="encartes">
    <h2 class="section-title">Encartes</h2>
    <div class="carousel-container encartes">
      <button class="nav-btn left" onclick="scrollCarousel('encarte', -1)">&lt;</button>
      <div class="carousel-track encartes" id="carousel-encartes">
      <?php 
        $conn = new mysqli("localhost", "root", "", "mercado"); 
        if ($conn->connect_error) { 
          die("Conexão falhou: " . $conn->connect_error); 
        }

        $sql = "SELECT imagem_encarte FROM encartes"; 
        $result = $conn->query($sql); 
        
        if ($result->num_rows > 0) { 
          while ($row = $result->fetch_assoc()) { 
            echo '<div class="carousel-box encartes"><img src="' . $row["imagem_encarte"] . '" alt="Encarte"></div>'; } 
            } else { 
              echo "Nenhum encarte disponível."; 
              } 
        $conn->close();
      ?>
      </div>
      <button class="nav-btn right" onclick="scrollCarousel('encarte', 1)">&gt;</button>
    </div>
  </section>
  <script>
    function toggleMenu() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('open');
      overlay.classList.toggle('show');
    }
    function toggleDropdown(event) {
      event.stopPropagation();
      const dropdown = document.getElementById('dropdown-menu');
      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
    document.addEventListener('click', function(event) {
      const dropdownMenu = document.getElementById('dropdown-menu');
      if (!event.target.closest('.profile-group')) {
        dropdownMenu.style.display = 'none';
      }
    });
    let currentScrollOferta = 0;
    let currentScrollEncarte = 0;
    function scrollCarousel(type, direction) {
      const carousel = document.getElementById(`carousel-${type}s`);
      const items = carousel.children;
      const itemWidth = items[0].offsetWidth + 20;
      const maxScroll = carousel.scrollWidth - carousel.parentElement.offsetWidth;
      if (type === 'oferta') {
        currentScrollOferta += direction * itemWidth;
        if (currentScrollOferta < 0) currentScrollOferta = maxScroll;
        if (currentScrollOferta > maxScroll) currentScrollOferta = 0;
        carousel.style.transform = `translateX(-${currentScrollOferta}px)`;
      } else {
        currentScrollEncarte += direction * itemWidth;
        if (currentScrollEncarte < 0) currentScrollEncarte = maxScroll;
        if (currentScrollEncarte > maxScroll) currentScrollEncarte = 0;
        carousel.style.transform = `translateX(-${currentScrollEncarte}px)`;
      }
    }
  </script>
</body>
</html>
