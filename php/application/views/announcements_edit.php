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
	 <div class="contact"> <h1>Edit Announcement</h1></br> </div> 
  {{#announcementsedit}}
  <div class="col-lg-2"></div>
  <div class="col-lg-8"><center />
   <form id="layout-form" action="<?= base_url('/announcements') ?>" method="post">
                <div class="form-group">
                  <label for="title" class="control-label">Announcement Title:</label>
                  <input id="title" type="text" class="form-control" name="title" placeholder="Title" value="{{title}}" required>
                </div>
                <div class="form-group">
                  <label for="body" class="control-label">Content:</label>
                  <textarea id="body" type="textarea" class="form-control" name="body" placeholder="Content" rows="5" required>{{body}}</textarea>
                </div>
                <input type="hidden" name="user" value="<?php echo $this->login->getName($this->session->userdata("user_id")); ?>"/>
                <input type="hidden" name="date" value="<?php echo date("Y-m-d h:i:sa"); ?>"/>
                <input type="hidden" class="form-control" name="id" value="{{id}}">
                <div class="layout-row">
                  <button type="submit" class="btn btn-primary" type="hidden" name="action" value="edited">Save Announcement</button>
                </div>
     </form>

 </div>
  <div class="col-lg-2"></div>
  {{/announcementsedit}}
</div>
{{/ extra_content }}

{{/ layout }}