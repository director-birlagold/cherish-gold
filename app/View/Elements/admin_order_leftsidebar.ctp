<ul class="projectmenu">
    <?php
    $order = ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
    $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $order['Order']['user_id'])));
    if ($user['User']['user_type'] == 0) {
        ?>
        <li <?php if ($this->params['action'] == 'admin_user_view') echo 'class="active"'; ?>><?php
            echo $this->Html->link('User details', array('action' => 'user_view', $this->params['pass'][0],
                'controller' => 'orders'));
            ?></li> 
    <?php }else { ?>
        <li <?php if ($this->params['action'] == 'admin_franchisee_view') echo 'class="active"'; ?>><?php
            echo $this->Html->link('Franchisee details', array('action' => 'franchisee_view', $this->params['pass'][0],
                'controller' => 'orders'));
            ?></li> 
    <?php } ?>
    <li <?php if ($this->params['action'] == 'admin_product_view') echo 'class="active"'; ?>><?php echo $this->Html->link('Product details', array('action' => 'product_view', $this->params['pass'][0], 'controller' => 'orders')); ?></li> 
    <li <?php if ($this->params['action'] == 'admin_billing_view') echo 'class="active"'; ?>><?php echo $this->Html->link('Billing details', array('action' => 'billing_view', $this->params['pass'][0], 'controller' => 'orders')); ?></li> 
    <li <?php if ($this->params['action'] == 'admin_shipping_view') echo 'class="active"'; ?>><?php echo $this->Html->link('Shipping details', array('action' => 'shipping_view', $this->params['pass'][0], 'controller' => 'orders')); ?></li> 
    <li <?php if ($this->params['action'] == 'admin_order_view') echo 'class="active"'; ?>><?php echo $this->Html->link('Order details', array('action' => 'order_view', $this->params['pass'][0], 'controller' => 'orders')); ?></li> 
    <?php if ($order['Order']['cod_status'] == 'CHQ/DD') { ?>
        <li <?php if ($this->params['action'] == 'admin_chq_dd_view') echo 'class="active"'; ?>><?php echo $this->Html->link('CHQ / DD ', array('action' => 'chq_dd_view', $this->params['pass'][0], 'controller' => 'orders')); ?></li> 
    <?php } ?>
    <li <?php if($this->params['action']=='admin_orderhistory_view') echo 'class="active"'; ?>><?php echo $this->Html->link('Order History',array('action'=>'orderhistory_view',$this->params['pass'][0],'controller'=>'orders'));?></li> 

</ul>  