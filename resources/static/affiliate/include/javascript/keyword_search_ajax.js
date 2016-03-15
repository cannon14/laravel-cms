var req;

//Starts the AJAX request - called from keyup on the search textbox.
function searchSuggest()
{
	var str = escape(document.getElementById("suggestTerm").value);
	var url = "/affiliate/scripts/keywordSuggest.php?keyword=" + str;
	
	if (window.XMLHttpRequest)
	{
		req = new XMLHttpRequest();
        req.onreadystatechange = handleSearchSuggest;
        req.open("GET", url, true);
        req.send(null);
        
    // branch for IE/Windows ActiveX version
    } else if (window.ActiveXObject) {
        isIE = true;
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = handleSearchSuggest;
            req.open("GET", url, true);
            req.send();
        }
    }
}

//Called when the AJAX response is returned.
function handleSearchSuggest()
{
    if (req.readyState == 4)
	{
		if (req.status == 200)
		{
			
			var ret = req.responseText.split("|,|");
			
			var ss = document.getElementById('search_suggest');
	        ss.innerHTML = '';
	
	        var str = ret[0].split("\n");
	        for(i=0; i < str.length - 1; i++)
			{
	            //Build our element string.  This is cleaner using the DOM, but
	            //IE doesn't support dynamically added attributes.
	            var suggest = '<div onmouseover="javascript:suggestOver(this);" ';
	            suggest += 'onmouseout="javascript:suggestOut(this);" ';
	            suggest += 'onclick="javascript:setSearch(this.innerHTML);" ';
	            suggest += 'class="suggest_link">' + str[i] + '</div>';
	            ss.innerHTML += suggest;
			}
			
			var rc = document.getElementById("result_count");
	        rc.innerHTML = '';
			//Build our element string.  This is cleaner using the DOM, but
			//IE doesn't support dynamically added attributes.
	
			var count = ret[1];
			count = (count==undefined ? "0" : count);
			
			rc.innerHTML = "# Records: <strong>" + count + "</strong>";
			
		} else {
			alert("There was a problem retrieving the data:\n" + req.statusText);
		}
    }
}

//Mouse over function
function suggestOver(div_value) {
    div_value.className = "suggest_link_over";
}
 
//Mouse out function
function suggestOut(div_value) {
    div_value.className = "suggest_link";
}

function clearSearchPopup()
{
	document.getElementById("search_suggest").innerHTML = "";
    document.getElementById("result_count").innerHTML = "";
}

function validateKeywordFields()
{
	if(document.getElementById("suggestTerm").value == '')
	{
    	document.getElementById("rt_keywordId").value = '';
    }
}

//Click function
function setSearch(value)
{
	var split = value.split(" - ");
	
	//add hidden var for keyword id
	document.getElementById("rt_keywordId").value = split[1];
    //add keyword text to search box
    document.getElementById("suggestTerm").value = split[0];
    
    clearSearchPopup();
    validateKeywordFields();
}