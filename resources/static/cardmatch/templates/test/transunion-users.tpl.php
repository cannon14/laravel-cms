<h1>TUNA Test</h1>

<table border="1" style="margin-bottom: 10px;">
	
	<thead>
	    <tr style="font-weight: bold;">
	        <th>Action:</th>
	        <th>First Name:</th>
	        <th>Middle Initial:</th>
	        <th>Last Name:</th>
	        <th>Address:</th>
	        <th>City:</th>
	        <th>State:</th>
	        <th>ZIP:</th>
	        <th>SSN:</th>
	    </tr>
	</thead>

	<tbody>
	<?php

	$count = 0;
	foreach( $this->testUsers as $user ):

	?>
    <tr>
        <td style="text-align: right;">
	        User <?php echo $count ?>
	        <a href="transunion.php?action=run_tuna_test&user=<?=$count?>"><img border="0" src="/cardmatch/images/submit-button.gif" /></a>
        </td>
        <td><?=$user->getFirstName(); ?></td>
        <td><?=($user->getMiddleInitial() ? $user->getMiddleInitial() : '&nbsp;'); ?></td>
        <td><?=$user->getLastName(); ?></td>
        <td><?=$user->getStreetAddress(); ?></td>
        <td><?=$user->getCity(); ?></td>
        <td><?=$user->getState(); ?></td>
        <td><?=$user->getZipCode(); ?></td>
        <td><?=$user->getSSN(); ?></td>
    </tr>

	<?php

	$count++;
	endforeach;

	?>

</table>
