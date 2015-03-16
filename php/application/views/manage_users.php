<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Tree Trail</title>

  <link rel="stylesheet" href="<?= base_url('static/node_modules/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('static/node_modules/bootstrap/dist/css/bootstrap-theme.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('static/node_modules/datatables/media/css/jquery.dataTables.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('static/css/manage_users.css'); ?>">
  
  <style>
    #login-form .login-row{
      width: 250px;
      padding: 0 15px 15px;
    }
    #login-form .login-row:first-child{
      padding-top: 15px;
    }
    body{
      padding-top: 50px;
    }
  {{$ extra_inline_styles }}{{/ extra_inline_styles }}
  </style>
  
  </head>
<body> 
  <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container-fluid">

      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">TreeTrail</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
		      <li><a href="<?= base_url('/statistics'); ?>">Statistics</a></li>
          <li><a href="<?= base_url('/about'); ?>">About Project Tree Trail</a></li>
          <li><a href="<?= base_url('/contact'); ?>">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
		  <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  Welcome, <?php echo $name;?>
			  <b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
			  <li>
			    <a href="<?= base_url('/settings'); ?>">Edit Profile</a>
			  </li>
			  <li>
			    <a href="<?= base_url('/manage_users'); ?>">Manage User Accounts</a>
			  </li>
        <li>
          <a href="<?= base_url('/contact'); ?>">Manage Contacts</a>
        </li>
        <li>
          <a href="<?= base_url('/'); ?>">View Pending Badges</a>
        </li>
      		  <li><a href="<?= base_url('/logout'); ?>">Logout</a></li>
			</ul>
          </li>
        </ul>
      </div>

    </div>
  </nav>
  
  <div id="page-wrapper" class="container">
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">
          User Management
        </h1>
          <ol class="breadcrumb">
            <li>
              <i class="fa fa-dashboard"></i>  <?php echo anchor('dashboard', 'Dashboard'); ?>
            </li>
            <li class="active">
               <i class="fa fa-bar-chart-o"></i> User Management
            </li>
          </ol>
        </div>
      </div>

      <div class="row">
         <div class="col-lg-12">
            <h2><p class = "col-xs-6 col-md-5">List of Administrators</p>
              <div class="col-md-2 col-md-offset-5 text-right">
                <?php
                  $button = array(
                    "id"    => "add",
                    "class"   => "btn btn-default btn-primary btn-xs",
                    "content" => "ADD USER",
                    "onClick" => "show_modal(this.id)"
                  );
                  echo form_button($button);
                ?>
              </div>         
            </h2> 
          </div>
        </div>
        <hr>



    <div class="well">

      <div class="table-responsive panel panel-default">

        <div class="panel-body">

          <div class="table-responsive">
            <?php   

              $table["table_open"] = "<table class='table table-striped table-hover' id='userTable'>";
              $this->table->set_template($table);
              
              $user_header      = array("data" => "Name");
              $username_header  = array("data" => "Username");
              $date_header      = array("data" => "Date Added");
       
              
              $this->table->set_heading($user_header, $username_header, $date_header, array('width'=> '10%'),array('width'=> '10%'));

              echo $this->table->generate($users);
            ?>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="usermodal" role="dialog" aria-hidden="true">
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
  </div>
</div>

<script src="<?= base_url('static/node_modules/jquery/dist/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('static/node_modules/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
  <script src="<?= base_url('static/node_modules/datatables/media/js/jquery.dataTables.min.js'); ?>"></script>



