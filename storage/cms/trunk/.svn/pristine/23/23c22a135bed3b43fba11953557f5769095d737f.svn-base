var productLinkFormHtml, productLinksTable, productLinksDeleteConfirm, productLinkDialog;

jQuery(function() {
    productLinkFormHtml = jQuery("#productLinkModal");
    productLinksTable = jQuery("#productLinksTable");
    productLinksDeleteConfirm = jQuery("#productLinkDeleteConfirm");


    // product link data table
    productLinksTable.dataTable({
        "scrollX" : true,
        "paging" : false,
        "order": [[ 4, "asc" ]],
	    "columnDefs": [
		    {"sortable": false, "targets": [0,1,2,3]},
		    {"visible": false, "targets": [0]}
	    ],
        "fnCreatedRow" : function(nRow, aData) {
            jQuery(nRow).attr('id', 'pl_row' + aData[0]);
        }
    });

    // product link dialog options/setup
    var dialog_options = {
        autoOpen: false,
        width: 500,
        modal: true,
        position: { my: "center", at: "center", of: "#productLinksHeader"},
        dialogClass: 'noTitle',
        closeOnEscape: true,
        close: function() {
            jQuery("#pl_form").trigger("reset");
        }
    };

    productLinkDialog = productLinkFormHtml.dialog(dialog_options);

    // add button to open product link modal
    jQuery("#pl_add").click(function() {
	    productLinkDialog.dialog("open");
        jQuery("#pl_linkId").val(-1);
        jQuery("#pl_account_type").prop('disabled', true);
        jQuery("#pl_website").prop('disabled', true);
        jQuery("#errorMsg").hide();
        jQuery("#pl_url").height(30).autogrow();
    });


    // confirmation dialog for deleting product link
    productLinksDeleteConfirm.dialog({
        autoOpen: false,
        modal: true,
	    position: { my: "center", at: "center", of: "#productLinksHeader"},
        dialogClass: 'noTitle',
        closeOnEscape: true,
        width: 240,
        height: 140
    });

    // remove button to delete product link
    productLinksTable.on("click", "button[id^=pl_delete]", function() {
        var deleteConfirmationDialog = jQuery("#productLinkDeleteConfirm");
        var productLinkId = jQuery(this).attr("id").replace('pl_delete', '');
        var rowId = '#pl_row' + productLinkId;
        var row = jQuery(rowId);

        deleteConfirmationDialog.dialog({
            buttons: {
                "Delete" : function() {
                    jQuery.post("productLinkRoutes.php?action=delete", {productLinkId : productLinkId})
                        .done(function(data) {
                            var response = jQuery.parseJSON(data);
                            var result = response.msg;
                            if (result != 'success') {
                                alert(result);
                            }
                            else {
                                // remove product link from select box
                                jQuery("#productLinksTable").DataTable().row(row).remove().draw(false);
                            }
                        });
                    jQuery(this).dialog("close");
                },
                "Cancel" : function() {
                    jQuery(this).dialog("close");
                }
            }
        });

        deleteConfirmationDialog.dialog("open");
    });

    // product link modal cancel button
    jQuery(document).on("click", "#pl-btn-cancel", function() {
        productLinkFormHtml.dialog("close");
    });

    // website autocomplete options setup
    var autocomplete_options = {
        source: 'productLinkRoutes.php?action=websiteAutocomplete',
        minLength: 2,
        open: function() {
            jQuery("#pl_websiteId").val("-1");
        },
        focus: function(event, ui) {
            event.preventDefault();
            jQuery("#pl_website").val(ui.item.label);
        },
        select: function(event, ui) {
            event.preventDefault();
            jQuery("#pl_website").val(ui.item.label);
            jQuery("#pl_websiteId").val(ui.item.value);
        }
    };

    // website id text box autocomplete
    jQuery("#pl_website").autocomplete(autocomplete_options);

    // disable inputs for account/website link type radio buttons unless checked
    jQuery(document).on("click", "input:radio[name=pl_link_type]", function() {
        if ($(this).is("#link_type_terms")) {
            jQuery("#pl_device_type").val("2");
        }
        var accountTypeSelect = jQuery("#pl_account_type");
        var websiteInput = jQuery("#pl_website");
        if (jQuery(":radio[value=account]").is(':checked')) {
            accountTypeSelect.prop('disabled', false);
        }
        else {
            accountTypeSelect.prop('selectedIndex', 0);
            accountTypeSelect.prop('disabled', true);
        }

        if (jQuery(":radio[value=website]").is(':checked')) {
            websiteInput.prop('disabled', false);
        }
        else {
            websiteInput.val("");
            websiteInput.prop('disabled', true);
        }
    });

    // save product link button
    jQuery(document).on("click", "#pl-btn-create", function() {
        if (validateProductLinkForm()) {
            var link_id = jQuery("#pl_linkId").val();
            if (link_id == -1) {
                saveNewProductLink();
            }
            else {
                editProductLink(link_id);
            }
        }
    });

});


