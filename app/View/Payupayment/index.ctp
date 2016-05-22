<div class="main">
    <header> &nbsp; </header>
    <div style="clear:both;">&nbsp;</div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td colspan="5" height="100" style="text-align:center"><?php echo $this->Html->image('payment_loader.gif');?><br/>Don't click "REFRESH" and "BACK" button.  </td></tr>
</table>
<form action="<?php echo $params['url'];?>" method="post" id="payment">
<input type="hidden" name="firstname" value="<?php echo $params['firstname'];?>" />
<input type="hidden" name="lastname" value="<?php echo $params['lastname'];?>" />
<input type="hidden" name="surl" value="<?php echo $params['surl'];?>" />
<input type="hidden" name="phone" value="<?php echo $params['phone'];?>" />
<input type="hidden" name="key" value="<?php echo $params['key'];?>" />
<input type="hidden" name="hash" value = "<?php echo $params['hash'];?>" />
<!--<input type="hidden" name="curl" value="<?php echo $params['url'];?>" />-->
<input type="hidden" name="furl" value="<?php echo $params['furl'];?>" />
<input type="hidden" name="txnid" value="<?php echo $params['txnid'];?>" />
<input type="hidden" name="productinfo" value="<?php echo $params['productinfo'];?>" />
<input type="hidden" name="amount" value="<?php echo $params['amount'];?>" />
<input type="hidden" name="email" value="<?php echo $params['email'];?>" />
</form>

<script>
$(document).ready(function(){
	$('#payment').submit();
});
</script>
</div>