<?php
require_once __DIR__ . '/../config/config.php';

function conectar() {
    $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

     // Configurar o mysqli para lançar exceções e usar UTF-8
    $conexao->set_charset("utf8mb4");

    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conexao->connect_error);
    }

    return $conexao;
}
?>