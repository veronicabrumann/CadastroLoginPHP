<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "", "test");
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verificando se o usuário existe
    $stmt = $conn->prepare("SELECT password_user FROM users WHERE email_user = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Validando a senha
    if (password_verify($password, $hashed_password)) {
        $_SESSION['loggedin'] = true;
        header("Location: private.php");  // Redireciona para a página privada
    } else {
        echo "Email ou senha inválidos!";
    }
    $stmt->close();
    $conn->close();
}
?>

<form method="POST" action="login.php">
    Email: <input type="email" name="email" required><br>
    Senha: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>
