<?php
require 'BD.php';

$message = "";

// Traitement du formulaire si soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sécuriser les inputs (éviter injections SQL etc)
    $nom = $mysqli->real_escape_string(trim($_POST['nomAnime']));
    $genre = $mysqli->real_escape_string(trim($_POST['genreAnime']));
    $format = $mysqli->real_escape_string(trim($_POST['formatAnime']));

    if ($nom && $genre && $format) {
        // Insert dans la base
        $sql = "INSERT INTO anime (nomAnime, genreAnime, formatAnime) VALUES ('$nom', '$genre', '$format')";
        if ($mysqli->query($sql)) {
            $message = "Suggestion ajoutée avec succès !";
        } else {
            $message = "Erreur lors de l'ajout : " . $mysqli->error;
        }
    } else {
        $message = "Merci de remplir tous les champs.";
    }
}

// Récupération de la liste des animés
$result = $mysqli->query("SELECT * FROM anime");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Liste des animés & Suggestions</title>
<link rel="stylesheet" href="my.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>
<body>

<a href="espace.html" title="Retour à l'accueil" id="home-icon">
  <i class="fas fa-house"></i>
</a>


<h2>Liste des animés à regarder</h2>

<?php if ($message): ?>
  <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<table>
  <tr>
    <th>Numéro</th>
    <th>Nom</th>
    <th>Genre</th>
    <th>Format</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?= htmlspecialchars($row['idAnime']) ?></td>
    <td><?= htmlspecialchars($row['nomAnime']) ?></td>
    <td><?= htmlspecialchars($row['genreAnime']) ?></td>
    <td><?= htmlspecialchars($row['formatAnime']) ?></td>
  </tr>
  <?php endwhile; ?>
</table>

<h3>Propose un animé</h3>
<form method="POST" action="">
  <label for="nomAnime">Nom de l'animé :</label>
  <input type="text" id="nomAnime" name="nomAnime" required />


  <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
    <label for="genreAnime" style="flex: 1;">
      Genre :
      <select id="genreAnime" name="genreAnime" required style="width: 100%;">
        <option value="" disabled selected>Choisissez un genre</option>
        <option value="Action">Action</option>
        <option value="Aventure">Aventure</option>
        <option value="Comédie">Comédie</option>
        <option value="Drame">Drame</option>
        <option value="Fantasy">Fantasy</option>
        <option value="Science-fiction">Science-fiction</option>
        <option value="Romance">Romance</option>
        <option value="Isekai">Isekai</option>
      </select>
    </label>

    <label for="formatAnime" style="flex: 1;">
      Format :
      <select id="formatAnime" name="formatAnime" required style="width: 100%;">
        <option value="" disabled selected>Choisissez un format</option>
        <option value="Série TV">Série TV</option>
        <option value="Film">Film</option>
        <option value="OVA">OVA</option>
        <option value="ONA">ONA</option>
        <option value="Spécial">Spécial</option>
      </select>
    </label>
  </div>

  <button type="submit">Envoyer la suggestion</button>
</form>


</body>
</html>
