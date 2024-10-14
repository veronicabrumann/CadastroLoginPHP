<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $code = $_POST['code'];
    

    // Consultando a API pública
    $api_url = 'https://jsonplaceholder.typicode.com/posts/1';
    $api_response = file_get_contents($api_url);
    $api_data = json_decode($api_response, true);
    $title = $api_data['title'];

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "", "test");
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Inserindo dados no banco
    $stmt = $conn->prepare("INSERT INTO users (name_user, email_user, password_user, title_user, code_user) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $password, $title, $code);
    if ($stmt->execute()) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<form method="POST" action="register.php">
    Nome: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Senha: <input type="password" name="password" required><br>
    Código Único: <input type="text" name="code" required><br>
    <input type="submit" value="Cadastrar">
</form>
