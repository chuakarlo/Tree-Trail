{{< layout }}

{{$ extra_inline_styles }}
    #contact{
      text-align: left;
    }
    #add{
      text-align: center;
    }
    u:after{
      content: "............................................................................";
    color: transparent;
    }
    em{
    color:green;
  }
{{/ extra_inline_styles }}

{{$ extra_content}}
 <div class="content"> 
  <div class="col-lg-12">
    <div class="col-lg-2"></div>
    <div class="col-lg-8" id="contact"> 
      <h1>Join Our Advocacy</h1>
      <h3><u>Towards a <em>GREENER</em> Cebu </u></h3>
      <h3>You may contact any of the following</h3>
    </div> 
    <div class="col-lg-2"></div>
  </div>

    
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
 <div class="table-responsive">
  <table class ="table table-hover" id="tblContacts">
    
  {{#contacts }}
    <tr>
      <td>
    <div class="col-lg-3">
      <img src="<?= base_url('/static/uploaded_photos') ?>/{{image_path}}" onerror="this.src= '<?= base_url('/static/images/plchlder.png') ?>'" id="loading" height="150" width="150" border="1px">
    </img>
    </div>
    <div>
      <strong>Contact: </strong>{{contact_person}}</br>
      <strong>Number: </strong>{{contact_number}}</br>
      <strong>Email: </strong>{{email}}</br>
      <strong>Organization: </strong>{{organization}}</td>
      </div>
    </tr>
  {{/ contacts }}
  </table></div></div>
  <div class="col-lg-2"></div>
    </div>
  </div>
{{/ extra_content }}

{{$ extra_scripts }}{{/ extra_scripts }}

{{/ layout }}