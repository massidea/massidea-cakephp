<?php
echo $this->Html->script(strtolower($this->name).DS.'add',array('inline' => false));

 
/*
$this->TinyMce->editor(array(
		'theme' => 'advanced',
		'mode' => 'exact',
		'elements' => 'NodeBody',
		'theme_advanced_toolbar_location' => "top",
		'theme_advanced_disable' => "charmap,sup,sub,code,help,cleanup,image,anchor,unlink,link,removeformat,visualaid,hr"
));
*/

/**
 * Here we set content specific field texts
 * 
 */ 
$challenge = '(Answer what, why, who, when and where questions)';
$idea = '(What is the idea and why it is important)';
$vision = '(What is the vision of the future and why it is important)';
$body = '';
?>

<?php if($content_type === 'challenge'): $body = $challenge; ?>

<div id="form_content_realcontent">
	<h2 class="light-gray border-problem">Share your challenge</h2>
	<p>Challenge is personal, business or social related problem, need, situation or observation. It describes the current status of affairs and recognizes the need to resolve the matter. </p>
	<p>Write to a person who is not familiar with the topic.</p>
	<p>Keep your focus on challenge and not related solutions or visions. You can publish those one a separate document and link them later on to this challenge.</p>
</div>

<?php elseif($content_type === 'idea'): $body = $idea; ?>

<div style="display: block;" id="form_content_realcontent">
	<h2 class="light-gray border-idea">Share your new idea</h2>
	<p>Ideas are solutions to today’s challenges and visions of the future related opportunities and threats. Idea can suggest small incremental improvement or radical revolutionary change in thinking, products, processes or organization. </p>
	<p>Write to a person who is not familiar with the topic. </p>
	<p>Keep your focus on idea and not related challenges or visions. You can publish those on a separate document and link them later on to this idea.</p>
</div>

<?php elseif($content_type === 'vision'): $body = $vision; ?>

<div style="display: block;" id="form_content_realcontent">
	<h2 class="light-gray border-finfo">Share your vision of the future</h2>
	<p>Vision concern the long-term future which is usually at least 10 years away. It can be future scenario, trend or anti-trend, which is most likely to be realized. It can also describe an alternative unlikely future based on seed of change or weak signal, which might significantly change all our life if realized.</p>
	<p>Write to a person who is not familiar with the topic.</p>
	<p>Keep your focus on vision and not related challenges or ideas. You can publish those on a separate document and link them later on to this vision.</p>
</div>

<?php endif; ?>


<?php 
$beforeTemplate = '<div class="field-label"><small class="right">%text%</small>';
$between = '</div><div class="field">';
$after = '</div><div class="limit bad">required</div></div><div class="clear">';
$afterNoReq = '</div></div><div class="clear">';
$afterClear = '</div><div class="clear">';
?>

<?php echo $form->create('Node', array('type' => 'file',
						 				'url' => array('controller' => 'contents', 'action' => 'edit'),
						 				'inputDefaults' => array('label' => false,
																'div' => false)
));
?>

<?php echo $form->hidden('type', array('value' => "Content")); ?>

<?php echo $form->hidden('id'); ?>

<?php echo $form->hidden('class', array('value' => $content_type)); ?>

<?php echo $form->hidden('Privileges.privileges'); ?>

<?php echo $form->hidden('published'); ?>

<?php ?>
<?php echo $form->input('language_id', array('type' => 'select',
										'label' 	=> 'Select language',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_languages', 'class' => 'row'),
										'before' 	=> str_replace('%text%','',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $afterNoReq,
										'options' 	=> $language_list							
)); 
?>

<?php echo $form->input('title', array('label' 		=> 'Header',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_title', 'class' => 'row'),
										'before' 	=> str_replace('%text%','(Explain in one sentence the whole story)',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after									
)); 
?>


<?php echo $form->input('lead', array('type' => 'textarea',
										'label' 	=> 'Lead chapter',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_lead', 'class' => 'row'),
										'before' 	=> str_replace('%text%','(This text is shown in search result lists)',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after	

));
?>

<?php if($content_type === 'challenge'): ?>

<?php echo $form->input('Specific.research', array('label' 	=> 'Research question',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_research', 'class' => 'row'),
										'before' 	=> str_replace('%text%','(The single question you want to get an answer)',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after									
)); 
?>

<?php elseif($content_type === 'idea'): ?>

<?php echo $form->input('Specific.solution', array('label' 	=> 'Your idea/solution in one sentence',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_solution', 'class' => 'row'),
										'before' 	=> str_replace('%text%','',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after									
)); 
?>

<?php elseif($content_type === 'vision'): ?>

<?php echo $form->input('Specific.opportunity', array('label' 	=> 'Opportunity',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_opportunity', 'class' => 'row'),
										'before' 	=> str_replace('%text%','(The most important if future scenario becomes realized)',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after									
)); 
?>

<?php echo $form->input('Specific.threat', array('label' 	=> 'Threat',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_threat', 'class' => 'row'),
										'before' 	=> str_replace('%text%','(The most important if future scenario becomes realized)',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after									
)); 
?>

<?php endif;?>

<?php echo $form->input('Tags.tags', array('label' 		=> 'Keywords, Tags',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_tags', 'class' => 'row'),
										'before' 	=> str_replace('%text%','(Use commas to separate tags)',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after									
)); 
?>

<?php echo $form->input('Companies.companies', array('label' 	=> 'Related companies and organizations',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_companies', 'class' => 'row'),
										'before' 	=> str_replace('%text%','(Use commas to separate)',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after									
)); 
?>

<?php echo $form->input('body', array('type' => 'textarea',
										'label' 	=> 'Body text',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_body', 'class' => 'row'),
										'before' 	=> str_replace('%text%',$body,$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after,
										'rows'		=> '20'	

));
?>

<?php echo $form->input('references', array('type' => 'textarea',
										'label' 	=> 'References',
										'error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true),
										'div'		=> array('id' => 'content_references', 'class' => 'row'),
										'before' 	=> str_replace('%text%','',$beforeTemplate),
										'between'	=> $between,
										'after'		=> $after	
));
?>

<?php echo $form->input('publish', array('type' 	=> 'radio',
										'legend' 	=> 'Do you want to publish your content now?',
										'label'		=> true,
										'div'		=> array('id' => 'content_publish', 'class' => 'row'),
										'options'	=> array('1' => 'Yes', '0' => 'No, I want to save it for later editing'),
										'value'		=> '0',
										'after'		=> $afterClear								
)); 
?>

<?php echo $form->end(array('div' => array('class' => 'row field',
											'id' => 'content_send'),
							'value' => 'Send',
							'label' => 'Send',
							'after'	=> $afterClear	
));
 ?>







