{{< layout }}

{{$ extra_styles}}
  <link rel="stylesheet" href="<?= base_url('static/css/manage_users.css'); ?>">
{{/ extra_styles}}

{{$ extra_inline_styles }}
    .contact{
      text-align: center;
    }
    .add{
      text-align: center;
    }
{{/ extra_inline_styles }}

{{$ extra_content}}
 <div class="container" id="page-wrapper"> 
    <div class="contact"> <h1>Manage Announcements</h1></br> </div> 

    <div class="col-lg-12">
        {{#message}}
          <div class="col-lg-2"></div>
          <div class="alert alert-success alert col-lg-8"><center>{{message}}</center></div>
          <div class="col-lg-2"></div>
        {{/message}}
        {{#error}}
        <div class="col-lg-2"></div>
          <div class="alert alert-danger alert col-lg-8"><center>{{error}}</center></div>
          <div class="col-lg-2"></div>
         {{/error}}
    </div>
    <div class="col-lg-12 text-right" id="add">
        <button class='btn btn-primary' data-toggle="modal" data-target="#myModal">Add Announcement</button>
    </div>
    <div class="col-lg-12">
    </div>
    <div class="col-lg-12">
 <div class="table-responsive">
  <table class ="table table-hover">
     <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Announcement Content</th>
        <th>Posted by</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
  {{#announcements }}
    <tr>
      <td>{{title}}</td>
      <td>{{date}}</td>
      <td>{{body}}</td>
      <td>{{user}}</td>
    <td>
    <form action="/announcements" method="post">
        <input type="hidden" name="action" value="edit" />
        <input type="hidden" name="id" value="{{id}}" />
        <button type="submit" class='btn btn-primary btn-xs'>Edit</button>
    </form>
    </td>
    <td>
    <form action="/announcements" method="post">
        <input type="hidden" name="action" value="delete" />
        <input type="hidden" name="id" value="{{id}}" />
        <button type="submit" class='btn btn-danger btn-xs' onClick = "return confirm('Are you sure you want to delete this announcement?')">Delete</button>
    </form>
    </td>
    </tr>
  {{/ announcements }}
  </table></div></div>
  <div class="col-lg-2"></div>
  

      <!--MODAL-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"><center>Add Announcement</center></h4></div>
            <div class="modal-body">
            <center>
            <form id="login-form" action="<?= base_url('/announcements') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="title" class="control-label">Announcement Title:</label>
                  <input id="title" type="text" class="form-control" name="title" placeholder="Title" required>
                </div>
                <div class="form-group">
                  <label for="body" class="control-label">Content:</label>
                  <textarea id="body" type="textarea" class="form-control" name="body" placeholder="Content" rows="5" required></textarea>
                </div>
                <input type="hidden" name="user" value="<?php echo $this->login->getName($this->session->userdata("user_id")); ?>"/>
                <input type="hidden" name="date" value="<?php echo date("Y-m-d h:i:sa"); ?>"/>
                <div class="login-row">
                  <button type="submit" class="btn btn-primary" type="hidden" name="action" value="add">Add Announcement</button>
                </div>
              </form>
            </center>
        </div><!-- modal header-->
      </div><!--modal content-->
    </div> <!--modal dialog-->
  </div> <!--modal-->
  </div>
{{/ extra_content }}

{{/ layout }}