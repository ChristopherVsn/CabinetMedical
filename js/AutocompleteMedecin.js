$(document).ready(function () {
    $("#autocompletemedecin").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "getMedecins.php",
                method: "post",
                dataType: "json",
                data: {
                    query: request.term
                },
                success: function (data) {
                    response(data);
                },

            });
        },
        messages: {
            noResults: '',
            results: function(){}
        }
    });
});
