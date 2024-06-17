<?php
require_once __DIR__ . '/../includes/db.php';

$conexao = conectar();

$cep = $_POST['cep'];
$uf = $_POST['uf'];
$cidade = $_POST['cidade'];
$bairro = $_POST['bairro'];
$rua = $_POST['rua'];
$valor_total = $_POST['valor_total'];
$produtos = $_POST['produtos'];
$data = date('Y-m-d');



$sql = "INSERT INTO vendas (data, cep, uf, cidade, bairro, rua, valor_total) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('ssssssd', $data, $cep, $uf, $cidade, $bairro, $rua, $valor_total);

if ($stmt->execute()) {
    $venda_id = $conexao->insert_id;

    foreach ($produtos as $produto) {
        if (!isset($produto['nome']) || !isset($produto['quantidade']) || !isset($produto['preco'])) {
            echo "Produto inválido encontrado: ";
            echo "<pre>";
            print_r($produto);
            echo "</pre>";
            continue;
        }

        $nome = $produto['nome'];
        $quantidade = $produto['quantidade'];
        $preco = $produto['preco'];

        // Fetch product ID by name
        $sql_select = "SELECT id FROM produtos WHERE nome = ?";
        $stmt_select = $conexao->prepare($sql_select);
        $stmt_select->bind_param('s', $nome);
        $stmt_select->execute();
        $result = $stmt_select->get_result();

        if ($result->num_rows > 0) {
            $produto_id = $result->fetch_assoc()['id'];

            $sql_insert = "INSERT INTO vendas_produtos (venda_id, produto_id, quantidade,  preco_venda) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conexao->prepare($sql_insert);
            $stmt_insert->bind_param('iiid', $venda_id, $produto_id, $quantidade, $preco);

            // Execute and check the result
            if ($stmt_insert->execute()) {
                continue;
            } else {
                echo "Erro ao inserir o produto: $nome";
                echo "Erro: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        } else {
            echo "Produto não encontrado: $nome";
        }

        $stmt_select->close();
    }
    echo "Venda salva com sucesso!";
} else {
    echo "Error: " . $stmt->error;
}

$conexao->close();
?>
