<?php
	$username_error = form_error("username");

	$username = $settings_data["username"];
	
	echo form_open('settings/edit_username', 'role="form" name="usernameform"');
?>

<div class="form-group <?php echo ($username_error)?"has-error has-feedback":""; ?>">
	<label for="username" class="control-label text-muted"><strong>Username</strong></label>
	<small class="pull-right text-muted"><?php echo $username_error; ?></small>
	<input type="text" class="form-control input-sm" name="username" value="<?php echo $username ?>">
	<?php echo ($username_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
</div>
<button type="button" id="user-name" class="btn btn-default btn-primary btn-xs submit-button" onclick="submit_username(this.id)">Save Changes</button>
<button type="button" class="btn btn-xs submit-button" onclick="refresh()">Cancel</button>