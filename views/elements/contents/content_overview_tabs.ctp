<div id="content-tabs">
	<ul>
		<li><a href="#overview">Overview</a></li>
		<li><a href="#readers">Readers (5232212)</a></li>
		<li><a href="#statistics">Statistics</a></li>
	</ul>
	<div id="overview">
		<div id="overview_top">
			<div id="overview_rating" class="center left">
				<h2>Rate the content</h2>
				<?php echo $html->image('icon_thumb_up.png',array('alt' => 'Vote Up', 'class' => '', 'id' => 'voteup')); ?>
				<span class="giantFont green">87%</span>
				<?php echo $html->image('icon_thumb_down.png',array('alt' => 'Vote Down', 'class' => '', 'id' => 'votedown')); ?>
				<br />
				<p class="magnifyFontMore">421 ratings!</p>
			</div>
			<div id="overview_viewed" class="center right">
				<h2>Content has</h2>
				<span class="giantFont">5128</span>
				<br />
				<p class="magnifyFontMore">views!</p>
			</div>
		</div>
		<div class="clear"></div>
		<div id="overview_bottom">
			<input type="button" value="Give a gift" class="left magnifyFont gift force-small-padding hoverLink" id="give_gift_button"/>
			<input type="button" value="Add to favourites" class="right magnifyFont favourite_off force-small-padding hoverLink" id="add_to_favourites_button"/>				
		</div>
		<div class="clear"></div>
	</div>
	<div id="readers">
		<div id="content-view-viewers-list-content">
			<ul>
				<li class="all">
					<div class="reader_user">
						<div class="photo left">
							<a href="#">
								<?php echo $html->image('no_profile_img_placeholder.png', array('class' => 'avatar')); ?>
							</a>
						</div>
						<div class="context left">
							<p><a href="#">Midnight Walker</a></p>
						</div>
						<div class="clear"></div>
					</div>
				</li>
			</ul>
		</div> 
	</div>
	<div id="statistics">
	
	</div>
</div> 