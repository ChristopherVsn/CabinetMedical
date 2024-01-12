$("#autocomplete").on("blur", function() {
    let clientName = $(this).val();
    let fullName = clientName.split(' ');
    let lastName = fullName[0];
    let firstName = fullName[1];
    $.ajax({
        url: 'MedecinTraitant.php',
        method: 'POST',
        data: { firstName: firstName, lastName: lastName },
        dataType: 'json',
        success: function(response) {
            if (response && response.NomMedecin && response.PrenomMedecin) { // ça test si un nom et un prenom est bien identifié
                // ne pas mettre "X !== null" car cela ne marche pas. On test donc juste si la valeur est défini
                $("#autocompletemedecin").val(response.NomMedecin + ' ' + response.PrenomMedecin);
            }
        },
        error: function(error) {
            console.error('Erreur lors de la requête AJAX :', error);
        }
    });
});
