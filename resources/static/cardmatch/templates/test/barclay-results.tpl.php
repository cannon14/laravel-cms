<h1>Barclay prescreened offers test</h1>

<a href="/cardmatch/testing/barclay.php">Go back</a>

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

} else {

	echo "<h3>Offers Returned</h3>";

	if(count($this->rawOffers)){

		echo "<ul>";

		foreach($this->rawOffers as $offer) {
			echo "<li>".$offer->productId."</li>";
		}

		echo "</ul>";
	} else {
		echo "<h4>No offers returned</h4>";
	}

}
