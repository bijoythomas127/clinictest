<?php
require_once __DIR__ . '/environment.php';

$conn = new mysqli($database_config['host'], $database_config['username'], $database_config['password'], $database_config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function createPatientWithQuestions($first_name, $surname, $dob, $questions) {
    global $conn;
    
    $first_name = $conn->real_escape_string($first_name);
    $surname = $conn->real_escape_string($surname);
    $dob = date('Y-m-d', strtotime($dob));
    $questions_json = json_encode($questions);
    $sql = "CALL create_patient_with_questions('$first_name', '$surname', '$dob', '$questions_json')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
    closeConnection();
}


function closeConnection(){
    global $conn;
    $conn->close();
}

