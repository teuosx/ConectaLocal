<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "mercado");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Obter o parâmetro da busca
$nomeOferta = isset($_GET['nome_oferta']) ? $_GET['nome_oferta'] : '';

// Consulta para buscar ofertas pelo nome, com os dados do mercado
$sql = "
    SELECT 
        ofertas.imagem_oferta,
        ofertas.nome_oferta,
        comercio.nome_fantasia,
        comercio.imagem_perfil
    FROM 
        ofertas
    INNER JOIN 
        comercio ON ofertas.id_comercio = comercio.id_comercio
    WHERE 
        ofertas.nome_oferta LIKE ?
";

// Preparar e executar a consulta
$stmt = $conn->prepare($sql);
$searchTerm = "%$nomeOferta%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Retornar os resultados como JSON
$ofertas = [];
while ($row = $result->fetch_assoc()) {
    $ofertas[] = $row;
}
echo json_encode($ofertas);

$stmt->close();
$conn->close();
?>
