<?php

include 'verificar_login.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Carrinho</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #141414;
            color: #fff;
            font-family: Arial, sans-serif;
        }


        .content {
            margin-left: 260px;
            padding: 20px;
        }

        .card {
            background-color: #222;
            border: 1px solid #FFB32C;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #FFB32C;
            color: #000;
        }

        .card-body {
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .car {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="container d-flex justify-center">
            <h4><img src="assets/img/logo.png" class="px-1" alt="" style="max-width: 35px; padding-left: 1vh;"> Cinemania</h4>
        </div>
        <hr>
        <a href="home.php"><i class="fas fa-home"></i> Início</a>
        <a href="carrinho.php"><i class="fas fa-ticket-alt"></i> Seus Itens</a>
        <a href="snackbar.php"><i class="fas fa-utensils"></i> Snackbar</a>
        <a href="#"><i class="fas fa-user-circle"></i> Perfil</a>
        <a href="postar_filme.php"><i class="fas fa-cogs"></i> Configurações</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </div>

    <div class="content">
        <h1 class="mb-4">Carrinho de Compras</h1>
        <div class="row car">
            <?php
            if (isset($_SESSION['carrinho']['filmes']) && !empty($_SESSION['carrinho']['filmes'])) {
                foreach ($_SESSION['carrinho']['filmes'] as $id => $item) {
                    echo '<div class="col-md-4 car">';
                    echo '<div class="card">';
                    echo '<div class="card-header">' . htmlspecialchars($item['nome']) . '</div>';
                    echo '<div class="card-body">';
                    echo '<p>Preço: R$ ' . number_format($item['preco'], 2, ',', '.') . '</p>';
                    echo '<p>Quantidade: ' . htmlspecialchars($item['quantidade']) . '</p>';
                    echo '<p>Lugares: ' . (isset($item['lugares']) && is_array($item['lugares']) ? implode(', ', $item['lugares']) : '-') . '</p>';
                    echo '<a href="remover_do_carrinho.php?id=' . htmlspecialchars($id) . '" class="btn btn-danger btn-sm">Remover</a>';
                    echo '</div>'; // .card-body
                    echo '</div>'; // .card
                    echo '</div>'; // .col-md-4
                }
            } else {
                echo '<div class="alert alert-warning" role="alert">Seu carrinho está vazio.</div>';
            }
            ?>
        </div>
    </div>
</body>

</html>
