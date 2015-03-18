{{< layout}}

{{$ extra_styles}}
  <link rel="stylesheet" href="<?= base_url('static/css/manage_users.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('static/node_modules/datatables/media/css/jquery.dataTables.min.css'); ?>">
{{/extra_styles}}

{{$ extra_content }}
  <div class="container" id="page-wrapper">
	<h2>Feedbacks from guests</h2>
	<br />
	<table id="feedbackTable" class="table table-hover">
	{{#feedback}}
	<tr>
		<td width="20%">
			<strong>{{name}}</strong>
		</td>
		<td>
			{{body}}<br /><br />Posted on: {{date_added}}
		</td>
	</tr>
	{{/feedback}}
	</table>
	<hr />
  </div>
{{/ extra_content}}

{{$ extra_scripts}}
  <script src="<?= base_url('static/node_modules/datatables/media/js/jquery.dataTables.min.js'); ?>"></script>
  <script type="text/javascript">
	$(document).ready(function() {
		$('#feedbackTable').dataTable();
	});
  </script>
{{/ extra_scripts}}

{{/ layout}}