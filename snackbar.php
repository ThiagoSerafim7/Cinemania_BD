<?php

include 'verificar_login.php';
if (!isset($_SESSION['carrinho']['filmes'])) {
    $_SESSION['carrinho']['filmes'] = [];
}

include 'config/connection.php';

// Adicionando comida ao carrinho se ID for válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_comida = $_GET['id'];
    
    $sql = "SELECT nome_comida, preco_comida FROM tb_comida WHERE id_comida = ? AND disponibilidade_comida = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_comida);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $comida = $result->fetch_assoc();
        
        if (isset($_SESSION['carrinho']['filmes'][$id_comida])) {
            $_SESSION['carrinho']['filmes'][$id_comida]['quantidade']++;
        } else {
            $_SESSION['carrinho']['filmes'][$id_comida] = [
                'nome' => $comida['nome_comida'],
                'preco' => $comida['preco_comida'],
                'quantidade' => 1
            ];
        }

        header('Location: carrinho.php');
        exit();
    } else {
        echo "Erro: Comida não encontrada.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Filmes</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #141414;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #181818;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        .carousel {
            margin-bottom: 20px;
        }

        .custom-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 5px;
        }

        .movie-card {
            background-color: #222;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .movie-card:hover {
            transform: scale(1.05);
        }

        .movie-card img {
            width: 100%;
            height: auto;
        }

        .movie-card .card-body {
            padding: 10px;
        }

        h2 {
            color: #FFB32C;
        }

        .movie-card .card-body {
            padding: 10px;
            color: #fff;
        }

        .btn {
            background-color: transparent;
            border-radius: 3px;
            border: #FFB32C solid;
        }

        .btn:hover {
            background-color: #FFB32C;
            border-color: #FFB32C;
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

        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/pipoca.webp" class="d-block w-100" alt="...">
                    <div class="carousel-caption text-start custom-caption">
                        <h1>Bem-vindo ao Cinemania</h1>
                        <p>Descubra os melhores filmes nas telonas.</p>
                    </div>
                </div>
            </div>
        </div>


        <h2 class="mb-4">Comidas Disponíveis</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4" id="comidasContainer">
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            include 'config/connection.php';

            $queryComidas = "SELECT id_comida, nome_comida, preco_comida, tipo_comida, disponibilidade_comida FROM tb_comida WHERE disponibilidade_comida = 1";
            $resultComidas = mysqli_query($conn, $queryComidas);

            if (!$resultComidas) {
                die('Erro na consulta: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($resultComidas) == 0) {
                echo '<p>Nenhuma comida disponível no momento.</p>';
            } else {
                while ($row = mysqli_fetch_assoc($resultComidas)) {
                    echo '<div class="col">';
                    echo '<div class="card movie-card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['nome_comida']) . '</h5>';
                    echo '<p class="card-text">Tipo: ' . htmlspecialchars($row['tipo_comida']) . '</p>';
                    echo '<p class="card-text">Preço: R$ ' . number_format($row['preco_comida'], 2, ',', '.') . '</p>';
                    echo '<a href="adicionar_ao_carrinho.php?id=' . $row['id_comida'] . '" class="btn btn-primary">Adicionar ao Carrinho</a>';
                    echo '</div></div></div>';
                }
            }


            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id_comida = $_GET['id'];
                
                $sql = "SELECT nome_comida, preco_comida FROM tb_comida WHERE id_comida = ? AND disponibilidade_comida = 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_comida);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $comida = $result->fetch_assoc();
                    
                    $_SESSION['carrinho']['filmes'][$id_comida] = [
                        'nome' => $comida['nome_comida'],
                        'preco' => $comida['preco_comida'],
                        'quantidade' => 1
                    ];
            
                    header('Location: carrinho.php');
                    exit();
                } else {
                    echo "Erro: Comida não encontrada.";
                }
            }
            ?>
        </div>
    </div>



    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>