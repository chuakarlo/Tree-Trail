{{< layout }}
{{$ extra_inline_styles }}
    .contact{
      text-align: center;
    }
    #layout-form{
      display: inline-block;
      width: 400px;
    }
    #layout-form .layout-row{
      display: inline-block;
      width: 250px;
      padding: 0 15px 15px;
    }
    
{{/ extra_inline_styles }}
{{$ extra_content }}
<div>
	 <div class="contact"> <h1>Edit Contact</h1></br> </div> 
  {{#contactedit}}
  <div class="col-lg-2"></div>
  <div class="col-lg-8"><center />
   <form id="layout-form" action="<?= base_url('/contact') ?>" method="post">
                <div class="layout-row">
                  	<input type="text" class="form-control" name="contact_person" value="{{contact_person}}" required>
                </div>
                <div class="layout-row">
                  <input type="text" class="form-control" name="contact_number" value="{{contact_number}}" required>
                </div>
                <div class="layout-row">
                  <input type="text" class="form-control" name="email" value="{{email}}" required>
                </div>
                <div class="layout-row">
                  <input type="text" class="form-control" name="organization" value="{{organization}}" required>
                </div>
                <div class="layout-row">
                  <input type="hidden" class="form-control" name="id" value="{{id}}">
                </div>
                <div class="layout-row">
                  <button type="submit" class="btn btn-primary" type="hidden" name="action" value="edited">Save Contact</button>
                </div>
     </form>

 </div>
  <div class="col-lg-2"></div>
  {{/contactedit}}
</div>
{{/ extra_content }}

{{/ layout }}