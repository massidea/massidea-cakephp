<?php 
$layout = 'layout'.DS; //Used for element folder structures

echo $html->docType('xhtml11'); 
?>

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
	
	<?php 
	//Here we set our own css files
	$cssFiles = array('reset', //Resets the CSS for browsers
					'layout' //Layout CSS file
	);
	//Sidebar css file added if we have a sidebar
	if ($content_class == 'narrow') {
		$cssFiles[] = 'sidebar'; //Sidebar CSS file
	}
	//Here we add additional CSS files from plugins etc.
	$cssFiles[] = 'smoothness'.DS.'jquery-ui-1.8.7.custom.css'; //jQuery UI CSS file
	echo $html->css($cssFiles);
	
	//Adds controller.css and its action.css files to CSS styles if exists
	if(!empty($css_for_layout)) { echo $html->css($css_for_layout); }
	?>
	
	<!--[if IE 7]> <?php echo $html->css('ie7fix'); ?> <![endif]-->
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
	<!--[if lt IE 7]> <span id="iewhine">Internet Explorer version 6 and below are not supported. Please update your browser for your own security.<br/> <a href="http://www.microsoft.com/windows/internet-explorer/worldwide-sites.aspx">Download newer version here</a> </span><![endif]-->
	<div id="alert"><?php //This element is hidden because its used to notify users if we are going to do updates to our site. 
		echo $this->element($layout.'alert', array('cache' => false)); 
	?> 
	</div>
	<div id="background">
		<div id="container">
			<div id="header">
				<?php echo $this->element($layout.'header', array('cache' => true)); ?> 
			</div>
			<div id="menu">
				<?php echo $this->element($layout.'menu', array('cache' => true)); ?>
			</div>
			<?php 
			/**
			 *	Some controller pages have sidebar and some dont. 
			 *	All pages have content div and its defined id is: controller
			 *	Inside this div there is action div with defined id: action-page
			 *	The $content_class defines whether the content uses narrow or wide style.
			 *	narrow style is used with sidebar and wide without and it's globally set to narrow in app_controller.php.
			 *	Sidebar is loaded from elements:
			 *	elements/controller/action_sidebar.ctp
			 */
			 $controller_id = strtolower($this->name);
			 $action_id		= $this->action . '-page';
			 $sidebar		= strtolower($this->name) . DS . $this->action. '_sidebar';
			 ?>
			
			<div id="content">
				<div id="<?php echo $controller_id; ?>" class="<?php echo $content_class; ?>">
					<div id="<?php echo $action_id; ?>">
						<?php echo $content_for_layout ?>
					</div>
				</div>
			</div>
			<?php if ($content_class == 'narrow'): ?>
			<div id="sidebar">
				<?php echo $this->element($sidebar, array('cache' => true)); ?>
			</div>
			<?php endif; ?>
			<div class="clear"></div>
			<div id="footer">
				<?php echo $this->element($layout.'footer', array('cache' => true)); ?>
			</div>			
		</div>
	</div>
</body>
</html>
