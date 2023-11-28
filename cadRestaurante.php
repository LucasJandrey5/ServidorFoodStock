<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = '200.98.129.120:3306';
$username = 'marcosvir_lucasJ';
$password = 'Lucas_1234';
$dbname = 'marcosvir_lucasJ';

// Add the following lines to set CORS headers
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin (you can restrict this in a production environment)
header("Access-Control-Allow-Methods: POST"); // Allow POST requests
header("Access-Control-Allow-Methods: GET"); // Allow POST requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow Content-Type header

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

$inputFile = file_get_contents('php://input');

if ($data = json_decode($inputFile, true)) {

    if (json_last_error() === JSON_ERROR_NONE) {

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
        $response = [
            "success" => false,
            "message" => "Invalid JSON format."
        ];
    }
    
} else {
    // No data provided
    $response = array(
        'success' => false,
        'message' => 'Dados insuficientes para o registro do restaurante!'
    );
    
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);

// Close the database connection
$conn = null;

?>