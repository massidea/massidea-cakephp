<?php
echo $this->Html->tag('h2', __('Sign up', true));
echo $this->Session->flash('auth');
echo $this->Form->create('User', array('action' => 'signup'));

echo $this->Html->tag('h2', __('Account information', true));
echo $this->Form->inputs(array(
	'legend' => false, 
	'User.username' => array(
		'type' => 'text', 
		'label' => __('Username', true)
	),
	'User.password' => array(
		'type' => 'password', 
		'label' => __('Password', true), 
		'value' => ''
	),
	'User.password_confirm' => array(
		'type' => 'password', 
		'label' => __('Confirm password', true), 
		'value' => '',
	)
));
echo $this->Html->tag('h2', __('Personal information', true));
echo $this->Form->inputs(array(
	'legend' => false, 
	'Profile.hometown' => array(
		'type' => 'text',
		'label' => __('Hometown', true)
	),
	'User.email' => array(
		'type' => 'text', 
		'label' => __('Email address', true)
	),
	'Profile.status' => array(
		'type' => 'select',
		'options' => array(
			'private_sector' => __('Private sector', true),
			'public_sector' => __('Public sector', true),
			'education_sector' => __('Education sector', true),
			'student' => __('Student', true),
			'pentioner' => __('Pentioner', true),
			'other' => __('Other', true)
		),
		'label' => __('I am currently', true),
		'empty' => __('-- Select one ---', true)
	)
));
echo $this->Html->div('separator', '');
echo $this->Recaptcha->show('clean');  // Display reCAPTCHA widget. 
echo $this->Recaptcha->error(); // Show validation message of reCAPTCHA. 
echo $this->Html->div('recaptcha-label', __('Please enter the words you see in the box, in order and separated by a space', true));
echo $this->Html->div('separator', '');
echo $this->Form->checkbox('agreement');

$servicesAgreement = $this->Html->link(__('services agreement', true), '#', array('class' => 'terms_link'));
$registerDescription = $this->Html->link(__('register description', true), '#', array('class' => 'privacy_link'));

echo $this->Form->label('agreement', sprintf(__('I agree to the %s and %s', true), $servicesAgreement, $registerDescription));
echo $this->Form->error('agreement');
echo $this->Form->end('Sign up!');

?>
