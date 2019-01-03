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
		<div class="page-header-actions"><a href="<?php echo base_url('admin/invoice');?>"><button type="button" class="btn btn-block btn-primary">All Invoices</button></a></div>
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
                  <a class="font-size-20" href="javascript:void(0)">#5669626</a>
                  <br> To:
                  <br>
                  <span class="font-size-20">Machi</span>
                </p>
                <address>
                  795 Folsom Ave, Suite 600
                  <br> San Francisco, CA, 94107
                  <br>
                  <abbr title="Phone">P:</abbr>&nbsp;&nbsp;(123) 456-7890
                  <br>
                </address>
                <span>Invoice Date: January 20, 2017</span>
                <br>
                <span>Due Date: January 22, 2017</span>
              </div>
            </div>

            <div class="page-invoice-table table-responsive">
              <table class="table table-hover text-right">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Description</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Unit Cost</th>
                    <th class="text-right">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">
                      1
                    </td>
                    <td class="text-left">
                      Server hardware purchase
                    </td>
                    <td>
                      32
                    </td>
                    <td>
                      $75
                    </td>
                    <td>
                      $2152
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">
                      2
                    </td>
                    <td class="text-left">
                      Office furniture purchase
                    </td>
                    <td>
                      15
                    </td>
                    <td>
                      $169
                    </td>
                    <td>
                      $4169
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">
                      3
                    </td>
                    <td class="text-left">
                      Company Anual Dinner Catering
                    </td>
                    <td>
                      69
                    </td>
                    <td>
                      $49
                    </td>
                    <td>
                      $1260
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">
                      4
                    </td>
                    <td class="text-left">
                      Payment for Jan 2017
                    </td>
                    <td>
                      149
                    </td>
                    <td>
                      $12
                    </td>
                    <td>
                      $866
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="text-right clearfix">
              <div class="float-right">
                <p>Sub - Total amount:
                  <span>$4800</span>
                </p>
                <p>VAT:
                  <span>$35</span>
                </p>
                <p class="page-invoice-amount">Grand Total:
                  <span>$4835</span>
                </p>
              </div>
            </div>

            <div class="text-right">
              <button type="submit" class="btn btn-animate btn-animate-side btn-primary">
                <span><i class="icon md-shopping-cart" aria-hidden="true"></i> Proceed
                  to payment</span>
              </button>
              <button type="button" class="btn btn-animate btn-animate-side btn-info" onclick="javascript:window.print();">
                <span><i class="icon md-print" aria-hidden="true"></i> Print</span>
              </button>
            </div>
          </div>
        </div>
        <!-- End Panel -->
      </div>
    </div>
    <!-- End Page -->

<?php $this->load->view('admin/common/footer'); ?>