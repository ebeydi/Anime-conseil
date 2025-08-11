const chatBox = document.getElementById('chatBox');
const form = document.getElementById('chatForm');
const input = document.getElementById('messageInput');

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

function loadMessages() {
  fetch('load_messages.php')
    .then(res => res.json())
    .then(data => {
      chatBox.innerHTML = '';
      data.forEach(msg => {
        const div = document.createElement('div');
        div.classList.add('message');

        let deleteBtn = '';
        // Affiche bouton supprimer seulement si c’est ton message
        if (msg.client_id == CLIENT_ID) {
          deleteBtn = `<button class="delete-btn" data-id="${msg.id}" aria-label="Supprimer ce message">🗑️</button>`;
        }

        div.innerHTML = `
          <span class="username">${escapeHtml(msg.username)}</span>
          <span class="time">[${msg.created_at}]</span>
          ${deleteBtn}
          <div class="message-text">${escapeHtml(msg.message)}</div>
        `;
        chatBox.appendChild(div);
      });

      chatBox.scrollTop = chatBox.scrollHeight;

      // Ajoute gestion des clics sur suppression
      document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.getAttribute('data-id');
          if (confirm('Supprimer ce message ?')) {
            fetch('delete_message.php', {
              method: 'POST',
              headers: {'Content-Type': 'application/x-www-form-urlencoded'},
              body: 'message_id=' + encodeURIComponent(id)
            })
            .then(res => res.json())
            .then(resp => {
              if (resp.success) {
                loadMessages();
              } else {
                alert('Erreur : ' + (resp.error || 'Suppression impossible'));
              }
            })
            .catch(() => alert('Erreur réseau'));
          }
        });
      });
    })
    .catch(console.error);
}

form.addEventListener('submit', e => {
  e.preventDefault();
  const msg = input.value.trim();
  if (!msg) return;

  fetch('send_message.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'message=' + encodeURIComponent(msg)
  }).then(() => {
    input.value = '';
    loadMessages();
  }).catch(console.error);
});

// Recharge les messages toutes les 2 secondes
setInterval(loadMessages, 2000);
loadMessages();
