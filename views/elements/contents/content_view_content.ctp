<div class="border-<?php echo $content['class']; ?>" id="content-page-head">
	<h2><?php echo $content['title']; ?></h2>
	<p class="italic magnifyFont"><?php echo $content['lead']; ?></p>
</div>


<div id="content-page-context">
	<p>This content is written in <?php echo $language['name']; ?></p>
	<p>
		<a href="#" class="bold">Tags: </a>
		<?php $tagSize = sizeof($tags); foreach($tags as $k => $tag): ?>
			<a href="#" class="<?php echo ($k % 2) ? "deepblue" : "blue"; ?>"><?php echo $tag['name']; ?></a><?php if($tagSize != $k+1):?>, <?php endif; ?>
		<?php endforeach; ?>
		</p>
	<p>
		<a href="#" class="bold">Related Companies: </a>
		<?php 
		$companySize = sizeof($relatedCompanies);
		if($companySize > 0):
			foreach($relatedCompanies as $k => $company): ?>
			<a href="#" class="<?php echo ($k % 2) ? "deepblue" : "blue"; ?>"><?php echo $company['name']; ?></a><?php if($companySize != $k+1):?>, <?php endif; ?>
			<?php endforeach;
		else: ?>
			No related companies
		<?php endif; ?>
	</p>

	<?php if($content['body'] != ''): ?>
	<p><?php echo $content['body']; ?></p>
	<?php endif; ?>
	
	<?php foreach($specific as $type => $spec): ?>
		<h3><?php 
		if($type == 'research') { echo "Research question"; }
		elseif($type == 'solution') { echo "Idea/Solution in one sentence"; }
		elseif($type == 'opportunity') { echo "Opportunities"; }
		elseif($type == 'threat') { echo "Threats"; }
		?>:</h3>
		<p><?php echo $spec; ?></p>
	<?php endforeach; ?>
	
	<h3>References: </h3>
	<p><?php echo ($content['references'] != '') ? $content['references'] : 'No references'; ?></p>
	
</div>