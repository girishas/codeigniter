<?php
$this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<?php $this->load->view('admin/common/navbar'); ?>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/admin_custom.css');?>">
	<?php $this->load->view('admin/common/left_menubar'); ?>
	<!-- Page -->
	<style type="text/css">
		select optgroup {
	color: #3A3937;
    font-style: normal;
    font-weight: normal;
    background: #bae6f4;
}
	</style>
	<div class="page">
		<?php $this->load->view('admin/common/header_messages'); ?>
		<!-- Contacts Content -->
		<div class="page-main">
			<div class="page-content">
				<!-- Contacts Content Header -->
				<div class="row">
					<div class="col-md-12">
						<!-- Panel Static Labels -->
						<div class="panel">
							<div class="page-header">
								<?php $this->load->view('admin/product/inventry_top'); ?>
							</div>
							<div class="page-header" style="padding:0px 30px">
							<?php if (is_null($product_data->box_product_unit)) {
								 if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){ ?>
								<button type="button" data-target="#exampleFillIn" data-toggle="modal" class="btn btn-info waves-effect waves-classic"><i class="icon md-plus" aria-hidden="true"></i>Stock In</button>

								<button type="button" data-target="#exampleFillOut" data-toggle="modal" class="btn btn-info waves-effect waves-classic"><i class="icon md-minus" aria-hidden="true"></i>Stock Out</button>
								<button type="button" data-target="#exampleProductUse" data-toggle="modal" class="btn btn-info waves-effect waves-classic">Open Product</button>
								<?php } ?>
								<?php if($admin_session['role']=="location_owner"){ ?>
								<button type="button" data-target="#exampleFillIn" data-toggle="modal" class="btn btn-info waves-effect waves-classic"><i class="icon md-plus" aria-hidden="true"></i>Stock In</button>

								<button type="button" data-target="#exampleFillOut" data-toggle="modal" class="btn btn-info waves-effect waves-classic"><i class="icon md-minus" aria-hidden="true"></i>Stock Out</button>

								<button type="button" data-target="#exampleProductUse" data-toggle="modal" class="btn btn-info waves-effect waves-classic">Open Product</button>
								<?php } 
							} ?>
							
							

								<?php 
								if ($product_data->box_product_unit>0) { ?>
									<button type="button" data-target="#exampleDistribution" data-toggle="modal" class="btn btn-info waves-effect waves-classic">Product Distribution</button>
								<?php }  ?>

								



								
							</div>
							<div class="panel-body">
								<div class="form-group row" data-plugin="formMaterial">
									<div class="col-md-6">
										<span  style="float:left;text-align:left;">
											<?php
												if(!empty($product_data->product_name)){
													echo '<strong>Product Name: </strong>'.$product_data->product_name;
												}
												if(!empty($product_data->category_id)){
													echo '<br/><strong>Product Category: </strong>'.getProductCategory($product_data->category_id);
												}
													if(!empty($product_data->brand_id)){
													echo '<br/><strong>Product Brand: </strong>'.getProductBrand($product_data->brand_id);
												}
													if(!empty($product_data->bar_code)){
													echo '<br/><strong>Bar Code: </strong>'.$product_data->bar_code;
												}
													if(!empty($product_data->sku)){
													echo '<br/><strong>SKU: </strong>'.$product_data->sku;
												}
													if(!empty($product_data->quantity)){
													echo '<br/><strong>Quantity: </strong>'.$product_data->quantity;
												}
												if(!empty($product_data->alert_quantity)){
													echo '<br/><strong>Alert Quantity: </strong>'.$product_data->alert_quantity;
												}
											?>
										</span>
									</div>
									
									<div class="col-md-6">
										<span  style="float:left;text-align:left;">
											<?php
											/* if(!empty($product_data->photo)){ ?>
											<img class="img-fluid" src="<?php echo base_url('images/product/thumb/'.$product_data->photo); ?>" width="50" />
											<?php  }*/
												if(!empty($product_data->description)){
												echo '<strong>Description: </strong>'.$product_data->description;
											}
												if(!empty($product_data->purchase_price)){
												echo '<br/><strong>Purchase Price: </strong>'.$product_data->purchase_price;
											}
												if(!empty($product_data->retail_price)){
												echo '<br/><strong>Retail Price: </strong>'.$product_data->retail_price;
											}
												if(!empty($product_data->special_price)){
												echo '<br/><strong>Special Price: </strong>'.$product_data->special_price;
											}
											if(!empty($product_data->supplier_id)){
												echo '<br/><strong>Supplier: </strong>'.getProductSupplier($product_data->supplier_id);
											}
											?>
										</span>
									</div>
								</div>
							</div>
							<br>
								<div class="panel-heading">
						<h1 class="panel-title"> Product Stock Details</h1>
						
					</div>
							<!-- Contacts Content -->
							<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
								<!-- Contacts -->
								<div class="col-md-12">
									<table  class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable" id="table_new_order">
										<thead>
											<tr>
												<th class="cell-300 dark-background-heading" scope="col">Location Name</th>
												<th class="cell-150 dark-background-heading" scope="col">Stock in Qty</th>
												<th class="cell-150 dark-background-heading" scope="col">Stock out Qty</th>
												<th class="cell-150 dark-background-heading" scope="col">Stock in Hand</th>
												<th class="cell-150 dark-background-heading" scope="col">Stock Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$price = 0;
											$total_stock = 0;
											foreach ($location_data as $key => $value) {
												$price = $price+$value['total_price'];
												$total_stock = $total_stock+$value['avl_qty'];
											?>
											<tr>
												<td><?php echo $value['location_name'] ?></td>
												<td><span data-target="#inventeryDetail" data-toggle="modal" class="badge badge-info" onclick="getDetail(<?php echo $product_data->id ?>,<?php echo $value['location_id'] ?>,'stockin')"><?php echo $value['stockin_quantity'] ?></span></td>
												<td><span data-target="#inventeryDetail" data-toggle="modal" class="badge badge-info" onclick="getDetail(<?php echo $product_data->id ?>,<?php echo $value['location_id'] ?>,'stockout')"><?php echo ($value['stockout_quantity']!="")?$value['stockout_quantity']:0 ?></span></td>
												<td><?php echo $value['avl_qty']; ?></td>
												<td><?php echo $value['total_price']; ?></td>
											</tr>
											<?php }
											?>
										</tbody>
										<tfoot>
										<tr>
											<td colspan="2">&nbsp;</td>
											<td><b>Total </b></td>
											<td><b><?php echo $total_stock; ?></b></td>
											<td><b><?php echo $price; ?></b></td>
										</tr>
										</tfoot>
									</table>
								</div>
							</div>


							<br>
								<div class="panel-heading">
						<h1 class="panel-title"> Warehouse Details</h1>
						
					</div>
							<!-- Contacts Content -->
							<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
								<!-- Contacts -->
								<div class="col-md-12">
									<table  class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable" id="table_new_order">
										<thead>
											<tr>
												<th class="cell-300 dark-background-heading" scope="col">Warehouse Name</th>
												<th class="cell-150 dark-background-heading" scope="col">Stock in Qty</th>
												<th class="cell-150 dark-background-heading" scope="col">Stock out Qty</th>

												<th class="cell-150 dark-background-heading" scope="col">Stock in Hand</th>
												
												<th class="cell-150 dark-background-heading" scope="col">Stock Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$price = 0;
											$total_stock = 0;
											foreach ($warehouse_data as $key => $value) {


												$price = $price+ $value['total_price'];
												$total_stock = $total_stock+$value['avl_qty'];
											?>
											<tr>
												<td><?php echo $value['warehouse_name'] ?></td>
												<td><span data-target="#inventeryDetail" data-toggle="modal" class="badge badge-info" onclick="getwarehouseDetail(<?php echo $product_data->id ?>,<?php echo $value['warehouse_id'] ?>,'stockin')"><?php echo $value['stockin_quantity'] ?></span></td>
												<td><span data-target="#inventeryDetail" data-toggle="modal" class="badge badge-info" onclick="getwarehouseDetail(<?php echo $product_data->id ?>,<?php echo $value['warehouse_id'] ?>,'stockout')"><?php echo ($value['stockout_quantity']!="")?$value['stockout_quantity']:0 ?></span></td>

												
												<!-- <td><?php echo $value['stockin_quantity']*$product_data->purchase_price; ?></td> -->
												<td><?php echo $value['avl_qty']; ?></td>
												<td><?php echo $value['total_price']; ?></td>
											</tr>
											<?php }
											?>
										</tbody>
										<tfoot>
										<tr>
											<td colspan="2">&nbsp;</td>
											<td><b>Total </b></td>
											<td><b><?php echo $total_stock; ?></b></td>
											<td><b><?php echo $price; ?></b></td>
										</tr>
										</tfoot>
									</table>
								</div>
							</div>



							<!-- Contacts Content -->
							<div class="panel-heading">
						<h1 class="panel-title">Open Product Details</h1>
						
					</div>
							<div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
								<!-- Contacts -->
								<div class="col-md-12">
									<table  class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable" id="table_new_order">
										<thead>
											<tr>
												<th class="cell-150 dark-background-heading" scope="col">Reason </th>
												<th class="cell-150 dark-background-heading" scope="col">staff </th>

												 <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){ ?>
												<th class="cell-150 dark-background-heading" scope="col">location</th>
												<?php } ?>

												<th class="cell-150 dark-background-heading" scope="col">Open date</th>
												<th class="cell-150 dark-background-heading" scope="col">Action</th>
												
											</tr>
										</thead>
										<tbody>
											<?php
										
											foreach ($getproduct_used as $key => $value) {
												
											?>
											<tr id="row_<?php echo $value['id']; ?>">
												<td><?php 
												if ($value['used_type']==1) {
													echo "Used in Salon";
												}
												else{
													echo "Use as Tester";
												}
												?></td>

												<td><?php echo getStaffName($value['staff_id']); ?></td>
												<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){ ?>
												<td><?php echo getLocationNameById($value['location_id']); ?></td>
												<?php } ?>
												
												<td> <?php echo date("D, d M Y",strtotime($value['date_created'])); ?>
												</td>
												<td>
            <!-- <a class="btn btn-primary " href="<?php echo base_url('admin/product/updateProductUseTypes/'.$value['id'].'/'.$value['product_id']);?>"> close </a> -->

            <a class="btn btn-primary" href="javascript:void(0)" onClick="operation_product_close('<?php echo $value['id']; ?>','delete')" role="menuitem">close</a>
         
													</td>

												
											</tr>
											<?php }
											?>
										</tbody>
									<!-- 	<tfoot>
											<tr>
												<th><b>City </b> </th>
												<?php foreach ($getCityproduct_used as $key => $value) {?>
													<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){ ?>
												<td><b><?php echo getLocationNameById($value['location_id']); ?></b></td>
												<?php } ?>
													
												<?php } ?>
											</tr>
											<tr>
												<th><b>Used in Salon</b></th>
												<?php foreach ($gettotal_Salon as $key => $value) {?>
													<td><b> <?php echo $value['total_Salon'] ?> </b></td>
												<?php } ?>
											</tr>
											<tr>
												<th><b>Use as Tester</b></th>
												<?php foreach ($gettotal_Tester as $key => $value) {?>
													<td><b> <?php echo $value['total_Tester'] ?> </b></td>
												<?php } ?>
											</tr>				
											
										</tfoot>	 -->									
									</table>
								</div>
							</div>



						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End page -->
	<!-- Modal -->
	<div class="modal fade modal-fade-in-scale-up" id="exampleFillIn" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Add Stock</h4>
				</div>
				<form method="post" action="<?= base_url()?>admin/product/stockin">
					<div class="modal-body">
						<div class="row">
							<input type="hidden" name="product_id" value="<?php echo $product_data->id ?>">
							
							<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){?>
							<?php if($locations){?>
							<div class="col-md-12 form-group">
								<label class="control-label">Choose Location</label>
								<select class="form-control" name="location_id">
									<?php $i=1;foreach($locations as $loc){?>
									<option value="<?= $loc['id'] ?>"><?= $loc['location_name'] ?></option>
									<?php $i++; } ?>
									<?php } ?>
								</select>
							</div>
							<?php } ?>
							<?php if($admin_session['role']=="location_owner"){?>
							<input type="hidden" name="location_id" value="<?php echo $admin_session['location_id'] ?>">
							<?php } ?>
							<div class="col-md-12 form-group">
								<label class="control-label">Quantity</label>
								<input type="text" class="form-control" name="quantity" placeholder="Quantity">
							</div>
							<div class="col-md-12 form-group">
								<label class="control-label">Reason</label>
								<select class="form-control" name="reason">
									<option value="1">Opening Balance</option>
									<option value="2">Other</option>
								</select>
							</div>
							<div class="col-md-12 form-group">
								<label class="control-label">Message</label>
								<textarea name="message" class="form-control" rows="3"></textarea>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade modal-fade-in-scale-up" id="exampleFillOut" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Remove Stock</h4>
				</div>
				<form method="post" action="<?= base_url()?>admin/product/stockout">
					<div class="modal-body">
						<div class="row">
							<input type="hidden" name="product_id" value="<?php echo $product_data->id ?>">
							<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){?>
							<?php if($locations){?>
							<div class="col-md-12 form-group">
								<label class="control-label">Choose Location</label>
								<select class="form-control" name="location_id">
									<?php $i=1;foreach($locations as $loc){?>
									<option value="<?= $loc['id'] ?>"><?= $loc['location_name'] ?></option>
									<?php $i++; } ?>
									<?php } ?>
								</select>
							</div>
							<?php } ?>
							<?php if($admin_session['role']=="location_owner"){?>
							<input type="hidden" name="location_id" value="<?php echo $admin_session['location_id'] ?>">
							<?php } ?>
							<div class="col-md-12 form-group">
								<label class="control-label">Quantity</label>
								<input type="text" class="form-control" name="quantity" placeholder="Quantity">
							</div>
							<div class="col-md-12 form-group">
								<label class="control-label">Reason</label>
								<select class="form-control" name="reason">
									<!-- <option value="1">Internal Use</option> -->
									<!-- <option value="2">Sold</option> -->
									<option value="3">Damage</option>
									<option value="4">Adjustment</option>
									<option value="5">Out of Date</option>
									<!-- <option value="7">Use as Tester</option> -->
									<option value="6">Other</option>
								</select>
							</div>
							<div class="col-md-12 form-group">
								<label class="control-label">Message</label>
								<textarea name="message" class="form-control" rows="3"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<div class="modal fade modal-fade-in-scale-up" id="exampleDistribution" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Stock Distribution</h4>
				</div>
				<form method="post" action="<?= base_url()?>admin/product/product_distribution">
					<div class="modal-body">
						<div class="row">
							<input type="hidden" name="product_id" value="<?php echo $product_data->id ?>">
							<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){?>
							<?php if($locations){?>
							<div class="col-md-12 form-group">
								<label class="control-label">Choose Location</label>

								<select class="form-control" name="location_id">
									<optgroup label="Select Location">
									<?php $i=1;foreach($locations as $loc){?>
									<option value="l<?= $loc['id'] ?>"><?= $loc['location_name'] ?></option>
									<?php $i++; } ?>
									<?php } ?>
								</optgroup>
									<optgroup label="Select Warehouse">
										<?php foreach($warehouse as $value){?>
										<option value="w<?php echo $value['id'];?>" ><?php echo  $value['warehouse_name'];?></option>
										<?php }  ?>
									</optgroup>
								</select>
							</div>
							<?php } ?>
							<?php if($admin_session['role']=="location_owner"){?>
							<input type="hidden" name="location_id" value="l<?php echo $admin_session['location_id'] ?>">
							<?php } ?>
							<div class="col-md-12 form-group">
								<label class="control-label">Quantity</label>
								<input type="text" class="form-control" name="quantity" placeholder="Quantity">
							</div>
							<div class="col-md-12 form-group">
								<label class="control-label">Reason</label>
								<select class="form-control" name="reason">
									<!-- <option value="1">Internal Use</option> -->
									<!-- <option value="2">Sold</option> -->
									<option value="8">Distribution</option>
									<option value="3">Damage</option>
									<option value="4">Adjustment</option>
									<option value="5">Out of Date</option>
									<!-- <option value="7">Use as Tester</option> -->
									<option value="6">Other</option>

								</select>
							</div>
							<div class="col-md-12 form-group">
								<label class="control-label">Message</label>
								<textarea name="message" class="form-control" rows="3"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>



	<!-- Product Use -->
	<div class="modal fade modal-fade-in-scale-up" id="exampleProductUse" aria-hidden="true"
		aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title"> Open Product</h4>
				</div>
				<form method="post" id="reg_form" action="#">
					<div class="modal-body">
						<div class="row">
							<input type="hidden" name="product_id" value="<?php echo $product_data->id ?>">
							<?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){?>
							<?php if($locations){?>
							<div class="col-md-12 form-group">
								<label class="control-label">Choose Location</label>
								<select class="form-control" name="location_id" id="location_id">
									<?php $i=1;foreach($locations as $loc){?>
									<option value="<?= $loc['id'] ?>"><?= $loc['location_name'] ?></option>
									<?php $i++; } ?>
									<?php } ?>
								</select>
							</div>
							<?php } ?>
							<?php if($admin_session['role']=="location_owner"){?>
							<input type="hidden" name="location_id" id="location_id" value="<?php echo $admin_session['location_id'] ?>">
							<?php } ?>
							 <div class="col-md-12 form-group">
								<label class="control-label">Quantity</label>
								<input type="text" class="form-control" name="quantity" placeholder="Quantity" value="1">
							</div>
							<!-- <?php if($admin_session['role']=="business_owner" || $admin_session['role']=="owner"){?> -->
							
							<!-- <?php } ?>

							<?php if($admin_session['role']=="location_owner"){?>
							<input type="hidden" name="staff_id" value="<?php echo $admin_session['staff_id'] ?>">
							<?php } ?>
 -->

 							<div class="col-md-12 form-group">
								<label class="control-label">Choose staff</label>
								<select class="form-control" name="staff_id" id="staff_id">
									<?php foreach ($get_staff as $key => $value) { ?>
										<option value="<?php echo $value['id']; ?>"><?php echo $value['first_name'].''.$value['last_name']; ?></option>
									<?php } ?>
									
								</select>
							</div>

							<div class="col-md-12 form-group">
								<label class="control-label">Product Use Types</label>
								<select class="form-control" name="product_types">
									<option value="1">Used in Salon</option>						
									<option value="7">Use as Tester</option>
									
								</select>
							</div>
							<div class="col-md-12 form-group">
								<label class="control-label">Notes</label>
								<textarea name="message" class="form-control" rows="3"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
						<button id="click_form" type="button" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--End -->

	<div class="modal fade modal-fade-in-scale-up" id="inventeryDetail" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-simple" style="width: 1000px;max-width: 1000px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Inventry Detail</h4>
				</div>
				<div class="modal-body inventeryDetailBody">

				</div>
			</div>
		</div>
	</div>
	<!-- End Modal -->
	<script language="javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js');?>"></script>
	<script language="javascript">
	function getDetail(product_id,location_id,type){
		if(product_id!="" && location_id!="")
		{
			$.ajax({
              type: 'POST',
              url: site_url + 'admin/Product/getProductInventryDetails/' + encodeURIComponent(product_id)+'/'+encodeURIComponent(location_id)+'/'+encodeURIComponent(type),
              datatype: 'json',
              beforeSend: function() {},
              success: function(data) {
                $(".inventeryDetailBody").html(data);
              }
          });
		}else{
			alert("An unknown error accured, Please refresh page and try again");
		}
	}

	function getwarehouseDetail(product_id,warehouse_id,type){
		if(product_id!="" && warehouse_id!="")
		{
			$.ajax({
              type: 'POST',
              url: site_url + 'admin/Product/getwarehouseProductInventryDetails/' + encodeURIComponent(product_id)+'/'+encodeURIComponent(warehouse_id)+'/'+encodeURIComponent(type),
              datatype: 'json',
              beforeSend: function() {},
              success: function(data) {
              	//alert(data); 
                $(".inventeryDetailBody").html(data);
              }
          });
		}else{
			alert("An unknown error accured, Please refresh page and try again");
		}
	}



	</script>
	<?php $this->load->view('admin/common/footer'); ?>

	<script type="text/javascript">
		function operation_product_close(id)
				{
					if(id!=""){
						swal({
				            title: "Are you sure?",
				           // text: "You will not be able to recover this customer!",
				            type: "info",
				            showCancelButton: true,
				            confirmButtonClass: "btn-info",
				            confirmButtonText: 'Yes',
				            closeOnConfirm: false
				          //closeOnCancel: false
				          }, function () {
							$.ajax({
								type: 'POST',
								url: site_url + 'admin/Operations/product_close/' + encodeURIComponent(id),
								datatype: 'json',
								beforeSend: function() {
								},
								success: function(data)
								{
									data = JSON.parse(data);
									if (data.status == 'not_logged_in') {
										location.href= site_url + 'admin'
									}else if (data.status == 'success') {
										$("#row_"+id).hide().remove();
									} else {
									swal("Error!", "Something went wrong, please refresh page and try again", "error");
					                  }
					                }
					              });
					            swal("Closed!", "Product has been closed!", "success");
					          });
					}else{
						return false;
					}
				}
		
	</script>


	  <script type="text/javascript"> 
    $(document).ready(function() {    
    $('#click_form').click(function() {          
            var data = $("#reg_form").serialize();
            $.ajax({
                url: site_url + 'admin/Product/productUseTypes',
                type: 'POST',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(data) { 
                	//alert(data);
                    if (data.status=='error') {
	                       swal({
					title: "Error",
					text: data.response,
					type: "error"
					},
					function() {
					//location.reload();
					});
                    }

                    if (data.status=='limit') {
	                       swal({
					title: "Error",
					text: data.response,
					type: "error"
					},function() {
					//location.reload();
					window.location.href = site_url + 'admin/product/product_use_settings';
					});
                    }

                    if (data.status=='success') { 
		            swal({
				title: "Success",
				text: data.response,
				type: "success"
				},function() {
				location.reload();
				});
                    }
                }
            });
        //}
    });
});
</script>
 <script type="text/javascript"> 
    $(document).ready(function() {    
    $('#location_id').change(function() {  
            var location_id = $("#location_id").val();          
            $.ajax({
                url: site_url + 'admin/Product/getStaffbyLocationId',
                type: 'POST',
                data:{location_id:location_id},
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(data) {
                	 if (data.status=='success') { 
                	 	 $('#staff_id').html(data.staff_html);
                	 }

                }
            });
    });
});
</script>
<script type="text/javascript"> 
    $(document).ready(function() {    
   // $('#location_id').change(function() {  
            var location_id = $("#location_id").val();          
            $.ajax({
                url: site_url + 'admin/Product/getStaffbyLocationId',
                type: 'POST',
                data:{location_id:location_id},
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(data) {
                	 if (data.status=='success') { 
                	 	 $('#staff_id').html(data.staff_html);
                	 }

                }
            });
    //});
});
</script>