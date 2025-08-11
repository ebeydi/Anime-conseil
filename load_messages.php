<?php
session_start();
require 'BD.php';

header('Content-Type: application/json');

// Vérifie si client connecté (optionnel, selon besoin)
if (!isset($_SESSION['client_id'])) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT 
            m.id, 
            m.client_id, 
            m.message, 
            CONCAT(c.NomClient, ' ', c.PrenomClient) AS username, 
            DATE_FORMAT(m.created_at, '%H:%i:%s') as created_at
        FROM messages m
        JOIN client c ON m.client_id = c.idClient
        ORDER BY m.created_at ASC
        LIMIT 100";

$result = $mysqli->query($sql);

if (!$result) {
    echo json_encode(['error' => $mysqli->error]);
    exit;
}

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
