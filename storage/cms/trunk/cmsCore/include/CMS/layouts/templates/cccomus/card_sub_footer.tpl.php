</div><!--all-schumer-boxes-->

<!--this variable unfortunately contains a special page layout added directly into CMS that hides the normal page.-->
<?= html_entity_decode($this->page->get('pageLearnMore')) ?>

	<div class="card-category-disclosure-hldr-bottom">
		<a href="#" data-toggle="modal" data-target="#myModalDisclosure">
			<img class="pull-right" src="/images/advertiser_dis_text.png" />
		</a>
		<div class="clearfix"></div>
	</div>
<!--card-category-disclosure-hldr-->

<a href="#" class="show-more-results">Show More Results</a><br><br>

<script>

    // Bullets for each schumer box
    function showMoreLess() {

	    // Show more/less on card details
	    $('.category-showhide-btn a')
		    .unbind()
		    .data('show', true) // set all show more buttons to true for toggling
		    .click(function () {

			    var span = $(this).find('span.showHide-text');

			    if ($(this).data('show')) {
				    span.text('Show Less');
				    $(this).data('show', false);
				    $(this).parent().find('i').attr('class', 'fa fa-chevron-up');
				    $(this).parent().find('span.amex_terms_and_restrictions').hide();
			    }
			    else {
				    $(this).data('show', true);
				    span.text('Show More');
				    $(this).parent().find('i').attr('class', 'fa fa-chevron-down');
				    $(this).parent().find('span.amex_terms_and_restrictions').show();
			    }

		    })
		    .siblings('i').click(function () {

			    $(this).parent().find('a').trigger('click');

		    });

    }

	$(document).ready(function() {
		//Get the show more button.
		var showMore = $(".show-more-results");
		//Get the name of the page containing the next set of cards from the link tags in the header.
		var nextPage = $('link[rel="next"]');

		if(nextPage.length > 0) {
			nextPage = nextPage.attr('href');
			showMore.css('display', 'block');
		}
		else {
			showMore.css('display', 'none');
		}

		//Load more cards when button is clicked.
		showMore.on('click', function (event) {
			//Prevent page from jumping to the top.
			event.preventDefault();
            event.stopImmediatePropagation();
            console.log("event.stopImmediatePropagation");

			var page = $("<div>");
			page.load(nextPage, [], function () {

				var next = page.find('link[rel="next"]');

				if (next.length > 0) {
					nextPage = next.attr('href').substring(1);
				}
				else {
					showMore.css('display', 'none');
				}

				//Load the contents of the nextPage and extract the contents of all-schumer-boxes.
				var cards = page.find('#all-schumer-boxes');

				//Append the retrieved cards ot the all-schumer-boxes.
				$('#all-schumer-boxes').append(cards);

				//Refresh the star ratings.:wq
				$('.category-star-rating').rating('refresh');

				//Recalculate balance transfer calculators.
				if (typeof calculate == 'function') {
					calculate();
				}

				// Bullet points for each schumer box
				showMoreLess();

			});
		});
	});
</script>

