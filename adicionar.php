<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "covilcompany";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if (isset($_POST['adicionar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Inserir cliente no banco de dados
    $sql = "INSERT INTO clientes (nome, email, cpf, senha) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $cpf, $senha);

    if ($stmt->execute()) {
        echo "Cliente adicionado com sucesso!";
        header("Location: index.php");
    } else {
        echo "Erro ao adicionar cliente: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Cliente</title>
</head>
<body>
    <h2>Adicionar Novo Cliente</h2>
    <form method="POST" action="adicionar.php">
        <label for="nome">Nome:</label><br>
        <input type="text" name="nome" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label for="cpf">CPF:</label><br>
        <input type="text" name="cpf" required maxlength="14" oninput="mascaraCPF(this)"><br><br>
        <label for="senha">Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        <button type="submit" name="adicionar">Adicionar</button>
    </form>

    <script>
        // Aplicar máscara ao CPF
        function mascaraCPF(cpf) {
            cpf.value = cpf.value
                .replace(/\D/g, "")
                .replace(/(\d{3})(\d)/, "$1.$2")
                .replace(/(\d{3})(\d)/, "$1.$2")
                .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        }
    </script>
</body>
</html>
