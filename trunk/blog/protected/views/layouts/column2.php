<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div class="span-6">
		<div id="sidebar">
			<?php $this->renderPartial('/layouts/sidebar'); ?>
		</div><!-- sidebar -->
	</div>
	<div class="span-20 last" style=" border-left: 1px solid #C9E0ED">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>