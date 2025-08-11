<?php
session_start();
require 'BD.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['client_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

if (empty($_POST['message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Message vide']);
    exit;
}

$message = trim($_POST['message']);

$stmt = $mysqli->prepare("INSERT INTO messages (client_id, message) VALUES (?, ?)");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur préparation requête']);
    exit;
}

$stmt->bind_param("is", $_SESSION['client_id'], $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur insertion base']);
}

$stmt->close();
exit;
