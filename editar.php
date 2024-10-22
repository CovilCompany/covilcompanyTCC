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

// Obter dados do cliente pelo ID
$id = $_GET['id'];
$sql = "SELECT * FROM clientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if (isset($_POST['editar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];

    // Atualizar cliente no banco de dados
    $sql_update = "UPDATE clientes SET nome = ?, email = ?, cpf = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $nome, $email, $cpf, $id);

    if ($stmt_update->execute()) {
        echo "Cliente atualizado com sucesso!";
        header("Location: index.php");
    } else {
        echo "Erro ao atualizar cliente: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
</head>
<body>
    <h2>Editar Cliente</h2>
    <form method="POST" action="editar.php?id=<?php echo $cliente['id']; ?>">
        <label for="nome">Nome:</label><br>
        <input type="text" name="nome" value="<?php echo $cliente['nome']; ?>" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" value="<?php echo $cliente['email']; ?>" required><br><br>
        <label for="cpf">CPF:</label><br>
        <input type="text" name="cpf" value="<?php echo $cliente['cpf']; ?>" required maxlength="14" oninput="mascaraCPF(this)"><br><br>
        <button type="submit" name="editar">Atualizar</button>
    </form>

    <script>
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
