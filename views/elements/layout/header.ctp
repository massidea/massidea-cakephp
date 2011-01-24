<div id="title">
<!-- Links/Lynx fix -->
	<h1><a href="<?php echo $this->Html->url('/'); ?>"><span>Massidea.org</span></a></h1>
</div>

<div id="search">
	<div id="search-top">
		<a href="#" id="loginlink">Login</a> | <a href="#">Sign up</a>
	</div>
	<form action="#" method="post">
		<div id="search-field">
			<input type="text" class="top_search_field" name="globalSearch" id="globalSearch">
		</div>
		<div id="search-submit">
			<input type="submit" value="Search" alt="Search" name="submitsearch" class="submit-button" id="submitsearch">
		</div>
	</form>
	<div class="clear"></div>
	<div id="select">
		<div class="left">
			<form method="post" action="#" enctype="application/x-www-form-urlencoded" id="translation_form">
				<select></select>
				<input type="submit" style="display: none;" value="submit" id="submit" name="submit">
			</form>
		</div>
		<div class="right"></div>
		<div class="clear"></div>
	</div>
</div>
