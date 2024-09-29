<?php
include 'config/connection.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $nome = trim($_POST['nome']);
    $data_nascimento = DateTime::createFromFormat('Y-m-d', $_POST['data'])->format('Y-m-d');
    $cpf = trim($_POST['cpf']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email inválido.";
    } elseif (strlen($senha) < 6) {
        $message = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("SELECT COUNT(*) FROM tb_usuario WHERE email_usuario = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                $message = "Este email já está cadastrado.";
            } else {
                $stmt = $conn->prepare("INSERT INTO tb_usuario (email_usuario, senha_usuario, nome_usuario, data_nasc_usuario, cpf_usuario) VALUES (?, ?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("sssss", $email, $senha_hash, $nome, $data_nascimento, $cpf);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        $message = "Usuário registrado com sucesso!";
                    } else {
                        $message = "Erro ao registrar o usuário.";
                    }
                    $stmt->close();
                } else {
                    $message = "Erro ao preparar a instrução para inserção.";
                }
            }
        } else {
            $message = "Erro ao preparar a instrução para verificação de email.";
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <title>Cinemania - Login</title>
</head>

<body>
    <div class="header">
        <div class="logo">
            <h2 style="color: #FFB32C; text-decoration: none !important; ">CINEMANIA</h2>
        </div>
    </div>

    <div class="login_body">
        <div class="login_box">
            <h2>Cadastrar</h2>

            <?php if ($message): ?>
                <div class="error-message" style="color: darkred;"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="post" action="register.php">
                <div class="input_box">
                    <input required type="text" name="nome" placeholder="Nome completo">
                </div>

                <div class="input_box">
                    <input required type="email" name="email" placeholder="E-mail">
                </div>

                <div class="input_box">
                    <input required type="date" name="data" placeholder="data de nascimento" style="color: gray;">
                </div>

                <div class="input_box">
                    <input required type="text" name="cpf" placeholder="CPF">
                </div>

                <div class="input_box">
                    <input required type="password" name="senha" placeholder="Senha">
                </div>

                <div>
                    <button class="submit" style="margin-top: 9%;">
                        Cadastrar
                    </button>
                </div>
            </form>

            <div class="login_footer">
                <div class="login_facebook">
                    <span><img height="20px" src="assets/img/google.png" alt="facebook"></span>
                    <span><a href="#">Conectar com Google</a></span>
                </div>

                <div class="sign_up">
                    <p>Já possui uma conta? <a href="login.php">Entrar.</a></p>
                </div>

                <div class="terms">
                    <p>Esta página é protegida pelo Google reCAPTCHA para garantir que você não é um robô. <a href="#">Saiba mais</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>