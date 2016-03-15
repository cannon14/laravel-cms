<script type="text/javascript">
	$(function() {
		var unslider = $('.banner').unslider({
			speed: 500,
			delay: 3500,
			keys: true,
			dots: true,
			pause: true

		});

	});
</script>

<div class="banner">
	<ul>
		<li>
			<map name='slide1map'>
				<area shape="rect" coords="471,100,688,184" href="/mastercard/global-acceptance.php" />
			</map>
			<img src='Slide1.jpg' width="706" height="195" usemap="#slide1map"/>
		</li>

		<li>
			<map name='slide2map'>
				<area shape="rect" coords="471,100,688,184" href="/mastercard/world-hotels-and-resorts.php" />
			</map>
			<img src='Slide2.jpg' width="706" height="195" usemap="#slide2map"/>
		</li>
		<li>
			<map name='slide3map'>
				<area shape="rect" coords="471,100,688,184" href="/mastercard/priceless-cities.php" />
			</map>
			<img src='Slide3.jpg' width="706" height="195" usemap="#slide3map" />
		</li>
	</ul>
</div>