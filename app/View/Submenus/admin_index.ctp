<div id="content" class="clearfix"> 
    <div class="container">
        <div class="mainheading">   
            <div class="btnlink"><?php // echo $this->Html->link(__('+Add Menu'), array('action' => 'add'),array('class'=>'button'));  ?></div> 	
            <div class="titletag"><h1><?php echo __('Sub Menu')." ({$menu['Menu']['menu_name']})"; ?></h1></div>
            <div class="btnlink">
            <?php echo $this->Html->link('Back to Mainmenu', array('controller' => 'menus',  'action' => 'index'), array('class' => 'button'));?>
            <?php echo $this->Html->link('+Add Submenu', array('action' => 'add', $id), array('class' => 'button'));?>
        </div>
        </div>
        <div class="tablefooter clearfix">

        </div>
        <?php //echo $this->Form->create('Submenu', array('action' => 'delete','id'=>'myForm','Controller'=>'orderstatuss')); ?>
        <table cellpadding="0" cellspacing="0" id="example" class="table gtable">
            <thead>
                <tr>
                    <th width="30" align="center"><?php echo $this->Html->image('icons/arrow.jpg');
        //echo __('<input type="checkbox" id="checkAllAuto" name="action[]" value="0" class="validate[minCheckbox[1]] checkbox" />'); 
        ?></th> 
                    <th width="30" align="center"><?php echo __('#'); ?></th>        
                    <th align="left"><?php echo $this->Paginator->sort('submenu_name', 'Submenu'); ?></th> 
                    <th width="40" align="center"><?php echo $this->Paginator->sort('is_active', 'Status'); ?></th>
                    <th width="30" align="center">Edit</th>
                    <?php if($menu['Menu']['menu_id'] == 8){?>
                    <th width="30" align="center">View Offer</th>
                    <?php }?>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($submenus))
                    echo '<tr><td colspan="4" align="center">' . __('No records found') . '</td></tr>';
                else {
                    $i = $this->Paginator->counter('{:start}');
                    foreach ($submenus as $submenu):
                        ?>
                        <tr>
                            <td align="center"><?php echo $this->Html->image('icons/arrow.jpg'); ?></td>
                            <td align="center"><?php echo h($i); ?></td>
                            <td align="left"><?php echo h($submenu['Submenu']['submenu_name']); ?></td>
                            <td align="left"><?php echo $submenu['Submenu']['is_active'] == 1 ? 'Active' : 'In-active'; ?></td>


                            <td align="center">
                                <?php
                                echo $this->Html->image('icons/edit.png', array('url' => array('action' => 'edit', $submenu['Submenu']['submenu_id']), 'border' => 0, 'alt' => __('Edit')));
                                ?>
                            </td>
                            <?php if($menu['Menu']['menu_id'] == 8){?>
                            <td align="center">
                                 <?php
                                echo $this->Html->image('icons/view.png', array('url' => array('controller' => 'offers', 'action' => 'index', $submenu['Submenu']['submenu_id']), 'border' => 0, 'alt' => __('View')));
                                ?>
                            </td>
                            <?php }?>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                }
                ?>
            </tbody>
        </table>
        <div class="tablefooter clearfix">   
            <div class="actions">
    <!--<input type="submit" id="action_btn"  class="button small" value="Delete"  />-->
            </div>
            <div class="pagination">
                <div class="pagenumber">
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Page') . ' {:page} ' . __('of') . ' {:pages}, ' . __('showing') . ' {:current} ' . __('records out of') . ' {:count} ' . __('total')
                    ));
                    ?>
                </div>
                <div class="paging">
                    <?php
                    echo $this->Paginator->prev(__('previous'), array(), null, array('class' => 'prev disabled'));
                    echo $this->Paginator->numbers(array('separator' => ''));
                    echo $this->Paginator->next(__('next'), array(), null, array('class' => 'next disabled'));
                    ?>
                </div>
            </div>
        </div>
<?php echo $this->Form->end(); ?>
    </div>
</div>