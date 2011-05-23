<?php
echo $this->Session->flash('auth');
echo $this->Form->create('User', array('action' => 'login'));
echo $this->Form->inputs(array(
	'legend' => __('Login', true),
	'username',
	'password' => array('type' => 'password', 'label' => 'Password', 'value' => '')
));
echo $this->Form->end('Login');
?>
