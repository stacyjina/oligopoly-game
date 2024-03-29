$("#move").on("click", function() {
    var y = $("#yield").val();
    var pr = $("#pr").val();

    $("#move").prop("disabled", true);
    $("#yield").prop("disabled", true);
    $("#pr").prop("disabled", true);

    $("#choice").text("Your choice: y = " + y + " pr = " + pr + ". Please wait until other players make their choice.");

    $.ajax({
        url: 'ajax/savechoice.php',
        type: 'post',
        cache: false,
        data: { 'yield' : y, 'pr' : pr },
        dataType: 'html',
        success: function(data) {
            alert(data);
        }
    })
});