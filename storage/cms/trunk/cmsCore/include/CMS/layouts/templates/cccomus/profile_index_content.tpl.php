<?php
/*
 * Created on Nov 21, 2008
 *
 * CreditCards.com
 * Author: Tyler Chamberlain
 */

$this->siteCatalystData['pageName'] = "profiles:home";
$this->siteCatalystData['channel'] = "profiles"
?>

<div style="background-color: #fff">

	<table width="790" id="content" border="0" align="center" cellpadding="3" cellspacing="0">
		<tr>
			<td rowspan="100" width="10%">&nbsp;</td>
			<td colspan="5" id="breadcrumbs">
				<a href="/">Credit Cards</a> > <a href="/credit-card-tools/">Tools</a> > Shop Credit Cards by Profile
			</td>
			<td rowspan="100" width="10%">&nbsp;</td>
		</tr>
		<tr height="190">
			<td align="center" valign="middle" bgcolor="#C6D9F0" colspan="5">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr><td>

							<script language="JavaScript" type="text/javascript" src="http://vhss-d.oddcast.com/vhost_embed_functions_v2.php?acc=783484&js=1"></script>
							<script language="JavaScript" type="text/javascript">
								AC_VHost_Embed(783484, 200, 267, '', 1, 1, 1716613, 0, 1, 0, 'c83e398ad0045c896f220189ea6fcd49', 8);
							</script>

							<!-- 
								<object width="300" height="200">
									<param name="movie" value="http://www.youtube.com/v/-83PItgPJj0&hl=en&fs=1">
									</param><param name="allowFullScreen" value="true"></param>
									<param name="allowscriptaccess" value="always"></param>
									<embed src="http://www.youtube.com/v/-83PItgPJj0&hl=en&fs=1" 
										type="application/x-shockwave-flash" allowscriptaccess="always" 
										allowfullscreen="true" width="300" height="200"></embed>
								</object>
							-->
						</td>
						<td valign="middle" bgcolor="#C6D9F0" style="padding: 5px;">
							<h1 class="profileHeading">Shop by Credit Card Profile</h1>
							<p>We've made it easy for you to shop for credit cards. Our credit card experts
								have created various credit card profiles to help you choose the card that's
								right for you, along with valuable tips and tools. Find recommendations and
								advice on what card is right for your credit card profile.</p>

							<p>Pick from one of the credit card profiles listed below for personalized
								recommendations. </p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!--  Blank Row  -->
		<tr height="5"> <td colspan="5"></td> </tr>
		<?php
		$t = 0;
		foreach ($this->profiles_data as $profile_data) {
			if ($t % 2 == 0) {
				//Left side
				?>
				<tr height="200">
					<td bgcolor="<?= $profile_data['background_color_code_dark'] ?>" align="center" width="100" class="profilePictureBox"><a href="<?= $profile_data['lowerName'] ?>.php"><img src="<?= $profile_data['image_path'] ?>" border="0" alt="<?= $profile_data['title'] ?> Credit Card Profile"/></a></td>
					<td bgcolor="<?= $profile_data['background_color_code_light'] ?>" class="profileInfoBox">
						<table height="218" width="180" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr height="44"><td> 
									<span class="profileTitle">
										<a href="<?= $profile_data['lowerName'] ?>.php">
											<?= $profile_data['title'] ?></a></span><br/>
									<span class="profileIndexTag">
										<?= $profile_data['sub_title'] ?>
									</span>
								</td></tr>
							<tr height="135"><td>
									<span class="profileInfoBoxText">
										<b>Description:</b><br/> <?= $profile_data['profile_description'] ?><br/><br/>
										<b>Looking for:</b><br/> <?= $profile_data['profile_card_types'] ?><br/>
									</span>
								</td></tr>
							<tr height="35"><td>
									<a href="<?= $profile_data['lowerName'] ?>.php">
										<center><img src="/images/start-here-button.png" border="0" alt="Credit card profile for <?= $profile_data['title'] ?>"/></center>
									</a>
								</td></tr>
						</table>
					</td>		
					<td bgcolor="white"></td>	
					<?php
				} else {
					//Right side
					?>

					<td bgcolor="<?= $profile_data['background_color_code_light'] ?>" valign="middle" class="profileInfoBox">
						<table height="218" width="180" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr height="44"><td> 
									<span class="profileTitle">
										<a href="<?= $profile_data['lowerName'] ?>.php">
											<?= $profile_data['title'] ?></a></span><br/>
									<span class="profileIndexTag">
										<?= $profile_data['sub_title'] ?>
									</span>
								</td></tr>
							<tr height="135"><td>
									<span class="profileInfoBoxText">
										<b>Description:</b><br/> <?= $profile_data['profile_description'] ?><br/><br/>
										<b>Looking for:</b><br/> <?= $profile_data['profile_card_types'] ?><br/>
									</span>
								</td></tr>
							<tr height="35"><td>
									<a href="<?= $profile_data['lowerName'] ?>.php">
										<center><img src="/images/start-here-button.png" border="0" alt="Credit card profile for <?= $profile_data['title'] ?>" /></center>
									</a>
								</td></tr>
						</table>
					</td>
					<td bgcolor="<?= $profile_data['background_color_code_dark'] ?>" align="center" width="100" class="profilePictureBox"><a href="<?= $profile_data['lowerName'] ?>.php"><img src="<?= $profile_data['image_path'] ?>" border="0" alt="<?= $profile_data['title'] ?> Credit Card Profile"/></a></td>
				</tr>
				<tr height="5"> <td colspan="5"></td> </tr>
				<?php
			}
			$t++;
		}
		if ($t % 2 == 1) {
			echo '<td bgcolor="white"></td></tr>';
		}
		?>
		<tr>
			<td colspan="5">
				<div style="margin-top: 30px;">
					<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.creditcards.com%2Fcredit-card-profiles%2F&amp;layout=standard&amp;show_faces=false&amp;width=300&amp;action=like&amp;font&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:35px;" allowTransparency="true"></iframe>
				</div>
				<p style="margin-top: 15px;">Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a></p>
			</td>
		</tr>
	</table>

</div> <!-- <div style="background-color: #fff"> -->