<script type="text/javascript">
  $(document).ready(function(){
    var tableElement = $('#userTable');

    tableElement.dataTable({
      bLengthChange : false,
      bFilter : false,
      aoColumnDefs : [{
        bSortable : false,
        aTargets : [3,4]
      }],
      autoWidth: false
    });
    
    $("#usermodal").on("hidden.bs.modal", function(e) {
      $(location).attr("href", "manage_users");
    });

    
  });
  
  function modify_modal(title, body, footer) {
    $(".modal-title").html(title);
    $(".modal-body").html(body);
    $(".modal-footer").html(footer);
  }



  function show_modal(action, data, id) {

    id = id || -1;
    
    if(action == "add") {
      $.post("<?php echo base_url(); ?>manage_users/manage_users_modal/"+id, function(data) {

        modify_modal("Add User", data, "<button type='button' id="+action+" class='btn btn-default btn-primary btn-xs submit-button'"+
                         "onClick='submit(this.id);' >Add</button>");
      });
    } else if(action == "delete") {
      modify_modal("Delete User", "Are you sure you want to delete user \""+data+"\"?",
             "<button type='button' id='"+id+"' class='btn btn-default btn-primary btn-xs submit-button'"+
             "onClick='delete_user(this.id);'>Delete</button>"+
             "<button type='button' class='btn btn-xs submit-button' onClick='$(\"#usermodal\").modal(\"hide\");' >"+
             "Cancel</button>");
    } else if(action == "notice") {
      var notice = JSON.parse(data);
      modify_modal(notice.title, notice.body,
             "<button type='button' class='btn btn-xs submit-button' onClick='$(\"#usermodal\").modal(\"hide\");' >"+
             "Dismiss</button>");
    } else {
      $.ajax({
        url: "<?php echo base_url('/manage_users/manage_users_modal'); ?>/"+id,
        type: "POST",
        data: {
        },
        success: function(data) {
          console.log(data);
          modify_modal("Update Info", data, "<button type='button' id="+action+" class='btn btn-default btn-primary btn-xs submit-button'"+
                              "onClick='submit(this.id);' >Save</button>");
        }
      });
    }
    
    $("#usermodal").modal("show");
  }

  function submit(action) {

    var username              = document.forms["userform"].username.value;
    var lastname              = document.forms["userform"].lastname.value;    
    var firstname             = document.forms["userform"].firstname.value;
    var middlename            = document.forms["userform"].middlename.value;
    var gender                = document.forms["userform"].gender.value;
    var contactnumber         = document.forms["userform"].contactnumber.value;
    var address               = document.forms["userform"].address.value;


    var user_id                     = (action == "update") ? document.forms["userform"].user_id.value : "-1";
    var init_username               = (action == "update") ? document.forms["userform"].init_username.value : "";
    var init_last_name              = (action == "update") ? document.forms["userform"].init_last_name.value : "";
    var init_first_name             = (action == "update") ? document.forms["userform"].init_first_name.value : "";
    var init_middle_name            = (action == "update") ? document.forms["userform"].init_middle_name.value : "";
    var init_gender                 = (action == "update") ? document.forms["userform"].init_gender.value : "";
    var init_contact_number         = (action == "update") ? document.forms["userform"].init_contact_number.value : "";
    var init_address                = (action == "update") ? document.forms["userform"].init_address.value : "";
    if(username===init_username && lastname===init_last_name && firstname===init_first_name && middlename===init_middle_name && gender===init_gender && contactnumber===init_contact_number && address===init_address){
    }else console.log("not ok");
    $(".submit-button").addClass("disabled");
    $.ajax({
      url: "<?php echo base_url(); ?>manage_users/manage_users_modal/"+user_id,
      type: "POST",
      data: {
        'id'                        : user_id,
        'username'                  : username,
        'lastname'                  : lastname,
        'firstname'                 : firstname,
        'middlename'                : middlename,
        'gender'                    : gender,
        'contactnumber'             : contactnumber,
        'address'                   : address,
        'init_username'             : init_username,
        'init_last_name'              : init_last_name,
        'init_first_name'             : init_first_name,
        'init_middle_name'            : init_middle_name,
        'init_gender'                 : init_gender,
        'init_contact_number'         : init_contact_number,
        'init_address'                : init_address,
        'submit'                    : action
      },
      success: function(data) {
        try {
          var json =  JSON.parse(data);
          console.log("ok");
          if(json.response == "Success!" || json.response == "Failure!")
            show_modal("notice", data);
            window.setTimeout(function () {
               $("#usermodal").modal("hide");
               window.location.reload();
            }, 1000);
          
        } catch(e) {
          $(".submit-button").removeClass("disabled");
          $(".modal-body").html(data);
        }
      }
    });
  }
  
  function delete_user(id) {
    $.post("<?php echo base_url(); ?>manage_users/delete_user/"+id, function(data) {
      show_modal("notice", data);
        window.setTimeout(function () {
          $("#usermodal").modal("hide");
            window.location.reload();
          }, 1000);
    });
  }
</script>


</body>
</html>