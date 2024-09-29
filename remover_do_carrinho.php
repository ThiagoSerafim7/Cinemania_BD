<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['carrinho']['filmes'][$_GET['id']])) {
    unset($_SESSION['carrinho']['filmes'][$_GET['id']]);
}

header('Location: carrinho.php'); // Redireciona de volta para o carrinho
exit;
?>
