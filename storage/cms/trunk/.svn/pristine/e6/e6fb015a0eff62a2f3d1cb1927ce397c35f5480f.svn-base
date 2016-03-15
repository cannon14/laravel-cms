</div><!--all-schumer-boxes-->

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

</div><!--col-lg-24-->
</div><!--row-->
</div><!--col-md-18-->

<div class="col-md-6">
</div><!--col-md-6-->
</div><!--row-->
</div><!--container-->
</div><!--card-category-block-->

<!-- Site Back Up Block-->
<div class="back-to-top-block">
    <div class="container">
        <div class="row">
            <div class="col-md-24">
                <a class="back-to-top" href="#Page-Top" style="display:none;"><i class="fa fa-chevron-up"></i><br><br>BACK<br>TO TOP</a>
            </div>
            <div class="col-md-24 see-terms-footer">
                <? if ($this->page->get('pageDisclaimer') != "") { ?>
                    <?= $this->page->get('pageDisclaimer') ?>
                <? } ?>
            </div>

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
