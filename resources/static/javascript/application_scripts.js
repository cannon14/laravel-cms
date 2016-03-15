
$(document).ready(function() {
    //Find out if screen is in mobile or desktop range.
    var isNotMobile = window.matchMedia("only screen and (min-width: 640px)");

    //If in desktop range, make the header sticky.
    if (isNotMobile.matches) {
        $("#header-block").sticky({ topSpacing: 0 });
    //}
    //If in the mobile range, hide the first two detail bullets.
    //else {
        //$.each($('.res-details'), function(index, value) {
            //Get the first two list items in the .res-details div.
            //var items = $(value).find('ul li').slice(0,2).detach();

            //Prepend those to list items in the div surrounding the other hidden list items to make them
            //invisible as well.
            //$(value).find('ul div').prepend(items);
        //});
    }
});
