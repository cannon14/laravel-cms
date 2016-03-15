$(document).ready(function(){
	// this can also be set in star-rating.js
	$('input.rating').rating({ showClear: false });

	/* Global Variables */
	var CARD_ID = $('#product-id').val();
	var $paginationFirst = $('#pagination-first');
	var $paginationPrevious = $('#pagination-previous');
	var $paginationNext = $('#pagination-next');
	var $paginationLast = $('#pagination-last');
	var $paginationInput = $('#reviews-pagination > input');
	var $lastPageNode = $('#last-page-number');
	var $sortFilter = $('#sort-filter');
	var $fromIndex = $('#from-index');
	var $toIndex = $('#to-index');

	var currentPage = 1;
	var previousCurrentPageValue = currentPage;
	var lastPage = parseInt($('#last-page-number').attr('data-value'));


	/* Helper functions */
	function getReviews() {
		var page = parseInt($paginationInput.val());
		var $sortSelection = $('#sort-filter option:selected');
		var sortBy = $sortSelection.val();
		var order = $sortSelection.attr('data-order');

		var requestUrl = "/lib/reviews/user-reviews.php";
		var json = {
			'cardId': CARD_ID,
			'sortBy': sortBy,
			'order': order,
			'pageNum': page
		};
		$.getJSON(requestUrl, json).done(function (data){
			injectReviews(data.data);
			updatePaginationButtons();
			updatePageViewText(data.from, data.to);
			$paginationInput.val(currentPage);
			var endIndex = window.location.href.search('#user-reviews');
			if (endIndex != -1) {
				window.location.href = window.location.href.substring(0, endIndex) + '#user-reviews';
			} else {
				window.location.href = window.location.href + '#user-reviews';
			}
		}).fail(function (data){
			currentPage = previousCurrentPageValue;
			$paginationInput.val(currentPage);
		});
	}


	function injectReviews(reviews) {
		var reviewsHtml = '';
		reviews.forEach(function(reviewJson) {
			reviewsHtml += generateReviewHtml(reviewJson);
		});
		$('#user-reviews').html(reviewsHtml);
	}


	function generateReviewHtml(review) {
		var startHtml = '<div id="review-' + review.review_id + '" class="review-row row">\n\t';
		startHtml += '<div class="col-xs-24">\n\t';

		var startInfoDivHtml = '<div class="rating-info-row row">\n\t';

		var openReviewerInfoDivHtml = '<div class="col-xs-8">\n\t';

		var star = '\u2605';
		var fiveStars = star + star + star + star + star;
		var stars = '';
		for (var i = 0; i < review.overall_rating; ++i) {
			stars += star;
		}

		var ratingHtml = '<div class="rating-stars">\n\t';
		ratingHtml += '<div class="star-rating rating-sm rating-disabled">\n\t';
		ratingHtml += '<div class="rating-container rating-uni" data-content="'+ fiveStars +'">\n\t';
		ratingHtml += '<div class="rating-stars" data-content="'+ stars +'"></div>\n';
		ratingHtml += '<input type="number" value="' + review.overall_rating + '" class="rating form-control" style="display: none;">\n';
		ratingHtml += '</div>\n';
		ratingHtml += '</div>\n';
		ratingHtml += '</div>\n';

		var reviewerInfoHtml = '<div class="username margin"><strong>Username:</strong> ' + review.user_nickname + '</div>\n';
		reviewerInfoHtml += '<div class="age margin"><strong>Age:</strong> ' + review.age + '</div>\n';
		// Don't show location if it is empty.
		if (review.user_location != '' && review.user_location != null && typeof review.user_location != 'undefined') {
			reviewerInfoHtml += '<div class="location margin"><strong>Location:</strong> ' + review.user_location + '</div>\n';
		}
		// Don't show member since date if it doesn't exist.
		if (review.member_since != '' && review.member_since != null && typeof review.member_since != 'undefined') {
			reviewerInfoHtml += '<div class="member-since margin"><strong>Member Since:</strong> ' + review.member_since + '</div>\n';
		}

		var closeReviewerInfoDivHtml = '</div>\n'

		var reviewMetaDataHtml = '<div class="col-xs-16">\n\t';

		//This just give title a value in case it is null or empty.  Marketing didn't want a blank.
		if(review.review_title == '' || review.review_title == null || typeof review.review_title == 'undefined') {
			review.review_title = 'Review';
		}

		reviewMetaDataHtml += '<div class="review-title"><strong>' + review.review_title + '</strong></div>\n';
		reviewMetaDataHtml += '<span class="submission-date">' + review.submission_date + '</span><br>\n';
		reviewMetaDataHtml += '</div>\n';

		var endInfoDivHtml = '</div>\n';

		var reviewTextDivHtml = '<div class="rating-text row">\n\t';
		reviewTextDivHtml += '<div class="col-xs-24">\n\t';
		reviewTextDivHtml += '<div class="review-text">' + review.review_text + '</div>\n';
		reviewTextDivHtml += '</div>\n';
		reviewTextDivHtml += '</div>\n';

		var closeHtml = '</div>\n';
		closeHtml += '</div>\n';

		var generatedHtml = startHtml + startInfoDivHtml + openReviewerInfoDivHtml + ratingHtml + reviewerInfoHtml + closeReviewerInfoDivHtml + reviewMetaDataHtml + endInfoDivHtml + reviewTextDivHtml + closeHtml;

		return generatedHtml;
	}


	function updatePaginationButtons() {
		if (currentPage == 1) {
			$paginationFirst.hide();
			$paginationPrevious.hide();
		} else {
			$paginationFirst.show();
			$paginationPrevious.show();
		}

		if (currentPage == lastPage) {
			$paginationNext.hide();
			$paginationLast.hide();
		} else {
			$paginationNext.show();
			$paginationLast.show();
		}
	}


	function updatePageViewText(from, to) {
		$fromIndex.html(from);
		$toIndex.html(to);
	}


	/* Event Listeners */
	$paginationInput.keypress(function (event){
		var enterPressed = event.which == 13;
		var validInput = !isNaN(parseInt($paginationInput.val()));

		if (!validInput && enterPressed) {
			alert('Please enter numbers only.'); // input is not a number
		}
		else if (validInput && enterPressed) {
			currentPage = parseInt($paginationInput.val());
			getReviews();
		}
	});

	$paginationFirst.click(function (){
		if (currentPage != 1) {
			previousCurrentPageValue = currentPage;
			currentPage = 1;
			$paginationInput.val(currentPage);
			getReviews();
		}
	});

	$paginationPrevious.click(function (){
		if (currentPage != 1) {
			previousCurrentPageValue = currentPage;
			--currentPage;
			$paginationInput.val(currentPage);
			getReviews();
		}
	});

	$paginationNext.click(function (){
		if (currentPage != lastPage) {
			previousCurrentPageValue = currentPage;
			++currentPage;
			$paginationInput.val(currentPage);
			getReviews();
		}
	});

	$paginationLast.click(function (){
		if (currentPage != lastPage) {
			previousCurrentPageValue = currentPage;
			currentPage = lastPage;
			$paginationInput.val(currentPage);
			getReviews();
		}
	});

	$sortFilter.change(function (){
		previousCurrentPageValue = currentPage;
		currentPage = 1;
		$paginationInput.val(currentPage);
		getReviews();
	});
});