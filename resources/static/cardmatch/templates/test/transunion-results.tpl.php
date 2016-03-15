<h1>TUNA Test</h1>

<a href="/cardmatch/testing/">Go back</a>

<h3>Results for:</h3>

<table border="1" cellpadding="5">
    <tr>
        <td>First Name:</td>
        <td><?=$this->user->getFirstName(); ?></td>
    </tr>
    <tr>
        <td>Middle Initial:</td>
        <td><?=$this->user->getMiddleInitial(); ?></td>
    </tr>
    <tr>
        <td>Last Name:</td>
        <td><?=$this->user->getLastName(); ?></td>
    </tr>
    <tr>
        <td>Address:</td>
        <td><?=$this->user->getStreetAddress(); ?></td>
    </tr>
    <tr>
        <td>City:</td>
        <td><?=$this->user->getCity(); ?></td>
    </tr>
    <tr>
        <td>State:</td>
        <td><?=$this->user->getState(); ?></td>
    </tr>
    <tr>
        <td>ZIP:</td>
        <td><?=$this->user->getZipCode(); ?></td>
    </tr>
    <tr>
        <td>SSN:</td>
        <td><?=$this->user->getSSN(); ?></td>
    </tr>
</table>

<?php

if( isset($this->error)) {

    echo '<h3>Error</h3>';
    echo '<b>Level:</b> ' . $this->error->getLevel();
    echo '<br /><b>Number:</b> ' . $this->error->getNumber();
    echo '<br /><b>Message:</b> ' . $this->error->getMessage();

} else { ?>

	<h3>Buckets Returned</h3>

	<table border="1" style="margin-bottom: 10px;">

		<thead>
		    <tr style="font-weight: bold;">
		        <td>TUNA Bucket:</td>
		        <td>CCCOM Category:</td>
		    </tr>
		</thead>

		<tbody>
		<?php

		foreach($this->buckets as $bucket=>$category ) {
		    echo "<tr>";
		    echo "<td>$bucket</td>";
		    echo "<td>$category</td>";
			echo "</tr>";
		}
		?>
		</tbody>
	</table>


	<h3>Cards</h3>
	<?php
	foreach($this->offers as $offer) {
		echo $offer->getCardId().'<br/>';
	}
}
