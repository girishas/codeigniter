
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'expense'){echo 'active';}?>" href="<?php echo base_url('admin/expense');?>">Open Register</a></li>
  <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'today_sale'){echo 'active';}?>" href="<?php echo base_url('admin/expense/today_sale');?>">Today Position</a></li>
  <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'close_register'){echo 'active';}?>" href="<?php echo base_url('admin/expense/close_register');?>">Close Register</a></li> 
  <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'all_expenses'){echo 'active';}?>" href="<?php echo base_url('admin/expense/all_expenses');?>">Expense</a></li>
  <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'all_pos_category'){echo 'active';}?>" href="<?php echo base_url('admin/expense/all_pos_category');?>">Expense Category</a></li>
 <li class="nav-item" role="presentation"><a class="nav-link <?php if($page == 'all_vendors'){echo 'active';}?>" href="<?php echo base_url('admin/expense/all_vendors');?>">Vendor</a></li>         
</ul>