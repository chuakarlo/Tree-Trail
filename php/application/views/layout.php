<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Tree Trail</title>

  <link rel="stylesheet" href="<?= base_url('static/node_modules/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Open+Sans'>
  <link rel="icon" href="<?=base_url()?>/favicon.ico" type="image/gif">

  {{$ extra_styles }}{{/ extra_styles }}


  <style>
    #login-form .login-row{
      width: 250px;
      padding: 0 15px 15px;
    }
    #login-form .login-row:first-child{
      padding-top: 15px;
    }
    body{
      font-family: "Open Sans" !important;
      padding-top: 50px;
    }
  {{$ extra_inline_styles }}{{/ extra_inline_styles }}
  </style>

  <script>
    var isLoggedIn = {{ isLoggedInString }};
    var isAdmin = {{ isAdminString }};
    var isSuperAdmin = {{ isSuperAdminString }};
	
  </script>
  {{$ extra_head_scripts }}{{/ extra_head_scripts }}

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
		      {{#isLoggedIn}}
		      <li><a href="<?= base_url('/statistics'); ?>">Statistics</a></li>
		      {{/isLoggedIn}}
          <li><a href="<?= base_url('/about'); ?>">About</a></li>
          <li><a href="<?= base_url('/contact?key=view'); ?>" method="get">Contact</a></li>
          <li><a href="<?= base_url('/announcements?key=view'); ?>" method="get">Announcements</a></li>
          {{^isLoggedIn}}
          <li><a href="<?= base_url('/feedback'); ?>">Feedback</a></li>
          {{/isLoggedIn}}
          {{#isMap}}
          <li><a href="#" id="badge-filter">Filter Badges</a></li>
          {{/isMap}}
        </ul>
        <ul class="nav navbar-nav navbar-right">
      		{{#isLoggedIn}}
		  <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, {{name}}
			  <b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
			  <li>
			    <a href="<?= base_url('/settings'); ?>">Edit Profile</a>
			  </li>
			  {{#isSuperAdmin}}
			  <li>
			    <a href="<?= base_url('/manage_users'); ?>">Manage User Accounts</a>
			  </li>
			  {{/isSuperAdmin}}
        <li>
          <a href="<?= base_url('/contact'); ?>">Manage Contacts</a>
          <a href="<?= base_url('/announcements'); ?>">Manage Announcements</a>
        </li>
        <li>
          <a href="/#unapproved" id="view-pending-badges">View Pending Badges</a>
        </li>
        <li>
          <a href="<?= base_url('/feedback'); ?>">Manage Feedbacks</a>
        </li>
      		  <li><a href="<?= base_url('/logout'); ?>">Logout</a></li>
			</ul>
          </li>
      		{{/isLoggedIn}}
      		{{^isLoggedIn}}
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login</a>
            <div class="dropdown-menu">
              <form id="login-form" action="<?= base_url('login') ?>" method="post">
                <div class="login-row">
                  <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                <div class="login-row">
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="login-row">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </form>
            </div>
          </li>
		      {{/isLoggedIn}}
        </ul>
      </div>

    </div>
  </nav>

  {{$ extra_content }}{{/ extra_content }}

  <script src="<?= base_url('static/node_modules/jquery/dist/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('static/node_modules/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
  {{$ extra_libs }}{{/ extra_libs}}
  
  {{$ extra_plugins }}{{/ extra_plugins }}

  {{$ extra_scripts }}{{/ extra_scripts }}

</body>
</html>
