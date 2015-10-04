{{< layout}}

{{$ extra_styles}}
  <link rel="stylesheet" href="<?= base_url('static/css/manage_users.css'); ?>">
{{/extra_styles}}

{{$ extra_content }}
  <div class="container" id="page-wrapper">
	<h2>Feedback</h2>
	<p>Use the form below to send us your comments. We read all feedback carefully, but please note that we cannot respond to the comments you submit.</p>
	<div class="col-lg-2"></div>
	{{#message}}
		<div class="alert alert-success alert col-lg-8"><center>{{message}}</center></div>
	{{/message}}
	<div class="col-lg-2"></div>
	<div class="col-lg-2"></div>
	<form action="<?= base_url('feedback') ?>" method="post">
		<div style="width: 50%">
		<div class="form-group <?php echo form_error("name")?"has-error has-feedback":""; ?>">
			<label for="name" class="control-label text-muted"><strong>Name: *</strong></label>
			<small class="pull-right text-muted"><?php echo form_error("name"); ?></small>
			<input type="text" class="form-control input-sm" name="name" value="<?php echo set_value("name") ?>"></input>
			<?php echo (form_error("name"))?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
		</div>
		<div class="form-group <?php echo form_error("email")?"has-error has-feedback":""; ?>">
			<label for="email" class="control-label text-muted"><strong>Email Address: *</strong></label>
			<small class="pull-right text-muted"><?php echo form_error("email"); ?></small>
			<input type="text" class="form-control input-sm" name="email" value="<?php echo set_value("email") ?>">
			<?php echo (form_error("email"))?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
		</div>
		</div>
		<div class="form-group <?php echo form_error("comment")?"has-error has-feedback":""; ?>">
			<label for="comment" class="control-label text-muted"><strong>Comment: *</strong></label>
			<small class="pull-right text-muted"><?php echo form_error("comment"); ?></small>
			<textarea rows="7" class="form-control input-sm" name="comment" value=""><?php echo set_value("comment"); ?></textarea>
			<?php echo (form_error("comment"))?"<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>":"" ?>
		</div>
		<hr />
		<button type="submit" class="btn btn-primary pull-right" type="hidden" name="action" value="add">Submit Feedback</button>
	</form>
  </div>
{{/ extra_content}}

{{$ extra_scripts}}
	<script type="text/javascript">
		jQuery("div.prompt").delay(2000).fadeOut("slow");
	</script>
{{/ extra_scripts}}

{{/ layout}}