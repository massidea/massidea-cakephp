<?php
echo $this->Session->flash('auth');
echo $this->Form->create('User', array('action' => 'signup'));
echo $this->Form->inputs(array(
	'legend' => __('Sign up', true),
	'username' => array(
		'type' => 'text', 
		'label' => 'Username'
	),
	'password' => array(
		'type' => 'password', 
		'label' => 'Password', 
		'value' => ''
	),
	'password_confirm' => array(
		'type' => 'password', 
		'label' => 'Confirm password', 
		'value' => '',
	),
	'email' => array(
		'type' => 'text', 
		'label' => 'Email address'
	)
));

echo $this->Recaptcha->show('white');  // Display reCAPTCHA widget. 
echo $this->Recaptcha->error(); // Show validation message of reCAPTCHA. 
echo $this->Html->div('recaptcha-label', 'Please enter the words you see in the box, in order and separated by a space');
echo $this->Form->end('Sign up!');

?>
