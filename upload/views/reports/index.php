<div class="admin-box">
	<h3>Upload</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($this->auth->has_permission('Upload.Reports.Delete') && isset($records) && is_array($records) && count($records)) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Name</th>
					<th>Description</th>
					<th>Tags</th>
					<th>Public</th>
					<th>MD5 Checksum</th>
					<th>Owner</th>
					<th>Created</th>
					<th>Modified</th>
				</tr>
			</thead>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<tfoot>
				<?php if ($this->auth->has_permission('Upload.Reports.Delete')) : ?>
				<tr>
					<td colspan="9">
						<?php echo lang('bf_with_selected') ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php e(js_escape(lang('upload_delete_confirm'))); ?>')">
					</td>
				</tr>
				<?php endif;?>
			</tfoot>
			<?php endif; ?>
			<tbody>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $record) : ?>
				<tr>
					<?php if ($this->auth->has_permission('Upload.Reports.Delete')) : ?>
					<td><input type="checkbox" name="checked[]" value="<?php echo $record->id ?>" /></td>
					<?php endif;?>
					
				<?php if ($this->auth->has_permission('Upload.Reports.Edit')) : ?>
				<td><?php echo anchor(SITE_AREA .'/reports/upload/edit/'. $record->id, '<i class="icon-pencil">&nbsp;</i>' .  $record->upload_name) ?></td>
				<?php else: ?>
				<td><?php e($record->upload_name) ?></td>
				<?php endif; ?>
			
				<td><?php e($record->upload_description) ?></td>
				<td><?php e($record->upload_tags) ?></td>
				<td><?php e($record->upload_public) ?></td>
				<td><?php e($record->upload_md5_checksum) ?></td>
				<td><?php e($record->upload_owner_userid) ?></td>
				<td><?php e($record->created) ?></td>
				<td><?php e($record->modified) ?></td>
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="9">No records found that match your selection.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
</div>