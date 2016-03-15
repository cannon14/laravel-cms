            </div>
        </td>
    </tr>

    <!--  CreditCards.com column 3 -->
</table>
<!--  CreditCards.com  botnav begins here -->
<table border="0" align="center" cellpadding="0" cellspacing="0" id="footer">
    <tr>
        <td>Copyright <? echo date("Y"); ?> CreditCards.com</td>
		
        <td align="right"><a href="http://www.creditcards.com/about-us.php" target="_blank">About Us</a> | <a href="http://www.creditcards.com/SSL-Security.php" target="_blank">Site Security Policy</a> | <a href="http://www.creditcards.com/privacy.php" target="_blank">Privacy Policy</a> | <a href="http://www.creditcards.com/terms.php" target="_blank">Terms of Use</a></td>
    </tr>
</table>
<br />
<div id="8e14851f-6d2b-497f-aa08-6f6bf9caf9d6" style="text-align: center;">
    <script type="text/javascript" src="//privacy-policy.truste.com/privacy-seal/CreditCards-Com/asc?rid=8e14851f-6d2b-497f-aa08-6f6bf9caf9d6"></script>
    <a href="//privacy.truste.com/privacy-seal/CreditCards-Com/validation?rid=1498e526-b56b-441b-af26-690b97b6d8f4" title="TRUSTe online privacy certification" target="_blank">
        <img style="border: none; height: 40px;" src="//privacy-policy.truste.com/privacy-seal/CreditCards-Com/seal?rid=1498e526-b56b-441b-af26-690b97b6d8f4" alt="TRUSTe online privacy certification"/></a>
        </div>
<br />
<div id="advertising_disclosure_footer"><img src="/images/advertising-disclosure/disclosure_footer.png"></div>
<div id="international-nav-container">
    <!--
<table width="790" border="0" align="center" cellpadding="0" cellspacing="0" id="international-nav">
    <tr>
        <td style="text-align: left;">&nbsp;</td>
        <td style="text-align: right;">
            <div class="bookmark"><a href="http://www.creditcards.com/tell-a-friend.php">Tell a Friend</a></div>
        </td>
    </tr>
</table>
    -->
</div>

<div id="toolTipLayer" style="position:absolute; z-index:5000; visibility:hidden; border: 2px solid #ff0000; background-color: #fff; padding: 7px;" onmouseover="javascript:hideToolTip=false;" onmouseout="javascript:hideToolTip=true; setTimeout('toolTip()', 1500);"></div>
<iframe id="DivShim" src="javascript:false;" scrolling="no" frameborder="0" style="position:absolute; top:0px; left:0px; display:none;"></iframe>

<script language="JavaScript" src="js/tooltip.js" type="text/javascript"></script>
<script type="text/javascript">
    initToolTips();
    jQuery(document).ready(function($){
                $(".advertising_disclosure_link>a").click(function(e){
                                    e.preventDefault();
                                                    $(this).parent().siblings('.advertising_disclosure_text').show();
                                            });
                        $(".advertising_disclosure_text>div>a.close_adtext").click(function(e){
                                            e.preventDefault();
                                                            $(this).parent().parent().hide();
                                                    });
    });
</script>
<script type="text/javascript">
jQuery(document).ready(function($){
	$(".advertising_disclosure_link>a").click(function(e){
		e.preventDefault();
		$(this).parent().siblings('.advertising_disclosure_text').show();
	});
	$(".advertising_disclosure_text>div>a.close_adtext").click(function(e){
		e.preventDefault();
		$(this).parent().parent().hide();
	});
});
</script>
<?
echo "<IMG SRC='//".$_SERVER['HTTP_HOST']."/xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";
?>

</body>
</html>
