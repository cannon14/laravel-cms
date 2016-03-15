
var m1, m2, m3, m4, m5, m6, m7, m8, m9, m10;

$(function() {

	// shorthand for refering to menus
	// must run after document has been created
	// you can also change the name of the select menus and
	// you would only need to change them in one spot, here
	m1 = document.getElementById('unAssignedAmenities');
	m2 = document.getElementById('assignedAmenities');
	m3 = document.getElementById('unassignedSitesFacade');
	m4 = document.getElementById('assignedSitesFacade');
	m5 = document.getElementById('unassignedSites');
	m6 = document.getElementById('assignedSites');
	m7 = document.getElementById('nonExcludedFacade');
	m8 = document.getElementById('excludedFacade');
	m9 = document.getElementById('nonExcluded');
	m10 = document.getElementById('excluded');

})


function isValidUrl(str) {
	// Function stolen from origin uiWerks.js
	//for our purposes, regular expression demands http:// or https:// at beginning of url
	//  followed by 1 or more groups of: valid hostname chars followed by "."
	//    (hostname labels can be between 1 and 63 chars)
	//  followed by 2 or more alphanumeric chars (top level domain names: com, net, etc.)
	//  followed by optional group, beginning with only \ or ?
	//    and followed by chars expected to be found in directory structures or parameter strings.

	var re = /^https?:\/\/([a-zA-Z0-9\-\(\)\,]{1,63}\.)+[a-zA-Z0-9\-\(\)\,]{2,63}([?\/][\w\-#-|\*\/?!=%&\.\,:;\(\)\[\]]*)?\s*$/

	return re.test(str);

}

function editVersion(ID, eid, module) {
	document.location.href = "index.php?mod=" + module + "&action=editVersion&versionId=" + ID + "&cardId=" + eid;

}

function one2two(list1, list2) {
	list1len = list1.length;
	for (i = 0; i < list1len; i++) {
		if (list1.options[i].selected == true) {
			list2len = list2.length;
			list2.options[list2len] = new Option(list1.options[i].text);
			list2.options[list2len].value = list1.options[i].value;
		}
	}

	for (i = (list1len - 1); i >= 0; i--) {
		if (list1.options[i].selected == true) {
			list1.options[i] = null;
		}
	}
}

function two2one(list1, list2) {
	list2len = list2.length;
	for (i = 0; i < list2len; i++) {
		if (list2.options[i].selected == true) {
			list1len = list1.length;
			list1.options[list1len] = new Option(list2.options[i].text);
			list1.options[list1len].value = list2.options[i].value;
		}
	}
	for (i = (list2len - 1); i >= 0; i--) {
		if (list2.options[i].selected == true) {
			list2.options[i] = null;
		}
	}
}

function selectAll() {
	for (i = 0; i < m2.length; i++) {
		m2.options[i].selected = true;
	}
	for (i = 0; i < m1.length; i++) {
		m1.options[i].selected = true;
	}
	for (i = 0; i < m5.length; i++) {
		m5.options[i].selected = true;
	}
	for (i = 0; i < m6.length; i++) {
		m6.options[i].selected = true;
	}
	for (i = 0; i < m9.length; i++) {
		m9.options[i].selected = true;
	}
	for (i = 0; i < m10.length; i++) {
		m10.options[i].selected = true;
	}

	return true;
}

function validateForm() {
	var e = [];
	if (document.forms[0].site_code.options[0].selected == true) {
		e.push("Sorry, you must select a site code.");
	}
	if (document.forms[0].network_id.options[0].selected == true) {
		e.push("Sorry, you must select a network.");
	}
	if (!defaultProductLinkExists()) {
		e.push("You must specify a default product link.");
	}
	if (e.length > 0) {
		eStr = e.join("\r\n");
		alert(eStr);
		return false;
	}
	else {
		document.forms[0].submit();
	}
	return true;
}

function defaultProductLinkExists() {
	var table = jQuery("#productLinksTable").DataTable();
	var rows = table.rows().data();

	var colLinkType = 4;
	var colDeviceType = 5;

	for (var i = 0; i < rows.length; i++) {
		var row = table.row(i).data();

		var linkType = row[colLinkType].toLowerCase();
		var deviceType = row[colDeviceType].toLowerCase();
		if (linkType === 'card' && deviceType === 'desktop') {
			return true;
		}
	}

	return false;
}


function siteHistory_one2two() {
	m3len = m3.length;
	m5len = m5.length;

	for (i = 0; i < m3len; i++) {
		if (m3.options[i].selected == true) {
			m4len = m4.length;
			m4.options[m4len] = new Option(m3.options[i].text);
			m4.options[m4len].value = m3.options[i].value;

			m6len = m6.length;
			m6.options[m6len] = new Option(m3.options[i].text);
			m6.options[m6len].value = m3.options[i].value;
		}
	}

	for (i = (m3len - 1); i >= 0; i--) {
		if (m3.options[i].selected == true) {
			for (j = (m5len - 1); j >= 0; j--) {
				if (m3.options[i].value == m5.options[j].value) {
					m5.options[j] = null;
				}
			}

			m3.options[i] = null;
		}
	}
}

function siteHistory_two2one() {
	m4len = m4.length;
	m6len = m6.length;
	for (i = 0; i < m4len; i++) {
		if (m4.options[i].selected == true) {
			m3len = m3.length;
			m3.options[m3len] = new Option(m4.options[i].text);
			m3.options[m3len].value = m4.options[i].value;

			m5len = m5.length;
			m5.options[m5len] = new Option(m4.options[i].text);
			m5.options[m5len].value = m4.options[i].value;
		}
	}
	for (i = (m4len - 1); i >= 0; i--) {
		if (m4.options[i].selected == true) {
			for (j = (m6len - 1); j >= 0; j--) {
				if (m4.options[i].value == m6.options[j].value) {
					m6.options[j] = null;
				}
			}

			m4.options[i] = null;
		}
	}
}

function excludes_one2two() {
	m7len = m7.length;
	m9len = m9.length;

	for (i = 0; i < m7len; i++) {
		if (m7.options[i].selected == true) {
			m8len = m8.length;
			m8.options[m8len] = new Option(m7.options[i].text);
			m8.options[m8len].value = m7.options[i].value;

			m10len = m10.length;
			m10.options[m10len] = new Option(m7.options[i].text);
			m10.options[m10len].value = m7.options[i].value;
		}
	}

	for (i = (m7len - 1); i >= 0; i--) {
		if (m7.options[i].selected == true) {
			for (j = (m9len - 1); j >= 0; j--) {
				if (m7.options[i].value == m9.options[j].value) {
					m9.options[j] = null;
				}
			}

			m7.options[i] = null;
		}
	}
}

function excludes_two2one() {
	m8len = m8.length;
	m10len = m10.length;
	for (i = 0; i < m8len; i++) {
		if (m8.options[i].selected == true) {
			m7len = m7.length;
			m7.options[m7len] = new Option(m8.options[i].text);
			m7.options[m7len].value = m8.options[i].value;

			m9len = m9.length;
			m9.options[m9len] = new Option(m8.options[i].text);
			m9.options[m9len].value = m8.options[i].value;
		}
	}
	for (i = (m8len - 1); i >= 0; i--) {
		if (m8.options[i].selected == true) {
			for (j = (m10len - 1); j >= 0; j--) {
				if (m8.options[i].value == m10.options[j].value) {
					m10.options[j] = null;
				}
			}

			m8.options[i] = null;
		}
	}
}
