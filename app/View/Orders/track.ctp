<div class="main">
<header> &nbsp; </header>
<div style="clear:both;">&nbsp;</div>

<!--- New HTML Start -->

<div id="tabs2" class="tabsDiv ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible" >
<div id="" class="tabsDiv">
	<div class="middleContent">
    	<h2>Account Dashboard</h2>
        <p> Manage your personal information and track your orders by clicking the sections below. Your Order items are not the same as your cart items(link at the top of this page).
The cart is the set of items that have been readied for purchase but have not been paid for. </p>
    </div>
  </div>
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a  href="<?php echo BASE_URL ?>signin/details"  class="ui-tabs-anchor">PERSONAL DETAILS</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/address_book"  class="ui-tabs-anchor">Address Book</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a  class="ui-tabs-anchor">My Order</a></li>
<li class="ui-state-default ui-corner-top ui-tabs-active ui-state"><a href="<?php echo BASE_URL ?>signin/wishlist"  class="ui-tabs-anchor">Wishlist</a></li>
</ul>
<div id="tabs-1" class="">
<p></p>
<div class="account_details">
<?php 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://www.bluedart.com/servlet/RoutingServlet?handler=tnt&action=custawbquery&loginid=BOM00001&awb=awb&numbers=".$this->request->query['id']."&format=html&lickey=4ecbd06dc0b9737d69120029cb05c9df&verno=1.3f&scan=1");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);
	echo $server_output;
	curl_close ($ch);
?>
  </div>
  </div>
  </div>
  <div style="clear:both;">&nbsp;</div>
  


</body>
</html>
