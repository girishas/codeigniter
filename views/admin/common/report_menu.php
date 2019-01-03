<ul class="nav nav-tabs" role="tablist">
               <?php 
               $last = $this->uri->total_segments();
				$page = $this->uri->segment($last);
               ?>
               
              <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'reports' || $page =='sale_by_staff' || $page =='sale_by_day' || $page =='sale_by_month'){echo 'active';}?>" href="<?php echo base_url('admin/reports');?>"  >Sale</a></li>

               <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'report_inventory' ){echo 'active';}?>" href="<?php echo base_url('admin/reports/report_inventory');?>"  >Inventory</a></li>

              

              <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'reports_customer'){echo 'active';}?>" href="<?php echo base_url('admin/reports/reports_customer');?>" >Customer</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'reports_appointment'){echo 'active';}?>" href="<?php echo base_url('admin/reports/reports_appointment');?>" >Booking </a></li>
              <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'reports_voucher'){echo 'active';}?>" href="<?php echo base_url('admin/reports/reports_voucher');?>" >Voucher </a></li>
              <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'reports_invoice'){echo 'active';}?>" href="<?php echo base_url('admin/reports/reports_invoice');?>" >Invoice </a></li>

              <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'daily_cash'){echo 'active';}?>" href="<?php echo base_url('admin/reports/daily_cash');?>" >Daily Cash </a></li>

               <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'staff_commission'){echo 'active';}?>" href="<?php echo base_url('admin/reports/staff_commission');?>" >Commission </a></li>

                <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'finances_summary'){echo 'active';}?>" href="<?php echo base_url('admin/reports/finances_summary');?>" >Finances</a></li>

                 <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'summary'){echo 'active';}?>" href="<?php echo base_url('admin/reports/summary');?>" >Summary </a></li>
            </ul>