function editLink(productLinkId) {

	jQuery("#pl_linkId").val(productLinkId);

	jQuery.getJSON("productLinkRoutes.php?action=getOne", {productLinkId : productLinkId}, function(response) {
		var result = response.msg;
		if (result != 'success') {
			alert(result);
		} else {
			var accountType = jQuery("#pl_account_type");
			var websiteName = jQuery("#pl_website");
			var urlTextArea = jQuery("#pl_url");

			accountType.prop('disabled', true);
			websiteName.prop('disabled', true);
			jQuery("#errorMsg").hide();

			// set up product link modal values
			var linkTypeName = response.link_type_name.toLowerCase();
			jQuery('input[name="pl_link_type"][value="' + linkTypeName + '"]').prop('checked', true);
			if (linkTypeName === 'account') {
				accountType.val(response.account_type_id);
				accountType.prop('disabled', false);
			}
			if (linkTypeName === 'website') {
				websiteName.val(response.website_name + ' (' + response.website_id + ')');
				jQuery("#pl_websiteId").val(response.website_id);
				websiteName.prop('disabled', false);
			}
			jQuery("#pl_device_type").val(response.device_type_id);

			urlTextArea.autogrow({ onInitialize : true });
			urlTextArea.height(1);
			urlTextArea.val(response.url);

			productLinkDialog.dialog("open");

			// reset height of url textarea to fit product link url
			var urlScrollHeight = jQuery("textarea#pl_url")[0].scrollHeight;
			urlTextArea.height(urlScrollHeight);
		}
	});
}

// form validation
function validateProductLinkForm() {
	// remove old error message, if any
	var errorMsgDiv = jQuery("#errorMsg");
	if (errorMsgDiv.length) {
		errorMsgDiv.hide();
	}

	// check website ID input (if link type is website)
	var pl_linkType = jQuery("input:radio[name=pl_link_type]:checked").val();
	var pl_website = jQuery("#pl_website").val();
	var pl_websiteId = jQuery("#pl_websiteId").val();
	if (pl_linkType == 'website') {
		if (pl_website.length == 0 || pl_websiteId == -1) {
			showProductLinkError('You must enter a valid website.');
			return false;
		}
	}

	// check URL input
	var pl_url = jQuery("#pl_url").val();
	if (pl_url.length == 0) {
		showProductLinkError('You must enter a URL.');
		return false;
	}
	else if (!isValidProductLink(pl_url)) {
		showProductLinkError('Invalid URL. Valid URL format: http://www.creditcards.com');
		return false;
	}

	return true;
}

