<?php
require_once __DIR__ . '/../includes/db.php';

$conexao = conectar();
if (isset($_GET['nome'])) {
    $nome = $_GET['nome'];
    $sql = "SELECT p.nome, p.preco, GROUP_CONCAT(f.nome) as fornecedores
            FROM produtos p
            LEFT JOIN produtos_fornecedores pf ON p.id = pf.produto_id
            LEFT JOIN fornecedores f ON pf.fornecedor_id = f.id
            WHERE p.nome LIKE '%$nome%' OR p.referencia LIKE '%$nome%'
            GROUP BY p.id";

    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
        echo json_encode($produto);
    } else {
        echo json_encode(null);
    }
}

$conexao->close();
?>