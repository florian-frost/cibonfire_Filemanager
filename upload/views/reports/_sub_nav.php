<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/upload') ?>" id="list"><?php echo lang('upload_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Upload.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/upload/create') ?>" id="create_new"><?php echo lang('upload_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>