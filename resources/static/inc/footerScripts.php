	<script src="/javascript/jquery/jquery.min.js"></script>
	<script src="/javascript/bootstrap.min.js"></script>
	<script src="/javascript/jquery/jquery-ui-1.11.2.js"></script>
<!--	<script src="/javascript/jquery/jquery.autocomplete.min.js"></script>-->
	<script src="/search/js/autocomplete.js"></script>
	<script src="/javascript/jquery.sticky.js"></script>
	<!--[if lte IE 8]>
	<script type="text/javascript" src="/javascript/respond.src.js"></script>
	<![endif]-->
	<script src="/javascript/application_scripts.js"></script>
	<script>

		// Compensating for browsers without matchMedia
		// function. Specifically IE9 and below.
		if (typeof window.matchMedia != 'function') {
			window.matchMedia = function (query) {
				return (window.innerWidth > 800) ? true : false;
			}
		}

		$(document).ready(function () {
			var isMobile = window.matchMedia("only screen and (min-width: 298px)");
				if (isMobile.matches) {
					$("#header-block").sticky({ topSpacing: 0 });
				}
		});

	</script>

	<script>
		$(document).ready(function() {
			var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
			// disable nav click activation on desktop / tablet
			var $navItems = $('.navbar-nav > li.dropdown > a.dropdown-toggle');
			var $navMenus = $('.navbar-nav > li.dropdown > ul.dropdown-menu');
			if(!isMobile) {
				$navItems.removeAttr('data-toggle');
				// toggle nav background on hover
				$('.navbar-nav > li.dropdown > ul.dropdown-menu').hover(function () {
					var $menu = $(this);
					var $menuLabel = $menu.parent().find('a.dropdown-toggle');
					$menuLabel.css('backgroundColor', '#124563');
					$menu.addClass('menu-hovered');
				}, function() {
					var $menu = $(this);
					$menu.removeClass('menu-hovered');
					$menu.hide();
					var $menuLabel = $menu.parent().find('a.dropdown-toggle');
					var menuItemHovered = $menuLabel.hasClass('menu-item-hovered');
					if (!menuItemHovered) {
						$(this).parent().find('a.dropdown-toggle').css('backgroundColor', '#0c4e77');
					}
				});
				// keep nav background on hover
				$('.navbar-nav > li.dropdown').hover(function (){
					var $menuLabel = $(this).find('a.dropdown-toggle');
					var $menu = $(this).find('ul.dropdown-menu');
					$menu.show();
					$menuLabel.css('backgroundColor', '#124563');
					$menuLabel.addClass('menu-item-hovered');
				}, function() {
					var $menuLabel = $(this).find('a.dropdown-toggle');
					var $menu = $(this).find('ul.dropdown-menu');
					$menuLabel.removeClass('menu-item-hovered');
					var menuHovered = $menu.hasClass('menu-hovered');
					if (!menuHovered) {
						$menu.hide();
						$menuLabel.css('backgroundColor', '#0c4e77');
					}
				});
				// toggle nav click menu activation with viewport size change
				$(window).resize(function() {
					var mobileView = $(window).width() < 768;
					if (mobileView) {
						$navItems.attr('data-toggle', 'dropdown');
					} else {
						if (!isMobile) {
							$navItems.removeAttr('data-toggle');
							$navMenus.hide();
						}
					}
				});
			}

			$('body').on('click', '[href^=collapse]', function (e) {
				e.preventDefault()
			});

			// smooth scrolling to page anchors with consideration
			// for sticky header on desktop and mobile
				$("a[href^='#']").each(function(index, element) {

				if ($(element).attr("href").length > 2) {

					var name = $(this).attr('href').replace(/\#/g, '');

					try {
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
					catch (err) {
					}
				}

			});

			// ensure all img tracking pixels do not have space on page
			$('body > img').each(function(index, element){

				if ($(element).width() === 1 || $(element).height() === 1) {
					$(element)
						.width(0)
						.height(0)
						.css('height', '0px')
						.css('width', '0px')
						.css('display', 'none')
						.css('border', 'solid transparent 0px');
				}

			});

			//Function for all bootstrap tooltips sitewide.
			$('[data-toggle="tooltip"]').tooltip();

		});

	</script>

<?php include_once( dirname(__FILE__).'/../actions/trackingUrls.php' ); ?>

	<!-- Begin Tynt Tag -->
<script src="/javascript/tynt.js" type="text/javascript"></script>
	<!-- END Tynt Tag -->

	<?php
	//FA: 37401 - AIDs {f1f8df42, 068cb91d, d69b68d1, 9b01fb32} - Google Remarketing Tag
	$google_remarket_aid = array('f1f8df42', '068cb91d', 'd69b68d1', '9b01fb32', '1004', '1047', '1064');
	if (in_array($_SESSION['aid'], $google_remarket_aid)) { ?>

		<script type="text/javascript"> /* <![CDATA[ */ var google_conversion_id = 997784174; var google_conversion_label = "g5q7CPrswQUQ7vTj2wM"; var google_custom_params = window.google_tag_params; var google_remarketing_only = true; var google_conversion_format = 3; /* ]]> */ </script>
		<div style="display: none;">
			<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"> </script>
		</div>
		<noscript> <div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/997784174/?value=0&label=g5q7CPrswQUQ7vTj2wM&guid=ON&script=0"/> </div> </noscript>
	<? } ?>

	<!--FA#0044199-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1072253289;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
var google_conversion_format = 3;
/* ]]> */
</script>

<div style="display: none;">
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"> </script>
</div>

<noscript>
	<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1072253289/?value=0&amp;guid=ON&amp;script=0" style="display: none;"/>
	</div>
</noscript>

	<!--FA#0044201-->
<script type="text/javascript">
  (function () {
	  var cachebust = (Math.random() + "").substr(2);
	  var protocol = "https:" == document.location.protocol ? 'https:' : 'http:';
	  new Image().src = protocol+"//20661977p.rfihub.com/ca.gif?rb=12533&ca=20661977&ra="+cachebust;
  })();
</script>

	<!--FA#0044201-->
<script type='text/javascript'>
    (function() {
	    var f = function() {
		    EF.init({ eventType: "pageview",
			    pageviewProperties : "",
			    segment : "20761",
			    searchSegment : "",
			    sku : "",
			    userid : "4397",
			    pixelHost : "pixel.everesttech.net"

			    , allow3rdPartyPixels: 1});
		    EF.main();
	    };
	    window.EF = window.EF || {};
	    if (window.EF.main) {
		    f();
		    return;
	    }
	    window.EF.onloadCallbacks = window.EF.onloadCallbacks || [];
	    window.EF.onloadCallbacks[window.EF.onloadCallbacks.length] = f;
	    if (!window.EF.jsTagAdded) {
		    var efjs = document.createElement('script'); efjs.type = 'text/javascript'; efjs.async = true;
		    efjs.src = 'https://www.everestjs.net/static/st.v3.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(efjs, s);
		    window.EF.jsTagAdded=1;
	    }
    })();
</script>
<noscript><img src="https://pixel.everesttech.net/4397/v?" width="1" height="1" style="display: none;"/></noscript>

<script>

//if you click on the placeholder, you get a red highlight
$('#placeholder').on('click', function(){
    $('.form-control-hero').addClass('has-error');
});
$('#placeholder-mobile').on('click', function(){
    $('.form-control-hero-mobile').addClass('has-error');
});

// remove the placeholder button if you change the dropdown 
$(function(){
	$('.form-control-hero').change(function(){
		if($(this).val() == "-- Select a Card Category --"){
   			$("#placeholder").show();
			$("#hero_btn").hide();
		} else {
			$("#hero_btn").show();
			$("#placeholder").hide();
			$('.form-control-hero').removeClass('has-error');
		}
	});
});
// for mobile
$(function(){
	$('.form-control-hero-mobile').change(function(){
		if($(this).val() == "Select a Category"){
   			$("#placeholder-mobile").show();
			$("#hero_btn_mobile").hide();
		} else {
			$("#hero_btn_mobile").show();
			$("#placeholder-mobile").hide();
			$('.form-control-hero-mobile').removeClass('has-error');
		}
	});
});

// This makes sure the dropdown is reset if the user hits the back button
$(window).load(function () {
    $("select").each(function () {
        $(this).val($(this).find('option[selected]').val());
    });
})

</script>
