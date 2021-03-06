<?php

function showReview($staff_review) {
	$name = $staff_review->member_name;
	$title = $staff_review->member_title;
	$image_path = $staff_review->member_image_path;
	$member_url = $staff_review->member_url;
	$review_title = $staff_review->review_title;
	$review = $staff_review->review;
	$created_at = strtotime( $staff_review->created_at );
	$formatted_date = date( 'Y-m-d', $created_at );

	$member_image_html = "";
	if(!empty($image)) {
		$member_image_html = '<img class="author_image" title="$name" src="'.$image_path.'" width="100">';
	}

	$member_url_html = "";
	if(!empty($member_url)) {
		$member_url_html = '<div class="author_name">By: <a href="$member_url" target="_blank" rel="author">'.$name.'</a></div>';
	}
	else {
		$member_url_html = '<div class="author_name">By: '.$name.'</div>';
	}

	$review_title_html = "";
	if(!empty($review)) {
		$review_title_html = '<div class="row">
		<div class="col-sm-24 col-md-24 col-lg-24">
			<div class="staff-review-title">'.
			$review_title
			.'</div>
		 	</div><!--column-->
		</div><!--row-->

		<br>';
	}

	$reviewHtml = <<<REVIEW_HTML
	<div class="row">
		<div class="col-sm-24 col-md-24 col-lg-24">
			<div class="staff-review-text">
			 	$review
			 </div>
		 </div><!--column-->
	</div><!--row-->

REVIEW_HTML;

	echo $reviewHtml;
}

?>