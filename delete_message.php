<?php
session_start();
require 'BD.php';

header('Content-Type: application/json');

if (!isset($_SESSION['client_id'])) {
    echo json_encode(['success' => false, 'error' => 'Non authentifié']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'])) {
    $message_id = intval($_POST['message_id']);
    $client_id = $_SESSION['client_id'];

    // Vérifie que le message appartient bien au client
    $stmt = $mysqli->prepare("SELECT client_id FROM messages WHERE id = ?");
    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $stmt->bind_result($owner_id);
    if ($stmt->fetch()) {
        if ($owner_id == $client_id) {
            $stmt->close();
            // Supprime le message
            $stmt_del = $mysqli->prepare("DELETE FROM messages WHERE id = ?");
            $stmt_del->bind_param("i", $message_id);
            if ($stmt_del->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erreur suppression']);
            }
            $stmt_del->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Pas autorisé']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Message non trouvé']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Requête invalide']);
}
