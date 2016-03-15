$(function() {

    var resultsPageSearchBox = $("#search-text");
    var modalSearchBox = $("#modal-search-text");

    resultsPageSearchBox.autocomplete({
        source: "/search/autocomplete.php",
        minLength: 2,
        select: function(event, ui) {
            $("#search-text").val(ui.item.value);
            $("#search-results-form").submit();
        }
    });

    modalSearchBox.autocomplete({
        source: "/search/autocomplete.php",
        appendTo: "#modal-search-form",
        minLength: 2,
        select: function(event, ui) {
            $("#modal-search-text").val(ui.item.value);
            $("#modal-search-form").submit();
        }
    });

});
