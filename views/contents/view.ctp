<?php echo $this->Html->script(strtolower($this->name).DS.$this->action,array('inline' => false)); ?>
<?php echo $this->element('global'.DS.'private_message', array('cache' => false));  ?>

<?php echo $this->element('contents'.DS.'add_new_link_to_content', array('cache' => false));  ?>

<?php echo $this->element('contents'.DS.'content_view_top', array('cache' => false));  ?>
	
<?php echo $this->element('contents'.DS.'content_view_content', array('cache' => false));  ?>
	
<?php echo $this->element('contents'.DS.'linked_contents_tabs', array('cache' => false));  ?>
	
<?php echo $this->element('contents'.DS.'content_overview_tabs', array('cache' => false));  ?>

