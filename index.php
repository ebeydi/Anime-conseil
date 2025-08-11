<?php
$messageErreur = "";

if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] === 'mdp') {
        $messageErreur = " Mot de passe incorrect.";
    } elseif ($_GET['erreur'] === 'non_inscrit') {
        $messageErreur = "Utilisateur non inscrit.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>CONNEXION</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <div> 
    <h1 class="titre-formulaire">ANIMES CONSEIL</h1>
    <form method="post" class="formulaire" action="verifier.php">
      <input type="text" name="login" placeholder="Nom d'utilisateur" required autocomplete="username" />
      <input type="password" name="passwd" id="passwd" placeholder="Mot de passe" required autocomplete="current-password" />
      <label><input type="checkbox" onclick="togglePassword()"> Afficher le mot de passe</label>

      <?php if (!empty($messageErreur)) : ?>
        <p class="error-msg"><?= htmlspecialchars($messageErreur) ?></p>
      <?php endif; ?>

      <button type="submit">Se connecter</button> 
    </form>

    <p class="signup">
      Pas encore de compte ? 
      <a href="inscription.php">Inscris-toi ici</a>
    </p>
  </div>

<script>
  function togglePassword() {
    const input = document.getElementById("passwd");
    input.type = (input.type === "password") ? "text" : "password";
  }

  // Nettoyer l'URL pour ne plus afficher le message d'erreur après rechargement
  if (window.location.search.includes("erreur")) {
    const cleanUrl = window.location.origin + window.location.pathname;
    window.history.replaceState({}, document.title, cleanUrl);
  }
</script>
</body>
</html>
