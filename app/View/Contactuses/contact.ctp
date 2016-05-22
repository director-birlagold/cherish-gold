<div class="main">
  <header> &nbsp; </header>
  <div style="clear:both;">&nbsp;</div>
  
  <!--- New HTML Start -->
  
  <div id="tabs2" class="tabsDiv">
	<div class="middleContent">
    	<h2><?php echo $static['Staticpage']['pagename'];?></h2>
        	<p>Allow us to meet you and serve you better! Please provide us with your contact details so that we can arrange our meeting.</p>
			<p>&nbsp;</p>
            <div class="contactUsDiv">
            	<div class="contactLeft">
                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                    	
                        <?php echo $static['Staticpage']['pagecontent'];?>
                       
                        <tr><td colspan="2">&nbsp;</td></tr>
                        
                        <tr>
                        	<td colspan="2"><h2> &nbsp;&nbsp; &nbsp;&nbsp;Fill Enquiry Form</h2></td>
                        </tr>
 					
                        <tr>
                        	<td colspan="2">
                             <form method="post" name="contactus" id="contactus">
                                    <div class="contact">
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr><td colspan="3" height="10"></td></tr>
                                   
                                	<tr>
                                    	<td width="90">To Become </td>
                                    	<td width="20">:</td>
                                    	<td><select style="width:268px;" name="data[Contactus][type]" class="validate[required]"><option>Select</option>
                                        <option value="User">User</option>
                                        <option value="Franchisee">Franchisee</option>
                                        <option value="Vendor">Vendor</option>
                                        </select></td>
                                    </tr>
                                    <tr><td colspan="3" height="10"></td></tr>
                                	<tr>
                                    	<td>Name * </td>
                                    	<td>:</td>
                                    	<td><input style="width:250px;" type="text" name="data[Contactus][name]" class="validate[required]" value=""></td>
                                    </tr>
                                    <tr><td colspan="3" height="10"></td></tr>
                                	<tr>
                                    	<td>Mobile No.*  </td>
                                    	<td>:</td>
                                    	<td><input style="width:250px;" type="text" name="data[Contactus][mobile]" class="validate[required,custom[integer],maxSize[10]] mobile" onkeypress="return intnumbers(this, event)" value=""></td>
                                    </tr>
                                    <tr><td colspan="3" height="10"></td></tr>
                                	<tr>
                                    	<td>Email ID * </td>
                                    	<td>:</td>
                                    	<td><input style="width:250px;" type="text" name="data[Contactus][email]" class="validate[required,custom[email]]" value=""></td>
                                    </tr>
                                    
                                    <tr><td colspan="3" height="10"></td></tr>
                                	<tr>
                                    	<td>Message * </td>
                                    	<td>:</td>
                                    	<td><textarea style="width:250px;" name="data[Contactus][query]" class="validate[required]" value=""></textarea></td>
                                    </tr>

                                    <tr><td colspan="3" height="10"></td></tr>
                                	<tr>
                                    	<td>City * </td>
                                    	<td>:</td>
                                    	<td><input style="width:250px;" type="text" name="data[Contactus][city]" class="validate[required]" value=""></td>
                                    </tr>

                                    <tr><td colspan="3">&nbsp;</td></tr>
                                	<tr>
                                    	<td>&nbsp;</td>
                                    	<td>&nbsp;</td>
                                    	<td> <input type="hidden" name="data[Contactus][contactsubmit]" value="" />
                                        <button type="submit" value="Submit" class="button" id="button"/>Submit</button></td>
                                    </tr>
                                    
                                    <tr><td colspan="3" height="10"></td></tr>
                                </table>
                                </div>
                                    </form>
                            </td>
                        </tr>
                        
                    </table>
                </div>
            	<div class="contactRight">
                	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3769.2324643696766!2d72.83318!3d19.141299!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b63c7d160f4d%3A0x1468944bedb41a71!2sBirla+Capital+and+Financial+Services+Limited%2C+Morya+Landmark+II%2C+Office+No.+G-002%2C+Ground+Floor%2C!5e0!3m2!1sen!2sin!4v1419148257336" width="748" height="470" frameborder="0" style="border:0"></iframe>
                </div>
            </div>
    </div>
  </div>
  <?php echo $this->Element('newsletter');?>
   <script>
        $(document).ready(function () {
            $("#contactus").validationEngine();
		});
			</script>