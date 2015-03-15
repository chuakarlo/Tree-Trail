<?php
	$current_error = form_error("current");
	$new_error = form_error("newpass");
	$matched_error = form_error("matched");
	
	$newpass = set_value("newpass");
	$matched = set_value("matched");
	
	echo form_open('settings/edit_username', 'role="form" name="passwordform"');
?>

<div class="form-group <?php echo ($current_error)?"has-error has-feedback":""; ?>">
	<label for="current" class="control-label text-muted"><strong>Current</strong></label>
	<small class="pull-right text-muted"><?php echo $current_error; ?></small>
	<input type="password" id="current" class="form-control input-sm" name="current">
	<?php echo ($current_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
</div>
<div class="form-group  <?php echo ($new_error)?"has-error has-feedback":""; ?>">
	<label for="newpass" class="control-label text-muted"><strong>New</strong></label>
	<small class="pull-right text-muted"><?php echo $new_error; ?></small>
	<input type="password" id="newpass" class="form-control input-sm" name="newpass" value="<?php echo $newpass?>">
	<?php echo ($new_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
	<span id="new_error"></span>
</div>
<div class="form-group <?php echo ($matched_error)?"has-error has-feedback":""; ?>">
	<label for="matched" class="control-label text-muted"><strong>Re-type new</strong></label>
	<small class="pull-right text-muted"><?php echo $matched_error; ?></small>
	<input type="password" id="confirmnewpass" class="form-control input-sm" name="matched" value="<?php echo $matched?>">
	<?php echo ($matched_error)?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
	<span id="confirm_error"></span>
</div>
<button type="button" id="pass-word" class="btn btn-default btn-primary btn-xs submit-button" onclick="submit_password(this.id)">Save Changes</button>
<button type="button" class="btn btn-xs submit-button" onclick="refresh()">Cancel</button>

<script type="text/javascript">
	$("#newpass").keyup(function(){
		if($("#newpass").val() != "") {
			if($("#newpass").val().length < 5) {
				$("#new_error").html("<strong style='color: orange'>Too short</strong>");
			} else {
				$("#new_error").html("");
			}
		} else {
			$("#new_error").html("");
		}
		
		if($("#confirmnewpass").val() != "") {
			if($("#confirmnewpass").val().length < $("#newpass").val().length) {
				$("#confirm_error").html("<strong style='color: orange'>Match password too short</strong>");
			} else {
				if($("#confirmnewpass").val()!=$("#newpass").val())
				{
					$("#confirm_error").html("<strong style='color: orange'>Passwords do not match</strong>");
				}
				else{
					$("#confirm_error").html("<strong style='color: green'>Passwords match</strong>");
				}
			}
		} else {
			$("#confirm_error").html("");
		}
	});

	$("#confirmnewpass").keyup(function(){
		if($("#confirmnewpass").val() != "") {
			if($("#confirmnewpass").val().length < $("#newpass").val().length) {
				$("#confirm_error").html("<strong style='color: orange'>Match password too short</strong>");
			} else {
				if($("#confirmnewpass").val()!=$("#newpass").val())
				{
					$("#confirm_error").html("<strong style='color: orange'>Passwords do not match</strong>");
				}
				else{
					$("#confirm_error").html("<strong style='color: green'>Passwords match</strong>");
				}
			}
		} else {
			$("#confirm_error").html("");
		}
	});

	$("#current").keyup(function(){
		if($("#current").val().length >= 4)
		{            
			$.ajax({
				type: "POST",
				url: "settings/verify_old_pass",
				data: {
					'db_pass': $("#current").val(),
					'id': <?php echo $this->session->userdata('user_id') ?>
				},
				success: function(msg){

					if(msg=="true")
					{
						$("#current_verify").attr('src',"images/yes.png");
					}
					else
					{
						$("#current_verify").attr('src',"images/no.png");
					}
				}
			});
		 
		}
		else 
		{
			$("#current_verify").attr('src',"images/none.png");
		}
	});
</script>