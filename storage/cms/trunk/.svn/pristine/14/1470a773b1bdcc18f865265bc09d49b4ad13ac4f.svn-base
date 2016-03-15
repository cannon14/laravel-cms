
<?php $pageType = $this->page->get('pageType');?>

<?php
$sectionAnchorText = ($this->page->get('pageAnchor') == null) ? 'featured' : $this->page->get('pageAnchor');
?>
<a name="<?= $sectionAnchorText ?>"></a>
<div class="card-category-top">
<?php if($pageType=="BANK"):?>
    <div class="logo-wrapper">
        <div class="outset">
            <div class="inset">
                <span></span><img src="/images/<?=$this->page->get('pageHeaderImage')?>" alt="<?=$this->page->get('pageHeaderImageAltText')?>" border="0">
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="category-description-block">
        <h1><?=$this->page->get('pageHeaderString')?></h1>
        <p class="category-description"><?=$this->page->get('pageDescription')?></p>
        <p class="category-description-mobile">See offers from our partners below.</p>
    </div>
</div>
<div class="card-category-disclosure-hldr"><a href="#" data-toggle="modal" data-target="#myModalDisclosure"><img  class="pull-right" src="/images/advertiser_dis_text.png" /></a>
    <div class="clearfix"></div>
</div>

<div id="all-schumer-boxes">

