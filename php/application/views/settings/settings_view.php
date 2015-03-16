{{< layout }}

{{$ extra_styles}}
  <link rel="stylesheet" href="<?= base_url('static/css/manage_users.css'); ?>">
{{/extra_styles}}

{{$ extra_content }}
<div class="container" id="page-wrapper">
    <h2>Account Settings</h2>	
    <table class="table table-hover">
      <tr>
        <td width="30%"><strong>Name</strong></td>
        <td id="settings-name" width="40%">
		  <span class="text-muted">
		    {{form_first_name}} {{form_middle_name}} {{form_last_name}}
		  </span>
		</td>
		<td width="30%" style="padding-left: 10%">
		  <a href="#" onclick="edit('name');">Edit</a>
		</td>
	  </tr>
	  <tr>
		<td><strong>Username</strong></td>
		<td id="settings-username">
		  <span class="text-muted">
		    {{form_username}}
		  </span>
		</td>
		<td style="padding-left: 10%">
		  <a href="#" onclick="edit('username');">Edit</a>
		</td>
	  </tr>
	  <tr>
		<td><strong>Password</strong></td>
		<td id="settings-password">
		  <span class="text-muted">
		    Updated on {{form_updated_on}}
		  </span>
		</td>
		<td style="padding-left: 10%">
		  <a href="#" onclick="edit('password');">Edit</a>
		</td>
	  </tr>
	</table>
</div>

<div class="modal fade" id="settingsmodal" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title"></h4>
	  </div>
	  <div class="modal-body">
	  </div>
	  <div class="modal-footer">
	  </div>
	</div>
  </div>
</div>
{{/ extra_content }}

{{$ extra_scripts }}
  <script type="text/javascript">
	$(document).ready(function(){
		$("#settingsmodal").on("hidden.bs.modal", function(e) {
			$(location).attr("href", "settings");
		});
	});
	
	function refresh() {
		$(location).attr("href", "settings");
	}

	function edit(target) {
		$.ajax({
			url: "<?= base_url('/settings'); ?>",
			type: "POST",
			data: {
			  'target' : target,
			  'first-attempt' : 'true',
			},
			success: function(data) {
				$("#settings-"+target).html(data);
			}
		});
	}

	function modify_modal(title, body, footer) {
		$(".modal-title").html(title);
		$(".modal-body").html(body);
		$(".modal-footer").html(footer);
	}
	
	function show_modal(action, data, id) {
		id = id || -1;

		if(action == "notice") {
			var notice = JSON.parse(data);
			modify_modal(notice.title, notice.body,
						 "<button type='button' class='btn btn-xs submit-button' onClick='$(\"#settingsmodal\").modal(\"hide\");' >"+
						 "Dismiss</button>");
		}
		
		$("#settingsmodal").modal("show");
	}
	
	function submit_name(action) {
		var firstname = document.nameform.first_name.value;
		var middlename = document.nameform.middle_name.value;
		var lastname = document.nameform.last_name.value;
		var gender = document.nameform.gender.value;
		var address = document.nameform.address.value;
		var contact = document.nameform.contact.value;
		
		$(".submit-button").addClass("disabled");
		$.ajax({
			url: "<?php echo base_url('/settings'); ?>",
			type: "POST",
			data: {
			    'target' : 'name',
				'first-name' : firstname,
				'middle-name' : middlename,
				'last-name' : lastname,
				'gender' : gender,
				'address' : address,
				'contact' : contact,
				'submit' : action,
			  'first-attempt' : 'false',
			},
			success: function(data) {
				try {
					var json =  JSON.parse(data);
					console.log(json);
					console.log(json.response);
					if(json.response == "Success!" || json.response == "Failure!")
						show_modal("notice", data);
				} catch(e) {
					$(".submit-button").removeClass("disabled");
					$("#settings-name").html(data);
				}
			}
		});
	}
	
	function submit_username(action) {
		var username = document.usernameform.username.value;
		
		$(".submit-button").addClass("disabled");
		$.ajax({
			url: "<?php echo base_url('/settings'); ?>",
			type: "POST",
			data: {
				'target' : 'username',
				'username' : username,
				'submit' : action,
			  'first-attempt' : 'false',
			},
			success: function(data) {
				try {
					var json =  JSON.parse(data);
					
					if(json.response == "Success!" || json.response == "Failure!")
						show_modal("notice", data);
				} catch(e) {
					$(".submit-button").removeClass("disabled");
					$("#settings-username").html(data);
				}
			}
		});
	}
	
	function submit_password(action) {
		var current = document.passwordform.current.value;
		var newpass = document.passwordform.newpass.value;
		var matched = document.passwordform.matched.value;
		
		$(".submit-button").addClass("disabled");
		$.ajax({
			url: "<?php echo base_url('/settings'); ?>",
			type: "POST",
			data: {
				'target' : 'password',
				'current' : current,
				'newpass' : newpass,
				'matched' : matched,
				'submit' : action,
			  'first-attempt' : 'false',
			},
			success: function(data) {
				try {
					var json =  JSON.parse(data);
					
					if(json.response == "Success!" || json.response == "Failure!")
						show_modal("notice", data);
				} catch(e) {
					$(".submit-button").removeClass("disabled");
					$("#settings-password").html(data);
				}
			}
		});
	}
</script>
{{/ extra_scripts }}

{{/ layout }}