<?php


include 'verificar_login.php';
include('config/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem']['name'];
    $genero = $_POST['genero'];
    $duracao = $_POST['duracao'];
    $diretor = $_POST['diretor'];
    $classind = $_POST['classind'];
    $preco = $_POST['preco'];

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); 
    }
    $target_file = $target_dir . basename($imagem);
    
    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)) {
        $query = "INSERT INTO tb_filme (titulo_filme, descricao, genero_filme, duracao_filme, diretor_filme, classind_filme, preco_ingresso, capa_filme) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, 'sssiisss', $titulo, $descricao, $genero, $duracao, $diretor, $classind, $preco, $imagem);
            if (mysqli_stmt_execute($stmt)) {
                echo "Filme adicionado com sucesso!";
            } else {
                echo "Erro ao adicionar filme: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Erro na preparação da consulta: " . mysqli_error($conn);
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postar Filme</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #141414;
            color: #fff !important;
            font-family: Arial, sans-serif;
            margin: 0;
        }


        .container {
            margin-left: 12vw;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            color: white;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            background-color: #222;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #FFB32C;
        }

        .form-control {
            background-color: #333;
            color: #fff;
            border: 1px solid #444;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .form-control:focus {
            background-color: #444;
            color: #fff;
            border-color: #FFB32C;
            box-shadow: 0 0 5px rgba(255, 179, 44, 0.5);
        }
        .form-control::placeholder {
            color: #fff;
            opacity: .5;
        }

        .btn-custom {
            background-color: #FFB32C;
            color: #fff;
            font-weight: bold;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .btn-custom:hover {
            background-color: #FFDA57;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4><img src="assets/img/logo.png" alt="Cinemania" style="max-width: 35px; margin-right: 10px;"> Cinemania</h4>
    <hr>
    <a href="home.php"><i class="fas fa-home"></i> Início</a>
    <a href="carrinho.php"><i class="fas fa-ticket-alt"></i> Seus Itens</a>
    <a href="snackbar.php"><i class="fas fa-utensils"></i> Snackbar</a>
    <a href="#"><i class="fas fa-user-circle"></i> Perfil</a>
    <a href="postar_filme.php"><i class="fas fa-cogs"></i> Configurações</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
</div>

<div class="container">
    <div class="form-container" style="color: white !important;">
        <h1>Postar Filme</h1>
        <form action="postar_filme.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="titulo" class="form-control" placeholder="Título do Filme" required>
            <textarea name="descricao" class="form-control" placeholder="Descrição do Filme" required></textarea>
            <input type="text" name="genero" class="form-control" placeholder="Gênero do Filme" required>

            <div class="form-row">
                <input type="number" name="duracao" class="form-control" placeholder="Duração (min)" required>
                <input type="text" name="classind" class="form-control" placeholder="Classificação" required>
            </div>

            <div class="form-row">
                <input type="text" name="diretor" class="form-control" placeholder="Diretor do Filme" required>
                <input type="number" name="preco" class="form-control" placeholder="Preço" required>
            </div>

            <input type="file" name="imagem" class="form-control" required>
            <button type="submit" class="btn btn-custom">Postar Filme</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
