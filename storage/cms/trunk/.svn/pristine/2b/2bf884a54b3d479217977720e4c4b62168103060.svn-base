<?php

function showReviews($reviewsObject, $cardId) {
	$sortByHtml = <<<SORT_BY_HTML
		<div id="sort-reviews" class="row">
			<div id="sort-by" class="col-md-24 col-xs-24 text-right">
				<input type="hidden" id="product-id" value="{$cardId}">
				<label for="sorting">Sort By: </label>
				<select id="sort-filter">
					<option value="submission_date" data-order="DESC" selected>Newest To Oldest Date</option>
					<option value="submission_date" data-order="ASC">Oldest To Newest Date</option>
					<option value="overall_rating" data-order="DESC">Highest To Lowest Rating</option>
					<option value="overall_rating" data-order="ASC">Lowest To Highest Rating</option>
				</select>
			</div>
		</div>

SORT_BY_HTML;

	echo $sortByHtml;
	echo '<div id="user-reviews">';

	$reviews = $reviewsObject->data;
	foreach ($reviews as $review) {

		$id = $review->review_id;
		$title = $review->review_title;
		$submissionDate = $review->submission_date;
		$username = $review->user_nickname;
		$age = $review->age;
		$memberSince = $review->member_since;
		$location = $review->user_location;
		$reviewText = $review->review_text;
		$rating = $review->overall_rating;

		$locationHtml = ($location == '') ? '' : "<div class=\"location margin\"><strong>Location:</strong> {$location}</div>";
		$memberSinceHtml = ($memberSince == '') ? '' : "<div class=\"member-since margin\"><strong>Member Since:</strong> {$memberSince}</div>";
		$title = ($title != '') ? $title : 'Review';

		$reviewHtml = <<<REVIEW_HTML

		<div class="review-row row">
            <div class="col-xs-24">
                <div class="rating-info-row row">
                    <div class="col-xs-8"><div class="rating-stars"><input type="number" value="{$rating}" class="rating"  data-show-caption="false"></div>
                        <div class="username margin"><strong>Username:</strong> {$username}</div>
                        <div class="age margin"><strong>Age:</strong> {$age}</div>
                        {$locationHtml}
                        {$memberSinceHtml}
                    </div><!--column-->

                    <div class="col-xs-16">
                        <div class="review-title margin"><strong>{$title}</strong></div>
                        <div class="submission-date margin">{$submissionDate}</div>
                    </div><!--column-->
                </div><!--rating-info-row-->

                <div class="rating-text row">
                    <div class="col-xs-24">
                        <div class="review-text">{$reviewText}</div>
                    </div><!--rating-text-->
                </div>
            </div>
            <!--column-->
        </div>
        <!--review-row-->

REVIEW_HTML;

		echo $reviewHtml;
	}

	echo '</div>'; // closes #user-reviews div

	$numTotalReviews = $reviewsObject->total;
	// $reviewsPerPage = $reviewsObject->per_page;
	$currentPage = $reviewsObject->current_page;
	$lastPage = $reviewsObject->last_page;
	$fromIndex = $reviewsObject->from;
	$toIndex = $reviewsObject->to;

	$paginationHtml = <<<PAGINATION_HTML
		<div id="reviews-pagination-container">
			<div id="reviews-pagination">
				<img src="/images/pagination-first.gif" id="pagination-first" class="pagination-button" style="display: none;">
				<img src="/images/pagination-prev.gif" id="pagination-previous" class="pagination-button" style="display: none;">
				Page <input type="text" value="{$currentPage}" data-current-page="{$currentPage}"> of <span id="last-page-number" data-value="{$lastPage}">{$lastPage}</span>
				<img src="/images/pagination-next.gif" id="pagination-next" class="pagination-button">
				<img src="/images/pagination-last.gif" id="pagination-last" class="pagination-button">
			</div>

			<div id="record-count-info">
				Reviews <span id="from-index">{$fromIndex}</span>-<span id="to-index">{$toIndex}</span> of {$numTotalReviews}
			</div>
		</div>
PAGINATION_HTML;

	echo $paginationHtml;

	echo '<script src="/javascript/user-reviews.js"></script>';
}
