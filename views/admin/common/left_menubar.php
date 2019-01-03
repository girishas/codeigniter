<?php $admin_session = $this->session->userdata('admin_logged_in');
	if($admin_session['role']=='staff' || $admin_session['role']=='location_owner' || $admin_session['role']=='business_manager' ){
		$loggedUserId = $admin_session['staff_id'];
	}else {
		$loggedUserId = $admin_session['admin_id'];
	}?>
<div class="site-menubar">
	<div class="site-menubar-body">
        <div>
			<div>
				<ul class="site-menu" data-plugin="menu">
					<!-- <li class="site-menu-category">General</li>-->
					
					<li class="site-menu-item <?php if(isset($dashboard_active_open) && $dashboard_active_open) echo "active";?>">
						<a class="animsition-link" href="<?php echo base_url('admin/dashboard');?>">
							<i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
							<span class="site-menu-title">Dashboard</span>
						</a>
					</li>
					<?php if(is_permissible($loggedUserId,'service','calendar')){ ?>
					<li class="site-menu-item has-sub <?php if(isset($calendar_active_open) && $calendar_active_open) echo "active";?>">
						<a href="<?php echo base_url('admin/service/calendar');?>">
							<i class="site-menu-icon md-calendar-check" aria-hidden="true"></i>
							<span class="site-menu-title">Calendar</span> 
						</a>
					</li> <?php } ?>
					
					<?php if(is_permissible($loggedUserId,'invoice','index')){?>  
						<li class="site-menu-item has-sub <?php if(isset($invoice_active_open) && $invoice_active_open) echo "active open";?>">
							<a href="<?php echo base_url('admin/invoice');?>">
								<i class="site-menu-icon md-money-box" aria-hidden="true"></i>
								<span class="site-menu-title">Invoices</span> 
							</a> 
						</li>
					<?php } ?>
					
					
					
					<?php if(is_permissible($loggedUserId,'expense','index')){?>
						<li class="site-menu-item has-sub <?php if(isset($expense_active_open) && $expense_active_open) echo "active open";?>">
							<a href="<?php echo base_url('admin/expense');?>">
								<i class="site-menu-icon md-money" aria-hidden="true"></i>
								<span class="site-menu-title">POS</span> 
							</a>
							
						</li><?php } 
						if(is_permissible($loggedUserId,'expense','index')){?>
						<li class="site-menu-item has-sub <?php  if(isset($appointment_active_open) && $appointment_active_open) echo "active";?>">
							<a href="<?php echo base_url('admin/service/appointments');?>">
								<i class="site-menu-icon md-airline-seat-recline-normal" aria-hidden="true"></i>
								<span class="site-menu-title">Appointments</span> 
							</a> 
						</li>
						<?php } if(is_permissible($loggedUserId,'customer','index')){?>
						<li class="site-menu-item has-sub <?php if(isset($customer_active_open) && $customer_active_open) echo "active";?>">
							<a href="<?php echo base_url('admin/customer');?>">
								<i class="site-menu-icon md-accounts-alt" aria-hidden="true"></i>
								<span class="site-menu-title">Customers</span> 
							</a> 
						</li>
						<?php } if(is_permissible($loggedUserId,'staff','index')){?>
						<li class="site-menu-item <?php if(isset($staff_active_open) && $staff_active_open) echo "active";?>">
							<a class="animsition-link" href="<?php echo base_url('admin/staff');?>">
								<i class="site-menu-icon md-group" aria-hidden="true"></i>
								<span class="site-menu-title">Staff Members</span>
							</a>
						</li>
						<?php } if(is_permissible($loggedUserId,'staff','roster_new')){?>
							<li class="site-menu-item <?php if(isset($roster_active_open) && $roster_active_open) echo "active";?>">
								<a class="animsition-link" href="<?php echo base_url('admin/staff/roster_new');?>">
									<i class="site-menu-icon icon md-time" aria-hidden="true"></i>
									<span class="site-menu-title">Roster</span>
								</a>
							</li>
						<?php } if(is_permissible($loggedUserId,'staff','attendence')){?>
						<li class="site-menu-item <?php if(isset($attendence_active_open) && $attendence_active_open) echo "active";?>">
							<a class="animsition-link" href="<?php echo base_url('admin/staff/attendence');?>">
								<i class="site-menu-icon icon md-assignment-check" aria-hidden="true"></i>
								<span class="site-menu-title">Attendance</span>
							</a>
						</li>
						<?php } if(is_permissible($loggedUserId,'product','index')){?>
						<li class="site-menu-item has-sub <?php if(isset($product_active_open) && $product_active_open) echo "active open";?>">
							<a  href="<?php echo base_url('admin/product');?>">
								<i class="site-menu-icon md-shopping-cart" aria-hidden="true"></i>
								<span class="site-menu-title">Inventory</span> 
								
							</a>  
						</li> 
						<?php } if(is_permissible($loggedUserId,'voucher','index')){?>
						<li class="site-menu-item has-sub <?php if(isset($voucher_active_open) && $voucher_active_open) echo "active open";?>">
							<a href="<?php echo base_url('admin/voucher');?>">
								<i class="site-menu-icon md-card-giftcard" aria-hidden="true"></i>
								<span class="site-menu-title">Vouchers</span>
								
							</a> 
						</li> 
						<?php } if(is_permissible($loggedUserId,'service','index')){?>
							<li class="site-menu-item has-sub <?php  if(isset($service_active_open) && $service_active_open) echo "active";?>">
								<a href="<?php echo base_url('admin/service');?>">
									<i class="site-menu-icon md-seat" aria-hidden="true"></i>
									<span class="site-menu-title">Services</span> 
								</a> 
							</li>
						<?php } if(is_permissible($loggedUserId,'reports','pre_gst_manager')){?>
							<li class="site-menu-item has-sub <?php if(isset($pre_gst_manager_active_open) && $pre_gst_manager_active_open) echo "active open";?>">
								<a href="<?php echo base_url('admin/reports/pre_gst_manager');?>">
									<i class="site-menu-icon md-accounts-list" aria-hidden="true"></i>
									<span class="site-menu-title">Pre Gst Manager</span> 
								</a>
								
							</li>
						<?php } if(is_permissible($loggedUserId,'reports','gst_ato_manager')){?>
							<li class="site-menu-item has-sub <?php if(isset($gst_ato_manager_active_open) && $gst_ato_manager_active_open) echo "active open";?>">
								<a href="<?php echo base_url('admin/reports/gst_ato_manager');?>">
									<i class="site-menu-icon md-accounts-list-alt" aria-hidden="true"></i>
									<span class="site-menu-title">Gst Ato Manager</span> 
								</a>
								
							</li>
						<?php } if(is_permissible($loggedUserId,'reports','index')){?>
							<li class="site-menu-item has-sub <?php if(isset($reports_active_open) && $reports_active_open) echo "active open";?>">
								<a href="<?php echo base_url('admin/reports');?>">
									<i class="site-menu-icon md-assignment-o" aria-hidden="true"></i>
									<span class="site-menu-title">Reports</span> 
								</a>
								
							</li>
						<?php } if(is_permissible($loggedUserId,'service','booking_widget')){?> 	
							<li class="site-menu-item has-sub <?php if(isset($booking_widget_active_open) && $booking_widget_active_open) echo "active";?>">
								<a href="<?php echo base_url('admin/service/booking_widget');?>">
									<i class="site-menu-icon md-code-setting" aria-hidden="true"></i>
									<span class="site-menu-title">Embed Booking Widget</span> 
								</a>
								
							</li> 
						<?php } if(is_permissible($loggedUserId,'audit','history')){?>
							<!--<li class="site-menu-item has-sub <?php if(isset($audit_history_active_open) && $audit_history_active_open) echo "active";?>">
								<a href="<?php echo base_url('admin/audit/history');?>">
									<i class="site-menu-icon md-assignment-o" aria-hidden="true"></i>
									<span class="site-menu-title">Audit History</span> 
								</a>
								
							</li>--> 
						<?php } if(is_permissible($loggedUserId,'setup','index')){?>
							<li class="site-menu-item has-sub <?php if(isset($setup_active_open) && $setup_active_open) echo "active open";?>">
								<a href="<?php echo base_url('admin/setup');?>">
									<i class="site-menu-icon md-settings" aria-hidden="true"></i>
									<span class="site-menu-title">Setup</span> 
								</a>
								
							</li>
						<?php } ?>
						
						<?php if($admin_session['role']=="owner"){?>
							<li class="site-menu-item <?php if(isset($admin_active_open) && $admin_active_open) echo "active";?>">
								<a class="animsition-link" href="<?php echo base_url('admin/user');?>">
									<i class="site-menu-icon md-group" aria-hidden="true"></i>
									<span class="site-menu-title">Admin</span>
								</a>
							</li>
							<li class="site-menu-item <?php if(isset($business_active_open) && $business_active_open) echo "active";?>">
								<a class="animsition-link" href="<?php echo base_url('admin/business');?>">
									<i class="site-menu-icon md-group" aria-hidden="true"></i>
									<span class="site-menu-title">Business</span>
								</a>
							</li>

							<li class="site-menu-item <?php if(isset($plan_active_open) && $plan_active_open) echo "active";?>">
								<a class="animsition-link" href="<?php echo base_url('admin/business/assign_plan');?>">
									<i class="site-menu-icon md-chart" aria-hidden="true"></i>
									<span class="site-menu-title">Assign Plan</span>
								</a>
							</li>

						<?php } ?>
						<?php /*	 		 
							<li class="site-menu-item has-sub <?php if(isset($admin_active_open) && $admin_active_open) echo "active open";?>">
							<a href="javascript:void(0)">
							<i class="site-menu-icon md-group" aria-hidden="true"></i>
							<span class="site-menu-title">Members</span>
							<span class="site-menu-arrow"></span>
							</a> 
							<ul class="site-menu-sub">
							<li class="site-menu-item">
							<a class="animsition-link" href="<?php echo base_url('admin/user');?>">
							<!-- <?php if($admin_session['role'] =="business_owner"){?> 
							<span class="site-menu-title">Location Admin</span>
							<?php }else{ ?> -->
							<span class="site-menu-title">Admin</span>
							<!-- <?php } ?> -->
							</a>
							</li>
							</ul>  
							<?php if($admin_session['role']=="owner"){?>
							<ul class="site-menu-sub"> 
							<li class="site-menu-item">
							<a class="animsition-link" href="<?php echo base_url('admin/business');?>">
							<span class="site-menu-title">Business</span>
							</a>
							</li>
							</ul>  
							<?php } ?>	
							<ul class="site-menu-sub <?php if(isset($staff_active_open) && $staff_active_open) echo "active open";?>">
							<li class="site-menu-item">
							<a class="animsition-link" href="<?php echo base_url('admin/staff');?>">
							<span class="site-menu-title">Staffs & Location Owners</span>
							</a>
							</li>
							</ul> 					 
						</li>  */ ?>
						<?php /*if($admin_session['role'] !="owner"){?>  
							<li class="site-menu-item has-sub <?php  if(isset($appointment_create) && $appointment_create) echo "active open";?>">
							<a href="<?php echo base_url('admin/service/add_appointment');?>">
							<i class="site-menu-icon md-airline-seat-recline-normal" aria-hidden="true"></i>
							<span class="site-menu-title">Book an Appointment</span> 
							</a> 
							</li>
						<?php } */?>	
						<?php if($admin_session['role'] =="owner"){?>  
							<!--  <li class="site-menu-item has-sub <?php  if(isset($email_template_active_open) && $email_template_active_open) echo "active";?>">
								<a href="<?php echo base_url('admin/service/email_templates');?>">
								<i class="site-menu-icon md-email" aria-hidden="true"></i>
								<span class="site-menu-title">Email Template</span> 
								</a> 
							</li> -->
						<?php } ?>	
						
						<!--<li class="site-menu-item has-sub < ?php if(isset($s_job_title_active_open) && $s_job_title_active_open) echo "active open";?>">
							<a href="javascript:void(0);">
							<i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
							<span class="site-menu-title">Support</span> 
							</a>					 
						</li>-->
				</ul>
			</li>
		</ul>
		<div class="site-menubar-section">
			
		</div>      </div>
</div>
</div>


</div> 

