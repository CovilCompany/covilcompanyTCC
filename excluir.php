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

// Excluir cliente
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_delete = "DELETE FROM clientes WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Cliente excluído com sucesso!";
        header("Location: index.php");
    } else {
        echo "Erro ao excluir cliente: " . $conn->error;
    }
}
?>
