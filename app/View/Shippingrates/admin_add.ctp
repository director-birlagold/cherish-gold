<?php echo $this->Html->script(array('ckeditor/ckeditor')); ?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Shipping Rates Details'), array('action' => 'index'), array('class' => 'button')); ?></div>        
        <form  name="Shippingrate" id="myForm" method="post" enctype="multipart/form-data" action>	
            <fieldset>
                <legend><?php echo __('Add Shipping Rate'); ?></legend>
                <dl class="inline">
                    <dt><label for="name">State<span class="required">*</span></label></dt> 
                    <dd>
                        <select name="data[Shippingrate][state]" id="state" class="validate[required]">
                            <option value="">State</option>
                            <?php foreach ($state as $state) { ?>
                                <option value="<?php echo $state['States']['state'] ?>"><?php echo $state['States']['state'] ?></option>
                            <?php } ?>
                        </select>
                    </dd>      
                    <dt><label for="name">City<span class="required">*</span></label></dt>     
                    <dd><input type="text" name="data[Shippingrate][city]" id="city"  class="validate[required]" size="50"  /></dd>

                    <dt><label for="name">Pincode<span class="required">*</span></label></dt>     
                    <dd><input type="text" name="data[Shippingrate][pincode]" id="pincode" onkeypress="return intnumbers(this, event)" maxlength="6"  class="validate[required,custom[integer],minSize[6]]" size="50"  /></dd>

                    <dt><label for="name">Delivery Days<span class="required">*</span></label></dt>     
                    <dd><input type="text" name="data[Shippingrate][delivery_date]" id="delivery_date"  onkeypress="return intnumbers(this, event)"   class="validate[required,custom[integer]]" size="50"  /></dd>

                    <dt><label for="name">Tax Code</label></dt>     
                    <dd><input type="text" name="data[Shippingrate][taxcode]" id="taxcode"   size="50"  /></dd>
                    <dt><label for="name">Tax Rate(%)</label></dt>     
                    <dd><input type="text" name="data[Shippingrate][taxrate]" id="taxrate" onkeypress="return floatnumbers(this, event)"  size="50"  /></dd>
                        <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
        </form>
    </div>
</div>





