<?php

$messageErreur = "";

if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] === 'mdp_diff') {
        $messageErreur = " Les mots de passe ne correspondent pas.";
    } elseif ($_GET['erreur'] === 'mdp_court') {
        $messageErreur = " Le mot de passe doit contenir au moins 8 caractères.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="inscription.css">
</head>
<body>
    
    <div class="container">
    <div class="image left"></div>
        <form method="post" class="inscription" action="connexion.php">
            <h1 class="b">INSCRIPTION</h1>
            <input type="text" name="nom" placeholder="Nom" required > <br>
            <input type="text" name="prenom" placeholder="Prenom" required > <br>
            <input type="text" name="adresse" placeholder="Adresse" required > <br>
            <input type="email" name="email" placeholder="Email" required > <br>
            <input type="password" name="pswd" id="pswd" placeholder="Mot De Passe" required > <br> 
             <input type="password" name="confirmer" id="confirmer" placeholder="Confirmer le mot de passe" required>
             <input type="checkbox" onclick="togglePassword()" > <span style="color:black;"> Afficher le mot de passe</span>
            <?php if (!empty($messageErreur)): ?>
    <p style="color:red;"><?php echo $messageErreur; ?></p>
  <?php endif; ?> 
             <button type="submit"> S'inscrire </button> 
        </form>
        <script>
     function togglePassword() {
  const input = document.getElementById("pswd");
  const pw2 = document.getElementById("confirmer");

  const newType = (input.type === "password") ? "text" : "password";
  input.type = newType;
  pw2.type = newType;
}
  </script>
        <div class="image right"></div>
</div>
    <script>
  
  if (window.location.search.includes("erreur")) {
    const cleanUrl = window.location.origin + window.location.pathname;
    window.history.replaceState({}, document.title, cleanUrl);
  }
</script>

</body>
</html>