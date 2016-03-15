$(document).ready(function() {

	// setup collapsible areas
	$('.Sub-subhead-black').prepend("<img src='/images/br-fixed.gif' class='downarrow' /><img src='/images/br-down.gif' class='rightarrow' />");
	$('.collapsible-content').css("display","none");

	// set default arrow status
	$('.section-header .downarrow').show();
	$('.section-header .rightarrow').hide();

	// toggle content areas
	$('.Sub-subhead-black').click(function() {
		var contentArea = $(this).parent().next("div.collapsible-content");
		var status = contentArea.css("display");

		// explicitly shown/hide the "arrow" based on state
		if (status == "none") {
			$(this).children(".downarrow").hide();
			$(this).children(".rightarrow").show();
		} else {
			$(this).children(".downarrow").show();
			$(this).children(".rightarrow").hide();
		}

		// toggle content area
		contentArea.toggle();
	});
});