var ns4 = document.layers;
var ns6 = document.getElementById && !document.all || (navigator.userAgent.indexOf('Opera') >= 0);
var ie4 = document.all;

var requester = null;

var offsetX = 0;
var offsetY = 20;
var toolTipSTYLE="";
var CAPTION='cap';
var FG='fg';
var BG='bg';
var TEXTCOLOR='tc';
var CAPTIONCOLOR='cc';
var WIDTH='tw';
var HEIGHT='th';
var FONT='font';
var POSITIONY='posy';
var hideToolTip=true;
var cap, fg, bg, tc, cc, tw, th, font, posy = 0;

function initToolTips() {
    if(ns4||ns6||ie4) {
        if(ns4) toolTipSTYLE = document.toolTipLayer;
        else if(ns6) toolTipSTYLE = document.getElementById("toolTipLayer").style;
        else if(ie4) toolTipSTYLE = document.all.toolTipLayer.style;
        if(ns4);
        else {
            toolTipSTYLE.visibility = "visible";
            toolTipSTYLE.display = "none";
        }
    }
}

function showLoadedData() {
    var msg = 'ERROR';
    if (requester.readyState == 4) {
        if (requester.status == 200) {
            msg = requester.responseText;
        } else {
            msg = "ERROR loading details";
        }
    }
    document.getElementById('infoDivTextRow').innerHTML = msg;
    return true;
}

function toolTipHide() {
    if(ns4) {
        toolTipSTYLE.visibility = "hidden";
    } else {
        toolTipSTYLE.display = "none";
        var IfrRef = document.getElementById('DivShim');
        IfrRef.style.display = "none";
    }
}

function toolTip() {

	if(arguments.length < 1) { // hide
        if (hideToolTip == false) {
            return;
        }
        if(ns4) {
            toolTipSTYLE.visibility = "hidden";
        } else {
            toolTipSTYLE.display = "none";
            var IfrRef = document.getElementById('DivShim');
            IfrRef.style.display = "none";
        }
    } else { // show
        e = arguments[0];
        var msg = arguments[1];

		var type = arguments[2];
        fg = "#000000";
        bg = "#DDDDDD";
        tc = "#000000";
        cc= "#FFFFFF";
        font = "Verdana,Arial,Helvetica";
        tw = '';
        th = '';
        cap = '';
        posy = 0;
        for(var i = 3; i < arguments.length; i+=2) {
            switch (arguments[i]) {
                case "cap": cap = arguments[i+1]; break;
                case "font": font = arguments[i+1]; break;
                case "fg": fg = arguments[i+1]; break;
                case "bg": bg = arguments[i+1]; break;
                case "tc": tc = arguments[i+1]; break;
                case "cc": cc = arguments[i+1]; break;
                case "tw": tw = arguments[i+1]; break;
                case "th": th = arguments[i+1]; break;
                case "posy": posy = arguments[i+1]; break;
            }
        }
        var imgdir = 'images/';
        var content = '';
		titletext = 'Details';

		content = '<div style="width: ' + tw + 'px;">' + msg + '</div>';

		if(ns4) {
            toolTipSTYLE.document.write(content);
            toolTipSTYLE.document.close();
            toolTipSTYLE.visibility = "visible";
        } else if(ns6) {
            moveToMouseLoc(arguments[5]);
            document.getElementById("toolTipLayer").innerHTML = content;
            toolTipSTYLE.display='block';
        } else if(ie4) {
            moveToMouseLoc(arguments[5]);
            document.all("toolTipLayer").innerHTML=content;
            toolTipSTYLE.display='block';
            var IfrRef = document.getElementById('DivShim');
            var DivRef = document.getElementById('toolTipLayer');
            IfrRef.style.width = DivRef.offsetWidth;
            IfrRef.style.height = DivRef.offsetHeight;
            IfrRef.style.top = DivRef.style.top;
            IfrRef.style.left = DivRef.style.left;
            IfrRef.style.zIndex = DivRef.style.zIndex - 1;
            IfrRef.style.display = "block";
        }
    }
}

function moveToMouseLoc(thisObj) {

	var pos = jQuery(thisObj).offset();
	var popupLeft = pos.left+20;
	var popupTop = pos.top+20;

    toolTipSTYLE.left = popupLeft + "px";
    toolTipSTYLE.top  = popupTop + "px";

    return true;
}