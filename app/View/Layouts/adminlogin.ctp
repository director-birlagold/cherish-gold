<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo SITE_NAME;?> - <?php echo __('Login') ?></title>
<meta name="description" content="<?php echo SITE_NAME;?> - <?php echo __('Login') ?>" />
<meta name="keywords" content="<?php echo SITE_NAME;?> - <?php echo __('Login') ?>" />
<meta name="author" content="<?php echo SITE_NAME;?>" />
<meta name="copyright" content="<?php echo SITE_NAME;?>" />
<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css(array('style','reset','uniform/uniform.default','jQuery.validation/validationEngine.jquery','jquery.confirm/jquery.confirm'));
	echo $this->Html->script(array('jquery-1.8.3','uniform/jquery.uniform','jQuery.validation/jquery.validationEngine','jQuery.validation/languages/jquery.validationEngine-en','confirm/jquery.confirm','adminlogin'));
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
</head>
<body style="background:#E4E4E4">
<div class="helpfade"></div>
<div class="helptips">
  <div class="loader_block">
    <div class="loader_block_inner"></div>
    <div class="loader_text"><?php echo __('Please wait') ?>...</div>
  </div>
</div>
<div class="dismsg" id="msginfo" style="top:10%;">
  <?php $msg=$this->Session->flash(); if(!empty($msg)) echo $msg.'<div class="close"> Click to close.</div>'; ?>
</div>
<div id="mainContainer">
  <div id="header" class="clearfix">
    <div id="topHeader">
      <div id="logo"><?php echo $this->Html->link($this->Html->image('logo.png',array('border'=>0,'alt'=>'logo')),array('action'=>'index'),array('escape'=>false)); ?></div>
    </div>
  </div>
  <?php echo $this->fetch('content'); ?> </div>
</body>
</html>