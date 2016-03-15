<?
$sortableLists = new csCore_UI_SLListsYui('../cmsCore/include/csCore/JS/yui_2_6');
$sortableLists->printTopJS();
?>

<script>

function submitCatForm( form )
{
    var ul = document.getElementById("ul2");
    var items = ul.getElementsByTagName("li");
    var values = '';
    
    for ( i=0; i < items.length; i=i+1 )
    {
        var id = items[i].id;
        id = id.replace(/li1_/, "");
        id = id.replace(/li2_/, "");
        
        values += id;
        
        if ( i != items.length )
        {
            values += ',';
        }
    }
    
    form.assignedCategories.value = values;
    return true;
}  
</script>

<style type="text/css">
body {
    margin:0;
    padding:0;
}

ul.draglist { 
    position: relative;
    width: 300px; 
    height:500px;
    background: #f7f7f7;
    border: 1px solid gray;
    list-style: none;
    margin:0;
    padding:0;
    overflow: auto;
}

ul.draglist li {
    margin: 1px;
    cursor: move;
    zoom: 1;
    padding: 2px;
}

li.list1 {
    background-color: #D1E6EC;
    border:1px solid #7EA6B2;
}

li.list2 {
    background-color: #D8D4E2;
    border:1px solid #6B4C86;
}
</style>
<? 

