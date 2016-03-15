	<script src="/credit-card-news/modules/polls/ajax.js"></script>
    <script src="/credit-card-news/modules/polls/ajax-poller.js"></script>
    <script src="https://apis.google.com/js/plusone.js"></script>
	<script>
        /* Ajax call that returns the html on success and unhides the div with data.*/
        $.ajax({
            type: "POST",
            url: '/lib/rate_chart/rate_chart.inc.php',
            success: function (data) {
                //Detach and save the #rateChartMoreInfo data for use after HTML is overwritten.
                var moreInfo = $('#rateChartMoreInfo').detach();
                /*Add the html table data inside the #rateChartArticleBox,
                 append the #rateChartMoreInfo data after it, then show all.*/
                $('#rateChartArticleBox').html(data).append(moreInfo).show();
            }
        });
    </script>
