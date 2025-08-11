<?php
session_start();
require 'BD.php';

if (!isset($_SESSION['client_id'])) {
    header('Location: index.php');
    exit;
}

$stmt = $mysqli->prepare("SELECT NomClient, PrenomClient FROM client WHERE idClient = ?");
$stmt->bind_param("i", $_SESSION['client_id']);
$stmt->execute();
$stmt->bind_result($nom, $prenom);

if (!$stmt->fetch()) {
    $stmt->close();
    session_destroy();
    header('Location: index.php');
    exit;
}

$stmt->close();
$pseudo = trim($nom . ' ' . $prenom);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Chat Moderne</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
  /* Reset basique */
  *, *::before, *::after {
    box-sizing: border-box;
  }

  body {
    margin: 0; 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #e0e7ff;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    color: #1e293b;
  }

  header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #4f46e5;
    color: white;
    padding: 1rem 2rem;
    font-weight: 700;
    font-size: 1.5rem;
    box-shadow: 0 2px 6px rgba(79, 70, 229, 0.4);
  }

  header a#home-icon {
    color: white;
    font-size: 1.8rem;
    text-decoration: none;
  }
  header a#home-icon:hover,
  header a#home-icon:focus {
    color: #d1d5db;
    outline: none;
  }

  header h1 {
    margin: 0;
    flex-grow: 1;
    text-align: center;
    font-weight: 700;
    user-select: none;
  }

  /* To balance flex spacing */
  header .spacer {
    width: 1.8rem;
  }

  main {
    flex: 1;
    display: flex;
    flex-direction: column;
    max-width: 800px;
    margin: 2rem auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    padding: 1rem;
  }

  #chatBox {
    flex-grow: 1;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    padding: 1rem;
    overflow-y: auto;
    background: #f8fafc;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
    min-height: 350px;
  }

  .message {
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e2e8f0;
  }

  .username {
    font-weight: 700;
    color: #4338ca;
  }

  .time {
    font-size: 0.75rem;
    color: #94a3b8;
    margin-left: 0.5rem;
  }

  .message-text {
    margin-top: 0.25rem;
    font-size: 1rem;
    color: #334155;
    white-space: pre-wrap;
  }

  #chatForm {
    margin-top: 1rem;
    display: flex;
    gap: 0.75rem;
  }

  #messageInput {
    flex: 1;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 9999px;
    outline-offset: 2px;
    transition: border-color 0.3s, box-shadow 0.3s;
  }
  #messageInput:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
  }

  #sendBtn {
    background-color: #4f46e5;
    border: none;
    padding: 0 1.5rem;
    border-radius: 9999px;
    color: white;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  #sendBtn:hover,
  #sendBtn:focus {
    background-color: #4338ca;
    outline: none;
  }

  /* Responsive */
  @media (max-width: 600px) {
    main {
      margin: 1rem;
      padding: 1rem;
    }
    #chatBox {
      min-height: 250px;
    }
  }
</style>
</head>
<body>

<header>
  <a href="espace.html" title="Retour à l'accueil" id="home-icon" aria-label="Retour à l'accueil">
    <i class="fas fa-house"></i>
  </a>
  <h1>Bienvenue, <?= htmlspecialchars($pseudo) ?> !</h1>
  <div class="spacer"></div>
</header>

<main>
  <div id="chatBox" role="log" aria-live="polite" aria-relevant="additions"></div>

  <form id="chatForm" autocomplete="off" aria-label="Formulaire de chat">
    <input type="text" id="messageInput" placeholder="Écris ton message ici..." required aria-label="Message à envoyer" />
    <button type="submit" id="sendBtn" aria-label="Envoyer le message">Envoyer</button>
  </form>
</main>

<script>
  // Déclare la constante CLIENT_ID pour usage dans chat.js
  const CLIENT_ID = <?= json_encode($_SESSION['client_id']) ?>;
</script>
<script src="chat.js"></script>

</body>
</html>
