<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = $_POST['age'] ?? '';

    if ($id && $name && $email && $age) {
        $stmt = $pdo->prepare("UPDATE students SET name = ?, email = ?, age = ? WHERE id = ?");
        $stmt->execute([$name, $email, $age, $id]);
        echo json_encode(["message" => "Student updated successfully!"]);
    } else {
        echo json_encode(["error" => "All fields are required"]);
    }
}
?>
