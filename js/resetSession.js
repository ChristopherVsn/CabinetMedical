
    // Fonction pour réinitialiser le temps de session
    function resetSessionTimeout() {
        // Envoyer une requête AJAX au serveur pour mettre à jour le temps de session
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '../php/reset-session.php', true);
        xhr.send();
    }

    // Ajouter des écouteurs d'événements pour les interactions de l'utilisateur
    let formInputs = document.querySelectorAll('form input, form select'); // Sélectionner tous les champs de saisie du formulaire
    formInputs.forEach(function(input) {
        input.addEventListener('input', resetSessionTimeout);
    });

    // Ajouter un écouteur d'événement pour le formulaire afin de réinitialiser le temps de session avant la soumission
    let form = document.querySelector('form');
    form.addEventListener('submit', resetSessionTimeout);