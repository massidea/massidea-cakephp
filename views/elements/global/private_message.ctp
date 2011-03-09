<?php echo $this->Html->script('elements'.DS.'private_message',array('inline' => false)); ?>

<div id="send_private_message" title="Send private message">
	<p class="validateTips">Message length is max. 2000 characters.</p>
	<form>
	<fieldset>
		<label for="private_message_to">To</label>
		<input type="text" name="private_message_to" id="private_message_to" value="hihhuli" disabled="disabled" />
		<input type="hidden" id="authorId" value="" />
		<label for="private_message">Message</label>
		<input type="text" name="private_message" id="private_message" value=""  />
	</fieldset>
	</form>
</div>