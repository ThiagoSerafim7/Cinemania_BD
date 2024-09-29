<?php
include 'config/connection.php';
include 'verificar_login.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id_filme = intval($_GET['id']);
$sql = "SELECT titulo_filme, descricao, genero_filme, classind_filme, capa_filme FROM tb_filme WHERE id_filme = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar a consulta: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $id_filme);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o filme foi encontrado

if ($result->num_rows > 0) {
    $filme = $result->fetch_assoc();
    // Define o caminho da imagem
    $imagem = !empty($filme['capa_filme']) ? 'uploads/' . $filme['capa_filme'] : 'assets/img/default.jpg'; // Caminho padrão
} else {
    echo "Filme não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Ingresso</title>
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #141414;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .movie-info {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .movie-info img {
            max-width: 300px;
            border-radius: 10px;
        }

        .movie-details {
            max-width: 600px;
        }

        .seats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .seat {
            width: 50px;
            height: 50px;
            background-color: #444;
            border-radius: 5px;
            text-align: center;
            line-height: 50px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .seat:hover {
            background-color: #FFB32C;
        }

        .seat-selected {
            background-color: #FFB32C;
        }

        .sidebar {
            position: relative;
            width: 240px;
            background-color: #181818;
            padding-top: 60px;
            float: left;
            height: 100vh;
        }

        .sidebar a {
            padding: 10px 20px;
            display: block;
            gap: 2rem;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #FFB32C;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
        }

        #title {
            color: #FFB32C;
        }
        .btn-success{
            background-color: #FFB32C;
            border-color: #FFB32C;
        }
        .btn-success:hover{
            background-color: #141414;
            border-color: #FFB32C
        }
        .btn-primary:hover{
            background-color: #FFB32C;
            border-color: #FFB32C;
        }
        .btn-primary{
            background-color: #141414;
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
        <a href="#"><i class="fas fa-ticket-alt"></i> Seus Ingressos</a>
        <a href="snackbar.php"><i class="fas fa-utensils"></i> Snackbar</a>
        <a href="#"><i class="fas fa-user-circle"></i> Perfil</a>
        <a href="postar_filme.php"><i class="fas fa-cogs"></i> Configurações</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </div>
    <div class="main-content">
        <div class="container mt-5">
            <h1 id="title">Comprar Ingresso</h1>


            <div class="movie-info">
                <img src="<?= $imagem ?>" alt="<?= htmlspecialchars($filme['titulo_filme']) ?>">
                <div class="movie-details">
                    <h2><?= htmlspecialchars($filme['titulo_filme']) ?></h2>
                    <p><?= htmlspecialchars($filme['descricao']) ?></p>
                    <p><strong>Gênero:</strong> <?= htmlspecialchars($filme['genero_filme']) ?></p>
                    <p><strong>Classificação Indicativa:</strong> <?= htmlspecialchars($filme['classind_filme']) ?></p>
                </div>
            </div>

            <h3>Escolha seus lugares</h3>
            <div class="seats-container">
                <?php for ($i = 1; $i <= 60; $i++): ?>
                    <div class="seat" data-seat="<?= $i ?>">L<?= $i ?></div>
                <?php endfor; ?>
            </div>

            <button class="btn btn-primary mt-4" id="confirmBtn">Confirmar Seleção</button>
            <button class="btn btn-success mt-4" id="addToCartBtn">Adicionar ao Carrinho</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const seats = document.querySelectorAll('.seat');
            let selectedSeats = [];

            seats.forEach(seat => {
                seat.addEventListener('click', function() {
                    if (selectedSeats.includes(seat.dataset.seat)) {
                        selectedSeats = selectedSeats.filter(s => s !== seat.dataset.seat);
                        seat.classList.remove('seat-selected');
                    } else {
                        selectedSeats.push(seat.dataset.seat);
                        seat.classList.add('seat-selected');
                    }
                });
            });

            document.getElementById('confirmBtn').addEventListener('click', function() {
                if (selectedSeats.length > 0) {
                    alert('Você selecionou os lugares: ' + selectedSeats.join(', '));
                } else {
                    alert('Por favor, selecione pelo menos um lugar.');
                }
            });

            document.getElementById('addToCartBtn').addEventListener('click', function() {
                if (selectedSeats.length > 0) {
                    fetch('adicionar_filme.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id_filme: <?= json_encode($id_filme) ?>,
                                lugares: selectedSeats
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                alert('Filme adicionado ao carrinho com os lugares: ' + selectedSeats.join(', '));
                                window.location.href = 'carrinho.php';
                            } else {
                                alert('Erro ao adicionar ao carrinho: ' + data.message);
                            }
                        })
                        .catch(error => {
                            alert('Ocorreu um erro ao adicionar ao carrinho.');
                        });
                } else {
                    alert('Por favor, selecione pelo menos um lugar antes de adicionar ao carrinho.');
                }
            });
        });
    </script>
</body>

</html>