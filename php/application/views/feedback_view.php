{{< layout}}

{{$ extra_styles}}
  <link rel="stylesheet" href="<?= base_url('static/css/manage_users.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('static/node_modules/datatables/media/css/jquery.dataTables.min.css'); ?>">
{{/extra_styles}}

{{$ extra_content }}
  <div class="container" id="page-wrapper">
	<div class="contact"> <h1>Feedbacks</h1></div>
	<div class="col-lg-12">
		{{#message}}
	      <div class="col-lg-2"></div>
	      <div class="alert alert-success alert col-lg-8"><center>{{message}}</center></div>
	      <div class="col-lg-2"></div>
	    {{/message}}
	</div>
	<br>
	<div class="col-lg-12"></div>
	<div class="col-lg-12">
	<div class="table-responsive">
		<table id="feedbackTable" class="table table-hover">
		<tr>
	      <th width="20%">Name</th>
	      <th>Email Address</th>
	      <th>Message</th>
	      <th></th>
	    <tr>
		{{#feedback}}
		<tr>
			<td width="20%">
				<strong>{{name}}</strong>
				<br />Posted on: {{date_added}}
			</td>
			<td>
				{{email}}
			</td>	
			<td>
				{{body}}
			</td>
			<td>
			<form action="/feedback" method="post">
			    <input type="hidden" name="action" value="delete" />
			    <input type="hidden" name="id" value="{{id}}" />
			    <button type="submit" class='btn btn-danger btn-xs' onClick = "return confirm('Are you sure you want to delete this feedback?')">Delete</button>
			</form>
			</td>
		</tr>
		{{/feedback}}	
		</table>
	</div>
	</div>
  </div>
{{/ extra_content}}

{{$ extra_scripts}}
  <script src="<?= base_url('static/node_modules/datatables/media/js/jquery.dataTables.min.js'); ?>"></script>
{{/ extra_scripts}}

{{/ layout}}