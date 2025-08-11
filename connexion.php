<?php
require"BD.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'] ;
    $adresse = $_POST['adresse'] ;
    $email = $_POST['email'] ;
    $psswd = $_POST['pswd'] ;
    $confirmer = $_POST['confirmer'] ;
if ($psswd !== $confirmer) {
    header("Location: inscription.php?erreur=mdp_diff");
    exit();
} elseif (strlen($psswd) < 8) {
    header("Location: inscription.php?erreur=mdp_court");
    exit();
} else {
    $hash = password_hash($psswd, PASSWORD_DEFAULT);

    $sql = "INSERT INTO client (NomClient, PrenomClient, AdresseClient, Email, MotDePasse) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("Erreur préparation requête : " . $mysqli->error);
    }

    $stmt->bind_param("sssss", $nom, $prenom, $adresse, $email, $hash);

    if ($stmt->execute()) {
        header("Location: index.php?msg=Connexion réussi");
        exit();
    } else {
        header("Location: inscription.php?erreur=sql");
        exit();
    }
}
}
?>