@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
        <?php

            if(isset($catid)) {
                $reviewApplyLink = "/oc/?pid=' . 0 . '&pg=0&pgpos=' . 0 . '&catid=' . 0 . '";
            } else {
                $reviewApplyLink = "/oc/?pid=' . 0 . '&pg=0&pgpos=' . 0 . '&catid=' . 0 . '";
            }

            $product_id = '22189517';
            //Pull the stats for the card.
            $api = new Cannon\APIClient('stats/'.$product_id);
            $stats_data = $api->getResponseAsArray();
            //SHOW THE STATS HEADER
            showStats($stats_data->stats[0]);

            ?>

             <div class="row" style="margin-top:15px; padding-top:15px; padding-bottom:10px; clear:both; border-top:thin solid #003B76">

                <div class="col-lg-12 text-right">
                    <form action="#">
                    <input type="hidden" id="product_id" value="<?= $product_id ?>">
                    <label for="sortables">Sort By: </label>
                    <select id="sortables">
                       <option value="order_by=submission_date&amp;order_dir=DESC" selected>Newest To Oldest Date</option>
                       <option value="order_by=submission_date&amp;order_dir=ASC">Oldest To Newest Date</option>
                       <option value="order_by=overall_rating&amp;order_dir=DESC">Highest To Lowest Rating</option>
                       <option value="order_by=overall_rating&amp;order_dir=ASC">Lowest To Highest Rating</option>
                    </select>
                    </form>
                </div>
            </div>

            <div style="clear:both"></div>

            <?php
                $api = new Cannon\APIClient('reviews/'.$product_id);
                $data = $api->getResponseAsArray();

                $reviews = $data->data;
            ?>

            @foreach($reviews as $review)
            <div class="row review_row">
            <div class="col-lg-12">
                <table>
                <tbody>
                    <tr>
                        <td width="250">
                            <div id="star_rating">
                            <input type="number" disabled="" showClear=false readonly="" value="5" step="1" max="5" min="0" class="rating" size="sm" id="rating-system"></div>
                        </td>
                        <td>
                            <div class="r_title"><?= $review->review_title ?> &nbsp;</div>
                            <span class="submission_date"><?= $review->submission_date ?>&nbsp;</span><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span class="data_name">Username:&nbsp;</span>
                            <span class="data_value"><?= $review->user_nickname ?>&nbsp;</span><br>
                            <span class="data_name">Age:&nbsp;</span>
                            <span class="data_value"><?= $review->age ?>&nbsp;</span><br>
                            <span class="data_name">Location:&nbsp;</span>
                            <span class="data_value"><?= $review->user_location ?>&nbsp;</span><br>
                            <span class="data_name">Member Since:&nbsp;</span>
                            <span class="data_value"><?= $review->member_since ?>&nbsp;</span><br>
                            <div class="data_value" style="margin-top:30px;"><?= $review->review_text ?>&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div><!--col-lg-12-->
            </div><!--row-->
            @endforeach

        </div><!--col-lg-12-->
    </div><!--row-->

<div class="row">
    <div class="col-lg-12 text-center">
        <?php
            //$start_range = ($data->current_page*$data->num_of_reviews);
            //$end_range = $start_range+$data->num_of_reviews;
            //$total_reviews = $data->total_num_of_reviews;
        ?>
        <p>Records <?= $data->from  ?> - <?= $data->to ?> of <?= $data->total ?></p>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#sortables').change(function() {
    var product_id = $('#product_id').val();
    var sortables = $(this).val();

        $.ajax({
            type: 'GET',
            url: 'libs/reviews/api.php',
            data: {product_id: product_id, sortables: sortables}
        });
    });
})
</script>
@stop


