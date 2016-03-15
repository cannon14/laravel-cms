<?php
$file = "http://feeds.creditcards.com/ehs?aid=test&module=rate_table&medium=xml";
$element = "category";
$DomDocument = domxml_open_file($file);
$RootDomNode = $DomDocument->document_element();
$array = $DomDocument->get_elements_by_tagname($element);
foreach($array as $element){
    foreach($element->attributes() as $attrib){
        $tempArray[trim($attrib->name())] = trim($attrib->value());
    }
    $rateChart[$tempArray['name']] = $tempArray;
}
?>
    <div class="articlebox3">
      <h2>Credit Card Rate Report</h2>
      <p><strong>Updated: <?=date('m-d-Y')?></strong></p>        
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><a href="/low-interest.php">Low Interest</a></td>
          <td><?=$rateChart['Low Interest']['avgApr']?>%</td>
        </tr>
        <tr>
          <td><a href="/balance-transfer.php">Balance Transfer</a></td>
          <td><?=$rateChart['Balance Transfer']['avgApr']?>%</td>
        </tr>
        <tr>
          <td><a href="/bad-credit.php">For Bad Credit</a></td>
          <td><?=$rateChart['For Bad Credit']['avgApr']?>%</td>
        </tr>
        <tr>
          <td><a href="/cash-back.php">Cash Back</a></td>
          <td><?=$rateChart['Cash Back']['avgApr']?>%</td>
        </tr>
        <tr>
          <td><a href="/reward.php">Reward</a></td>
          <td><?=$rateChart['Reward']['avgApr']?>%</td>
        </tr>
        <tr>
          <td><a href="/business.php">Business</a></td>
          <td><?=$rateChart['Business']['avgApr']?>%</td>
        </tr>
        <tr>
          <td><a href="/instant-approval.php">Instant Approval</a></td>
          <td><?=$rateChart['Instant Approval']['avgApr']?>%</td>
        </tr>
        <tr>
          <td><a href="/airline-miles.php">Airline</a></td>
          <td><?=$rateChart['Airline']['avgApr']?>%</td>
        </tr>
        <tr>
          <td><a href="/college-students.php">Student</a></td>
          <td><?=$rateChart['Student']['avgApr']?>%</td>
        </tr>
      </table>
      <p class="moreinfo">&nbsp;</p>
    </div>