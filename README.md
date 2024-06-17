# Guia para rodar o projeto 🆘

## Configuração do Banco de Dados

### 1. Configurar o Banco de Dados

Antes de rodar a aplicação, certifique-se de configurar o banco de dados e inserir os dados iniciais necessários. Siga os passos abaixo:

- Criar Tabelas e Inserir Dados

Abra o cliente MySQL (pode ser via linha de comando ou usando ferramentas como phpMyAdmin) e execute os seguintes comandos SQL para criar as tabelas necessárias e inserir dados de exemplo:

```sql
CREATE TABLE fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    referencia VARCHAR(255) NOT NULL UNIQUE,
    preco DECIMAL(10, 2) NOT NULL
);

CREATE TABLE produtos_fornecedores (
    produto_id INT,
    fornecedor_id INT,
    PRIMARY KEY (produto_id, fornecedor_id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id),
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
);

CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    cep VARCHAR(9) NOT NULL,
    uf VARCHAR(2) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    bairro VARCHAR(255) NOT NULL,
    rua VARCHAR(255) NOT NULL,
    valor_total DECIMAL(10, 2) NOT NULL
);

CREATE TABLE vendas_produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_venda DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (venda_id) REFERENCES vendas(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- Inserir dados de exemplo
INSERT INTO fornecedores (nome) VALUES ('Fornecedor 1'), ('Fornecedor 2');

INSERT INTO produtos (nome, referencia, preco) VALUES
('Produto A', 'REF001', 10.00),
('Produto B', 'REF002', 20.00);

INSERT INTO produtos_fornecedores (produto_id, fornecedor_id) VALUES
(1, 1),
(1, 2),
(2, 1);

```

## Instalação com Docker 🐋

### Pré-requisitos - Com docker

- [Docker](https://www.docker.com/get-started) instalado na máquina.
- [Docker Compose](https://docs.docker.com/compose/install/) instalado.

## Configuração do Projeto

### 1. Clone o repositório

Clone este repositório na sua máquina local:

```sh
git clone https://github.com/LucasMeyble/gs3-teste.git
cd gs3-teste
```

### 2. Configurar o Docker

O projeto está configurado para usar Docker. O arquivo `docker-compose.yml` define os serviços necessários.

### 3. Subir os contêineres

Para subir os contêineres, execute o comando:

```bash
docker-compose up -d

```

### 4. Verificar os serviços

Verifique se os contêineres estão em execução:

```bash
docker-compose ps
```

### 5. Acessar a Aplicação

Abra o navegador e acesse a aplicação em <http://localhost:8081>.

### 6. Configuração do Banco de Dados

O projeto utiliza MySQL como banco de dados. As credenciais padrão são:

- Host: mysql
- Usuário: user
- Senha: 1234
- Banco de Dados: loja_db

Se necessário, você pode modificar essas configurações no arquivo config/config.php.

## Intalação normal - Sem docker 👾

### Pré-requisitos

- PHP instalado na sua máquina. Você pode baixar o PHP em php.net.
- Um servidor web instalado, como Apache ou Nginx.
- MySQL instalado na sua máquina, se você pretende usar o mesmo banco de dados configurado no Docker.

### 1. Configuração do Ambiente PHP

Instale o PHP de acordo com o sistema operacional que você está usando. Certifique-se de incluir extensões necessárias como pdo_mysql.

### 2. Configuração do Servidor Web (Exemplo com Apache)

#### Windows

- Se estiver usando Windows, você pode instalar o Apache usando o pacote XAMPP ou WAMP, que inclui PHP, Apache, MySQL e outras ferramentas necessárias.

### 3. Configuração do Banco de Dados

Se você pretende usar o MySQL localmente, instale o MySQL Server e configure um banco de dados com as mesmas credenciais e estrutura que estão definidas no arquivo config/config.php (usuário: user, senha: 1234, banco de dados: loja_db).

### 4. Configuração do Projeto

Clone este repositório na sua máquina local:

```sh
git clone https://github.com/LucasMeyble/gs3-teste.git
cd gs3-teste
```

### 5. Configuração do Servidor Web (Apache)

No Apache, configure um virtual host para o seu projeto. Por exemplo, crie um arquivo de configuração meu_projeto.conf em C:\xampp\apache\conf\extra\ (se estiver usando XAMPP no Windows) ou /etc/apache2/sites-available/ (no Linux) com o seguinte conteúdo:

```bash
  <VirtualHost *:80>
    ServerName localhost
    DocumentRoot "C:/caminho/para/seu/projeto/meu_projeto/public"  # ajuste o caminho conforme necessário

    <Directory "C:/caminho/para/seu/projeto/meu_projeto/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 6. Acessar a Aplicação

Abra o navegador e acesse a aplicação em <http://localhost>.

## 🤖 Tecnologias Utilizadas

- Docker
- PHP 8.3
- Nginx
- php-fmp
- Mysql
- Bootstrap

Feito com ❤️ por Lucas Meyble! 😁🐠
