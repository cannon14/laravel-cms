<?php
/**
 * Name: Card Category Page
 * Type: category
 * Description: Standard Credit Card Category Page
 * Version: 1.0.0
 * Date: 2015-11-20
 */
?>

@extends('cccomus.templates.layouts.master')

@section('title', $page->category->name)

@section('styles')

    <link href="/css/reviews.css" type="text/css" rel="stylesheet">

    <style>
        .res-details ul {
            list-style-type: disc;
        }
        .res-details ul:nth-child(1) li, .res-details ul:nth-child(2) li {
            display:none;
        }

        .res-details ul:nth-child(1) li:nth-child(1), .res-details ul:nth-child(1) li:nth-child(2) {
            display:block;
        }

        .schumer-package {
            display:none;
        }
        .schumer-package:nth-child(-n+10) {
            display:block;
        }

        .show-more-link {
            margin-left:40px;
            margin-bottom:15px;
        }

        .show-more-results {
            display:block;
        }


    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var target = $('.show-more-link');

            target.on('click', function(e) {
                e.preventDefault();

                var text = $(this).find('.text');

                if(text.text() == 'Show More') {
                    $(this).parent().find('.res-details ul li').css('display', 'block');
                    $('a', this).html('<span class="text">Show Less</span> <i class="fa fa-chevron-up"></i>');
                }
                else {
                    $(this).parent().find('.res-details ul li').css('display', 'none');
                    $(this).parent().find('.res-details ul:nth-child(1) li:nth-child(1), .res-details ul:nth-child(1) li:nth-child(2)').css('display', 'block');
                    $('a', this).html('<span class="text">Show More</span> <i class="fa fa-chevron-down"></i>');
                }
            });

            var count = 10;
            var schumerCount = $('.schumer-package').length;

            $('.show-more-results').on('click', function(e) {
                e.preventDefault();
                count += 10;
                $('.schumer-package:nth-child(-n+'+count+')').css('display', 'block');

                if(count >= schumerCount) {
                    $('.show-more-results').css('display', 'none');
                }
            });

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
        });
    </script>
@endsection

