<?php
$controller =  $this->router->fetch_class();
$method =  $this->router->fetch_method();

//print_r($method); //exit;
?>
<ul class="nav nav-tabs" role="tablist">
	<?php if($controller == 'product' && in_array($method,array('index','add_product','edit_product','view'))){
		$active =  'active';
	}else{
		$active = '';
	}?>
  <li class="nav-item" role="presentation"><a class="nav-link <?=$active;?>" href="<?php echo base_url('admin/product');?>">Products</a></li>
  <?php if($controller == 'product' && in_array($method,array('orders','add_order','order_received','order_detail','order_attechments','edit_order'))){
		$active =  'active';
	}else{
		$active = '';
	}?>
  <li class="nav-item" role="presentation"><a class="nav-link  <?=$active;?>" href="<?php echo base_url('admin/product/orders');?>" >Orders</a></li> 
   <?php if($controller == 'product' && in_array($method,array('brand_category','add_brand_category'))){
		$active =  'active';
	}else{
		$active = '';
	}?>
  <li class="nav-item" role="presentation"><a class="nav-link <?=$active;?>" href="<?php echo base_url('admin/product/brand_category');?>">Brands</a></li>
   <?php if($controller == 'product' && in_array($method,array('brands','add_brand','edit_brand'))){
		$active =  'active';
	}else{
		$active = '';
	}?>
  <li class="nav-item" role="presentation"><a class="nav-link <?=$active;?>" href="<?php echo base_url('admin/product/brands');?>">Brand Sub Category</a></li>
   <?php if($controller == 'product' && in_array($method,array('categories','add_category','edit_category'))){
		$active =  'active';
	}else{
		$active = '';
	}?>
  <li class="nav-item" role="presentation"><a class="nav-link  <?=$active;?>" href="<?php echo base_url('admin/product/categories');?>">Product Categories</a></li>
    <?php if($controller == 'product' && in_array($method,array('all_suppliers','add_supplier','edit_supplier'))){
		$active =  'active';
	}else{
		$active = '';
	}?>

	 <li class="nav-item" role="presentation"><a class="nav-link <?=$active;?>" href="<?php echo base_url('admin/product/all_suppliers');?>">Suppliers</a></li>
	 <?php if($controller == 'product' && in_array($method,array('all_expense'))){
		$active =  'active';
	}else{
		$active = '';
	}?>
	  <li class="nav-item" role="presentation"><a class="nav-link <?=$active;?>" href="<?php echo base_url('admin/product/all_expense');?>">Expense</a></li>
  


</ul>