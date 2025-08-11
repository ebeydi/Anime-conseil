<?php
$mysqli = new mysqli('localhost', 'root', '', 'essai');
if ($mysqli->connect_error) {
    die('Erreur connexion : ' . $mysqli->connect_error);
}
echo 'Connexion réussie';
?>
