
// Cela permet d'envoyer un message de confirmation avant de supprimer un client. Pour cela on enlève l'action par défaut du <a> (l8) puis si l'utilisateur
// accepte de supprimer le client, alors on récupère le lien du bouton et on redirige vers ce lien (Qui supprime le client (SupprimerClient.php)).
document.addEventListener('DOMContentLoaded', function () {
    let deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            let nom = button.getAttribute('data-nom');
            let prenom = button.getAttribute('data-prenom');
            
            let confirmation = confirm("Êtes-vous sûr de vouloir supprimer " + prenom + " " + nom + " ?" + "\n" + "Cette action est irréversible !" + "\n" + "Toutes les données liées à ce client comme les rendez-vous seront supprimées.");

            if (confirmation) {
                let link = button.getAttribute('href');
                window.location.href = link;
            }
        });
    });
});
