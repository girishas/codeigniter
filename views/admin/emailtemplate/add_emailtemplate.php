<?php $this->load->view('admin/common/header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('global/vendor/summernote/summernote.css') ?>">
<body class="animsition">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  
  <!-- Page -->
  <div class="page">
    <!-- Alert message part -->
    <?php $this->load->view('admin/common/header_messages'); ?>
    <!-- End alert message part -->
    <div class="page-content">
      <div class="panel">

        <div class="page-header">
          <h1 class="page-title">Add Template</h1>
          <div class="page-header-actions">
            <a class="btn btn-info" href="<?php echo base_url('admin/emailtemplate');?>">All Tempaltes </a>
            <a class="btn btn-primary " href="<?php echo base_url('admin/setup');?>"> Setup </a>
          </div>
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-md-8">
              <form method="post">
                <input type="hidden" name="action" value="save">
              <div class="form-group" data-plugin="formMaterial">
                <label class="form-control-label" for="inputGrid1">Title*</label>
                <input type="text" class="form-control" name="title" id="title">
                <span class="text-danger"><?php echo form_error('title'); ?></span>
              </div>

              <div class="form-group" data-plugin="formMaterial">
                <label class="form-control-label" for="inputGrid1">Slug*</label>
                <input type="text" class="form-control" name="slug" id="slug">
                 <span class="text-danger"><?php echo form_error('slug'); ?></span>
              </div>

              <div class="form-group" data-plugin="formMaterial">
                <label class="form-control-label" for="inputGrid1">Subject*</label>
                <input type="text" class="form-control" name="subject" id="subject">
                 <span class="text-danger"><?php echo form_error('subject'); ?></span>
              </div>

              <div class="form-group" data-plugin="formMaterial">
                <label class="form-control-label" for="inputGrid1">Shortcodes*</label>
                <input type="text" class="form-control" name="shortcodes" id="shortcodes">
                 <span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
              </div>

              <div class="form-group" data-plugin="formMaterial">
                <label class="form-control-label" for="inputGrid1">Shortcodes*</label>
                <textarea class="form-control" name="email_html" id="myEditor"></textarea>
                 <span class="text-danger"><?php echo form_error('shortcodes'); ?></span>
              </div>

              <div class="form-group" data-plugin="formMaterial">
               <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Page -->
  <!-- End page -->
  <script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
  <script type="text/javascript">
    $(document).ready(function(){
       $('#myEditor').summernote({
        height:200
       });
    });
$("#title").keyup(function(){
    var Text = $(this).val();
    Text = convertToSlug(Text)
    $("#slug").val(Text);    
});
$("#title").change(function(){
    var Text = $(this).val();
    Text = convertToSlug(Text)
    $("#slug").val(Text);    
});

    function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'');
}
  </script>
  <?php $this->load->view('admin/common/footer'); ?>