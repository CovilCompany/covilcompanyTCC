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

// Verificar login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar o cliente pelo email
    $sql = "SELECT * FROM clientes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();

        // Verificar se a senha está correta
        if (password_verify($senha, $cliente['senha'])) {
            echo "Login realizado com sucesso!";
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Cliente não encontrado.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login de Cliente</title>
</head>
<body>
    <h2>Login de Cliente</h2>
    <form method="POST" action="applications.html">
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label for="senha">Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        <button type="submit" name="login">Entrar</button>
    </form>
</body>
</html>