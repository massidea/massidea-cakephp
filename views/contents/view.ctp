<?php echo $this->Html->script(strtolower($this->name).DS.$this->action,array('inline' => false)); ?>
<?php echo $this->element('global'.DS.'private_message', array('cache' => false));  ?>