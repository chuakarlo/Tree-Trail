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
    <div class="contact"> <h1>Manage Contact</h1></br> </div> 

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

    <div class="col-lg-2"></div>
    <div class="col-lg-8">
 <div class="table-responsive">
  <table class ="table table-hover">
     <tr>
        <th>Contact Person</th>
        <th>Contact Number</th>
        <th>Email</th>
        <th>Organization</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
  {{#contacts }}
    <tr>
      <td>{{contact_person}}</td>
      <td>{{contact_number}}</td>
      <td>{{email}}</td>
      <td>{{organization}}</td>
    <td>
    <form action="/contact" method="post">
        <input type="hidden" name="action" value="edit" />
        <input type="hidden" name="id" value="{{id}}" />
        <button type="submit" class='btn btn-primary btn-xs'>Edit</button>
    </form>
    </td>
    <td>
    <form action="/contact" method="post">
        <input type="hidden" name="action" value="delete" />
        <input type="hidden" name="id" value="{{id}}" />
        <button type="submit" class='btn btn-danger btn-xs'>Delete</button>
    </form>
    </td>
    </tr>
  {{/ contacts }}
  </table></div></div>
  <div class="col-lg-2"></div>
  <div id="add">
        <button class='btn btn-primary' data-toggle="modal" data-target="#myModal">Add Contact</button>

      <!--MODAL-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"><center>Add Contacts</center></h4></div>
            <div class="modal-body">
            <center>
            <form id="login-form" action="<?= base_url('/contact') ?>" method="post">
                <div class="login-row">
                  <input type="text" class="form-control" name="contact_person" placeholder="Contact Person" required>
                </div>
                <div class="login-row">
                  <input type="text" class="form-control" name="contact_number" placeholder="Contact Number" required>
                </div>
                <div class="login-row">
                  <input type="text" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="login-row">
                  <input type="text" class="form-control" name="organization" placeholder="Organization" required>
                </div>
                <div class="login-row">
                  <button type="submit" class="btn btn-primary" type="hidden" name="action" value="add">Add Contact</button>
                </div>
              </form>
            </center>
        </div><!-- modal header-->
      </div><!--modal content-->
    </div> <!--modal dialog-->
  </div> <!--modal-->
    </div>
  </div>
{{/ extra_content }}

{{/ layout }}