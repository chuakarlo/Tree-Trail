<?php
	if($user_data != NULL) {
		$isUpdate = $user_id = $user_data["id"];
	} else {
		$isUpdate = 0;
	}

	$username_error 		= form_error('username');
	$last_name_error 		= form_error('lastname');
	$first_name_error 		= form_error('firstname');
	$middle_name_error 		= form_error('middlename');
	$gender_error 			= form_error('gender');
	$contact_number_error 	= form_error('contactnumber');
	$address_error 			= form_error('address');
	
	if($isUpdate):
		$username 		= $user_data["username"];
		$last_name 		= $user_data["last_name"];
		$first_name 	= $user_data["first_name"];
		$middle_name 	= $user_data["middle_name"];
		$gender 		= $user_data["gender"];
		$contact_number = $user_data["contact_number"];
		$address 		= $user_data["address"];
	else:
		$username 		= set_value("username");
		$last_name 		= set_value("lastname");
		$first_name 	= set_value("firstname");
		$middle_name 	= set_value("middlename");
		$gender 		= set_value("gender");
		$contact_number = set_value("contactnumber");
		$address 		= set_value("address");
	endif;
	echo form_open('manage_users/manage_users_modal', 'role="form" name="userform"');
?>

<div class="container-fluid">
	<?php
		if($isUpdate):
			$initial_values = array(
				array("type" => "hidden", "id" => "user_id", "value" => $user_id),
				array("type" => "hidden", "id" => "init_username", "value" => $username),
				array("type" => "hidden", "id" => "init_last_name", "value" => $last_name),
				array("type" => "hidden", "id" => "init_first_name", "value" => $first_name),
				array("type" => "hidden", "id" => "init_middle_name", "value" => $middle_name),
				array("type" => "hidden", "id" => "init_gender", "value" => $gender),
				array("type" => "hidden", "id" => "init_contact_number", "value" => $contact_number),
				array("type" => "hidden", "id" => "init_address", "value" => $address),
			);
			foreach($initial_values as $field):
				echo form_input($field);
			endforeach;
		else:
	?>

	<div id="note">
		<strong>NOTE: </strong> The default password is "123456".
	</div>
	<br />
	<?php
		endif;
	?>
	<div class="form-group <?php echo ($first_name_error)?" has-error has-feedback":""; ?>">
		<label for="firstname" class="control-label">First Name</label>
		<small class="pull-right text-muted"><?php echo $first_name_error; ?></small>
		<input type="text" id="firstname" name="firstname" class="form-control input-sm" value="<?php echo $first_name; ?>">
		<?php echo ($first_name_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
	</div>
	<div class="form-group <?php echo ($middle_name_error)?" has-error has-feedback":""; ?>">
		<label for="middlename" class="control-label">Middle Name</label>
		<small class="pull-right text-muted"><?php echo $middle_name_error; ?></small>
		<input type="text" id="middlename" name="middlename" class="form-control input-sm" value="<?php echo $middle_name; ?>">
		<?php echo ($middle_name_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
	</div>
	<div class="form-group <?php echo ($last_name_error)?" has-error has-feedback":""; ?>">
		<label for="lastname" class="control-label">Last Name</label>
		<small class="pull-right text-muted"><?php echo $last_name_error; ?></small>
		<input type="text" id="lastname" name="lastname" class="form-control input-sm" value="<?php echo $last_name; ?>">
		<?php echo ($last_name_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
	</div>
	<div class="form-group <?php echo ($username_error)?"has-error has-feedback":""; ?>">
		<label for="username" class="control-label">Username</label>
		<small class="pull-right text-muted"><?php echo $username_error; ?></small>
		<input type="text" id="username" name="username" class="form-control input-sm" value="<?php echo $username; ?>">
		<?php echo ($username_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
	</div>
	
	<div class="form-group <?php echo ($gender_error)?" has-error has-feedback":""; ?>">
		<label for="gender" class="control-label">Gender<?php echo nbs(2);?></label>
		<small class="pull-right text-muted"><?php echo $gender_error; ?></small>
		<label class="control-label">
			<input type="radio" name="gender" value="Male" <?php echo $gender == "Male" ? "checked" : ""; ?>>
			Male
		</label>
		<label class="control-label">
			<input type="radio" name="gender" value="Female" <?php echo $gender == "Female" ? "checked" : ""; ?>>
			Female
		</label>
		<?php echo ($gender_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
	</div>
	
	<div class="form-group <?php echo ($contact_number_error)?" has-error has-feedback":""; ?>">
		<label for="contactnumber" class="control-label">Mobile Number</label>
		<small class="pull-right text-muted"><?php echo $contact_number_error; ?></small>
		<input type="text" id="contactnumber" name="contactnumber" class="form-control input-sm" value="<?php echo $contact_number; ?>">
		<?php echo ($contact_number_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
	</div>
	<div class="form-group <?php echo ($address_error)?" has-error has-feedback":""; ?>">
		<label for="address" class="control-label">Address</label>
		<small class="pull-right text-muted"><?php echo $address_error; ?></small>
		<input type="text" id="address" name="address" class="form-control input-sm" value="<?php echo $address; ?>">
		<?php echo ($address_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
	</div>

</div>
<?php echo form_close(); ?>