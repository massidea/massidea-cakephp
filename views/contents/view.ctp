<?php 
echo $this->Html->script('infinitecarousel'.DS.'jquery.infinitecarousel2.min',array('inline' => false));
echo $this->Html->script(strtolower($this->name).DS.$this->action,array('inline' => false));
echo $this->element('global'.DS.'private_message', array('cache' => false)); 
echo $this->element('global'.DS.'flag', array('cache' => false));
echo $this->element('contents'.DS.'add_new_link_to_content', array('cache' => false));
?>

<div id="related-info">
		<ul>
			<li><a href="#related-author">Hihhuli (241)</a></li>
			<li><a href="#related-readers">Readers</a></li>
			<li><a href="#related-tags">Tag related contents</a></li>
			<li><a href="#related-related_companies">Company related contents</a></li>
			<li><a href="#related-campaigns">Campaigns</a></li>
			<li><a href="#related-statistics">Statistics</a></li>
		</ul>
		<div id="related-author">
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
		</div>
		<div id="related-readers">

			<?php echo $this->element('contents'.DS.'content_related_readers', array('cache' => false));  ?>
	
		</div>
		<div id="related-tags">
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
		</div>
		<div id="related-related_companies">
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
			<p>hihiHAH hHAH hHHrh hfshsfh fsh fshsh fshsf fsh</p>
		</div>
		
		<div id="related-campaigns"></div>
		
		<div id="related-statistics"></div>
	</div>

<div id="content-page-head" class="left">
	<div class="border-<?php echo $content['class']; ?> margin-top">
		<h2><?php echo $content['title']; ?></h2>
		<span class="grey">Published: <?php echo $content['created']; ?>, Last updated: <?php echo $content['modified']; ?></span>
		<p class="italic magnifyFont"><?php echo $content['lead']; ?></p>
	</div>
	<p>
		<a href="#" class="bold">Tags: </a>
		<?php $tagSize = sizeof($tags); foreach($tags as $k => $tag): ?>
			<a href="#" class="<?php echo ($k % 2) ? "deepblue" : "blue"; ?>"><?php echo $tag['name']; ?></a><?php if($tagSize != $k+1):?>, <?php endif; ?>
		<?php endforeach; ?>
	</p>
	<?php 
		$companySize = sizeof($relatedCompanies);
		if($companySize > 0):
	?>
	<p>
		<a href="#" class="bold">Related Companies: </a>
		<?php foreach($relatedCompanies as $k => $company): ?>
			<a href="#" class="<?php echo ($k % 2) ? "deepblue" : "blue"; ?>"><?php echo $company['name']; ?></a><?php if($companySize != $k+1):?>, <?php endif; ?>
		<?php endforeach;?>
	</p>
	<?php endif; ?>

	<div class="clear"></div>
	<div id="content-page-context">
			
		<?php if($content['body'] != ''): ?>
		<p><?php echo nl2br($content['body']); ?></p>
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
</div>
<?php echo $this->element('contents'.DS.'content_view_top', array('cache' => false));  ?>
<div class="clear"></div>
	

