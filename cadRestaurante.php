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
    // Prepare the data for insertion
    $nomeRes = isset($jsonParam['nome']) ? $jsonParam['nome'] : '';
    $descricaoRes = isset($jsonParam['descricao']) ? $jsonParam['descricao'] : '';
    $enderecoRes = isset($jsonParam['endereco']) ? $jsonParam['endereco'] : '';
    $horarioRes = isset($jsonParam['horario']) ? $jsonParam['horario'] : '';


    // Prepare the SQL statement for insertion
    $insertQuery = "INSERT INTO restaurante (nome, descricao, endereco, horario) 
		VALUES ('$nomeRes', '$descricaoRes', '$enderecoRes', '$horarioRes')";

    if ($con->query($insertQuery) === true) {
        // Insertion successful
        $response = array(
            'success' => true,
            'message' => 'Restaurante cadastrado com sucesso!'
        );
        echo json_encode($response);
    } else {
        // Error in insertion
        $response = array(
            'success' => false,
            'message' => 'Erro no registro do restaurante: ' . $con->error
        );
        echo json_encode($response);
    }
} else {
    // No data provided
    $response = array(
        'success' => false,
        'message' => 'Dados insuficientes para o registro do restaurante!'
    );
    echo json_encode($response);
}

$con->close();

?>