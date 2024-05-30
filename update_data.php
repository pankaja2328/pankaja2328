<?php
require_once "PHP/db_connection.php"; 

$input = file_get_contents("php://input");
$data = json_decode($input, true); 

if ($data) {
    
    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL); 
    $index = filter_var($data['index'], FILTER_SANITIZE_STRING); 
    $academic = filter_var($data['academic'], FILTER_SANITIZE_STRING);
    $batch = filter_var($data['batch'], FILTER_SANITIZE_STRING);

   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); 
        echo json_encode(["error" => "Invalid email"]);
        exit();
    }

    
    $updateQuery = "
        UPDATE student
        SET 
            email = ?,
            Acedemic_year = ?,
            Batch = ?
        WHERE 
            id = ?
    ";

    $stmt = $conn->prepare($updateQuery);

    if ($stmt) {
        
        $stmt->bind_param("ssss",$email , $academic, $batch, $index);

        if ($stmt->execute()) {
            http_response_code(200); 
            echo json_encode(["message" => "Data updated successfully"]);
        } else {
            http_response_code(500); 
            echo json_encode(["error" => "Database update failed"]);
        }

        $stmt->close(); 
    } else {
        http_response_code(500); 
        echo json_encode(["error" => "Failed to prepare statement"]);
    }

    $conn->close(); 
} else {
    http_response_code(400); 
    echo json_encode(["error" => "No data received or invalid JSON"]);
}
