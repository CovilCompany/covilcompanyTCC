<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "covilcompany";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Função para cadastrar cliente
if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha

    // Inserir cliente no banco de dados
    $sql = "INSERT INTO clientes (nome, email, senha, cpf) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $senha, $cpf);

    if ($stmt->execute()) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar cliente: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cliente</title>
</head>
<body>
    <h2>Cadastro de Cliente</h2>
    <form method="POST" action="cadastrar_cliente.php">
        <label for="nome">Nome:</label><br>
        <input type="text" name="nome" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label for="cpf">CPF:</label><br>
        <input type="text" name="cpf" required maxlength="14" oninput="mascaraCPF(this)"><br><br>
        <label for="senha">Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>

    <script>
        // Aplicar máscara ao CPF no formato 000.000.000-00
        function mascaraCPF(cpf) {
            cpf.value = cpf.value
                .replace(/\D/g, "")              // Remove tudo que não é número
                .replace(/(\d{3})(\d)/, "$1.$2") // Aplica o primeiro ponto
                .replace(/(\d{3})(\d)/, "$1.$2") // Aplica o segundo ponto
                .replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Aplica o traço
        }
    </script>
</body>
</html>