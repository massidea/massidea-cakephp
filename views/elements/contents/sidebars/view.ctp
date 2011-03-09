<?php $expandIcons = array('block' => 'icon_minus_tiny.png',
							'none' => 'icon_plus_tiny.png');
 ?>

<?php echo $this->element('contents'.DS.'corresponding_author', array('cache' => true));  ?>

<div id="related-author">
  	<h2 class="pointerCursor">
  		<?php echo $html->image($expandIcons[$sidebarCookies['author']], array('class' => 'icon_plusminus')); ?>
  		More from author
  	</h2>
  	<div class="scroll-box nolist shrinkFontMore" style="display: <?php echo $sidebarCookies['author']; ?>;">
		<?php echo $this->element('contents'.DS.'more_from_author', array('cache' => true));  ?>
	</div>
	<a href="#" id="show_more">Show more</a>
</div>

<div id="related-content">
	<h2 class="pointerCursor">
  		<?php echo $html->image($expandIcons[$sidebarCookies['content']], array('class' => 'icon_plusminus')); ?>
  		Related Content
  	</h2>
    <div class="scroll-box nolist shrinkFontMore" style="display: <?php echo $sidebarCookies['content']; ?>;">
		<?php echo $this->element('contents'.DS.'related_content', array('cache' => true));  ?>
	</div>
	<a href="#" id="show_more">Show more</a>
</div>

<div id="related-campaigns">
    <h2 class="pointerCursor">
  		<?php echo $html->image($expandIcons[$sidebarCookies['campaigns']], array('class' => 'icon_plusminus')); ?>
  		Linked to campaigns
  	</h2>
  	<div class="scroll-box nolist shrinkFontMore" style="display: <?php echo $sidebarCookies['campaigns']; ?>;">
		<?php echo $this->element('contents'.DS.'linked_to_campaigns', array('cache' => true));  ?>
	</div>
	<a href="#" id="show_more">Show more</a>
</div>


