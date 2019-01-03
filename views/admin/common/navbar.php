<?php 
  $admin_session = $this->session->userdata('admin_logged_in');
  $user_data = getUserData($admin_session['admin_id']);
?>
<style>
.site-navbar .navbar-header .navbar-toggler {
    color: #00B3F0 !important;
}

.site-navbar .navbar-header .hamburger .hamburger-bar,
.site-navbar .navbar-header .hamburger::after,
.site-navbar .navbar-header .hamburger::before {
    background-color: #00B3F0 !important;
}
</style>
<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
  <div class="navbar-header" style="background-color: white;">
    <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
    data-toggle="menubar">
    <span class="sr-only">Toggle navigation</span>
    <span class="hamburger-bar"></span>
    </button>
    <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
    data-toggle="collapse" >
    <i class="icon md-more" aria-hidden="true"></i>
    </button>
    <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" style="padding:0px !important; margin-left: 23px;">
      <a href="<?php echo base_url('admin/dashboard');?>">
        <img  style="height:63px !important;" src="<?php echo base_url('assets/images/logo.png');?>" title="Dashboard">
      </a>
      
    </div>
    <!--<button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
    data-toggle="collapse">
    <span class="sr-only">Toggle Search</span>
    <i class="icon md-search" aria-hidden="true"></i>
    </button>-->
  </div>
  
  <div class="navbar-container container-fluid">
    <!-- Navbar Collapse -->
    <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
      <!-- Navbar Toolbar -->
      <ul class="nav navbar-toolbar">
        <li class="nav-item hidden-float" id="toggleMenubar">
          <a class="nav-link" data-toggle="menubar" href="#" role="button">
            <i class="icon hamburger hamburger-arrow-left">
            <span class="sr-only">Toggle menubar</span>
            <span class="hamburger-bar"></span>
            </i>
          </a>
        </li>
        <li class="nav-item hidden-sm-down" id="toggleFullscreen">
          <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
            <span class="sr-only">Toggle fullscreen</span>
          </a>
        </li>
        <!--<li class="nav-item hidden-float">
          <a class="nav-link icon md-search" data-toggle="collapse" href="#" data-target="#site-navbar-search"
            role="button">
            <span class="sr-only">Toggle Search</span>
          </a>
        </li>-->
      </ul>
      <!-- End Navbar Toolbar -->
      
      <!-- Navbar Toolbar Right -->
      
      <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
        <?php if($admin_session['role']=="owner"):
        $businesses = getBusinessesForAdmin();
        ?>
        <li>
          <form method="post" name="set_business" action="<?= base_url('admin/Dashboard/set_business') ?>">
            <select name="bid" onchange="setBusiness()" class="form-control" style="margin-top: 15px;">
              <option value="">Choose a Business</option>
              <?php foreach ($businesses as $key => $value):
              $selected = ($admin_session['business_id']==$value['id'])?"selected":"";
              ?>
              <option <?= $selected; ?> value="<?=$value['id']?>"><?= $value['name']." (". $value['owner_first_name']." ".$value['owner_last_name'].")" ?></option>
              <?php endforeach ?>
            </select>
          </form>
        </li>
        <?php endif ?>
        <?php if($admin_session['role']=="staff" or $admin_session['role']=="location_owner"):
        // gs($admin_session);die;
        $locations = getLocationsForStaff($admin_session['business_id']);
        $status = getStaffAttendenceStatus($admin_session['staff_id']);
        ?>
        <?php if (count((array)$status['previous_status'])==0){ ?>
        <li>
          <form method="post" name="set_attendence" action="<?= base_url('admin/Staff/set_attendence') ?>">
            <?php if(count((array)$status['current_status'])==0): ?>
            <select name="location_id" class="form-control" style="margin-top: 15px;">
              <option value="">Choose a Location</option>
              <?php foreach ($locations as $key => $value):
              $selected = ($admin_session['location_id']==$value['id'])?"selected":"";
              ?>
              <option <?= $selected; ?> value="<?=$value['id']?>"><?= $value['location_name']; ?></option>
              <?php endforeach ?>
            </select>
            <?php else: ?>
            <span class="badge badge-dark badge-outline" style="margin-top: 17px;font-size: 14px;">Checked in at <?php echo date("h:i a",strtotime($status['current_status']['start_hours'])); ?></span>
            <input type="hidden" value="<?= $status['current_status']['id']; ?>" name="attendence_id">
            <?php endif ?>
          </form>
        </li>
        <?php if(count((array)$status['current_status'])==0): ?>
        <li><button onclick="setAttendence()" type="button" style="margin-top: 14px;margin-left: 12px;" class="btn btn-info">Checkin</button></li>
        <?php else: ?>
        <li><button onclick="setAttendence()" type="button" style="margin-top: 14px;margin-left: 12px;" class="btn btn-info">CheckOut</button></li>
        <?php endif ?>
        <?php }else{
        if($status['uri'] !="attendence"){
        redirect('admin/staff/attendence');
        }
        ?>
        <div class="panel panel-default" id="exampleNiftyJustMe" style="position: absolute;width: 100%;left: 0px;z-index: 9999;height: -webkit-fill-available;" >
          
          <div class="panel-body">
            <div class="alert alert-danger">
              <p>You have a previous uncompleted shift of <b><?= date("j M Y, l",strtotime($status['previous_status']['checkin_date'])) ?></b>&nbsp;,Please complete the shift by filling the form to perform futher actions.</p>
            </div>
            <div class="mform" style="width: 400px;margin: 20px auto;padding: 20px;border:1px solid #ddd;">
              <form method="post" action="<?= base_url('admin/staff/saveUncompletedShift') ?>">
                <input type="hidden" value="save" name="action">
                <div class="row">
                  <input type="hidden" required="required" value="<?=$status['previous_status']['id']?>" name="attendence_id">
                  <div class="col-md-6">
                    <label>SHIFT END</label>
                    <input required="required" type="text" class="form-control timepicker" name="end_hours">
                  </div>
                  <div class="col-md-6">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-info btn-block">Save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php } ?>
        <?php endif ?>
        <?php if ($admin_session['role'] =="business_owner"):
          ?>  
        <li>
          <?php if ($user_data['trial_expire_date'] > date('Y-m-d') && $user_data['payment_status'] == 0): ?>
              <div class="alert dark alert-warning" role="alert" style="margin-top: 11px;padding: 3px 20px;">
                Your free trial will expires on  <b><?php echo date("d F Y",strtotime($user_data['trial_expire_date'])); ?>&nbsp;(<?php echo ddiff($user_data['trial_expire_date']) ?> Days Left)</b>&nbsp; <a href="<?php echo base_url('admin/service/membership_payment') ?>" class="btn btn-danger btn-sm">Activate Now</a>
              </div>
          <?php elseif($admin_session['trial_expire_date'] <= date('Y-m-d') && $admin_session['payment_status'] == 0): ?>
            <div class="alert dark alert-warning" role="alert" style="margin-top: 11px;padding: 3px 20px;">
                Your free trial is now finished and you're ready to activate your account.  <a href="<?php echo base_url('admin/service/membership_payment') ?>" class="btn btn-danger btn-sm">Activate Now</a>
            </div>                  
          <?php endif ?>        
        </li>
        <?php endif ?>
        <li class="nav-item dropdown" style="width:280px;text-align:right">
          <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"
            aria-expanded="false" role="button">

            <span ><strong><span style="text-transform: capitalize;">( <?=$admin_session['role']?> )</span> <?php echo substr(ucfirst($admin_session['admin_name']),0,12);?></strong></span>
          </a>
          
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
            data-animation="scale-up" role="button">
            <span class="avatar avatar-online">
              <img src="<?php echo base_url('global/portraits/5.jpg');?>" alt="...">
              <i></i>
            </span>
          </a>
          <div class="dropdown-menu" role="menu">
            <!--<a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> Profile</a>
            <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-settings" aria-hidden="true"></i> Settings</a>
            <div class="dropdown-divider" role="presentation"></div>-->
            <?php if($admin_session['role']=='business_owner'){ ?>
             <a class="dropdown-item" href="<?php echo base_url('admin/business/company_detail');?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i> Profile</a> 
            <?php }elseif($admin_session['role']=='location_owner' or $admin_session['role']=='staff'){ ?>
            <a class="dropdown-item" href="<?php echo base_url('admin/user/change_staff_profile');?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i> Profile</a>
            <?php }elseif($admin_session['role']=='owner' ){ ?>
            <a class="dropdown-item" href="<?php echo base_url('admin/user/change_owner_profile');?>" role="menuitem"><i class="icon md-eye" aria-hidden="true"></i> Profile</a>
            <?php } ?>
            <a class="dropdown-item" href="<?php echo base_url('admin/user/change_password');?>" role="menuitem"><i class="icon md-key" aria-hidden="true"></i> Change Password</a>
            <a class="dropdown-item" href="<?php echo base_url('admin/logout');?>" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Logout</a>
          </div>
        </li>
      </ul>
      <!-- End Navbar Toolbar Right -->
    </div>
    <!-- End Navbar Collapse -->
    
    <!-- Site Navbar Seach -->
    <div class="collapse navbar-search-overlap" id="site-navbar-search">
      <form role="search">
        <div class="form-group">
          <div class="input-search">
            <i class="input-search-icon md-search" aria-hidden="true"></i>
            <input type="text" class="form-control" name="site-search" placeholder="Search...">
            <button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search"
            data-toggle="collapse" aria-label="Close"></button>
          </div>
        </div>
      </form>
    </div>
    <!-- End Site Navbar Seach -->
  </div>
</nav>
<!-- End Modal -->
<script type="text/javascript">

function setBusiness(){
document.set_business.submit();
}
function setAttendence(){
document.set_attendence.submit();
}
</script>