<?php echo $this->Html->docType('xhtml11'); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout ?></title>
	<?php echo $this->Html->charset(); ?>
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<?php echo $this->Html->script('jquery-1.4.4.min'); ?>
	
	<?php echo $this->Html->script('jquery-ui-1.8.7.custom.min'); ?>
	
	<?php echo $scripts_for_layout; ?>
	
</head>
<body>
<?php echo $this->Html->image('cake.icon.png', array('alt' => 'CakePHP')); ?>
	<div id="header">
	    <?php echo $this->element('header', array('cache' => false)); ?> 
	</div>
	<div id="menu">
		<?php echo $this->element('menu', array('cache' => true)); ?>
	</div>
	
	<?php echo $content_for_layout ?>
	
	<div id="footer">
		<?php echo $this->element('footer', array('cache' => true)); ?>
	</div>

</body>
</html>
