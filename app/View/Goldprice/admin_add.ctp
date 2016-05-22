<div id="content"  class="clearfix">
  <div class="container">
    <div align="right" style="padding-right:10px;"><?php echo $this->Html->link(__('Back to Gold Price List'),array('action'=>'index'),array('class'=>'button')); ?></div>
    <form name="Gold" id="myForm" method="post" enctype="multipart/form-data" action="">
      <fieldset>
        <legend>Add Gold Price</legend>
        <dl class="inline">
          <dt><label for="name">Gold Price<span class="required">*</span></label></dt>
          <dd><input type="text" name="data[GoldPrice][gold_price]" id="gold_price"  class="validate[required]" size="50" value="<?php if(isset($this->request->data['GoldPrice']['gold_price'])){ echo $this->request->data['GoldPrice']['gold_price'];}?>"/>
          </dd>
          <dt><label for="name">Gold Date<span class="required">*</span></label></dt>
          <dd><input type="date" name="data[GoldPrice][gold_date]" id="gold_date"  class="validate[required]" size="50" value="<?php if(isset($this->request->data['GoldPrice']['gold_date'])){ echo $this->request->data['GoldPrice']['gold_date'];}?>"/>
          </dd>
        
          <div class="buttons" ><input type="submit" name="submit" value="Submit" id="submit" class="button"   /></div>
        </dl>
      </fieldset>
    </form>
  </div>
</div>
