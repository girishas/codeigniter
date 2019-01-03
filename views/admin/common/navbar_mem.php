 <?php $admin_session = $this->session->userdata('admin_logged_in'); ?>
 <style type="text/css">
 .site-navbar {

    background-color: white !important;   
    border-color: #00a0d7;

}
   
 </style>
 <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">    
      <div class="navbar-header">
       
      <!--   <div class="navbar-brand navbar-brand-center site-gridmenu-toggle">         
		  <img class="navbar-brand-logo" src="<?php echo base_url('assets/images/logo.png');?>" title="Dashboard"> 
        </div> -->

        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" style="padding:0px !important; margin-left: 23px;">
      <a href="<?php echo base_url('admin/dashboard');?>">
        <img  style="height:63px !important;" src="<?php echo base_url('assets/images/logo.png');?>" title="Dashboard">
      </a>
      
    </div>

       
      </div>
    
      <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
          
         
          <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
          
            <li class="nav-item dropdown" style="width:280px;text-align:right">
              <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"
                aria-expanded="false" role="button">
                <span >Logged in as <strong><?php echo ucfirst($admin_session['admin_name']);?></strong></span>
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
    <script type="text/javascript">
      function setBusiness(){
        //$("#setBusiness").submit();
        document.set_business.submit();
      }
    </script>