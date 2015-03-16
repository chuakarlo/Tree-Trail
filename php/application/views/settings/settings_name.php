<?php
	$first_name_error = form_error("first-name");
	$middle_name_error = form_error("middle-name");
	$last_name_error = form_error("last-name");
	$address_error = form_error("address");
	$contact_error = form_error("contact");
	
	$first_name = $settings_data["first_name"];
	$middle_name = $settings_data["middle_name"];
	$last_name = $settings_data["last_name"];
	$address = $settings_data["address"];
	$contact = $settings_data["contact"];
	$gender = $settings_data["gender"];
	
	echo form_open('settings', 'role="form" name="nameform"');
?>

<div class="form-group <?php echo ($first_name_error)?"has-error has-feedback":""; ?>">
	<label for="first_name" class="control-label text-muted"><strong>First</strong></label>
	<small class="pull-right text-muted"><?php echo $first_name_error; ?></small>
	<input type="text" class="form-control input-sm" name="first_name" value="<?php echo $first_name ?>">
	<?php echo ($first_name_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
</div>
<div class="form-group <?php echo ($middle_name_error)?"has-error has-feedback":""; ?>">
	<label for="middle_name" class="control-label text-muted"><strong>Middle</strong></label>
	<small class="pull-right text-muted"><?php echo $middle_name_error; ?></small>
	<input type="text" class="form-control input-sm" name="middle_name" value="<?php echo $middle_name ?>">
	<?php echo ($middle_name_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
</div>
<div class="form-group <?php echo ($last_name_error)?"has-error has-feedback":""; ?>">
	<label for="last_name" class="control-label text-muted"><strong>Last</strong></label>
	<small class="pull-right text-muted"><?php echo $last_name_error; ?></small>
	<input type="text" class="form-control input-sm" name="last_name" value="<?php echo  $last_name ?>">
	<?php echo ($last_name_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
</div>
<div class="form-group">
	<label for="gender" class="control-label text-muted"><strong>Gender<?php echo nbs(2);?></strong></label>
	<label class="control-label text-muted">
		<input type="radio" name="gender" value="Male" <?php echo $gender == "Male" ? "checked" : ""; ?>>
		Male
	</label>
	<label class="control-label text-muted">
		<input type="radio" name="gender" value="Female" <?php echo $gender == "Female" ? "checked" : ""; ?>>
		Female
	</label>
</div>
<div class="form-group <?php echo ($address_error)?"has-error has-feedback":""; ?>">
	<label for="address" class="control-label text-muted"><strong>Address</strong></label>
	<small class="pull-right text-muted"><?php echo $address_error; ?></small>
	<input type="text" class="form-control input-sm" name="address" value="<?php echo  $address ?>">
	<?php echo ($address_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
</div>
<div class="form-group <?php echo ($contact_error)?"has-error has-feedback":""; ?>">
	<label for="contact" class="control-label text-muted"><strong>Mobile Number</strong></label>
	<small class="pull-right text-muted"><?php echo $contact_error; ?></small>
	<input type="text" class="form-control input-sm" name="contact" value="<?php echo  $contact ?>">
	<?php echo ($contact_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
</div>
<button type="button" id="name" class="btn btn-default btn-primary btn-xs submit-button" onclick="submit_name(this.id)">Save Changes</button>
<button type="button" class="btn btn-xs submit-button" onclick="refresh()">Cancel</button>