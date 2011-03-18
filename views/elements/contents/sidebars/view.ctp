<?php $expandIcons = array('block' => 'icon_minus_tiny.png',
							'none' => 'icon_plus_tiny.png');
 ?>

<?php echo $this->element('contents'.DS.'corresponding_author', array('cache' => false));  ?>

<div id="related-author">
  	<h2 class="pointerCursor">
  		<?php echo $html->image($expandIcons[$sidebarCookies['author']], array('class' => 'icon')); ?>
  		More from author
  	</h2>
  	<div class="scroll-box nolist shrinkFontMore" style="display: <?php echo $sidebarCookies['author']; ?>;">
		<?php echo $this->element('contents'.DS.'more_from_author', array('cache' => true));  ?>
	</div>
</div>

<div id="related-content">
	<h2 class="pointerCursor">
  		<?php echo $html->image($expandIcons[$sidebarCookies['content']], array('class' => 'icon')); ?>
  		Related Content
  	</h2>
    <div class="scroll-box nolist shrinkFontMore" style="display: <?php echo $sidebarCookies['content']; ?>;">
		<?php echo $this->element('contents'.DS.'related_content', array('cache' => true));  ?>
	</div>
</div>

<div id="related-campaigns">
    <h2 class="pointerCursor">
  		<?php echo $html->image($expandIcons[$sidebarCookies['campaigns']], array('class' => 'icon')); ?>
  		Linked to campaigns
  	</h2>
  	<div class="scroll-box nolist shrinkFontMore" style="display: <?php echo $sidebarCookies['campaigns']; ?>;">
		<?php echo $this->element('contents'.DS.'linked_to_campaigns', array('cache' => true));  ?>
	</div>
</div>


