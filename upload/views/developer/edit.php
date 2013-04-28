
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($upload) ) {
    $upload = (array)$upload;
}
$id = isset($upload['id']) ? $upload['id'] : '';
?>
<div class="admin-box">
    <h3>Upload</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group <?php echo form_error('upload_name') ? 'error' : ''; ?>">
            <?php echo form_label('Name', 'upload_name', array('class' => "control-label") ); ?>
            <div class="controls">

               <input id="upload_name" type="text" name="upload_name" maxlength="200" value="<?php echo set_value('upload_name', isset($upload['upload_name']) ? $upload['upload_name'] : ''); ?>"  />
               <span class="help-inline"><?php echo form_error('upload_name'); ?></span>
            </div>

        </div>        <div class="control-group <?php echo form_error('upload_description') ? 'error' : ''; ?>">
            <?php echo form_label('Description', 'upload_description', array('class' => "control-label") ); ?>
            <div class="controls">
                <?php echo form_textarea( array( 'name' => 'upload_description', 'id' => 'upload_description', 'rows' => '5', 'cols' => '80', 'value' => set_value('upload_description', isset($upload['upload_description']) ? $upload['upload_description'] : '') ) )?>
                <span class="help-inline"><?php echo form_error('upload_description'); ?></span>
            </div>

        </div>        <div class="control-group <?php echo form_error('upload_tags') ? 'error' : ''; ?>">
            <?php echo form_label('Tags', 'upload_tags', array('class' => "control-label") ); ?>
            <div class="controls">

               <input id="upload_tags" type="text" name="upload_tags" maxlength="255" value="<?php echo set_value('upload_tags', isset($upload['upload_tags']) ? $upload['upload_tags'] : ''); ?>"  />
               <span class="help-inline"><?php echo form_error('upload_tags'); ?></span>
            </div>

        </div>

        <?php // Change the values in this array to populate your dropdown as required ?>

<?php $options = array(
                1 => 1,); ?>

        <?php echo form_dropdown('upload_public', $options, set_value('upload_public', isset($upload['upload_public']) ? $upload['upload_public'] : ''), 'Public'. lang('bf_form_label_required'))?>        <div class="control-group <?php echo form_error('upload_md5_checksum') ? 'error' : ''; ?>">
            <?php echo form_label('MD5 Checksum'. lang('bf_form_label_required'), 'upload_md5_checksum', array('class' => "control-label") ); ?>
            <div class="controls">

               <input id="upload_md5_checksum" type="text" name="upload_md5_checksum" maxlength="255" value="<?php echo set_value('upload_md5_checksum', isset($upload['upload_md5_checksum']) ? $upload['upload_md5_checksum'] : ''); ?>"  />
               <span class="help-inline"><?php echo form_error('upload_md5_checksum'); ?></span>
            </div>

        </div>

        <?php // Change the values in this array to populate your dropdown as required ?>

<?php $options = array(
                11 => 11,); ?>

        <?php echo form_dropdown('upload_owner_userid', $options, set_value('upload_owner_userid', isset($upload['upload_owner_userid']) ? $upload['upload_owner_userid'] : ''), 'Owner'. lang('bf_form_label_required'))?>


        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="Edit Upload" />
            or <?php echo anchor(SITE_AREA .'/developer/upload', lang('upload_cancel'), 'class="btn btn-warning"'); ?>
            

    <?php if ($this->auth->has_permission('Upload.Developer.Delete')) : ?>

            or <button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('upload_delete_confirm'))); ?>')">
            <i class="icon-trash icon-white">&nbsp;</i>&nbsp;<?php echo lang('upload_delete_record'); ?>
            </button>

    <?php endif; ?>


        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
