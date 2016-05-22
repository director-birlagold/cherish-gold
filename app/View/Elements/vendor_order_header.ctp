<?php if ($this->Session->read('User.user_type') == 2) { ?>
    <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
        <?php
        $order = ClassRegistry::init('Order')->find('first', array('conditions' => array('order_id' => $this->params['pass']['0'])));
        $user = ClassRegistry::init('User')->find('first', array('conditions' => array('user_id' => $order['Order']['user_id'])));
        if ($user['User']['user_type'] == 0) {
            ?>
<!--            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state <?php if ($this->params['action'] == 'user_view') echo 'ui-state-active'; ?>"><?php
                echo $this->Html->link('User details', array('action' => 'user_view', $this->params['pass'][0],
                    'controller' => 'orders'), array('class' => "ui-tabs-anchor"));
                ?></li> -->
        <?php }else { ?>
<!--            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state <?php if ($this->params['action'] == 'franchisee_view') echo 'ui-state-active'; ?>"><?php
                echo $this->Html->link('Franchisee details', array('action' => 'franchisee_view', $this->params['pass'][0],
                    'controller' => 'orders'), array('class' => "ui-tabs-anchor"));
                ?></li> -->
        <?php } ?>
        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state <?php if ($this->params['action'] == 'product_view') echo 'ui-state-active'; ?>"><?php echo $this->Html->link('Product details', array('action' => 'product_view', $this->params['pass'][0], 'controller' => 'orders'), array('class' => "ui-tabs-anchor")); ?></li> 
<!--        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state <?php if ($this->params['action'] == 'billing_view') echo 'ui-state-active'; ?>"><?php echo $this->Html->link('Billing details', array('action' => 'billing_view', $this->params['pass'][0], 'controller' => 'orders'), array('class' => "ui-tabs-anchor")); ?></li> 
        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state <?php if ($this->params['action'] == 'shipping_view') echo 'ui-state-active'; ?>"><?php echo $this->Html->link('Shipping details', array('action' => 'shipping_view', $this->params['pass'][0], 'controller' => 'orders'), array('class' => "ui-tabs-anchor")); ?></li> -->
        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state <?php if ($this->params['action'] == 'order_view') echo 'ui-state-active'; ?>"><?php echo $this->Html->link('Order details', array('action' => 'order_view', $this->params['pass'][0], 'controller' => 'orders'), array('class' => "ui-tabs-anchor")); ?></li> 
        <?php if ($order['Order']['cod_status'] == 'CHQ/DD') { ?>
            <!--<li class="ui-state-default ui-corner-top ui-tabs-active ui-state <?php if ($this->params['action'] == 'chq_dd_view') echo 'ui-state-active'; ?>"><?php echo $this->Html->link('CHQ / DD ', array('action' => 'chq_dd_view', $this->params['pass'][0], 'controller' => 'orders'), array('class' => "ui-tabs-anchor")); ?></li>--> 
        <?php } ?>
        <!--<li class="ui-state-default ui-corner-top ui-tabs-active ui-state <?php if ($this->params['action'] == 'orderhistory_view') echo 'ui-state-active'; ?>"><?php echo $this->Html->link('Order History', array('action' => 'orderhistory_view', $this->params['pass'][0], 'controller' => 'orders'), array('class' => "ui-tabs-anchor")); ?></li>--> 

    </ul>  
<?php } ?>
