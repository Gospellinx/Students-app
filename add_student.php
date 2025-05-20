<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = $_POST['age'] ?? '';

    if ($name && $email && $age) {
        $stmt = $pdo->prepare("INSERT INTO students (name, email, age) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $age]);
        echo json_encode(["message" => "Student added successfully!"]);
    } else {
        echo json_encode(["error" => "All fields are required"]);
    }
}
?>
