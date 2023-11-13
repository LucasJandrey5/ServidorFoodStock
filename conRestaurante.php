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

// Retrieve the JSON parameter
$jsonParam = json_decode(file_get_contents('php://input'), true);

if (!empty($jsonParam)) {
    // Prepare the WHERE clause
    $whereClause = ' WHERE ';
    foreach ($jsonParam as $field => $value) {
        if ($value != '' && $value != '0') {
            $whereClause .= "$field = '$value' AND ";
        }
    }
    $whereClause = rtrim($whereClause, ' AND ');

    // Prepare the SQL statement
    $consulta = "SELECT idrestaurante, nome, descricao, endereco, horario 
                 FROM restaurante $whereClause";

    $result = $con->query($consulta);

    $json = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert character encoding for each field
            foreach ($row as &$value) {
                $value = mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
            }

            $restaurante = array(
                "idrestaurante" => $row['idrestaurante'],
                "nome" => $row['nome'],
                "descricao" => $row['descricao'],
                "endereco" => $row['endereco'],
                "horario" => $row['horario']
            );
            $json[] = $restaurante;
        }
    } else {
        $restaurante = array(
            "idrestaurante" => 0,
            "nome" => "",
            "descricao" => "",
            "endereco" => "",
            "horario" => 0
        );
        $json[] = $restaurante;
    }

    if ($json) {
        $encoded_json = json_encode($json);
        if ($encoded_json === false) {
            echo "Error encoding JSON: " . json_last_error_msg();
        } else {
            header('Content-Type: application/json; charset=utf-8');
            echo "Alterado com sucesso!", $consulta;
            echo $encoded_json;
        }
    } else {
        echo "Empty JSON data.";
    }

    $result->free_result();
}

$con->close();

?>