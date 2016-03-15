<?php
/**
 * Rate Chart Template
 * 
 * This is where the rate chart is actually rendered into HTML
 * 
 * @copyright 2008 CreditCards.com
 * 
 */
?>

<table border="0" cellpadding="0" cellspacing="0" class="table table-striped">
<?php
    foreach($this->_rates as $rate){
    	if ($rate->getName() == 'National Average') {
    ?>
        <tr>
            <td><a href="<?=$rate->getLink() ?>"><?=$rate->getName() ?></a></td>
            <td><?=$rate->getAvgApr() ?>%</td>
        </tr>
    <?php
    	}
    }
    
    foreach($this->_rates as $rate){
    	if ($rate->getName() != 'National Average') {
    ?>
        <tr>
            <td><a href="<?=$rate->getLink() ?>"><?=$rate->getName() ?></a></td>
            <td><?=$rate->getAvgApr() ?>%</td>
        </tr>
    <?php
    	}
    }
?>

</table>