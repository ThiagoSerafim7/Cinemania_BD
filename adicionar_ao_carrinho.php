<?php
session_start();
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
        
        // Adicionando ao carrinho
        if (isset($_SESSION['carrinho']['filmes'][$id_comida])) {
            $_SESSION['carrinho']['filmes'][$id_comida]['quantidade']++;
        } else {
            $_SESSION['carrinho']['filmes'][$id_comida] = [
                'nome' => $comida['nome_comida'],
                'preco' => $comida['preco_comida'],
                'quantidade' => 1
            ];
        }
        
        // Depuração para verificar o carrinho
        echo '<pre>';
        print_r($_SESSION['carrinho']);
        echo '</pre>';
        
        header('Location: carrinho.php');
        exit();
    } else {
        echo "Erro: Comida não encontrada.";
    }
}