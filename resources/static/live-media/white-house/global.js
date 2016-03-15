function toggleTip(link) {
    var ref = document.getElementById("linkCodeDiv");
    var currentDisplay = ref.style.display;
    if(currentDisplay == "block") {
        ref.style.display = "none";
        
        //update link text
        link.innerHTML = '<img src="/images/icn_link.gif" align="absmiddle"><a href="javascript:;">Link to this page</a>';
    } else {
        ref.style.display = "block";
        
        //update link text
        link.innerHTML = '<img src="/images/icn_link.gif" align="absmiddle"><a href="javascript:;">Close code box</a>';
    }
}

function inviteFriend(){
    window.location = "mailto:?subject=White House Town Hall on Credit Card Reform&body=An online town hall event with a live video feed from the White House: http://www.creditcards.com/askthewhitehouse. Coming on Monday, Feb. 22, at 2 p.m. Eastern.";
}

function launchViewer() {
    
    window.open('viewer.php', 'whitehouse', 'width=430,height=422,status=0');
    
    var out = '<div class="video-paused"><a href="javascript:;" onclick="javascript:playVideo();">Play Video</a><br /><br /><a href="javascript:;" onclick="javascript:playVideo();"><img src="/live-media/images/icn-play.gif" border="0" style="text-decoration: none;" /></a></div>';
    
    document.getElementById('video-object').innerHTML = out;
}

function playVideo() {
    
    var out = '<object width="415" height="260"><param name="movie" value="http://www.whitehouse.gov/sites/default/modules/wh_multimedia/EOP_OVP_player.swf"></param><param name="allowScriptAccess" value="always"></param><param name="wmode" value="opaque"></param><param name="bgcolor" value="#FFFFFF"></param><param name="scale" value="showall"></param><param name="quality" value="best"></param><param name="align" value="l"></param><param name="allowfullscreen" value="true"></param><param name="play" value="false"></param><param name="menu" value="false"></param><param name="loop" value="false"></param><param name="flashvars" value="player=http://www.whitehouse.gov/sites/default/modules/wh_multimedia/EOP_OVP_player.swf&src=rtmp://cp68969.live.edgefcs.net/live/WHLive3@4855&scaleMode=stretch&link=&path_to_image=http://www.whitehouse.gov/sites/default/themes/whitehouse/img/facebook_bubble.gif&width=415&height=260"></param><embed src="http://www.whitehouse.gov/sites/default/modules/wh_multimedia/EOP_OVP_player.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" menu="false" width="415" height="260" flashvars="player=http://www.whitehouse.gov/sites/default/modules/wh_multimedia/EOP_OVP_player.swf&src=rtmp://cp68969.live.edgefcs.net/live/WHLive3@4855&scaleMode=stretch&link=&path_to_image=http://www.whitehouse.gov/sites/default/themes/whitehouse/img/facebook_bubble.gif&width=415&height=260"></embed></object>';
    
    document.getElementById('video-object').innerHTML = out;
}