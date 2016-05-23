<?php echo $this->Html->script(array('ckeditor/ckeditor'));?>
<div id="content"  class="clearfix">			
    <div class="container">
        <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Product Details'), array('action' => 'index'), array('class' => 'button')); ?></div> 
		<form  name="importproduct" id="myForm" method="post" enctype="multipart/form-data" action>	
            <fieldset>
                <legend><?php echo __('Import Product');?></legend>
                 <dl class="inline">
                 
                 <fieldset>
                <legend><?php echo __('Import File');?></legend>
                 <dl class="inline"> 
				<dt><label for="importfile">Import files<span class="required">*</span></label></dt>     
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
							<dd><label for="name"><strong> <a href="<?php echo BASE_URL?>orders/download/product_sample.xls">Click&nbsp;to&nbsp;download&nbsp;sample&nbsp;XLS&nbsp;File</a></strong></label></dd>   
                          </dl>
                        </fieldset>
                        <?php echo $this->Form->submit(__('Submit'), array('div' => false, 'before' => ' <div class="buttons" >', 'after' => '</div>', 'class' => 'button', 'name' => 'submit', 'value' => __('Submit'))); ?>
                </dl>
            </fieldset>
      </form>
    </div>
</div>