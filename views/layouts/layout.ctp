<?php echo $html->docType('xhtml11'); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout ?></title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<?php /*
	 echo $html->charset();
	 For some reason this returns content as just text/html which is used for HTML.
	 application/xhtml+xml is for XHTML. Wonder why CakePHP doesnt use this as default...
	*/ ?>	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

	<?php echo $html->css(array('layout','smoothness/jquery-ui-1.8.7.custom.css')); ?>
	
	<!--[if IE 7]> <?php echo $html->css('ie7'); ?> <![endif]-->
	<?php 
	echo $html->script(array('jquery-1.4.4.min', //jQuery javascript library
							'jquery-ui-1.8.7.custom.min', //User Interface extension for jQuery
							'jquery.cookie.js', //jQuery cookie plugin
							'functions', //All global functions used in site
							'events' //All global events used in site
	)); 
	?>
	<?php echo $scripts_for_layout; ?>	

</head>
<body>
	<!--[if lt IE 7]> <span style="display:block; width: 100%; background: red; text-align: center; font-size: 24px; padding: 10px; ">Internet Explorer version 6 and below are not supported. Please update your browser for your own security.<br/> <a href="http://www.microsoft.com/windows/internet-explorer/worldwide-sites.aspx">Download newer version here</a> </span><![endif]-->
	<div id="alert" style="display:none"><?php //This element is hidden because its used to notify users if we are going to do updates to our site.
		echo $this->element('/layout/alert', array('cache' => false)); 
	?> 
	</div>
	<div id="background">
		<div id="container">
			<div id="header">
				<?php echo $this->element('/layout/header', array('cache' => true)); ?> 
			</div>
			<div id="menu">
				<?php echo $this->element('/layout/menu', array('cache' => true)); ?>
			</div>
			<div class="clear"></div>
			<hr />
			<div id="content">		
				<?php echo $content_for_layout ?>
			</div>
			<div id="footer">
				<?php echo $this->element('/layout/footer', array('cache' => true)); ?>
			</div>			
		</div>
	</div>
</body>
</html>
