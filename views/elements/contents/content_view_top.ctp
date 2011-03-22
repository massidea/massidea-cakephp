<div id="viewtop" class="margin-top">
	<div class="small-padding-top-bottom">
		<span>Added: <?php echo $content['created']; ?></span>
		<!-- AddThis Button BEGIN -->
		<a href="http://www.addthis.com/bookmark.php?v=250&amp;pub=xa-4b12c6f671039279" class="addthis_button_expanded small-padding-left-right" title="View more services">
			<img class="icon" height="16" width="125" style="border: 0pt none;" alt="Bookmark and Share" src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif">
		</a>
		<script src="http://s7.addthis.com/js/250/addthis_widget.js#pub=xa-4b12c6f671039279" type="text/javascript"></script>
		<!-- AddThis Button END -->
		
		<?php echo $form->create('flag',array('action' => 'add', 'class' => 'right')); ?>
		<?php echo $form->hidden('id', array('value' => $content['id'])); ?>
		<?php echo $form->hidden('type', array('value' => 'Content')); ?>
		<a href="#">Flag as inappropriate</a>
		<?php echo $form->end(); ?>
		
		<div class="clear"></div>
	</div>
</div>