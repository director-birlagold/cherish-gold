<ul class="projectmenu">
	<li <?php if($this->params['action']=='edit') echo 'class="active"'; ?>><?php echo $this->Html->link('Personal detail',array('action'=>'edit',$this->params['pass'][0],'controller'=>'signin'));?></li> 
     <li <?php if($this->params['action']=='admin_index') echo 'class="active"'; ?>><?php echo $this->Html->link('Shipping detail',array('action'=>'shipping_edit',$this->params['pass'][0],'controller'=>'signin'));?></li> 
</ul>  