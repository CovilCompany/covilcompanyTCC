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

// Alterar a senha
if (isset($_POST['alterar_senha'])) {
    $email = $_POST['email'];
    $senha_antiga = $_POST['senha_antiga'];
    $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT); // Criptografar a nova senha

    // Verificar se o email e a senha antiga estão corretos
    $sql = "SELECT * FROM clientes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();

        if (password_verify($senha_antiga, $cliente['senha'])) {
            // Atualizar a senha no banco de dados
            $sql_update = "UPDATE clientes SET senha = ? WHERE email = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ss", $nova_senha, $email);

            if ($stmt_update->execute()) {
                echo "Senha alterada com sucesso!";
            } else {
                echo "Erro ao alterar a senha.";
            }
        } else {
            echo "Senha antiga incorreta.";
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
    <title>Alterar Senha</title>
</head>
<body>
    <h2>Alterar Senha</h2>
    <form method="POST" action="alterar_senha.php">
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label for="senha_antiga">Senha Antiga:</label><br>
        <input type="password" name="senha_antiga" required><br><br>
        <label for="nova_senha">Nova Senha:</label><br>
        <input type="password" name="nova_senha" required><br><br>
        <button type="submit" name="alterar_senha">Alterar Senha</button>
    </form>
</body>
</html>
