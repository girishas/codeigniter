<?php $this->load->view('admin/common/header'); ?>
<body class="animsition page-invoice">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>  
 <!-- Page -->
    <div class="page">
      <div class="page-header">
        <h1 class="page-title">Invoice</h1>
		<!-- <div class="page-header-actions"><a href="<?php echo base_url('admin/invoice');?>"><button type="button" class="btn btn-block btn-primary">All Invoices</button></a></div> -->
      </div>

      <div class="page-content">
        <!-- Panel -->
        <div class="panel">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="col-lg-3">
                <h3>
                  <img width="150px;" class="mr-10" src="<?php echo base_url('assets/images/logo.png');?>"
                    alt="...">Bookingintime</h3>
                <address>
                  795 Folsom Ave, Suite 600
                  <br> San Francisco, CA, 94107
                  <br>
                  <abbr title="Mail">E-mail:</abbr>&nbsp;&nbsp;example@google.com
                  <br>
                  <abbr title="Phone">Phone:</abbr>&nbsp;&nbsp;(123) 456-7890
                  <br>
                  <abbr title="Fax">Fax:</abbr>&nbsp;&nbsp;800-692-7753
                </address>
              </div>
              <div class="col-lg-3 offset-lg-6 text-right">
                <h4>Invoice Info</h4>
                <p>
                  <a class="font-size-20" href="javascript:void(0)">#<?php echo $data[0]['order_id'] ?></a>
                  <br> To:
                  <br>
                  <span class="font-size-20"><?php echo $supplier_detail[0]['first_name']." ".$supplier_detail[0]['last_name']; ?></span>
                </p>
                <address>
                  <?php echo ($supplier_detail[0]['address1'])?$supplier_detail[0]['address1'].",":""; ?> <?php echo ($supplier_detail[0]['address2'])?$supplier_detail[0]['address2'].",":""; ?>
                  <br> <?php echo ($supplier_detail[0]['city'])?$supplier_detail[0]['city'].",":""; ?><?php echo ($supplier_detail[0]['state'])?$supplier_detail[0]['state'].",":""; ?>
                  <?php echo ($supplier_detail[0]['postcode'])?$supplier_detail[0]['postcode'].",":""; ?>
                  <br>
                  <abbr title="Phone">P:</abbr>&nbsp;&nbsp;<?php echo ($supplier_detail[0]['mobile_number'])?$supplier_detail[0]['mobile_number']:"---"; ?>
                  <br>
                </address>
                <span>Invoice Date: <?php echo date('F d,Y',strtotime($supplier_detail[0]['date_created'])) ?></span>
                <br>
                <!-- <span>Due Date: January 22, 2017</span> -->
              </div>
            </div>

            <div class="page-invoice-table table-responsive">
              <table class="table table-hover text-right">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Product Name</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Base Price</th>
                    <th class="text-right">Discount</th>
                    <th class="text-right">Free Goods</th>
                    <th class="text-right">Amount</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $sub_total = 0;
                    foreach ($data as $key => $value) { 
                      $single_product_value = 0;
                      $single_product_value = $value['purchase_price']*$value['quantity'];
                      $single_product_value = $single_product_value-$value['product_disount']-$value['product_free_goods'];
                      $sub_total += $single_product_value;
                      ?>
                      <tr>
                       <td class="text-center">#<?=$i; ?></td>
                       <td><?php echo getProductName($value['product_id']); ?></td>
                       <td><?php echo $value['quantity']; ?></td>
                       <td><?php echo $value['purchase_price']; ?></td>
                       <td><?php echo $value['product_disount']; ?></td>
                       <td><?php echo $value['product_free_goods']; ?></td>
                       <td><?php echo $single_product_value; ?></td>
                        </tr>
                    <?php $i++; } ?>
                </tbody>
              </table>
            </div>

            <div class="text-right clearfix">
              <div class="float-right">
                <p><b>Sub - Total amount :
                  <span><?= $sub_total; ?></span></b>
                </p>
                <p><b>VAT :
                  <span><?php echo $order_data['total_tax']; ?></span></b>
                </p>
                <p><b>Shipping :
                  <span><?php echo $order_data['shipping_cost']; ?></span></b>
                </p>
                <p class="page-invoice-amount"><b>Grand Total :
                  <span><?php echo $order_data['total_amount']; ?></span></b>
                </p>
              </div>
            </div>

            <div class="text-right">
             <!--  <button type="submit" class="btn btn-animate btn-animate-side btn-primary">
                <span><i class="icon md-shopping-cart" aria-hidden="true"></i> Proceed
                  to payment</span>
              </button> -->
              <!-- <button type="button" class="btn btn-animate btn-animate-side btn-info" onclick="javascript:window.print();">
                <span><i class="icon md-print" aria-hidden="true"></i> Print</span>
              </button> -->
            </div>
          </div>
        </div>
        <!-- End Panel -->
      </div>
    </div>
    <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>