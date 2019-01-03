<!DOCTYPE html>
 <html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Booking In Time">
    <meta name="author" content="">
    
    <title><?php if (isset($invoice_active_open)) {
           echo "Invoice | Booking In Time";
			} elseif (isset($expense_active_open)) {
             echo "POS | Booking In Time";
         } elseif (isset($appointment_active_open)) {
           echo "Appointment | Booking In Time";
        }  elseif (isset($customer_active_open)) {
           echo "Customer | Booking In Time";
        }  elseif (isset($staff_active_open)) {
           echo "Staff | Booking In Time";
        }  elseif (isset($roster_active_open)) {
           echo "Roster | Booking In Time";
        }  elseif (isset($attendence_active_open)) {
           echo "Attendence | Booking In Time";
        }  elseif (isset($product_active_open)) {
           echo "Inventory | Booking In Time";
        }  elseif (isset($voucher_active_open)) {
           echo "Voucher | Booking In Time";
        }  elseif (isset($service_active_open)) {
           echo "Service | Booking In Time";
        }  elseif (isset($pre_gst_manager_active_open)) {
           echo "Pre Gst Manager | Booking In Time";
        }  elseif (isset($gst_ato_manager_active_open)) {
           echo "Gst ATO Manager | Booking In Time";
        }  elseif (isset($reports_active_open)) {
           echo "Reports | Booking In Time";
        }  elseif (isset($booking_widget_active_open)) {
           echo "Embed Booking Widget | Booking In Time";
        }  elseif (isset($audit_history_active_open)) {
           echo "Audit History | Booking In Time";
        }  elseif (isset($setup_active_open)) {
           echo "Setup | Booking In Time";
        } ?>
</title>
    
    <link rel="apple-touch-icon" href="<?php echo base_url('assets/images/apple-touch-icon.png');?>">
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico');?>">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url('global/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/css/bootstrap-extend.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/site_new.min.css');?>">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/animsition/animsition.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/asscrollable/asScrollable.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/switchery/switchery.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/intro-js/introjs.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/slidepanel/slidePanel.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/flag-icon-css/flag-icon.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/waves/waves.css');?>">
    
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/datatables.net-bs4/dataTables.bootstrap4.css');?>">
     <link rel="stylesheet" href="<?php echo base_url('global/css/pace-theme-minimal.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/examples/css/tables/datatable.css');?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/examples/css/apps/contacts_new.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/fonts/font-awesome/font-awesome.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('global/vendor/timepicker/jquery-timepicker.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css');?>">

    <!-- select2 -->
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/select2/select2.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/bootstrap-sweetalert/sweetalert.min.css');?>">
    
    <!-- select2 -->
    
    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo base_url('global/fonts/material-design/material-design.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/css/custom.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/css/pace-theme-minimal.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/fonts/brand-icons/brand-icons.min.css');?>">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('global/vendor/html5shiv/html5shiv.min.js');?>"></script>
    <![endif]-->
    
    <!--[if lt IE 10]>
    <script src="<?php echo base_url('global/vendor/media-match/media.match.min.js');?>"></script>
    <script src="<?php echo base_url('global/vendor/respond/respond.min.js');?>"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="<?php echo base_url('global/vendor/breakpoints/breakpoints.js');?>"></script>
	<script src="<?php echo base_url('assets/js/Chart.js');?>"></script>
    <script>
      Breakpoints();
	 
    </script>
  </head>