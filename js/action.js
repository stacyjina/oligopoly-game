// Script that saves a player's choice and waits for other players
$("#move").on("click", function() {
    var y = $("#yield").val();
    var pr = $("#pr").val();

    $("#choice").text("Your choice: y = " + y + " r = " + pr + ". Please wait until other players make their choice.");

    $.ajax({
        url: 'ajax/savechoice.php',
        type: 'post',
        cache: false,
        data: { 'yield' : y, 'pr' : pr },
        dataType: 'html',
        beforeSend: function() {
            $("#move").prop("disabled", true);
            $("#yield").prop("disabled", true);
            $("#pr").prop("disabled", true);
        },
        success: function(data) {
            if (data == "timeout") {
                location.replace('logout.php');
                alert("Timeout: other players didn't make their moves :(");
            } else {
                $("#move").prop("disabled", false);
                $("#yield").prop("disabled", false);
                $("#pr").prop("disabled", false);
                location.reload();
            }
        }
    })

});

// Script that gives recommedations
$("#move_help").on("click", function() {
    var y = $("#agg_yield").val();
    $.ajax({
        url: 'ajax/helper.php',
        type: 'post',
        cache: false,
        data: { 'yield' : y },
        dataType: 'html',
        beforeSend: function() {
        },
        success: function(data) {
            var res = data.split(" ").map((e) => parseInt(e));
            var y = res[0];
            var x = res[1];
            $("#helper").text("We recommend you to go for y = " + y + " and r = " + x + ".");
        }
    })
});

// Script that opens and hides login form on click
$("#login").on("click", function() {
    var x = document.querySelector("#login-form");
    var flag = x.classList.replace("closed", "open");
    if (!flag) {
        x.classList.replace("open", "closed");
    }
});