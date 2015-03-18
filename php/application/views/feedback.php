{{< layout}}

{{$ extra_styles}}
  <link rel="stylesheet" href="<?= base_url('static/css/manage_users.css'); ?>">
{{/extra_styles}}

{{$ extra_content }}
  <div class="container" id="page-wrapper">
	{{#success}}
		<div class="text-center prompt" style="height: 35px; background: lightgreen; border-width: 3px; border-color: green; border-radius: 5px; border-style: solid">
			Feedback successfully added!
		</div>
	{{/success}}
	<h2>Feedback</h2>
	<p>Use the form below to send us your comments. We read all feedback carefully, but please note that we cannot respond to the comments you submit.</p>
	
	<form action="<?= base_url('feedback') ?>" method="post">
		<div style="width: 50%">
		<div class="form-group <?php echo form_error("name")?"has-error has-feedback":""; ?>">
			<label for="name" class="control-label text-muted"><strong>Name: *</strong></label>
			<small class="pull-right text-muted"><?php echo form_error("name"); ?></small>
			<input type="text" class="form-control input-sm" name="name" value="<?php echo set_value("name") ?>">
			<?php echo (form_error("name"))?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
		</div>
		<div class="form-group <?php echo form_error("email")?"has-error has-feedback":""; ?>">
			<label for="email" class="control-label text-muted"><strong>Email Address: *</strong></label>
			<small class="pull-right text-muted"><?php echo form_error("email"); ?></small>
			<input type="text" class="form-control input-sm" name="email" value="<?php echo set_value("email") ?>">
			<?php echo (form_error("email"))?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
		</div>
		<div class="form-group <?php echo form_error("subject")?"has-error has-feedback":""; ?>">
			<label for="subject" class="control-label text-muted"><strong>Subject: *</strong></label>
			<small class="pull-right text-muted"><?php echo form_error("subject"); ?></small>
			<input type="text" class="form-control input-sm" name="subject" value="<?php echo set_value("subject") ?>">
			<?php echo (form_error("subject"))?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
		</div>
		</div>
		<div class="form-group <?php echo form_error("comment")?"has-error has-feedback":""; ?>">
			<label for="comment" class="control-label text-muted"><strong>Comment: *</strong></label>
			<small class="pull-right text-muted"><?php echo form_error("comment"); ?></small>
			<textarea rows="7" class="form-control input-sm" name="comment" value="<?php echo set_value("comment") ?>"></textarea>
			<?php echo (form_error("comment"))?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
		</div>
		<hr />
		<input type="submit" class="btn btn-primary pull-right" value="Submit Feedback">
	</form>
  </div>
{{/ extra_content}}

{{$ extra_scripts}}
	<script type="text/javascript">
		jQuery("div.prompt").delay(2000).fadeOut("slow");
	</script>
{{/ extra_scripts}}

{{/ layout}}