<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function showStats($stats){

    $rewards_show = "";
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
    //$click_here_link = $vals[14];

    $bars_rewards_percent =  ($bars_rewards/5)*100;
    $bars_benefits_percent = ($bars_benefits/5)*100;
    $bars_service_percent =  ($bars_service/5)*100;
    $bars_online_percent =   ($bars_online/5)*100;

    if ($stats->rewards_program > 0){
        $rewards_show = <<<EOT
            <div class="row"> 
                <div class="col-xs-4 col-md-4 text-left" style="font-weight: bold;">
                    Rewards Program
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="tprogress">
                        <div class="outer">
                            <div class="inner" style="width: $bars_rewards_percent%">
                                <ul><li></li><li></li><li></li><li></li><li></li></ul>
                                <p><span>$bars_rewards</span></p>
                            </div>
                            <p>$bars_rewards</p>
                        </div>
                    </div>
                </div>
            </div>
EOT;

    }


echo <<< END_OF_HEAD
<div class="row">
<div class="col-lg-12">
<div class="star-rating">
        <div class="starrating_info">Ratings and reviews provided by issuer as of 9/23/2014. <BR/>To see the latest reviews on the issuer site, click <a target="_blank" href="#">here</a>.</div>
        <h3>Customer Reviews</h3>
        <hr style="height:4px; color:#003B76; background-color:#003B76;" />
            <div style="width: 100%;">
                <div id="left" class="col-xs-4 col-md-4" style="width: 40%; ">
                    <div class="row">
                        <div class="heading-container" style="width: 100%; ">
                            <span class="rating-subhead">Rating Snapshots</span> <span class="rating-subinfo">(Total $total_reviews)</span>
                        </div>
                    </div>
                    <!-- end of row -->
                    <div class="row">
                            <div class="col-xs-3 col-md-3 text-right">
                                <span class="glyphicon glyphicon-star"></span>5
                            </div>
                            <div class="col-xs-8 col-md-9">
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
                            <div class="col-xs-3 col-md-3 text-right">
                                <span class="glyphicon glyphicon-star"></span>4
                            </div>
                            <div class="col-xs-8 col-md-9">
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
                            <div class="col-xs-3 col-md-3 text-right">
                                <span class="glyphicon glyphicon-star"></span>3
                            </div>
                            <div class="col-xs-8 col-md-9">
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
                            <div class="col-xs-3 col-md-3 text-right">
                                <span class="glyphicon glyphicon-star"></span>2
                            </div>
                            <div class="col-xs-8 col-md-9">
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
                            <div class="col-xs-3 col-md-3 text-right">
                                <span class="glyphicon glyphicon-star"></span>1
                            </div>
                            <div class="col-xs-8 col-md-9">
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
                <div id="right" class="col-xs-8 col-md-8" style="width: 60%; ">
                    <div class="row">
                        <div class="heading-container" style="width: 100%;">
                            <div class="rating-subhead">Average Ratings</div>
                        </div>
                    </div>
                    <div class="row">

                            <div class="col-xs-4 col-md-4 text-left" style="font-weight: bold;">
                                Overall Rating
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <div class="star_rating">
                                    <div class="outer">
                                        <input id='rating-system' size='sm' type='number' class='rating' min='0' max='5' step='1' value='$stars_overall'  readonly disabled>
			                            <p><span>$stars_overall</span></p>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="row">
                            <div class="col-xs-12 col-md-12 text-left" style="margin-top: 4px;">
                                $total_recommend_yes out of $total_recommend_complete ($recommend_percent%) reviewers recommend this product<BR/><P/>
                            </div>
                    </div>
                    <div class="row">
                            <div class="col-xs-4 col-md-4 text-left"  style="font-weight: bold;">
                                Online Experience
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <div class="tprogress">
                                    <div class="outer">
                                        <div class="inner" style="width: $bars_online_percent%">
                                            <ul><li></li><li></li><li></li><li></li><li></li></ul>
                                            <p><span>$bars_online</span></p>
                                        </div>
                                        <p>$bars_online</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- end of row -->
                    <div class="row">
                            <div class="col-xs-4 col-md-4 text-left" style="font-weight: bold;">
                                Customer Service
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <div class="tprogress">
                                    <div class="outer">
                                        <div class="inner" style="width: $bars_service_percent%">
                                            <ul><li></li><li></li><li></li><li></li><li></li></ul>
                                            <p><span>$bars_service</span></p>
                                        </div>
                                        <p>$bars_service</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- end of row  -->
                    <div class="row">
                            <div class="col-xs-4 col-md-4 text-left" style="font-weight: bold;">
                                Account Benefits
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <div class="tprogress">
                                    <div class="outer">
                                        <div class="inner" style="width: $bars_benefits_percent%">
                                            <ul><li></li><li></li><li></li><li></li><li></li></ul>
                                            <p><span>$bars_benefits</span></p>
                                        </div>
                                        <p>$bars_benefits</p>
                                    </div>
                                </div>
                            </div>
                    </div>
		    <!-- end of row -->
		    $rewards_show
                    <!-- end of row -->
                </div>
            </div>
        </div>
    </div>
</div>
END_OF_HEAD;
}
?>