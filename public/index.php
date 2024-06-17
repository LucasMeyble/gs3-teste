<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$conexao = conectar();
?>

<div class="container">
    <div id="liveAlertPlaceholder" class="mt-3"></div>
    <h1>Cadastro de Vendas</h1>
    <form id="venda-form">
        <div class="mb-3">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control" id="cep" name="cep" required>
        </div>
        <div class="mb-3">
            <label for="uf" class="form-label">UF</label>
            <input type="text" class="form-control" id="uf" name="uf" readonly required>
        </div>
        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" readonly required>
        </div>
        <div class="mb-3">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" readonly required>
        </div>
        <div class="mb-3">
            <label for="rua" class="form-label">Rua</label>
            <input type="text" class="form-control" id="rua" name="rua" readonly required>
        </div>
        <div class="mb-3">
            <label for="produto" class="form-label">Buscar Produto</label>
            <input type="text" class="form-control" id="produto" name="produto">
        </div>
        <button type="button" class="btn btn-primary" id="adicionar-produto">Adicionar Produto</button>
        <div class="table-responsive">
            <table class="table mt-3" id="tabela-produtos">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Fornecedor(es)</th>
                        <th>Quantidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="mb-3">
            <label for="valor_total" class="form-label">Valor Total</label>
            <input type="text" class="form-control" id="valor_total" name="valor_total" readonly>
        </div>
        <button type="submit" class="btn btn-success mb-4">Salvar Venda</button>
    </form>
</div>

</body>
</html>