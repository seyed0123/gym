$(document).ready(function() {
    $("#username").keyup(function() {
        let query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: "php/suggest_user.php",
                method: "GET",
                data: { term: query },
                success: function(data) {
                    let users = JSON.parse(data);
                    let suggestionBox = $("#suggestion-box");
                    suggestionBox.empty();
                    if (users.length > 0) {
                        users.forEach(function(user) {
                            suggestionBox.append("<div class='suggestion-item' data-username='" + user.username + "'>" + user.username + " (" + user.name + ")</div>");
                        });
                        suggestionBox.show();
                    } else {
                        suggestionBox.hide();
                    }
                }
            });
        } else {
            $("#suggestion-box").hide();
        }
    });

    $(document).on("click", ".suggestion-item", function() {
        $("#username").val($(this).data("username"));
        $("#suggestion-box").hide();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest("#username, #suggestion-box").length) {
            $("#suggestion-box").hide();
        }
    });
});