function saveNewProductLink() {
	var form_data = jQuery("#pl_form").serialize();

	jQuery.getJSON("productLinkRoutes.php?action=add", form_data, function(response) {
		var result = response.msg;
		if (result != 'success') {
			showProductLinkError(result);
		}
		else {
			// add new product link to select box
			var linkId = response.product_link_id;
			var editButtonId = 'pl_edit' + linkId;
			var editButton = '<button type="button" class="btn btn-primary btn-sm" aria-label="Left Align" ' +
				'id="' + editButtonId + '" onclick="editLink(' + linkId + ')"><span class="glyphicon glyphicon-pencil" aria-hidden="true">' +
				'</span></button>';

			var deleteButtonId = 'pl_delete' + linkId;
			var deleteButton = '<button type="button" class="btn btn-danger btn-sm" aria-label="Left Align" ' +
				'id="' + deleteButtonId + '"><span class="glyphicon glyphicon-remove" aria-hidden="true">' +
				'</span></button>';


			var testButtonId = 'pl_test' + linkId;
			var testButton = '<button type="button" class="btn btn-primary btn-sm" aria-label="Left Align" ' +
				'id="' + testButtonId + '" title="Test link" onclick="testLink(' + linkId + ')"><span class="glyphicon glyphicon-link" aria-hidden="true" >' +
				'</span></button>';

			jQuery("#productLinksTable").DataTable().row.add([
				linkId,
				editButton,
				deleteButton,
				testButton,
				response.link_type_name,
				response.device_type_name,
				response.website_id,
				response.account_type_name,
				response.url
			]).draw(false);

			productLinkFormHtml.dialog("close");
		}
	}, "json");
}

function editProductLink(link_id) {
	var form_data = jQuery("#pl_form").serialize();

	jQuery.getJSON("productLinkRoutes.php?action=edit&product_link_id=" + link_id, form_data, function(response) {
		var result = response.msg;
		if (result != 'success') {
			showProductLinkError(result);
		}
		else {
			var tableRowId = '#pl_row' + link_id;
			var tableRow = jQuery("#productLinksTable").DataTable().row(tableRowId);

			var editButtonId = 'pl_edit' + link_id;
			var editButton = '<button type="button" class="btn btn-primary btn-sm" aria-label="Left Align" ' +
				'id="' + editButtonId + '" onclick="editLink(' + link_id + ')"><span class="glyphicon glyphicon-pencil" aria-hidden="true">' +
				'</span></button>';

			var deleteButtonId = 'pl_delete' + link_id;
			var deleteButton = '<button type="button" class="btn btn-danger btn-sm" aria-label="Left Align" ' +
				'id="' + deleteButtonId + '"><span class="glyphicon glyphicon-remove" aria-hidden="true">' +
				'</span></button>';

			var testButtonId = 'pl_test' + link_id;
			var testButton = '<button type="button" class="btn btn-primary btn-sm" aria-label="Left Align" ' +
				'id="' + testButtonId + '" title="Test link" onclick="testLink(' + link_id + ')"><span class="glyphicon glyphicon-link" aria-hidden="true" >' +
				'</span></button>';

			tableRow.data([
				link_id,
				editButton,
				deleteButton,
				testButton,
				response.link_type_name,
				response.device_type_name,
				response.website_id,
				response.account_type_name,
				response.url
			]).draw(false);

			productLinkFormHtml.dialog("close");
		}
	}, "json");
}

function showProductLinkError(msg) {
	var errorMsg = jQuery("#errorMsg");
	errorMsg.find("label").text(msg);
	errorMsg.show();
}

function isValidProductLink(link) {
	var regex = /^(https?:\/\/)([\da-z\.-]+)\.([a-z\.]{2,6})([\/?].*)*$/;
	return regex.test(link);
}

function testLink(linkId) {

	var url = "productLinkRoutes.php?action=testLink";

	var networkId = jQuery("#network_id_select").val();

	if(networkId == -1) {
		alert('Please select a network');
	} else {

		var params = {
			"linkId": linkId,
			"networkId": networkId
		};


		jQuery.getJSON(url, params, function (data) {
			testUrl = data.url;
			window.open(testUrl);
		});
	}
}
