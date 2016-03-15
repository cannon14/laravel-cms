$(document).ready(function (){
	// restructure DOM for show more / less functionality
	/*
	var $ulContainers = $('.res-details');
	$ulContainers.each(function (){
		var $ul = $(this).find('ul');
		var $listItems = $ul.find('li');
		var numListItems = $listItems.length;
		var cardId = $(this).find('.category-showhide-btn > a').attr('data-target');

		// change <ul> dom structure if there are at least two bullet points
		if (numListItems > 2) {
			$ul.html('');
			$ul.append($listItems[0]);
			$ul.append($listItems[1]);

			var $secondUl = $('<ul></ul>');
			var $collapsibleDiv = $('<div class="collapsible" id="' + cardId + '""></div>');

			for (i = 2; i < numListItems; i++) {
				$secondUl.append($listItems[i]);
			}
			$collapsibleDiv.append($secondUl);
			$collapsibleDiv.hide();
			$collapsibleDiv.insertBefore($(this).find('.category-showhide-btn'));
		}
	});

	// attach event listeners for show more / less
	$('.category-showhide-btn > a').click(function () {
		var collapsibleListId = $(this).attr('data-target');
		$('#' + collapsibleListId).slideToggle();

		if($.trim($(this).text()) == 'Show More') {
            $(this).text('Show Less');
            $('.category-showhide-btn i').attr('class', 'fa fa-chevron-up');
        }
        else {
            $(this).text('Show More');
            $('.category-showhide-btn i').attr('class', 'fa fa-chevron-down');
        }
	});
	*/

	// back to top button
	$(window).scroll(function() {
        if($(window).scrollTop() <= 0) {
            $('.back-to-top').css({'display':'none'});
        }
        else {
            $('.back-to-top').css({'display':'block'});
        }
    });
});