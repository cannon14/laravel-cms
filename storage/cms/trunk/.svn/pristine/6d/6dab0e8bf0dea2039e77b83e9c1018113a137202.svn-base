<?php

function showStats($stats, $offerClickLink=''){

	$rewardsHtml = '';
	$total_reviews = $stats->total_reviews;
	$stars_5 = $stats->five_stars;
	$stars_4 = $stats->four_stars;
	$stars_3 = $stats->three_stars;
	$stars_2 = $stats->two_stars;
	$stars_1 = $stats->one_star;

	$stars_5_percent = ($stars_5/$total_reviews)*100;
	$stars_4_percent = ($stars_4/$total_reviews)*100;
	$stars_3_percent = ($stars_3/$total_reviews)*100;
	$stars_2_percent = ($stars_2/$total_reviews)*100;
	$stars_1_percent = ($stars_1/$total_reviews)*100;

	$stars_overall = number_format($stats->overall_rating, 1);
	$bars_rewards = number_format($stats->rewards_program, 1);
	$bars_benefits = number_format($stats->account_benefits, 1);
	$bars_service = number_format($stats->customer_service, 1);
	$bars_online = number_format($stats->online_experience, 1);

	$total_recommend_complete = $stats->total_reviews;
	$total_recommend_yes = $stats->recommend;
	$recommend_percent = floor(($total_recommend_yes/$total_recommend_complete)*100);

	$bars_rewards_percent =  ($bars_rewards/5)*100;
	$bars_benefits_percent = ($bars_benefits/5)*100;
	$bars_service_percent =  ($bars_service/5)*100;
	$bars_online_percent =   ($bars_online/5)*100;

	if ($stats->rewards_program > 0){
		$rewardsHtml = <<< REWARDS_HTML
			<div class="row">
				<div class="col-xs-7 category-name text-left"><strong>Rewards Program</strong></div>
				<div class="col-xs-14 category-progress-bar">
					<div class="tprogress">
						<div class="outer">
							<div class="inner" style="width: $bars_rewards_percent%">
								<ul><li></li><li></li><li></li><li></li><li></li></ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-3 category-average"><strong>$bars_rewards</strong></div>
			</div>
REWARDS_HTML;

	}

	echo <<< RENDERED_OUTPUT
<div class="row" id="rating-stats-row">
<div class="col-xs-24">
<div class="star-rating">
			<div class="row">
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-12 heading-container">
							<span class="rating-subhead">Rating Snapshots</span> <span class="rating-subinfo">(Total $total_reviews)</span>
						</div>
					</div>
					<!-- end of row -->
					<div class="row">
							<div class="col-xs-2 text-right">
								<span class="fa fa-star"></span><strong>5</strong>
							</div>
							<div class="col-xs-18">
								<div class="progress">
									<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
										aria-valuemin="0" aria-valuemax="100" style="width: $stars_5_percent%">
										<span class="sr-only">$stars_5</span>
									</div>
								</div>
							</div>
					</div>
					<!-- end of row -->
					<div class="row">
							<div class="col-xs-2 text-right">
								<span class="fa fa-star"></span><strong>4</strong>
							</div>
							<div class="col-xs-18">
								<div class="progress">
									<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
										aria-valuemin="0" aria-valuemax="100" style="width: $stars_4_percent%">
										<span class="sr-only">$stars_4</span>
									</div>
								</div>
							</div>
					</div>
					<!-- end of row -->
					<div class="row">
							<div class="col-xs-2 text-right">
								<span class="fa fa-star"></span><strong>3</strong>
							</div>
							<div class="col-xs-18">
								<div class="progress">
									<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
										aria-valuemin="0" aria-valuemax="100" style="width: $stars_3_percent%">
										<span class="sr-only">$stars_3</span>
									</div>
								</div>
							</div>
					</div>
					<!-- end of row -->
					<div class="row">
							<div class="col-xs-2 text-right">
								<span class="fa fa-star"></span><strong>2</strong>
							</div>
							<div class="col-xs-18">
								<div class="progress">
									<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
										aria-valuemin="0" aria-valuemax="100" style="width: $stars_2_percent%">
										<span class="sr-only">$stars_2</span>
									</div>
								</div>
							</div>
					</div>
					<!-- end of row -->
					<div class="row">
							<div class="col-xs-2 text-right">
								<span class="fa fa-star"></span><strong>1</strong>
							</div>
							<div class="col-xs-18">
								<div class="progress">
									<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80"
										aria-valuemin="0" aria-valuemax="100" style="width: $stars_1_percent%">
										<span class="sr-only">$stars_1</span>
									</div>
								</div>
							</div>
					</div>
					<!-- end of row -->
				</div>
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-12 heading-container">
							<div class="rating-subhead">Average Ratings</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-7 category-name text-left"><strong>Overall Rating</strong></div>
						<div class="col-xs-14 category-progress-bar">
							<div class="star_rating">
								<div class="outer">
									<input id='header-rating' type='number' class='rating' data-show-caption='false' value='$stars_overall'>
								</div>
							</div>
						</div>
						<div class="col-xs-3 category-average"><strong>$stars_overall</strong></div>
					</div>
					<div class="row">
						<div class="col-xs-7 category-name text-left"><strong>Online Experience</strong></div>
						<div class="col-xs-14 category-progress-bar">
							<div class="tprogress">
								<div class="outer">
									<div class="inner" style="width: $bars_online_percent%">
										<ul><li></li><li></li><li></li><li></li><li></li></ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-3 category-average"><strong>$bars_online</strong></div>
					</div>
					<!-- end of row -->
					<div class="row">
						<div class="col-xs-7 category-name text-left"><strong>Customer Service</strong></div>
						<div class="col-xs-14 category-progress-bar">
							<div class="tprogress">
								<div class="outer">
									<div class="inner" style="width: $bars_service_percent%">
										<ul><li></li><li></li><li></li><li></li><li></li></ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-3 category-average"><strong>$bars_service</strong></div>
					</div>
					<!-- end of row  -->
					<div class="row">
						<div class="col-xs-7 category-name text-left"><strong>Account Benefits</strong></div>
						<div class="col-xs-14 category-progress-bar">
							<div class="tprogress">
								<div class="outer">
									<div class="inner" style="width: $bars_benefits_percent%">
										<ul><li></li><li></li><li></li><li></li><li></li></ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-3 category-average"><strong>$bars_benefits</strong></div>
					</div>
			<!-- end of row -->
			$rewardsHtml
					<!-- end of row -->
				</div>
			</div>
		</div>
	</div>
</div><!--rating-stats-row-->
RENDERED_OUTPUT;
}
?>