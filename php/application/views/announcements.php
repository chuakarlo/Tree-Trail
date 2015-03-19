{{< layout }}

{{$ extra_styles }}
  <link rel="stylesheet" href="<?= base_url('static/node_modules/datatables/media/css/jquery.dataTables.min.css'); ?>">
 {{/ extra_styles }}

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
      <h1>ANNOUNCEMENTS</h1>
      <h3><u></u></h3>
    </div> 
    <div class="col-lg-2"></div>
  </div>

    
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
      
      <div class="panel-body">
        <div class="table-responsive">
                    <!-- table starts here -->
    
                    <table id="announcementTable" class="table" cellspacing="0" width="100%">
                        
                        <thead>
                            <tr>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>

                        <tbody>
              
                            {{#announcements }}
                            <tr class="">

                                <td>
                                  <div class="panel-group wholeaccordio" id="accordion2" > 
                                    <div class="panel-success accpanel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title danger" >
                                                <a data-toggle="collapse" class="collapsed" data-parent="#accordion2" href="#{{id}}">
                                                  {{title}}
                                                </a>
                                            </h3>
                                              posted {{date}} by {{user}}
                                        </div> 
                                        <div id="{{id}}" class="panel-collapse collapse">
                                            <div class="panel-body"> 
                                              {{body}}
                                            </div>
                                        </div>  
                                    </div><!-- panel -->    
                                  </div><!-- panel-group --> 
                                </td>
                            
                            </tr>
                            {{/ announcements }}
                                                 
                        </tbody>
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
      </div>
    </div>

    </div>
    <div class="col-lg-2"></div>
  </div>
{{/ extra_content }}

{{$ extra_libs }}
  <script src="<?= base_url('static/node_modules/datatables/media/js/jquery.dataTables.min.js'); ?>"></script>  
{{/ extra_libs }}

{{$ extra_scripts }}
  <script>
    $('#announcementTable').DataTable();
  </script>
{{/ extra_scripts }}

{{/ layout }}