$("#move").on("click", function() {
    var y = $("#yield").val();
    var pr = $("#pr").val();

    $("#choice").text("Your choice: y = " + y + " pr = " + pr + ". Please wait until other players make their choice.");

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
            $("#move").prop("disabled", false);
            $("#yield").prop("disabled", false);
            $("#pr").prop("disabled", false);
            alert(data);
        }
    })

    location.reload();

});