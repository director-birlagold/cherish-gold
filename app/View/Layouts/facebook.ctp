
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

<?php echo $this->Facebook->html(); ?>
<head>
    <?php echo $this->Html->css('cake.generic'); ?>
</head>
<body>
    <!-- content -->
    <div id="content" >
        <?php echo $content_for_layout; ?>
    </div>
    <!-- end content -->
</body>
<?php echo $this->Facebook->init(); ?> 
</html>
