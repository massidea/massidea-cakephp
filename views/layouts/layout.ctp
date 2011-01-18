<?php echo $html->docType('xhtml11'); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout ?></title>
	<?php echo $html->charset(); ?>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<?php echo $html->css('smoothness/jquery-ui-1.8.7.custom.css'); ?>
	
	<?php echo $html->script('jquery-1.4.4.min'); ?>
	
	<?php echo $html->script('jquery-ui-1.8.7.custom.min'); ?>
	
	<?php echo $html->script('jquery.cookie.js'); ?>
	
	<?php echo $html->script('functions'); ?>
	
	<?php echo $html->script('events'); ?>
	
	<?php echo $scripts_for_layout; ?>
</head>
<body>
<?php echo $html->image('cake.icon.png', array('alt' => 'CakePHP')); ?>
	<div id="header">
	    <?php echo $this->element('header', array('cache' => true)); ?> 
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
