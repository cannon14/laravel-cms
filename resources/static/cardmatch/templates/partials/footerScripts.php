	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.sticky.js"></script>

	<!--[if lte IE 8]>
	   <script type="text/javascript" src="js/respond.src.js"></script>
	 <![endif]-->

	<script src="js/cardmatch.js"></script>

	<script>

		// Compensating for browsers without matchMedia
		// function. Specifically IE9 and below.
		if (typeof window.matchMedia != 'function') {
			window.matchMedia = function (query) {
				return (window.innerWidth > 800) ? true : false;
			}
		}

		$(document).ready(function () {
			var isMobile = window.matchMedia("only screen and (min-width: 800px)");
				if (isMobile.matches) {
					$("#header-block").sticky({ topSpacing: 0 });
				}
		});

	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			// force view to start at page top for mobile browsers
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				$(document).scrollTop(0);
			}

			$('body').on('click', '[href^=collapse]', function (e) {
				e.preventDefault()
			});

			// smooth scrolling to page anchors with consideration
			// for sticky header on desktop and mobile
			$("a[href^='#']").each(function(index, element) {

				if ($(element).attr("href").length > 2) {

					var name = $(this).attr('href').replace(/\#/g, '');
					var anchor = $('a[name=' + name + ']');

					if (anchor.length > 0) {
						$(element).click(function(event) {

							event.preventDefault();

							// desktop
							if (window.innerWidth > 800) {
								$('html,body').animate({scrollTop: anchor.offset().top  - 122},'slow');
							}
							else { // mobile
								$('html,body').animate({scrollTop: anchor.offset().top},'slow');
							}

						});
					}

				}

			});

		});
	</script>
