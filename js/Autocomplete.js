$(document).ready(function () {
    $("#autocomplete").autocomplete({
        source: function (request, response) {
            // console.log("Query:", request.term);

            $.ajax({
                url: "getClients.php",
                method: "post",
                dataType: "json",
                data: {
                    query: request.term
                },
                success: function (data) {
                    // console.log("Response:", data);
                    response(data);
                },
                // error: function (err) {
                //     console.error("AJAX Error:", err);
                // }
            });
        },
        messages: {
            noResults: '',
            results: function(){}
        }
    });
});
