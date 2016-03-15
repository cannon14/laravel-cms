<?php

/**
 * Echo out correct version of the yieldmo targeting script
 * @param $ymCategory
 * @return string
 */
function printYieldmoScript($ymCategory)
{
	return <<<EOT
<!-- Yieldmo Targeting -->
<script>
	/* DO NOT MODIFY CODE BELOW */
	(function(){
		var __yms, __p;
		__p = document.body || document.head;
		__yms = document.createElement('script');
		__yms.async = true;
		__yms.src = '//static.yieldmo.com/ym.adv.min.js';
		__yms.className = 'ym-adv';
		if (__p) __p.appendChild(__yms);
	})();

	window['_ymq'] = window._ymq || [];
	/* DO NOT MODIFY CODE ABOVE */

	// consideration
	window['_ymq'].push(['consideration', '1230362814768855398', {
		'ym-category': '{$ymCategory}',
		'ym-kw': '[SEARCH_KEYWORDS]'
	}]);
</script>
EOT;
}