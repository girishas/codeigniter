<?php $this->load->view('admin/common/header'); ?>
<body class="animsition">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <div class="page">
    <div class="page-content">
      <div class="panel">
        <div class="page-header">
          <h1 class="page-title">Embed Booking Widget</h1>
          <div class="page-header-actions"></div>
        </div>
        <div class="page-content container-fluid">
          <div class="row">
            <?php if($admin_session['role']=="owner" && $admin_session['business_id']==''): ?>
            <div class="col-md-12">
              <div class="alert dark alert-icon alert-info alert-dismissible" role="alert">
                <i class="icon md-info-outline" aria-hidden="true"></i> Please select a business to use booking widget.
              </div>
            </div>
            <?php else: ?>
            <div class="col-md-6">
              <!-- Panel Static Labels -->
              <div class="form-group  row" data-plugin="formMaterial">
                <div class="col-md-12">
                  <label class="form-control-label" for="inputGrid1">Add online bookings inside a page on your own website. Adjust the frame height to suit your page layout, then copy the embed code to add in your webpage HTML</label> 
                  <div class="row">
                    <div class="col-md-6">FRAME HEIGHT (PX):<br/>
                      <input type="text" class="form-control height" name="wg_height" id="inputPlaceholder" value="500" placeholder="500px">
                    </div>
                  </div> 
                </div>
              </div>
              <div class="form-group  row" data-plugin="formMaterial">
                <div class="col-md-12">
                  <label class="form-control-label" for="inputGrid1">Embed CODE FOR YOUR WEBSITE</label>
                  <textarea class="form-control copyText appendsrc" id="textareaDefault" rows="4"></textarea>
                </div>
              </div>
              <div class="form-group  row" data-plugin="formMaterial">
                <div class="col-md-12">
                  <button class="btn btn-primary" data-dismiss="modal" type="button" onclick="copyFunction()">Copy Code</button>
                </div>
              </div>
                  <label class="form-control-label" id="embeded" for="inputGrid1"> EMBED PREVIEW</label>
                  <!-- <iframe id="shedulWidget" class="embeddsrc" src="" style="width: 100%; max-width: 991px; height: 500px; border: 1px solid rgb(128, 128, 128);"></iframe> -->
                  <div class="embed-preview"></div>
              <!-- End Panel Static Labels -->
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Page -->
  <?php $this->load->view('admin/common/footer'); ?>
  <script>
  // alert(site_url);
  //var width = '600';
  var add_last = '<?php echo base64_encode($admin_session['business_id'].'_app.bit');?>';
  var srcvalue = site_url+'online-bookings/'+add_last;
  var height = 500;
  $(document).ready(function(){
  var height = $(".height").val();
  $(".appendsrc").val('<iframe id="shedulWidget" class="embeddsrc" src="'+srcvalue+'" style="width:100%;max-width: 991px; height:'+height+'px;border: 1px solid rgb(128, 128, 128);"></iframe>');
  $(".embed-preview").html('<iframe id="shedulWidget" class="embeddsrc" src="'+srcvalue+'" style="width:100%;max-width: 991px; height:'+height+'px;border: 1px solid rgb(128, 128, 128);"></iframe>');
  });
  
/*  jQuery(document).on('blur keyup paste copy cut mouseup change','.width',function(){
  width = $(this).val();
  $( "#textareaDefault" ).html( '<iframe id="shedulWidget" src="'+srcvalue+'" style=" max-width: 100%; height:px; border: 1px solid rgb(128, 128, 128);"></iframe>');
  $("#shedulWidget").css("width",width+"px");

  });*/

  jQuery(document).on('blur paste copy cut change','.height',function(){
  height = $(this).val();
  $("#textareaDefault").val('<iframe id="shedulWidget" class="embeddsrc" src="'+srcvalue+'" style="width:100%;max-width: 991px; height:'+height+'px;border: 1px solid rgb(128, 128, 128);"></iframe>');
  //$("#shedulWidget").css("height",height+"px");
  $(".embed-preview").html('<iframe id="shedulWidget" class="embeddsrc" src="'+srcvalue+'" style="width:100%;max-width: 991px; height:'+height+'px;border: 1px solid rgb(128, 128, 128);"></iframe>');
  });
  function copyFunction() {
    $("textarea").select();  
    document.execCommand("copy");
  }
  </script>