if($_POST['runQuery'] == null){	
?>
<form action="index.php" method="get" name="update" onSubmit="javascript: return submitCatForm(this);">
	    
    <table class="component" align="center">
        <tr>
            <td class="componentHead">Manage Cards Categories for <?= $_POST['cardCategoryGroupInfo']['card_category_group_name'] ?></td>
        </tr>
        <tr>
            <td>
                <table align="center">
				<tr>
					<td align="center" width="50%" colspan="2"><b>Unassigned Card Categories</b></td>
					<td align="center" width="50%" colspan="2"><b>Assigned Card Categories</b></td>
				</tr>
				<tr>
		            <td colspan="2" width="50%" valign="top">
					    
					    <ul id="ul1" class="draglist">
					    
							<?foreach($this->unassignedCategories as $category){ ?>
								<li class="list1" id="li1_<?=$category['id']?>"><?=$category['name']?> [<?=$category['id']?>]</li>
							<? } ?>
					    
					    </ul>
					    
					</td>
					<td colspan="2" width="50%" valign="top">
		
		                <ul id="ul2" class="draglist">
						
							<?
							   $count = 1;
							   foreach($this->assignedCategories as $category) {
						    ?>
							   
								<li class="list2" id="li2_<?=$category['id']?>"><div id="rank" style="float: left; width: 25px;"><?=$count ?>.</div><?=$category['name']?> [<?=$category['id']?>]</li>
							<? 
							   $count++;
							   }
							?>
					    
					    </ul>
		            
					</td> 
				</tr>
				<tr>
					<td colspan="4" style="text-align: right;">
						<input class="formbutton" type="button" value="<< Back to Groups" onClick="goToMod('CMS_view_cardCategoryGroups')" style="margin-right: 25px; height: 25px;" />
						<input type="submit" value="Save" style="width: 100px; height: 25px; font-weight: bold;" />
					</td>
				</tr>
                </table>
            </td>
        </tr>
    </table>

<input type=hidden name=tmdl_status value="<?=$_REQUEST['tmdl_status']?>">
<input type="hidden" name="assignedCategories" value="" /> 
<input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
<input type=hidden name=id value='<?=$_REQUEST['id']?>'>
<input type="hidden" name="action" value="updateCardCategoryGroups" />
<input type=hidden name=commited value='yes'>
</form>

<script type="text/javascript">
(function() {

var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;
var DDM = YAHOO.util.DragDropMgr;

//////////////////////////////////////////////////////////////////////////////
// example app
//////////////////////////////////////////////////////////////////////////////
YAHOO.example.DDApp = {
    init: function() {
        
        //init lists
        new YAHOO.util.DDTarget("ul1");
        new YAHOO.util.DDTarget("ul2");
        
        //init list 1 items
        <?foreach($this->unassignedCategories as $category){ ?>
            new YAHOO.example.DDList("li1_<?=$category['id']?>");
        <? } ?>
        
        //init list 2 items
        <?foreach($this->assignedCategories as $category){ ?>
            new YAHOO.example.DDList("li2_<?=$category['id']?>");
        <? } ?>
    },

    showOrder: function() {
        var parseList = function(ul, title) {
            var items = ul.getElementsByTagName("li");
            var out = title + ": ";
            for (i=0;i<items.length;i=i+1) {
                out += items[i].id + " ";
            }
            return out;
        };

        var ul1=Dom.get("ul1"), ul2=Dom.get("ul2");
        alert(parseList(ul1, "List 1") + "\n" + parseList(ul2, "List 2"));

    }
};

//////////////////////////////////////////////////////////////////////////////
// custom drag and drop implementation
//////////////////////////////////////////////////////////////////////////////

YAHOO.example.DDList = function(id, sGroup, config) {

    YAHOO.example.DDList.superclass.constructor.call(this, id, sGroup, config);

    this.logger = this.logger || YAHOO;
    var el = this.getDragEl();
    Dom.setStyle(el, "opacity", 0.67); // The proxy is slightly transparent

    this.goingUp = false;
    this.lastY = 0;
};

YAHOO.extend(YAHOO.example.DDList, YAHOO.util.DDProxy, {

    startDrag: function(x, y) {
        this.logger.log(this.id + " startDrag");

        // make the proxy look like the source element
        var dragEl = this.getDragEl();
        var clickEl = this.getEl();
        Dom.setStyle(clickEl, "visibility", "hidden");

        dragEl.innerHTML = clickEl.innerHTML;

        Dom.setStyle(dragEl, "color", Dom.getStyle(clickEl, "color"));
        Dom.setStyle(dragEl, "backgroundColor", Dom.getStyle(clickEl, "backgroundColor"));
        Dom.setStyle(dragEl, "border", "2px solid gray");
    },

    endDrag: function(e) {

        var srcEl = this.getEl();
        var proxy = this.getDragEl();

        // Show the proxy element and animate it to the src element's location
        Dom.setStyle(proxy, "visibility", "");
        var a = new YAHOO.util.Motion( 
            proxy, { 
                points: { 
                    to: Dom.getXY(srcEl)
                }
            }, 
            0.2, 
            YAHOO.util.Easing.easeOut 
        )
        var proxyid = proxy.id;
        var thisid = this.id;

        // Hide the proxy and show the source element when finished with the animation
        a.onComplete.subscribe(function() {
                Dom.setStyle(proxyid, "visibility", "hidden");
                Dom.setStyle(thisid, "visibility", "");
            });
        a.animate();
        
        /*
        //set sort order of items
        var ul = Dom.get("ul2");
        var tags = ul.getElementsByTagName("li");
        
        for(i=0; i<tags.length; i++)
        {
            //alert(tags[i]);
            
            //tags[i].getChildren("rank").innerHTML = "sdf";
            alert(getChildren(tags[i]));
        }
        */
    },

    onDragDrop: function(e, id) {

        // If there is one drop interaction, the li was dropped either on the list,
        // or it was dropped on the current location of the source element.
        if (DDM.interactionInfo.drop.length === 1) {

            // The position of the cursor at the time of the drop (YAHOO.util.Point)
            var pt = DDM.interactionInfo.point; 

            // The region occupied by the source element at the time of the drop
            var region = DDM.interactionInfo.sourceRegion; 

            // Check to see if we are over the source element's location.  We will
            // append to the bottom of the list once we are sure it was a drop in
            // the negative space (the area of the list without any list items)
            if (!region.intersect(pt)) {
                var destEl = Dom.get(id);
                var destDD = DDM.getDDById(id);
                destEl.appendChild(this.getEl());
                destDD.isEmpty = false;
                DDM.refreshCache();
            }

        }
    },

    onDrag: function(e) {

        // Keep track of the direction of the drag for use during onDragOver
        var y = Event.getPageY(e);

        if (y < this.lastY) {
            this.goingUp = true;
        } else if (y > this.lastY) {
            this.goingUp = false;
        }

        this.lastY = y;
    },

    onDragOver: function(e, id) {
    
        var srcEl = this.getEl();
        var destEl = Dom.get(id);

        // We are only concerned with list items, we ignore the dragover
        // notifications for the list.
        if (destEl.nodeName.toLowerCase() == "li") {
            var orig_p = srcEl.parentNode;
            var p = destEl.parentNode;

            if (this.goingUp) {
                p.insertBefore(srcEl, destEl); // insert above
            } else {
                p.insertBefore(srcEl, destEl.nextSibling); // insert below
            }

            DDM.refreshCache();
        }
    }
});

Event.onDOMReady(YAHOO.example.DDApp.init, YAHOO.example.DDApp, true);

})();
</script>

<? } ?>