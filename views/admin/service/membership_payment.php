<?php 
$this->load->view('admin/common/header'); ?>

<body class="animsition app-contacts page-aside-left">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar_mem'); ?>
  <!-- Page -->
  <style type="text/css">
    .pricing-list .pricing-price{
      font-size: 2.858rem;
    }
  </style>
  <style type="text/css">
    .pricing-list .pricing-price{
    font-size: 1.858rem;
  }
  .pricing-title{
    background-color: #0E7CA0;
      color: #fff;
      font-size: 21px!important;
    }
    

    

  </style>

  <div class="page" style="margin-left:0px !important;">
     <?php if ($admin_session['role']=='business_owner') { ?>
    <?php $this->load->view('admin/common/header_messages'); ?>
    <?php }?>

    <div class="page-main">
      <div class="page-content">
        <div class="panel">
     
     <!-- Contacts Content Header -->
          <div class="panel-heading">
             
            <h1 class="panel-title">
               <?php if ($admin_session['role']=='business_owner') { ?>
            Membership
            <?php }?>
          </h1>
            
            <div class="page-header-actions">
              <a href="<?php echo base_url('admin/logout');?>"><button type="button" class="btn btn-block btn-primary">Back</button></a>
            </div>
          </div>
          <!-- Contacts Content -->
        <div class="panel-body container-fluid">
          
          <!-- Example Pricing List -->
          <div class="example-wrap" style="margin-bottom:20px;">
            
            <div class="example">
               <?php if ($admin_session['role']=='staff') { ?>
               <img   src="<?php echo base_url('assets/images/renewal.png');?>" alt="..." style="padding-left: 45%; height: 170px;">
                <div class="row">

                  
                    <h4 style="color: red; text-align:center; padding-left: 24%;">Seems like your Business Plan has expired, please contact your Business Owner for renewal.</h4>
                 

                </div>

                <?php }?>




              <?php if ($admin_session['role']=='business_owner') { ?>              
             

              <div class="row">
                <?php foreach ($plans as $key => $value): ?>                
                <div class="col-md-6 col-xl-3">
                  <form action="<?php echo base_url('/admin/service/make_payment') ?>" method="POST">
                  <input name="plan" type="hidden" value="<?=$value['stripe_plan_id']?>" />
                  <input name="plan_name" type="hidden" value="<?=$value['name']?>" />
                  <input name="plan_price" type="hidden" value="<?=$value['plan_price']?>" />
                  <input name="plan_staff_limit" type="hidden" value="<?=$value['staff_allowed']?>" />
                  <div class="pricing-list">
                    <div class="pricing-header">
                      <div class="pricing-title"><?=$value['name']?></div>
                      <div class="pricing-price">
                        <span class="pricing-currency">$</span>
                        <span class="pricing-amount"><?=$value['plan_price']?></span>
                        <span class="pricing-period">/ mo</span>
                      </div>
                    </div>
                    <ul class="pricing-features">
                      <li>You have <strong><?=$value['staff_allowed']?> Bookable Staff</strong></li>
                    </ul>
                    <div class="pricing-footer">
                     <script
                      src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                      data-key="<?=$stripe_keys['publishable_key']?>"
                      data-image=""
                      data-email="<?=$admin_session['admin_email']?>"
                      data-name="<?=$value['name']?>"
                      data-description="You have <?=$value['staff_allowed']?> Bookable Staff"
                      data-panel-label="Pay $<?=$value['plan_price']?>"
                      data-label="Pay $<?=$value['plan_price']?>"
                      data-locale="auto">
                    </script>
                    </div>
                  </div>
                </form>
                </div>
                <?php endforeach ?>
              </div>
              <?php } ?>

            </div>
          </div>
          <!-- End Example Pricing List -->        
      </div>
    </div>
    <!-- End Panel -->
  </div>
</div>
</div>
<!-- End Page -->
<?php $this->load->view('admin/common/footer'); ?>