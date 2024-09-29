<?php
include 'verificar_login.php';
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

    <!-- Barra Lateral -->
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
                    <img src="assets/img/dead.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption text-start custom-caption">
                        <h1>Bem-vindo ao Cinemania</h1>
                        <p>O lugar perfeito para a sua experiência no cinema.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/img/shadow.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption text-start custom-caption">
                        <h1>Filmes em Cartaz</h1>
                        <p>Descubra os lançamentos mais esperados da temporada.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/img/coringa.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption text-start custom-caption">
                        <h1>Experiência Cinemática</h1>
                        <p>Viva momentos inesquecíveis em cada sessão.</p>
                    </div>
                </div>
            </div>
        </div>


        <h2 class="mb-4">Filmes em Cartaz</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4" id="filmesContainer"">
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            include 'config/connection.php';

            $query = "SELECT id_filme, titulo_filme, genero_filme, duracao_filme, diretor_filme, classind_filme, capa_filme FROM tb_filme";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die('Erro na consulta: ' . mysqli_error($conn));
            }

            $filmes = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $imagem = $row['capa_filme'] ? 'uploads/' . $row['capa_filme'] : 'assets/img/default.jpg'; // Caminho para a imagem padrão
                echo '<div class="col">';
                echo '<div class="card movie-card">';
                echo '<img src="' . $imagem . '" class="card-img-top" alt="' . $row['titulo_filme'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['titulo_filme'] . '</h5>';
                echo '<p class="card-text">Gênero: ' . $row['genero_filme'] . '</p>';
                echo '<p class="card-text">Classificação: ' . $row['classind_filme'] . '</p>';
                echo '<a href="comprar_ingresso.php?id=' . $row['id_filme'] . '" class="btn btn-primary">Comprar Ingresso</a>';
                echo '</div></div></div>';
            }

            ?>
        </div>
    </div>



    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script>
</body>

</html>