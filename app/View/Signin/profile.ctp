
<div class="main">
  <header> &nbsp; </header>
  <div style="clear:both;">&nbsp;</div>
  
  <!--- New HTML Start -->
  
  <div id="tabs2" class="tabsDiv">
	<div class="middleContent">
    	<h2>Profile</h2>
        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
            	<tr><td colspan="3">&nbsp;</td></tr>
            	<tr>
                	<td valign="top" width="160">First Name</td>
                	<td valign="top" width="20">:</td>
                	<td><?php echo $user['first_name'];?></td>
                </tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				
				
                <tr>
                	<td valign="top" width="160">Last Name</td>
                	<td valign="top" width="20">:</td>
                	<td><?php echo $user['last_name'];?></td>
                </tr>
				<tr><td colspan="3">&nbsp;</td></tr>
                 <tr>
                	<td valign="top" width="160">Gender</td>
                	<td valign="top" width="20">:</td>
                	<td><?php echo $user['gender'];?></td>
                </tr>
            	<tr><td colspan="3">&nbsp;</td></tr>
            	<tr>
                	<td valign="top">Email</td>
                	<td valign="top">:</td>
                	<td><?php echo $user['email'];?></td>
                </tr>
            	<tr><td colspan="3" height="10"></td></tr>
				
				<tr><td colspan="3">&nbsp;</td></tr>
            	<tr>
                	<td valign="top">Image</td>
                	<td valign="top">:</td>
                	<td><img src="<?php echo 'http://graph.facebook.com/'.$user['id'].'/picture?type=normal'; ?>"></td>
                </tr>
            	<tr><td colspan="3" height="10"></td></tr>
            	
            	<tr><td colspan="3">&nbsp;</td></tr>
            </table>
    </div>
  </div>
  
  
</div>
</body>
</html>