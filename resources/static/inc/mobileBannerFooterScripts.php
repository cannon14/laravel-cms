<script src="/javascript/jquery.smartbanner.js"></script>
<script>
$(document).ready(function() {
	if(/Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		$.smartbanner({ 'title': 'WalletUp', 'author': 'CreditCards.com'});
		$('.sb-close').click(function() {
			$('#smartbanner').hide();
			$('body').css('backgroundColor', '#fff');
		});
		if(/Android/i.test(navigator.userAgent) ) {
			$('body').css('backgroundColor', '#003063');
		}
		$('a.sb-button').click(function() {
			$('#smartbanner').hide();
			$('body').css('backgroundColor', '#fff');
		});
		if(/Android/i.test(navigator.userAgent) ) {
			$('body').css('backgroundColor', '#003063');
		}
	}
});
</script>
