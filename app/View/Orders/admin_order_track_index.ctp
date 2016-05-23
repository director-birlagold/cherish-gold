<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">			
    <div class="container">
        <form  name="orderaddwaybill" id="orderaddwaybill" method="post" enctype="multipart/form-data" action>	
            <fieldset>
                <legend><?php echo __('Add Tracking Code');?></legend>
                 <dl class="inline">
                <dl class="inline"> 
				<dt><label for="name">Invoice No<span class="required">*</span></label></dt>     
                            <dd>
								<input type="text" name="invoice" id="invoice" class="validate[required]"/>
								
							</dd>
							
                            
                   <dt></dt><dd></dd>
					<dt><label for="name">Way Bill No<span class="required">*</span></label></dt>     
                            <dd><input type="text" name="way_bill_no" id="way_bill_no" class="validate[required]" /></dd>
                            
                   <dt></dt><dd></dd>				   
                    
                       </dl>
                        
                      
                        <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submitmapwaybillno', 'value' => __('Submitdfd'))); ?>
                </dl>
            </fieldset>
      </form>
		<form  name="ordermap" id="myForm" method="post" enctype="multipart/form-data" action>	
            <fieldset>
                <legend><?php echo __('Map Order Tracking');?></legend>
                 <dl class="inline">
                 
                 <fieldset>
                <legend><?php echo __('Import Files');?></legend>
                 <dl class="inline"> 
				<dt><label for="name">import files<span class="required">*</span></label></dt>     
                            <dd><input type="file"   name="importfile" id="importfile" class="validate[required]"/></dd>
                            
                   <dt></dt><dd></dd>         
                    <dt></dt>
                    <dd><label for="name"><strong> (xls  Extension file Only)</strong></label></dd>            
                       </dl>
                        </fieldset>      
                      <fieldset>  
                       <legend>Download Sample Import files </legend>
                         <dl class="inline">
                          <dt></dt>
							<dd><label for="name"><strong> <a href="<?php echo BASE_URL?>orders/download/mapbluedartwithordersample.xls">Click&nbsp;to&nbsp;download&nbsp;sample&nbsp;XLS&nbsp;File</a></strong></label></dd>   
                          </dl>
                        </fieldset>
                        <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
      </form>
    </div>
</div>





