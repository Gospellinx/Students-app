<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(["message" => "Student deleted successfully!"]);
    } else {
        echo json_encode(["error" => "Student ID required"]);
    }
}
?>
