<html>
<head>
	<title>Click Success CMS v2.0</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" href="style.css" type="text/css">
	<script type="text/javascript">

	</script>


	<!-- these are required for product links (card edit) -->
	<link rel="stylesheet" href="css/productLinksForm.css" type="text/css" />
	<link rel="stylesheet" href="js/jquery-ui-1.11.3.custom/jquery-ui.css" type="text/css" />
	<link rel="stylesheet" href="js/bootstrap-3.3.4-dist/css/bootstrap-with-prefix.min.css" type="text/css" />
	<link rel="stylesheet" href="js/DataTables-1.10.6/media/css/jquery.dataTables.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/transmenu.css">


	<script type="text/javascript" src="js/transmenuC.js"></script>
	<script type="text/javascript" src="js/jquery-1.11.2.min.js" ></script>
	<script type="text/javascript" src="js/jquery-ui-1.11.3.custom/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/DataTables-1.10.6/media/js/jquery.dataTables.min.js"></script>
	<!-- <script type="text'javascript" src="bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>-->
	<script type="text/javascript" src="js/productLinksForm.js"></script>
	<script type="text/javascript" src="js/autogrow.js"></script>
	<script type="text/javascript" src="functions.js"></script>

	<script type="text/javascript">
		$(function() {
			TransMenu.initialize();
		});

		function redirect(mod, confirmString){
			if(confirmString == null){
				window.location = "index.php?mod=" + mod;
				return;
			}
			if(confirm(confirmString))
				window.location = "index.php?mod=" + mod;
		}

		var djConfig = {
			debugAtAllCosts: true,
			isDebug: true
		};
	</script>




</head>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="white">
	<div id="banner"></div>
	<div id="content">
		<div id="wrap">
			<div id="menu">
				<a id="manage" href="#">Manage</a>
				<a id="tools" href="#">Tools</a>
				<a id="edit" href="#">Edit</a>
				<a id="about" href="#">About</a>
				<a id="logout" href="javascript:redirect('CMS_view_login&logout=1', 'Are you sure you want to logout?');">Logout</a>
			</div>
		</div>
	</div>

	<script language="javascript">
	// set up drop downs anywhere in the body of the page. I think the bottom of the page is better.. 
	// but you can experiment with effect on loadtime.
	if (TransMenu.isSupported()) {

		//==================================================================================================
		// create a set of dropdowns
		//==================================================================================================
		// the first param should always be down, as it is here
		//
		// The second and third param are the top and left offset positions of the menus from their actuators
		// respectively. To make a menu appear a little to the left and bottom of an actuator, you could use
		// something like -5, 5
		//
		// The last parameter can be .topLeft, .bottomLeft, .topRight, or .bottomRight to inidicate the corner
		// of the actuator from which to measure the offset positions above. Here we are saying we want the 
		// menu to appear directly below the bottom left corner of the actuator
		//==================================================================================================
		var ms = new TransMenuSet(TransMenu.direction.down, 1, 0, TransMenu.reference.bottomLeft);

		//==================================================================================================
		// create a dropdown menu
		//==================================================================================================
		// the first parameter should be the HTML element which will act actuator for the menu
		//==================================================================================================
		var menu1 = ms.addMenu(document.getElementById("manage"));
		menu1.addItem("Users", "javascript:redirect('CMS_view_users');"); 
		menu1.addItem("Sites", "javascript:redirect('CMS_view_sites');"); 
		menu1.addItem("Pages", "javascript:redirect('CMS_view_pages');"); 
		menu1.addItem("Page Components", "javascript:redirect('CMS_view_content');"); 
		menu1.addItem("Cards", "javascript:redirect('CMS_view_cards');"); 
		menu1.addItem("Card Categories", "javascript:redirect('CMS_view_cardCategories');");
		menu1.addItem("Card Categories Groups", "javascript:redirect('CMS_view_cardCategoryGroups');"); 
		menu1.addItem("Amenities", "javascript:redirect('CMS_view_amenities');");
		menu1.addItem("Merchant Services", "javascript:redirect('CMS_view_merchantServices');"); 
		menu1.addItem("Merchants", "javascript:redirect('CMS_view_merchants');");
		menu1.addItem("Versions", "javascript:redirect('CMS_view_versions');");
		menu1.addItem("Site Catalyst", "javascript:redirect('CMS_view_sitecatalyst');");
		menu1.addItem("Redirects", "javascript:redirect('CMS_view_redirects');");

		
		var menu2 = ms.addMenu(document.getElementById("tools"));
		menu2.addItem("Publish to CCBuild", "javascript:redirect('CMS_view_publishSite');");
		menu2.addItem("Publish to Production", "javascript:redirect('CMS_view_publishSiteToProd');");
		//menu2.addItem("Export XML", "javascript:redirect('CMS_view_exportXml');");
		//menu2.addItem("Export Rates", "javascript:redirect('CMS_view_ExportRates', 'Are you sure you want to export rates to CSV?');");
		menu2.addItem("Upload EPC Rates", "javascript:redirect('CMS_view_uploadRates');");
		//menu2.addItem("Refactor Prime", "javascript:redirect('CMS_view_refactorPrime', 'Are you sure you want to refactor prime?');");
		//menu2.addItem("Diff Tool", "javascript:redirect('CMS_view_diff');");

		//==================================================================================================

		//==================================================================================================
		var menu3 = ms.addMenu(document.getElementById("edit"));
		menu3.addItem("Settings", "javascript:redirect('CMS_view_settings');");
		menu3.addItem("History", "javascript:redirect('CMS_view_history');");

		//==================================================================================================

		//==================================================================================================
		var menu4 = ms.addMenu(document.getElementById("about"));
		menu4.addItem("About CMS", "javascript:redirect('CMS_view_about');");

		//==================================================================================================

		//==================================================================================================
		//var menu5 = ms.addMenu(document.getElementById("logout"));

		//==================================================================================================

		//==================================================================================================
		// write drop downs into page
		//==================================================================================================
		// this method writes all the HTML for the menus into the page with document.write(). It must be
		// called within the body of the HTML page.
		//==================================================================================================
		TransMenu.renderAll();
	}
	</script>


<table height=40>

</table>
<br />
<img src='img/credit-cards-logo.gif'>
<br /><br /><br /><br />
<center>

<table border="0" cellpadding="0" cellspacing="0" width='100%'>
  <tr>
	<td class="right_main">
	<table border="0" cellpadding="0" cellspacing="0" width='100%'>
	  <tr>
	    <td class="right_id" valign='top'>
	    <table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="header_main">
    <b>Content Management System</b> [Version 2.0]
    <br>
	</td>
  </tr>
</table>
<br><br>


	