<div class="disqus-block">
	<?php
	// Only apply the relevant story if page 1 of category
	if ($this->pageNumber === 1) {

		echo '
    <?php

        $categoryStoryPath = CATEGORY_PAGE_STORY_PATH . \'cat_\' . $_SESSION[\'fid\'] . \'.php\';
        if (file_exists($categoryStoryPath)) {
            include($categoryStoryPath);
        }
    ?>';

	}

	?>

	<?php
	echo '
    <?php

    /*
    * Disqus comment block for category editorial module.
    * Only show on balance transfer page for now
    */

    $fid_array = array(12,14,15,16,18,2275,11,17,1477,77);
    $fid = $_SESSION[\'fid\'];

    if (in_array($fid, $fid_array)) {
        switch($fid) {
            case 12:
                $disqusCategory = \'3175896\';
                $disqusUrl = \'http://www.creditcards.com/balance-transfer.php\';
                break;
            case 14:
                $disqusCategory = \'3181642\';
                $disqusUrl = \'http://www.creditcards.com/reward.php\';
                break;
            case 15:
                $disqusCategory = \'3181639\';
                $disqusUrl = \'http://www.creditcards.com/cash-back.php\';
                break;
            case 16:
                $disqusCategory = \'3181640\';
                $disqusUrl = \'http://www.creditcards.com/airline-miles.php\';
                break;
            case 18:
                $disqusCategory = \'3181658\';
                $disqusUrl = \'http://www.creditcards.com/college-students.php\';
                break;
            case 2275:
                $disqusCategory = \'3391765\';
                $disqusUrl = \'http://www.creditcards.com/apple-pay.php\';
                break;
            case 11:
                $disqusCategory = \'3181635\';
                $disqusUrl = \'http://www.creditcards.com/low-interest.php\';
                break;
            case 17:
                $disqusCategory = \'3181641\';
                $disqusUrl = \'http://www.creditcards.com/business.php\';
                break;
            case 1477:
                $disqusCategory = \'3181638\';
                $disqusUrl = \'http://www.creditcards.com/0-apr-credit-cards.php\';
                break;
            case 77:
                $disqusCategory = \'3497323\';
                $disqusUrl = \'http://www.creditcards.com/points-rewards.php\';
                break;
        }
    ?>';
	?>


	<h2>Join the Discussion</h2><br>

	<p style="font-size: .8em;">We encourage an active and insightful conversation among our users. Please help us keep
		our community civil and respectful. For your safety, we ask that you do not disclose confidential or personal
		information such as your bank account number, phone number, or email address. Keep in mind that anything you
		post may be disclosed, published, transmitted or reused.</p>

	<p style="font-size: .8em;">The comments posted below are not provided, reviewed or approved by the card issuers or
		advertisers. Additionally, the card issuer or advertiser does not assume responsibility to ensure that all posts
		and/or questions are answered.</p>

	<div id="disqus_thread"></div>
	<script type="text/javascript">
		/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		var disqus_shortname = 'creditcardscom';
		var disqus_identifier = '<?php echo '<?=$_SESSION[\'fid\'] ?>'; ?>';
		var disqus_category_id = '<?php echo '<?=$disqusCategory ?>'; ?>';
		var disqus_url = '<?php echo '<?=$disqusUrl ?>'; ?>';

		/* * * DON'T EDIT BELOW THIS LINE * * */
		(function () {
			var dsq = document.createElement('script');
			dsq.type = 'text/javascript';
			dsq.async = true;
			dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
	</script>
	<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by
			Disqus.</a></noscript>

	<?php
	echo '
<?php
    }
?>';
	?>
</div><!--DISQUE-BLOCK-->
</div><!--col-lg-24-->
</div><!--row-->
</div><!--col-md-18-->

<div class="col-md-6">
	<div id="right-gutter" class="category-rightgutter-hldr">
		<?php
		$categoryFids = array(11, 12, 1477, 14, 77, 79, 78, 15, 16, 2022, 2005, 17, 18, 19, 1768, 13, 2116, 2018, 76, 75, 74, 20, 1077, 2314, 37, 2351);
		$fid = $this->page->get('fid') ? $this->page->get('fid') : '35';
		$isCategoryPage = in_array($fid, $categoryFids);
		if ($isCategoryPage) {
			echo '<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/right-column/column-template.php"; ?>';
		}
		/*
			$showGutter = in_array($_SESSION['fid'], unserialize(RIGHT_GUTTER_INCLUDE_FID_LIST));
			if ($showGutter) {
				echo '<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/right-column/column-template.php"; ?>';
			}
		*/
		?>
	</div>
</div><!--col-md-6-->
</div><!--row-->
</div><!--container-->
</div><!--card-category-block-->

<!-- Site Back Up Block-->
<div class="back-to-top-block">
	<div class="container">
		<div class="row">
			<?php
			//Exclude the BACK TO TOP button for the specials page for now. If the exclude begins to span multiple
			//pages...move exclusion to an array.
			if($this->page->get('fid') != 37) {
			?>
			<div class="col-md-24">
				<a class="back-to-top" href="#Page-Top" style="display:none;"><i class="fa fa-chevron-up"></i><br><br>BACK<br>TO TOP</a>
			</div>
			<?php } ?>
			<div class="col-md-24 see-terms-footer">
				<? if ($this->page->get('pageDisclaimer') != "") { ?>
					<?= $this->page->get('pageDisclaimer') ?>
				<? } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-24 see-terms-footer-mobile"> * For additional rates, fees and costs see issuer's website for detailed pricing and terms. </div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		
		// defining this here so there is not a lookup on every scroll
		var beginScrollTopHeight = 0;
		if ( $('.res-schumer-box').length > 2) {
			beginScrollTopHeight = $( $('.res-schumer-box')[1] ).offset().top + $( $('.res-schumer-box')[1] ).height();
		}
		
		$(window).scroll(function () {
			if ($(window).scrollTop() <= beginScrollTopHeight) {
				$('.back-to-top').css({'display': 'none'});
			}
			else {
				$('.back-to-top').css({'display': 'block'});
			}
		});

		// Bullets for each schumer box
		showMoreLess();

	})
</script>

