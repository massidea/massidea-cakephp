<?php if($content_type === 'challenge'): ?>

<div id="form_content_realcontent">
	<h2 class="light-gray border-problem">Share your challenge</h2>
	<p>Challenge is personal, business or social related problem, need, situation or observation. It describes the current status of affairs and recognizes the need to resolve the matter. </p>
	<p>Write to a person who is not familiar with the topic.</p>
	<p>Keep your focus on challenge and not related solutions or visions. You can publish those one a separate document and link them later on to this challenge.</p>
</div>

<?php elseif($content_type === 'idea'): ?>

<div style="display: block;" id="form_content_realcontent">
	<h2 class="light-gray border-idea">Share your new idea</h2>
	<p>Ideas are solutions to today’s challenges and visions of the future related opportunities and threats. Idea can suggest small incremental improvement or radical revolutionary change in thinking, products, processes or organization. </p>
	<p>Write to a person who is not familiar with the topic. </p>
	<p>Keep your focus on idea and not related challenges or visions. You can publish those on a separate document and link them later on to this idea.</p>
</div>

<?php elseif($content_type === 'vision'): ?>

<div style="display: block;" id="form_content_realcontent">
	<h2 class="light-gray border-finfo">Share your vision of the future</h2>
	<p>Vision concern the long-term future which is usually at least 10 years away. It can be future scenario, trend or anti-trend, which is most likely to be realized. It can also describe an alternative unlikely future based on seed of change or weak signal, which might significantly change all our life if realized.</p>
	<p>Write to a person who is not familiar with the topic.</p>
	<p>Keep your focus on vision and not related challenges or ideas. You can publish those on a separate document and link them later on to this vision.</p>
</div>

<?php endif; ?>

<?php echo $form->create('Node', array('type' => 'file', 'url' => array('controller' => 'contents'))); ?>

<?php echo $form->hidden('type', array('value' => "Content")); ?>

<?php echo $form->hidden('class', array('value' => $content_type)); ?>

<?php echo $form->hidden('published', array('value' => 0)); ?>

<?php echo $form->input('title'); ?>

<?php echo $form->input('lead', array('type' => 'textarea')); ?>

<?php echo $form->input('body', array('type' => 'textarea')); ?>

<?php echo $form->input('references', array('type' => 'textarea')); ?>

<?php echo $form->hidden('Privileges.privileges', array('value' => '755')); ?>

<?php echo $form->end('lähetä'); ?>