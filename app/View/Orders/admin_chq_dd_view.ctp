<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align="right" valign="top" width="230" class="sidepromenu">
<?php echo $this->Element('admin_order_leftsidebar'); ?></td>
<td align="left" valign="top">

<div id="content"  class="clearfix">			
    <div class="container">
    
        <div align="right" style="padding-right:50px;"><?php echo $this->Html->link('Back to Order Details',array('action'=>'order_index'),array('class'=>'button')); ?></div>   
        <div class="texttabBox"> 
            <form name="Paymentdetails" method="post" id="myForm">       	
           <fieldset><legend>CHQ/DD  Details</legend>
            			 <dl class="inline">
                         
                             <table width="600" align="left" >
                               <tr><td width="200" valign="top"><strong> Cheque / Demand Draft Number</strong></td><td>
                            <p><dd><input type="text" name="data[Paymentdetails][chq/dd]" id=""  class="validate[required]" size="50" 
                            value="<?php if(empty($paymentaldetails['Paymentdetails']['chq/dd'])){echo '';}else{echo $paymentaldetails['Paymentdetails']['chq/dd'];}?>"/></dd></p>
                            </td></tr>
                              <tr><td width="200"  valign="top"><strong>Bank Name </strong></td><td>
                            <p><dd><input type="text" name="data[Paymentdetails][bankname]" id=""  class="validate[required]" size="50"
                             value="<?php if(empty($paymentaldetails['Paymentdetails']['bankname'])){echo '';}else{echo $paymentaldetails['Paymentdetails']['bankname'];}?>"/></dd></p>
                            </td></tr>
                              <tr><td width="200"  valign="top"><strong> Bank  Branch</strong></td><td>
                            <p><dd><input type="text" name="data[Paymentdetails][bankbranch]" id=""  class="validate[required]" size="50"
                             value="<?php if(empty($paymentaldetails['Paymentdetails']['bankbranch'])){echo '';}else{echo $paymentaldetails['Paymentdetails']['bankbranch'];}?>"/></dd></p>
                            </td></tr>
                              <tr><td width="200"  valign="top"><strong> Amount</strong></td><td>
                            <p><dd><input type="text" name="data[Paymentdetails][amount]" id=""  class="validate[required,custom[number]]" size="50"
                             value="<?php if(empty($paymentaldetails['Paymentdetails']['amount'])){echo '';}else{echo $paymentaldetails['Paymentdetails']['amount'];}?>"/></dd></p>
                            </td></tr>
                                                   
                             <tr><td colspan="2" align="center">
                            <input type="hidden" name="data[Paymentdetails][chkdd]" id=""  value="0" size="50"/>
                             <button type="submit"  class="button " name="data[Paymentdetails][chkdd]" value="">Submit</button></td></tr>
                             </table>             
                         
                         </dl>
                               
                        
            </fieldset>
            </form>
          </div>
       </div> 
    </div>
</div>
</td>
</tr>
</table>
