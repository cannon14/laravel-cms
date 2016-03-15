<?php
    function encodeToIso($string) {
        return mb_convert_encoding($string, "ISO-8859-1", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    }
?>
<div id="contents">
	<div class="search_results">
		<form name="search-results-form" id="search-results-form" method="GET" action="/search.php">
			<br />
			<input type="text" id="search-text" name="query" value="<?=$this->currentQuery ?>" style="width: 300px;" onBlur="this.value = this.value.replace(/(<([^>]+)>)/ig,'');" />
			<input type="hidden" name="filter_code" value="<?=$this->filterCode ?>" />
			<input type="submit" value="Search" id="search_button" name="search_button" />
			<br />
		</form>
		<br />
		<div class="search_showing">
			<?php
                if($this->numTotalResults > 0) {
                    $resultSubCount = $this->resultsOffset + $this->numResultsPerPage;
                    if ($resultSubCount > $this->numTotalResults) {
                        $resultSubCount = $this->numTotalResults;
                    }
			?>
				Search Results <?=($this->resultsOffset + 1) ?> - <?= $resultSubCount ?>
					of <?= $this->numTotalResults ?> for search term: <span class="highlight">"<?=$this->currentQuery ?>"</span>
			<?php
				} /* End if search results > 0 */
			?>
		</div>
		<div id="tabsB">
			<ul>
                <li <?= ($_REQUEST['filter_code'] == '' || $_REQUEST['filter_code'] == 'all' ? 'id="selected"' : '') ?>>
					<a	href="<?= $_SERVER['PHP_SELF'] ?>?query=<?= $this->encodedCurrentQuery ?>&filter_code=all" title="All">
						<span>All Results</span>
					</a>
				</li>
				<li <?= ($_REQUEST['filter_code'] == 'card' ? 'id="selected"' : '') ?> >
					<a href="<?= $_SERVER['PHP_SELF'] ?>?query=<?= $this->encodedCurrentQuery ?>&filter_code=card" title="Credit Cards">
						<span>Credit Cards</span>
					</a>
				</li>
				<li <?= ($_REQUEST['filter_code'] == 'editorial' ? 'id="selected"' : '') ?> >
					<a href="<?= $_SERVER['PHP_SELF'] ?>?query=<?= $this->encodedCurrentQuery ?>&filter_code=editorial" title="News and Advice">
						<span>News and Advice</span>
					</a>
				</li>
				<li <?= ($_REQUEST['filter_code'] == 'blog' ? 'id="selected"' : '') ?> >
					<a href="<?= $_SERVER['PHP_SELF'] ?>?query=<?= $this->encodedCurrentQuery ?>&filter_code=blog" title="Blog">
						<span>Blog</span>
					</a>
				</li>
				<li <?= ($_REQUEST['filter_code'] == 'review' ? 'id="selected"' : '') ?> >
					<a href="<?= $_SERVER['PHP_SELF'] ?>?query=<?= $this->encodedCurrentQuery ?>&filter_code=review" title="Review">
						<span>Card Reviews</span>
					</a>
				</li>
			</ul>
		</div>

		<br /><br />

		<!-- Match list check for bank contact information section -->
		<?php
			$matchList = "
					login,
					log in,
					signin,
					sign in,
					my account,
					account balance,
					check account,
					check balance,
					check account balance,
					pay bill,
					pay bill online,
					online bill pay,
					phone number,
					make a payment,
					make payment,
					make a payment online,
					make payment online
				";

			if (stripos($matchList, $this->currentQuery)) {
		?>
			<br />
			<div id="issuerContacts">
				<a href="bank-partner-contact-information.php">Get contact information for your bank</a><br/>
				List of toll-free numbers for major credit card issuers and banks. Find out where to log in to pay bills online and check your account balance.
			</div>
		<?php
			} /* End if query member of keyword matchList */
		?>

        <!-- Match list check for card match -->
        <?php
        $matchList = "
					card match,
					cardmatch,
					match,
					card
				";

        if (stripos($matchList, $this->currentQuery)) {
            ?>
            <br />
            <div id="issuerContacts">
				<a href="http://www.creditcards.com/cardmatch/?action=show_form">CardMatch</a><br/>
				CardMatch can help you find special credit card deals by matching your credit profile with offers you're likely to qualify for. It's free and doesn't impact your credit score.
			</div>
        <?php
        } /* End if query member of cardmatch matchList */
        ?>


		<!-- No results found section -->
		<?php
			if($this->numTotalResults <= 0) {
		?>
			<br />
			There were no results found for search term: <span class="highlight">"<?=$this->currentQuery ?>"</span>
			<br/>
			Here are different ways to <a href="http://www.creditcards.com/apply">search for a credit card</a>.
		<?php
			} /* End if search results <= 0 */
		?>

		<br />

		<!-- Server failure error section -->
		<?php
			if($this->serverDown) {
		?>
				<span class="search_error">Search is temporarily unavailable.</span>
		<?php
				exit;
			} /* End if server is down error */
		?>

		<!-- Search results table -->
		<table class="search">
			<tr>
				<td class="search_cell" valign="top" width="66%">

					<?php
						$count = 0;

						if($this->numTotalResults > 0) {
							foreach($this->searchResults as $searchResult) {

								++$count;

								if (!empty($searchResult['_source']['title'])) {
					?>

									<div class="search_result">
                                        <span class="page_title">
                                            <a href="<?= $searchResult['_source']['url'] ?>"
                                               onmousedown="return clickit(<?= $count ?>,
                                                   '<?= urlencode($searchResult['_source']['url']) ?>',
                                                   '<?= $this->currentQuery ?>')"
                                                <?= ($_REQUEST['filter_code'] == 'blog' ? 'target="_BLANK"' : '') ?> >
                                                <?= encodeToIso($searchResult['_source']['title']) ?>
                                            </a>
                                        </span>
                                        <br/>
                                        <span class="blurb">
                                            <?php

											if (isset($searchResult['_source']['metatag.description'])
												&& !empty($searchResult['_source']['metatag.description'])
												&& !is_array($searchResult['_source']['metatag.description'])) {
													$desc = substr(strip_tags($searchResult['_source']['metatag.description']), 0, 300) . '...';
											}
											else {
												$desc = substr(strip_tags($searchResult['_source']['content']), 0, 300) . '...';
											}
											echo encodeToIso($desc);
                                            ?>
                                        </span>
                                        <br/><br/>
									</div>
					<?php
								} /* End if title empty ignore */

							} /* End foreach search results */

						} /* End if total results > 0 */
					?>

				</td>
			</tr>
		</table>

		<br /><br />

		<!-- Search results pagination -->
		<center>
			<div class="search_pagination">
                <?php

                    $page = $this->pagination_start_page;

					for($i = 1; $i <= $this->pagination_end_page; $i++) {
						if($i == $page) {
				?>
							<span class="highlight"><?= $page ?> </span>
				<?php
						} else {
				?>
							<a href="?query=<?= $this->encodedCurrentQuery ?>&page=<?= $i ?>&filter_code=<?= (isset($_REQUEST['filter_code']) ? $_REQUEST['filter_code'] : 'all') ?>"><?= $i ?></a>
				<?php
						}
					} /* End pagination foreach */
                ?>
			</div>
		</center>
	</div>
</div>
