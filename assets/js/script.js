$(document).ready(function () {
    $('#cep').on('blur', function () {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep !== "") {
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/", function (dados) {
                if (!("erro" in dados)) {
                    $('#uf').val(dados.uf);
                    $('#cidade').val(dados.localidade);
                    $('#bairro').val(dados.bairro);
                    $('#rua').val(dados.logradouro);
                } else {
                    alert("CEP não encontrado.");
                }
            });
        }
    });

    $('#adicionar-produto').on('click', function () {
        var produto = $('#produto').val();
        if (produto !== "") {
            $.ajax({
                url: 'controller/buscar_produto.php',
                method: 'GET',
                data: { nome: produto },
                success: function (response) {
                    var produto = JSON.parse(response);
                    if (produto) {
                        var fornecedoresArray = produto.fornecedores.split(',');
                        var fornecedoresFormatados = fornecedoresArray.join(', ');
                        var row = `
                        <tr>
                            <td>${produto.nome}</td>
                            <td>${produto.preco}</td>
                            <td>${fornecedoresFormatados}</td>
                            <td>1</td>
                            <td><button type="button" class="btn btn-danger remover-produto">Remover</button></td>
                        </tr>`;
                        $('#tabela-produtos tbody').append(row);
                        atualizarValorTotal();
                    } else {
                        alert("Produto não encontrado.");
                    }
                }
            });
        }
    });

    $('#tabela-produtos').on('click', '.remover-produto', function() {
        $(this).closest('tr').remove();
        atualizarValorTotal();
    });

    function atualizarValorTotal() {
        var total = 0;
        $('#tabela-produtos tbody tr').each(function () {
            var preco = parseFloat($(this).find('td:nth-child(2)').text());
            total += preco;
        });
        $('#valor_total').val(total.toFixed(2));
    }

    $('#venda-form').on('submit', function(event) {
        event.preventDefault();
        if ($('#uf').val() === "" || $('#cidade').val() === "" || $('#bairro').val() === "" || $('#rua').val() === "") {
            alert("Por favor, preencha o endereço completo.");
        } else {
            console.log($(this).serialize());

            var produtos = [];
            $('#tabela-produtos tbody tr').each(function() {
                var nome = $(this).find('td:nth-child(1)').text();
                var preco = $(this).find('td:nth-child(2)').text();
                produtos.push({ nome: nome, preco: preco, quantidade: 1 });
            });
            console.log(produtos);
            $.ajax({
                url: 'controller/salvar_venda.php',
                method: 'POST',
                data: {
                    cep: $('#cep').val(),
                    uf: $('#uf').val(),
                    cidade: $('#cidade').val(),
                    bairro: $('#bairro').val(),
                    rua: $('#rua').val(),
                    valor_total: $('#valor_total').val(),
                    produtos: produtos,
                },
                success: function(response) {
                    $('#cep').val('');
                    $('#uf').val('');
                    $('#cidade').val('');
                    $('#bairro').val('');
                    $('#rua').val('');
                    $('#valor_total').val('');
                    $('#tabela-produtos tbody').empty();
                
                    appendAlert(response, 'success');
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                },
                error: function(response) {
                    console.log(response)
                    appendAlert(response, 'danger');
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                }
            });
        }
    });

    const appendAlert = (message, type) => {
        const wrapper = document.createElement('div')
        wrapper.innerHTML = [
            `<div class="alert alert-${type} alert-dismissible" role="alert">`,
            `   <div>${message}</div>`,
            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
            '</div>'
        ].join('')
    
        document.getElementById('liveAlertPlaceholder').append(wrapper)
    }
});