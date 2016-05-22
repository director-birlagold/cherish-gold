<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr><td align="right" valign="top" width="230" class="sidepromenu">
            <?php echo $this->Element('admin_order_leftsidebar'); ?></td>
        <td align="left" valign="top">

            <div id="content"  class="clearfix">			
                <div class="container">

                    <div align="right" style="padding-right:50px;">
                        <?php 
                        $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $orderdetails['Order']['user_id']))); 
                        if ($user['User']['user_type'] == '0') {
                            echo $this->Html->link('Back to Vendor Brokerage', array('action' => 'vendors_brokerage'), array('class' => 'button'));
                        } elseif ($user['User']['user_type'] == '1') {
                            echo $this->Html->link('Back to Franchisee Brokerage', array('action' => 'franchisee_brokerage'), array('class' => 'button'));
                        }
                        ?>
                        <?php echo $this->Html->link('Back to Order Details', array('action' => 'order_index'), array('class' => 'button')); ?>
                    </div>   
                    <div class="texttabBox"> 
                        <form>       	
                            <fieldset>
                                <legend>User  Details</legend>
                                <dl class="inline">
                                    <table width="600" align="left">
                                        <tr><td width="150"><strong>Type</strong></td>                    
                                            <td><p><?php
                                                    if ($user['User']['user_type'] == '0') {
                                                        echo 'User';
                                                    } elseif ($user['User']['user_type'] == '1') {
                                                        echo 'Franchisee';
                                                    }
                                                    ?></p></td></tr>

                                        <tr><td width="150"><strong>First Name</strong></td>                    
                                            <td><p><?php
                                                    $firstname = h($user['User']['first_name']);
                                                    if (!empty($firstname))
                                                        echo $firstname;
                                                    else
                                                        '-';
                                                    ?></p></td></tr>
                                        <tr><td width="150"><strong>Last Name</strong></td>                    
                                            <td><p><?php
                                                    $lastname = h($user['User']['last_name']);
                                                    if (!empty($lastname))
                                                        echo $lastname;
                                                    else
                                                        '-';
                                                    ?></p></td></tr>

                                        <tr><td width="150"><strong>Date of Birth</strong></td>                    
                                            <td><p><?php
                                                    $dobf = h($user['User']['date_of_birth']);
                                                    $dob = date("Y-m-d", strtotime($dobf));
						  if(!empty($dobf))echo $dob; else echo '-';  ?></p></td></tr>
                                                     

                                        <tr><td width="150"><strong>Email</strong></td>                    
                                            <td><p><?php
                                                    $email = h($user['User']['email']);
                                                    if (!empty($email))
                                                        echo $email;
                                                    else
                                                        '-';
                                                    ?></p></td></tr>

                                        <tr><td width="150"><strong>Phone Number</strong></td>                    
                                            <td><p><?php
                                                    $phone = h($user['User']['phone_no']);
                                                    if (!empty($phone))
                                                        echo $phone;
                                                    else
                                                        '-';
                                                    ?></p></td></tr>

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
