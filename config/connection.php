<?php
$host = 'localhost'; 
$user = 'root';       
$pass = 'Seg@123';            
$db = 'Cinemania';     

// Cria uma conexão
$conn = new mysqli($host, $user, $pass, $db);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Código adicional pode ir aqui (por exemplo, consultas ao banco de dados)

// Fecha a conexão quando não for mais necessária
