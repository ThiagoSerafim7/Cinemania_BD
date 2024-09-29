<?php
session_start();
include 'config/connection.php';

$message = ""; // Variável para armazenar mensagens

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Verifique se o email e a senha estão corretos
    $stmt = $conn->prepare("SELECT senha_usuario FROM tb_usuario WHERE email_usuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($senha_hash);
    $stmt->fetch();
    
    if ($senha_hash && password_verify($senha, $senha_hash)) {
        // Autenticação bem-sucedida
        $_SESSION['user_email'] = $email; // Inicie a sessão do usuário
        header("Location: home.php"); // Redireciona para a página principal
        exit();
    } else {
        $message = "Email ou senha inválidos."; // Armazena mensagem de erro
    }
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
            <h2 style="color: #FFB32C; text-decoration: none !important;">CINEMANIA</h2>
        </div>
    </div>

    <div class="login_body">
        <div class="login_box">
            <h2>Entrar</h2>
            <?php if ($message): ?>
                <div class="error-message" style="color: darkred;"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="post" action="login.php">
                <div class="input_box">
                    <input required type="email" name="email" placeholder="Email ou número de telefone">
                </div>

                <div class="input_box">
                    <input required type="password" name="senha" placeholder="Senha">
                </div>

                <div>
                    <button class="submit">
                        Entrar
                    </button>
                </div>
            </form>

            <div class="support">
                <div class="remember">
                    <span><input type="checkbox" style="margin: 0; padding: 0; height: 13px;"></span>
                    <span>Lembre-se de mim</span>
                </div>
                <div class="help">
                    <a href="#">
                        Precisa de ajuda?
                    </a>
                </div>
            </div>

            <div class="login_footer">
                <div class="login_facebook">
                    <span><img height="20px" src="assets/img/google.png" alt="facebook"></span>
                    <span><a href="#">Conectar com Google</a></span>
                </div>

                <div class="sign_up">
                    <p>Não possui uma conta? <a href="register.php">Cadastrar.</a></p>
                </div>

                <div class="terms">
                    <p>Esta página é protegida pelo Google reCAPTCHA para garantir que você não é um robô. <a href="#">Saiba mais</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
