<?php
include 'conexao.php'; 

$query = "SELECT id_filme, titulo_filme, genero_filme, duracao_filme, diretor_filme, classind_filme, capa_filme FROM tb_filme";
$result = mysqli_query($conexao, $query);

$filmes = [];

while($row = mysqli_fetch_assoc($result)) {
    $filmes[] = [
        'id_filme' => $row['id_filme'],
        'titulo_filme' => $row['titulo_filme'],
        'genero_filme' => $row['genero_filme'],
        'duracao_filme' => $row['duracao_filme'],
        'diretor_filme' => $row['diretor_filme'],
        'classind_filme' => $row['classind_filme'],
        'capa_filme' => base64_encode($row['capa_filme'])
    ];
}

header('Content-Type: application/json');