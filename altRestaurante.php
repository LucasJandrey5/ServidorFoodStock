<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = 'localhost:3306';
$username = 'root';
$password = 'l19UcaS2_TxL';
$dbname = 'foodStock';

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Retrieve the JSON parameter from the POST request
$jsonParam = json_decode(file_get_contents('php://input'), true);

if (!empty($jsonParam)) {
    // Prepare the data for updating
    $idrestaurante = isset($jsonParam['idrestaurante']) ? intval($jsonParam['idrestaurante']) : 0;
    $nome = isset($jsonParam['nome']) ? $jsonParam['nome'] : '';
    $descricao = isset($jsonParam['descricao']) ? $jsonParam['descricao'] : '';
    $endereco = isset($jsonParam['endereco']) ? $jsonParam['endereco'] : '';
    $horario = isset($jsonParam['horario']) ? intval($jsonParam['horario']) : 0;


    // Prepare the SQL statement for updating
    $updateQuery = "UPDATE restaurante SET nome = '$nome', descricao = '$descricao', endereco = '$endereco', 
        horario = '$horario' WHERE idrestaurante = '$idrestaurante'";

    if ($con->query($updateQuery) === true) {
        // Update successful
        $response = array(
            'success' => true,
            'message' => 'Restaurante atualizado com sucesso!'
        );
        echo json_encode($response);
    } else {
        // Error in update
        $response = array(
            'success' => false,
            'message' => 'Erro ao atualizar o restaurante: ' . $con->error
        );
        echo json_encode($response);
    }
} else {
    // No data provided
    $response = array(
        'success' => false,
        'message' => 'Dados insuficientes para atualizar o restaurante!'
    );
    echo json_encode($response);
}

$con->close();

?>