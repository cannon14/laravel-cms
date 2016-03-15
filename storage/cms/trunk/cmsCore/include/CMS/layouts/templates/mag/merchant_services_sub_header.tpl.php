<?php
/*
 * Created on Jun 16, 2006
 * Click Success L.P.
 * Author: Jason Huie
 * <jasonh@clicksuccess.com>
 */
?>

<div align="center">

<table width="90%" border="0" cellpadding="0" cellspacing="0" class="headtable">
  <tr>
    <td rowspan="2" valign="top"><img src="/images/<?=$this->page->get('pageHeaderImage')?>" alt="<?=$this->page->get('pageHeaderImageAltText')?>" border="0" ></td>
    <td><h1><?=$this->page->get('pageHeaderString')?><?=$this->page->get('navBarString') && !$this->isPageTop?'<a name="'.$this->page->get('pageAnchor').'"></a>':'<a name="top"></a>';?></h1></td>
  </tr>
  <tr>
  	<td><p><?=$this->page->get('pageIntroDescription')?></p></td>
  </tr>
</table>
<?php if(!$this->pageNav && $this->isPageTop){ ?>
  <br>
<?php } else if($this->isPageTop){ ?>
	<table width="90%" border="0" cellspacing="0" cellpadding="1" align="center">
  		<tr>
    		<td align="center"><br><?=$this->pageNav?><br></td>
  		</tr>
	</table>
	<br>
<?php } ?>
<?php
if($this->subPageNav && sizeof($this->page->getMerchantServices()) > 0) {
	echo '<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
			<tr>
				<td class="page-sub-nav" align="center">'.$this->subPageNav.'</td>
			</tr>
			</table><br>';
}
?>
</div>