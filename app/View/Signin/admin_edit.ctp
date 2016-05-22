
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align="right" valign="top" width="230" class="sidepromenu">
<?php echo $this->Element('admin_leftsidebar'); ?></td>
<td align="left" valign="top">

<div id="content"  class="clearfix">			
    <div class="container">
    
        <div align="right" style="padding-right:50px;"><?php echo $this->Html->link('Back to User',array('action'=>'index'),array('class'=>'button')); ?></div>   
        <div class="texttabBox"> 
         <?php echo $this->Form->create('User',array('id'=>'myForm','type' => 'file','inputDefaults' => array ('fieldset' => false, 'legend' => false))); ?>    
      <fieldset>
        <legend>Personal Details </legend>
        <dl class="inline">
       <dt><label for="name">Title</label></dt>
          <dd><p><?php if(!empty($this->request->data['User']['title'])) { echo $this->request->data['User']['title'];  } else { echo '-'; }?></p> </dd>
          
          <dt><label for="name">First Name</label></dt>
          <dd><p><?php if(!empty($this->request->data['User']['first_name'])) { echo $this->request->data['User']['first_name'];  } else { echo '-'; }?></p></dd>
          
          <dt><label for="name">Last Name</label></dt>
          <dd><p><?php if(!empty($this->request->data['User']['last_name'])) { echo $this->request->data['User']['last_name'];  } else { echo '-'; }?></p></dd>
          
          
          <dt><label for="name">Mobile Number</label></dt>
          <dd><p><?php if(!empty($this->request->data['User']['phone_no'])) { echo $this->request->data['User']['phone_no'];  } else { echo '-'; }?></p></dd>
          
          <dt><label for="name">Email-ID</label></dt>
          <dd><p><?php if(!empty($this->request->data['User']['email'])) { echo $this->request->data['User']['email'];  } else { echo '-'; }?></p></dd>
          
           <dt><label for="name">Address</label></dt>
          <dd><p><?php if(!empty($this->request->data['User']['address'])) { echo $this->request->data['User']['address'];  } else { echo '-'; }?></p></dd>
               <?php
                  $key= $this->request->data['User']['date_of_birth'];
				  
                    $pattern = "/(\d+)/";
                    
                    $array = preg_split($pattern, $key, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
					
                    ?>
            	<dt><label for="name">Birthday</label></dt>
             <dd><p><?php if(!empty($this->request->data['User']['date_of_birth']) && count($array) >=3) { echo $array[0];?>&nbsp;<?php echo $array[1].' '.$array[2].' '.$array[3].' '.$array[4]; } else { echo '-'; }?></p></dd>
                 <?php
                  $key= $this->request->data['User']['anniversary'];
                    $pattern = "/(\d+)/";
                    
                    $arraynew = preg_split($pattern, $key, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
					
                    ?>
             
                 <dt class="anniversary" <?php if($this->request->data['User']['title']=='Miss') { echo 'style="display:none";'; } ?>><label for="name">Anniversary</label></dt>
            	<dd class="anniversary" <?php if($this->request->data['User']['title']=='Miss') { echo 'style="display:none";'; } ?>>
                <p><?php if(!empty($this->request->data['User']['anniversary']) && count($arraynew) >=3) { echo $arraynew[0];?>&nbsp;<?php echo $arraynew[1].' '.$arraynew[2].' '.$arraynew[3].' '.$arraynew[4]; } else { echo '-'; }?></p></dd>
                
               <dt><label for="name">Status</label></dt>
          <dd><select name="data[User][status]" id="status">
          <option value="Active" <?php if(isset($this->request->data['User']['status']) && $this->request->data['User']['status']=='Active'){ echo 'selected="selected"';}?> >Active</option>
          <option value="Inactive" <?php if(isset($this->request->data['User']['status']) && $this->request->data['User']['status']=='Inactive'){ echo 'selected="selected"';}?> >Inactive</option>
          </select></dd>
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
 
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
