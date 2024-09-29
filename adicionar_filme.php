<?php
session_start();
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    error_log(print_r($data, true));

    if (isset($data['id_filme']) && isset($data['lugares']) && is_array($data['lugares'])) {
        $id_filme = intval($data['id_filme']);
        $lugares = $data['lugares'];

        include 'config/connection.php';
        $sql = "SELECT titulo_filme, preco_ingresso FROM tb_filme WHERE id_filme = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_filme);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $filme = $result->fetch_assoc();

            if (!isset($_SESSION['carrinho']['filmes'])) {
                $_SESSION['carrinho']['filmes'] = [];
            }

            $_SESSION['carrinho']['filmes'][$id_filme] = [
                'nome' => $filme['titulo_filme'],
                'preco' => $filme['preco_ingresso'],
                'lugares' => $lugares,
                'quantidade' => count($lugares)
            ];

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Filme não encontrado']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido']);
}
