<?php 
session_start();
require "BD.php";

$email = $_POST['login'] ?? '';
$passwd = $_POST['passwd'] ?? '';

if (empty($email) || empty($passwd)) {
    header("Location: index.php?erreur=champs_vides");
    exit();
}

$sql = "SELECT * FROM client WHERE Email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($passwd, $user['MotDePasse'])) {
        // Stockage cohérent en session
        $_SESSION['client_id'] = $user['idClient'];
        $_SESSION['NomClient'] = $user['NomClient'];
        $_SESSION['PrenomClient'] = $user['PrenomClient'];

        // Redirige vers une page PHP (par exemple espace.php)
        header("Location: espace.html");
        exit();
    } else {
        header("Location: index.php?erreur=mdp");
        exit();
    }
} else {
    header("Location: index.php?erreur=non_inscrit");
    exit();
}
?>