@section('content')

    <a id="Page-Top"></a>

    <div class="card-category-block">

        <div class="container">

            <div class="row">
                <div class="col-sm-18 col-md-18 col-lg-18">
                    <!--category name-->
                    <div class="row">
                        <div class="col-lg-24">
                            <div class="card-category-top">
                                <div class="category-description-block">
                                    <h1>{{ $page->category->name }}</h1>

                                    <div class="category-description">{!! $page->description !!}</div>
                                </div>
                            </div>

                            <div class="card-category-disclosure-hldr"><a data-target="#myModalDisclosure"
                                                                          data-toggle="modal" href="#"><img
                                            src="/images/advertiser_dis_text.png" class="pull-right"></a>

                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>

                    <!--Schumer boxes-->
                    <div class="row">
                        <div class="col-lg-24">
                            @foreach ($cards as $card)
                                <div class="schumer-package">
                                    <?php
                                    try { ?>
                                    @include('cccomus.templates.partials.schumers.'.$page->schumer->slug, ['page'=>$page, 'card'=>$card])
                                    <?php }
                                    catch(Exception $e) {
                                        dd($e->getMessage());
                                    }
                                    ?>
                                </div>
                            @endforeach
                        </div><!--column-->
                    </div><!--row-->

                    <div class="card-category-disclosure-hldr-bottom">
                        <a data-target="#myModalDisclosure" data-toggle="modal" href="#">
                            <img src="/images/advertiser_dis_text.png" class="pull-right">
                        </a>
                        <div class="clearfix"></div>
                    </div>

                    <a class="show-more-results" href="#">Show More Results</a>

                    <div class="disqus-block">

                        <div class="editorial-piece-hldr">
                            <hr>
                            <h2></h2>
                            <div class="row">
                                <div class="col-md-16">
                                    <div class="story-info">
                                        <img title="Creditcards.com Creative Team" src="/credit-card-news/images/authors/logo-blue-card-thumb.png">
                                        <div class="story-metadata">
                                            <div class="author-name">By: Creditcards.com Creative Team</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-8">
                                    <div class="social-hldr">
                                        <ul class="list-inline">

                                            <li>

                                                <script src="https://apis.google.com/js/plusone.js" gapi_processed="true"></script>
                                                <div style="text-indent: 0px; margin: 0px; padding: 0px; background: transparent none repeat scroll 0% 0%; border-style: none; float: none; line-height: normal; font-size: 1px; vertical-align: baseline; display: inline-block; width: 106px; height: 24px;" id="___plusone_0"><iframe width="100%" frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" style="position: static; top: 0px; width: 106px; margin: 0px; border-style: none; left: 0px; visibility: visible; height: 24px;" tabindex="0" vspace="0" id="I0_1449881724875" name="I0_1449881724875" src="https://apis.google.com/se/0/_/+1/fastbutton?usegapi=1&amp;origin=http%3A%2F%2Fwww.creditcards.com&amp;url=http%3A%2F%2Fwww.creditcards.com%2Fbalance-transfer.php&amp;gsrc=3p&amp;ic=1&amp;jsh=m%3B%2F_%2Fscs%2Fapps-static%2F_%2Fjs%2Fk%3Doz.gapi.en_US.m4gOzTKMZCU.O%2Fm%3D__features__%2Fam%3DAQ%2Frt%3Dj%2Fd%3D1%2Ft%3Dzcms%2Frs%3DAGLTcCN1zKn0Anjhz6GlNMluDoc4My1tWg#_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart%2Concircled%2Cdrefresh%2Cerefresh&amp;id=I0_1449881724875&amp;parent=http%3A%2F%2Fwww.creditcards.com&amp;pfname=&amp;rpctoken=41673493" data-gapiattached="true" title="+1"></iframe></div>

                                            </li>

                                            <li>
                                                <iframe frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:80px; height:21px;" scrolling="no" src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fcardpress-us.in.creditcards.com%2Fmanager%2Findex.php&amp;layout=button_count&amp;show_faces=true&amp;width=75&amp;action=like&amp;colorscheme=light&amp;height=21"></iframe>

                                            </li>

                                            <li>

                                                <iframe frameborder="0" id="twitter-widget-0" scrolling="no" allowtransparency="true" class="twitter-share-button twitter-share-button-rendered twitter-tweet-button" style="position: static; visibility: visible; width: 60px; height: 20px;" title="Twitter Tweet Button" src="http://platform.twitter.com/widgets/tweet_button.ab4ec33f73214445796a87ce54aee452.en.html#_=1449881726528&amp;dnt=false&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=http%3A%2F%2Fwww.creditcards.com%2Fbalance-transfer.php&amp;size=m&amp;text=Balance%20Transfer%20Credit%20Cards%20-%20Many%20choices%20available%20for%20your%20transfers%20-%20CreditCards.com&amp;type=share&amp;url=http%3A%2F%2Fwww.creditcards.com%2Fbalance-transfer.php"></iframe>
                                                <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>

                                            </li>

                                            <li>

                                                <script type="text/javascript" src="//platform.linkedin.com/in.js">
                                                </script>
                                                <span style="line-height: 1; vertical-align: baseline; display: inline-block; text-align: center;" class="IN-widget"><span style="padding: 0px ! important; margin: 0px ! important; text-indent: 0px ! important; display: inline-block ! important; vertical-align: baseline ! important; font-size: 1px ! important;"><span id="li_ui_li_gen_1449881725364_0"><a href="javascript:void(0);" id="li_ui_li_gen_1449881725364_0-link"><span id="li_ui_li_gen_1449881725364_0-logo">in</span><span id="li_ui_li_gen_1449881725364_0-title"><span id="li_ui_li_gen_1449881725364_0-mark"></span><span id="li_ui_li_gen_1449881725364_0-title-text">Share</span></span></a></span></span><span style="padding: 0px ! important; margin: 0px ! important; text-indent: 0px ! important; display: inline-block ! important; vertical-align: baseline ! important; font-size: 1px ! important;"><span class="IN-right" id="li_ui_li_gen_1449881725371_1-container"><span class="IN-right" id="li_ui_li_gen_1449881725371_1"><span class="IN-right" id="li_ui_li_gen_1449881725371_1-inner"><span class="IN-right" id="li_ui_li_gen_1449881725371_1-content">2</span></span></span></span></span></span><script data-counter="right" type="IN/Share+init"></script>

                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <h2>Join the Discussion</h2><br>

                        <p style="font-size: .8em;">We encourage an active and insightful conversation among our users. Please help us keep
                            our community civil and respectful. For your safety, we ask that you do not disclose confidential or personal
                            information such as your bank account number, phone number, or email address. Keep in mind that anything you
                            post may be disclosed, published, transmitted or reused.</p>

                        <p style="font-size: .8em;">The comments posted below are not provided, reviewed or approved by the card issuers or
                            advertisers. Additionally, the card issuer or advertiser does not assume responsibility to ensure that all posts
                            and/or questions are answered.</p>

                        <div id="disqus_thread"><iframe width="100%" frameborder="0" id="dsq-app1" name="dsq-app1" allowtransparency="true" scrolling="no" tabindex="0" title="Disqus" style="width: 100% ! important; border: medium none ! important; overflow: hidden ! important; height: 6553px ! important;" src="http://disqus.com/embed/comments/?base=default&amp;version=ef8a04cc55a4466175b5cff18466d48b&amp;f=creditcardscom&amp;t_i=12&amp;t_u=http%3A%2F%2Fwww.creditcards.com%2Fbalance-transfer.php&amp;t_d=Balance%20Transfer%20Credit%20Cards%20-%20Many%20choices%20available%20for%20your%20transfers%20-%20CreditCards.com&amp;t_t=Balance%20Transfer%20Credit%20Cards%20-%20Many%20choices%20available%20for%20your%20transfers%20-%20CreditCards.com&amp;t_c=3175896&amp;s_o=default" horizontalscrolling="no" verticalscrolling="no"></iframe><iframe frameborder="0" id="indicator-north" name="indicator-north" allowtransparency="true" scrolling="no" tabindex="0" title="Disqus" style="width: 863px ! important; border: medium none ! important; overflow: hidden ! important; top: 0px ! important; min-width: 863px ! important; max-width: 863px ! important; position: fixed ! important; z-index: 2147483646 ! important; height: 29px ! important; min-height: 29px ! important; max-height: 29px ! important; display: none ! important;"></iframe><iframe frameborder="0" id="indicator-south" name="indicator-south" allowtransparency="true" scrolling="no" tabindex="0" title="Disqus" style="width: 863px ! important; border: medium none ! important; overflow: hidden ! important; bottom: 0px ! important; min-width: 863px ! important; max-width: 863px ! important; position: fixed ! important; z-index: 2147483646 ! important; height: 29px ! important; min-height: 29px ! important; max-height: 29px ! important; display: none ! important;"></iframe></div>
                        <script type="text/javascript">
                            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                            var disqus_shortname = 'creditcardscom';
                            var disqus_identifier = '12';
                            var disqus_category_id = '3175896';
                            var disqus_url = 'http://www.creditcards.com/{{ $page->slug }}.php';

                            /* * * DON'T EDIT BELOW THIS LINE * * */
                            (function () {
                                var dsq = document.createElement('script');
                                dsq.type = 'text/javascript';
                                dsq.async = true;
                                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the &lt;a href="http://disqus.com/?ref_noscript"&gt;comments powered by
                            Disqus.&lt;/a&gt;</noscript>


                    </div>

                </div>
                <!--right gutter-->
                <div class="col-lg-6">
                    @if(View::exists('cccomus.templates.partials.gutters.'.$page->slug))
                        @include('cccomus.templates.partials.gutters.'.$page->slug)
                    @endif
                </div>
            </div>
        </div>

    </div><!--card-category-block-->

    <div class="back-to-top-block">
        <div class="container">
            <div class="row">
                <div class="col-md-24">
                    <a style="display: block;" href="#Page-Top" class="back-to-top"><i class="fa fa-chevron-up"></i><br><br>BACK<br>TO
                        TOP</a>
                </div>
                <div class="col-md-24 see-terms-footer">
                    See the online balance transfer credit card applications for details about terms and conditions of
                    offer. Reasonable efforts are made to maintain accurate information. However all credit card
                    information is presented without warranty. When you click on the " Apply Now" button you can review
                    the credit card terms and conditions on the issuer's web site.
                </div>
            </div>
            <div class="row">
                <div class="col-md-24 see-terms-footer-mobile"> * For additional rates, fees and costs see issuer's
                    website for detailed pricing and terms.
                </div>
            </div>
        </div>
    </div>

@endsection
