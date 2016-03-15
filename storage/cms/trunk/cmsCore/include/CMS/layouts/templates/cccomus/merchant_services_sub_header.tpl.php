<?php
/*
 * Created on Jun 16, 2006
 * Click Success L.P.
 * Author: Jason Huie
 * <jasonh@clicksuccess.com>
 */
?>



<div align="center">
        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="headtable">
  <tr>
    <td rowspan="2" valign="top"><img src="/images/<?=$this->page->get('pageHeaderImage')?>" alt="<?=$this->page->get('pageHeaderImageAltText')?>" border="0" ></td>
    <td rowspan="2"><img src="/images/10-10-spacer.gif" width="10" height="10"></td>
    <td><h1><?=$this->page->get('pageHeaderString')?></h1></td>
  </tr>
  <tr><td><p><?=$this->page->get('pageIntroDescription')?></p></td>
  </tr>
</table>
		<?if(!$this->pageNav && $this->isPageTop){?>
			<table border="0" cellspacing="0" cellpadding="0" class="stepstable">
                  <tr>
                    <td width="33%" class="step1td"><p><img src="/images/Credit-Cards-Search.gif" alt="Search <?=$this->page->get('pageHeaderImageAltText')?>"><br>
                  Search through the Merchant Service Offers below.<br>
                    </p></td>
                    <td width="34%" class="step2td"><p><img src="/images/Credit-Cards-Compare.gif" alt="Compare <?=$this->page->get('pageHeaderString')?>"><br>
                  Compare offers side by side to determine which merchant account best suits your needs. </p></td>
                    <td width="33%" class="step3td"><p><img src="/images/apply-credit-cards.gif" alt="Apply Online for <?=$this->page->get('pageHeaderString')?>"><br>
                    	Apply for the Merchant Account of your choice by completing a secure online application.</p></td>
                  </tr>
          </table>
          <br>
        <?}else if($this->isPageTop){?>
        	<table width="90%" border="0" cellspacing="0" cellpadding="1" align="center">
          		<tr>
            		<td align="center"><br><?=$this->pageNav?><br></td>
          		</tr>
        	</table>
        	<br>
		<?}?>
      </div>