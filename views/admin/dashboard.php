<?php  $this->load->view('admin/common/header_dashboard'); ?>
<body class="animsition">
<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<?php $this->load->view('admin/common/navbar'); ?>
<?php $this->load->view('admin/common/left_menubar'); ?>   
   <!-- Page -->
    <div class="page">
      <?php $this->load->view('admin/common/header_messages'); ?>
      <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        
        <div class="page-header-actions">
         
        </div>
      </div>
      <div class="page-content container-fluid">
<?php $admin_session = $this->session->userdata('admin_logged_in');  
	  //print_r($admin_session) ;

 //print_r($admin_session); die;

if(!empty($admin_session['business_id'])){
	
  $staff_id = isset($admin_session['staff_id'])?$admin_session['staff_id']:1;
  $dashbaord = getDashboardNotify($admin_session['business_id'],$staff_id);
  //print_r($dashbaord);die;
  if($dashbaord !=''){  ?>
    <ul class="list-group list-group-gap" style="text-align:center">
      <?php foreach ($dashbaord as $key => $value ) { ?>
      <li class="list-group-item list-group-item-info" style="color:#fff;background-color: #ff9800;font-weight:500;"><?php echo $value['comments'];//$dashbaord; ?></li>
      <?php } ?>
    </ul>
  <?php  } } 

	   if($admin_session['role'] =="owner" || $admin_session['role'] =="business_owner"){ ?>
		  


		  <div class="row">
          <!-- First Row -->
          <div class="col-xl-3 col-md-6 info-panel">
            <div class="card card-shadow">
              <div class="card-block bg-white p-20">
                <button type="button" class="btn btn-floating btn-sm btn-warning waves-effect waves-classic">
                  <i class="icon md-seat" style="color: #fff;"></i>
                </button>
                <span class="ml-15 font-weight-400">Total Services</span>
                <div class="content-text text-center mb-0">
                  <i class="text-danger icon wb-triangle-up font-size-20">
              </i>
                  <span class="font-size-20 font-weight-100"><?php echo $count_all_services['total_services'] ?></span> 
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 info-panel">
            <div class="card card-shadow">
              <div class="card-block bg-white p-20">
                <button type="button" class="btn btn-floating btn-sm btn-danger waves-effect waves-classic">
                  <i class="icon fa fa-dollar"></i>
                </button>
                <span class="ml-15 font-weight-400">Invoices</span>
                <div class="content-text text-center mb-0">
                  <i class="text-success icon wb-triangle-down font-size-20">
              </i>
              
                  <span class="font-size-20 font-weight-100">$<?php echo (round($total_sale['total_amount'], 2))  ?></span> 
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 info-panel">
            <div class="card card-shadow">
              <div class="card-block bg-white p-20">
                <button type="button" class="btn btn-floating btn-sm btn-success waves-effect waves-classic">
                  <i class="icon md-airline-seat-recline-normal"></i>
                </button>
                <span class="ml-15 font-weight-400">Bookings</span>
                <div class="content-text text-center mb-0">
                  <i class="text-danger icon wb-triangle-up font-size-20">
              </i>
                  <span class="font-size-20 font-weight-100"><?php echo $count_all_booking['total_booking'] ?></span> 
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 info-panel">
            <div class="card card-shadow">
              <div class="card-block bg-white p-20">
                <button type="button" class="btn btn-floating btn-sm btn-primary waves-effect waves-classic">
                  <i class="icon md-accounts-alt"></i>
                </button>
                <span class="ml-15 font-weight-400">Customers</span>
                <div class="content-text text-center mb-0">
                  <i class="text-danger icon wb-triangle-up font-size-20">
              </i>
                  <span class="font-size-20 font-weight-100"><?php echo $count_all_customer['total_customer'] ?></span> 
                </div>
              </div>
            </div>
          </div>
          <!-- First Row --> 
        </div> 
		  
		  <?php  }  ?> 
	   
       

     <?php   if($admin_session['role'] =="owner" || $admin_session['role'] =="business_owner" || $admin_session['role'] =="location_owner"){ ?> 
 <!-- Panel -->
        <div class="panel">
          <div class="panel-body">
            <div class="row row-lg">                         

              <div class="col-lg-6">
                <!-- Example C3 Spline -->
                <div class="example-wrap">
                  <h4 class="example-title">Recent Sales</h4>
                 <!-- <p>Display as Spline Chart. </p>-->
                  <div class="example">
                    <div id="exampleC3Spline"></div>
                  </div>
                </div>
                <!-- End Example C3 Spline -->				
              </div>

              <div class="col-lg-6">
                <!-- Example C3 Timeseries -->
                <div class="example-wrap m-md-0">
                  <h4 class="example-title">Upcoming Appointments</h4>
                  <!--<p>Simple line chart with timeseries data. </p>-->
                  <div class="example example-responsive pb-15">
                    <div id="exampleC3TimeSeries"></div>
                  </div>
                </div>
                <!-- End Example C3 Timeseries -->
              </div>
            </div>
          </div>
        </div>
        <!-- End Panel -->
	
	  <?php  }  ?> 

     <?php   //if($admin_session['role'] !="owner"){ ?> 
<!-- Panel Pie Charts -->
        <div class="panel">
         
          <div class="panel-body">
            <div class="row row-lg">
              
              <div class="col-lg-6">

                <?php $admin_session = $this->session->userdata('admin_logged_in'); ?>

                <h4 class="example-title">Current Month Activity</h4>
                <!--<p>Display as Donut Chart. </p>-->
                <div class="tab-pane animation-fade active" id="forum-newest" role="tabpanel">
                  <table class="table is-indent">
                    <tbody>

                      <?php if(!empty($current_month_activity)) { 
                      foreach ($current_month_activity as $key => $value) { ?>
                        <tr data-url="panel.tpl" data-toggle="slidePanel">
                          <td>
                            <div class="content">
                              <h5 class="mt-0 mb-5">
                                <?= getServiceName($value['service_id']).' with '.getCustomerNameById($value['customer_id']); ?>
                              </h5>
                              <div class="metas">
                                <span class="author">
                                <?= date("D j F G:ia Y",strtotime($value['date_created'])); ?>
                                </span>
                                <span class="started"> | <i class="icon fa-clock-o" aria-hidden="true"></i>
                                15 mins
                                </span>
                                <span class="badges"> | <i class="icon fa-user" aria-hidden="true"></i> 
                                <?= getStaffName($value['staff_id']); ?>
                                </span>
                              </div>
                            </div>
                          </td>
                          <td class="suf-cell"></td>
                        </tr>
                      <?php } }else{ ?>
                        <tr data-url="panel.tpl" data-toggle="slidePanel"> No Activity.</tr>
                      <?php } ?>

                    </tbody>
                  </table>
                </div>
              </div>

              <div class="col-lg-6">
          
                <div class="example-wrap">
                  <h4 class="example-title">Today's Next Appointments</h4>
                  <div class="tab-pane animation-fade active" id="forum-newest" role="tabpanel">
                    <table class="table is-indent">
                      <tbody>

                      <?php if(!empty($next_appointments)) {
                      foreach ($next_appointments as $key => $value) { ?>
                      
                        <tr data-url="panel.tpl" data-toggle="slidePanel">
                          <td><?= date("H:ia",strtotime($value['book_start_time'])); ?></td>
                          <td>
                            <div class="content">
                              <h5 class="mt-0 mb-5">
                              <?= getServiceName($value['service_id']).' with '.getCustomerNameByBookingId($value['booking_id']); ?>
                              </h5>
                              <div class="metas">
                                <span class="started"><i class="icon fa-clock-o" aria-hidden="true"></i>15 mins</span>
                                <span class="badges"> | <i class="icon fa-user" aria-hidden="true"></i> <?= getStaffName($value['staff_id']); ?></span>
                              </div>
                            </div>
                          </td>
                          <td class="suf-cell"></td>
                        </tr>

                      <?php } }else { ?>
                        <tr data-url="panel.tpl" data-toggle="slidePanel"> No Appointments.</tr>
                      <?php } ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
        <!-- End Panel Pie Charts -->
	  <?php // }  ?> 


      <?php if($admin_session['role'] !="staff"){ ?> 
        <div class="panel">
          <div class="panel-body">
            <div class="row row-lg">
             
              <div class="col-lg-6">
                <div class="example-wrap">
                  <h4 class="example-title">Top Services</h4>
                  <div class="example table-responsive">

                    <?php if(!empty($top_service)) {   $i=1; ?>

                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Top Services</th>
                          <th>This Month</th>
                          <th>Last Month</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                        <?php foreach ($top_service as $key => $value) { ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td><?= getServiceName($value['service_id']); ?></td>
                            <td><?= '$ '.round(getServiceCurrentMonthSale($value['service_id']),2); ?> </td>
                            <td><?= '$ '.round(getServicePreviousMonthSale($value['service_id']),2); ?> </td>
                          </tr>
                        <?php $i++; } ?>

                      </tbody>
                    </table>

                    <?php }else { ?>
                      No Services.
                    <?php } ?>

                  </div>
                </div>
              </div>


              <div class="col-lg-6">
                <div class="example-wrap">
                  <h4 class="example-title">Top Staffs</h4>
                  <div class="example table-responsive">

                    <?php if(!empty($top_staff)) { ?>

                    <table class="table table-hover">
                      <thead>
                        <tr>
                        <th>#</th>
                        <th>Top Staffs</th>
                        <th>This Month</th>
                        <th>Last Month</th>
                        </tr>
                      </thead>
                      <tbody>

                        
                        <?php $i=1; foreach ($top_staff as $key => $value) { ?>
                        <tr>
                          <td><?= $i; ?></td>
                          <td><?= getStaffName($value['staff_id']); ?></td>
                          <td><?= '$ '.round(getStaffCurrentMonthSale($value['staff_id']),2); ?> </td>
                          <td><?= '$ '.round(getStaffPreviousMonthSale($value['staff_id']),2); ?> </td>
                        </tr>
                        <?php $i++; } ?>

                      </tbody>
                    </table>

                    <?php }else { ?>
                        No Staffs.
                    <?php } ?>
                  </div>
                </div>
              </div>
		          
			  
            </div>
          </div>
        </div>
      <?php } ?>

     
       
      </div>
    </div>
    <!-- End Page -->

<?php $this->load->view('admin/common/footer_dashboard'); ?>
<script type="text/javascript">
  (function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define('/charts/c3', ['jquery', 'Site'], factory);
  } else if (typeof exports !== "undefined") {
    factory(require('jquery'), require('Site'));
  } else {
    var mod = {
      exports: {}
    };
    factory(global.jQuery, global.Site);
    global.chartsC3 = mod.exports;
  }
})(this, function (_jquery, _Site) {
  'use strict';

  var _jquery2 = babelHelpers.interopRequireDefault(_jquery);

  (0, _jquery2.default)(document).ready(function ($$$1) {
    (0, _Site.run)();
  });

  // Example C3 Simple Line
  // ----------------------
  (function () {
    var simple_line_chart = c3.generate({
      bindto: '#exampleC3SimpleLine',
      data: {
        columns: [['data1', 100, 165, 140, 270, 200, 140, 220], ['data2', 110, 80, 100, 85, 125, 90, 100]]
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600)]
      },
      axis: {
        x: {
          tick: {
            outer: false
          }
        },
        y: {
          max: 300,
          min: 0,
          tick: {
            outer: false,
            count: 7,
            values: [0, 50, 100, 150, 200, 250, 300]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })();

  // Example C3 Line Regions
  // -----------------------
  (function () {
    var line_regions_chart = c3.generate({
      bindto: '#exampleC3LineRegions',
      data: {
        columns: [['data1', 100, 165, 140, 270, 200, 140, 220], ['data2', 110, 80, 100, 85, 125, 90, 100]],
        regions: {
          'data1': [{
            'start': 1,
            'end': 2,
            'style': 'dashed'
          }, {
            'start': 3
          }], // currently 'dashed' style only
          'data2': [{
            'end': 3
          }]
        }
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600)]
      },
      axis: {
        x: {
          tick: {
            outer: false
          }
        },
        y: {
          max: 300,
          min: 0,
          tick: {
            outer: false,
            count: 7,
            values: [0, 50, 100, 150, 200, 250, 300]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })();




var currentday= new Date();
var lastday = new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()-1);
var fiveday=new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()-5);
var fourday=new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()-4);
var thirday=new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()-3);
var scondday=new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()-2);





// UPCOMING cancelled BOOKING NEXT FIVE DAY
var currentday_services_booking= <?php echo $currentday_services_booking ?>;
var firstday_services_booking = <?php echo $firstday_services_booking ?>;
var second_services_booking= <?php echo $second_services_booking ?>;
var thirday_services_booking= <?php echo $thirday_services_booking ?>;
var fourday_services_booking= <?php echo $fourday_services_booking ?>;
var fiveday_services_booking= <?php echo $fiveday_services_booking ?>;

//End

// UPCOMING cancelled BOOKING NEXT FIVE DAY
var currentday_product_booking= <?php echo $currentday_product_booking ?>;
var firstday_product_booking = <?php echo $firstday_product_booking ?>;
var second_product_booking= <?php echo $second_product_booking ?>;
var thirday_product_booking= <?php echo $thirday_product_booking ?>;
var fourday_product_booking= <?php echo $fourday_product_booking ?>;
var fiveday_product_booking= <?php echo $fiveday_product_booking ?>;

//End



  (function () {
    var time_series_chart = c3.generate({
      bindto: '#exampleC3Spline',
      data: {
        x: 'x',
        columns: [['x',currentday,lastday,scondday,thirday,fourday,fiveday], ['Total Service', currentday_services_booking, firstday_services_booking, second_services_booking, thirday_services_booking, fourday_services_booking, fiveday_services_booking], ['Total Product', currentday_product_booking, firstday_product_booking, second_product_booking, thirday_product_booking, fourday_product_booking, fiveday_product_booking]]
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600), Config.colors("red", 500)]
      },
      padding: {
        right: 40
      },
      axis: {
        x: {
          type: 'timeseries',
          tick: {
            outer: false,
            format: '%Y-%m-%d'
          }
        },
        y: {
          max: 300,
          min: 0,
          tick: {
            outer: false,
            count: 7,
            values: [0, 50, 100, 150, 200, 250, 300]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });

    
  })();





 

// UPCOMING NEXT FIVE DAY



var currentday= new Date();
var lastday = new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()+1);
var fiveday=new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()+5);
var fourday=new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()+4);
var thirday=new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()+3);
var scondday=new Date(currentday.getFullYear(),currentday.getMonth(),currentday.getDate()+2);

//End

// UPCOMING NEW BOOKING NEXT FIVE DAY
var newbooking_currentday= <?php echo $currentday_new_booking ?>;
var newbooking_lastday = <?php echo $firstday_new_booking ?>;
var newbooking_fiveday= <?php echo $fiveday_new_booking ?>;
var newbooking_fourday= <?php echo $fourday_new_booking ?>;
var newbooking_thirday= <?php echo $thirday_new_booking ?>;
var newbooking_scondday= <?php echo $second_new_booking ?>;

//End

// UPCOMING confirmed BOOKING NEXT FIVE DAY
var confirmedbooking_currentday= <?php echo $currentday_confirmed_booking ?>;
var confirmedbooking_lastday = <?php echo $firstday_confirmed_booking ?>;
var confirmedbooking_fiveday= <?php echo $fiveday_confirmed_booking ?>;
var confirmedbooking_fourday= <?php echo $fourday_confirmed_booking ?>;
var confirmedbooking_thirday= <?php echo $thirday_confirmed_booking ?>;
var confirmedbooking_scondday= <?php echo $second_confirmed_booking ?>;

//End

// UPCOMING cancelled BOOKING NEXT FIVE DAY
var cancelledbooking_currentday= <?php echo $currentday_cancelled_booking ?>;
var cancelledbooking_lastday = <?php echo $firstday_cancelled_booking ?>;
var cancelledbooking_fiveday= <?php echo $fiveday_cancelled_booking ?>;
var cancelledbooking_fourday= <?php echo $fourday_cancelled_booking ?>;
var cancelledbooking_thirday= <?php echo $thirday_cancelled_booking ?>;
var cancelledbooking_scondday= <?php echo $second_cancelled_booking ?>;

//End






  // Example C3 Timeseries
  // ---------------------
  

   (function () {
    var time_series_chart = c3.generate({
      bindto: '#exampleC3TimeSeries',
      data: {
        x: 'x',
        columns: [['x',currentday,lastday,scondday,thirday,fourday,fiveday], ['New booking', newbooking_currentday, newbooking_lastday, newbooking_scondday, newbooking_thirday, newbooking_fourday, newbooking_fiveday], ['Confirmed', confirmedbooking_currentday, confirmedbooking_lastday, confirmedbooking_scondday, confirmedbooking_thirday, confirmedbooking_fourday, confirmedbooking_fiveday]]
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600), Config.colors("red", 500)]
      },
      padding: {
        right: 40
      },
      axis: {
        x: {
          type: 'timeseries',
          tick: {
            outer: false,
            format: '%Y-%m-%d'
          }
        },
        y: {
          max: 30,
          min: 0,
          tick: {
            outer: false,
            count: 7,
            values: [0, 5, 10, 15, 20, 25, 30]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });

    setTimeout(function () {
      time_series_chart.load({
        columns: [['Cancelled', cancelledbooking_currentday, cancelledbooking_lastday, cancelledbooking_scondday, cancelledbooking_thirday, cancelledbooking_fourday, cancelledbooking_fiveday]]
      });
    }, 1000);
  })();

  // Example C3 Spline
  // -----------------
/*  (function () {
    var spline_chart = c3.generate({
      bindto: '#exampleC3Spline',
      data: {
        columns: [['Sales', 100, 165, 140, 270, 200, 140, 220], ['Appointments', 110, 80, 100, 85, 125, 90, 100]],
        type: 'spline'
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600)]
      },
      axis: {
        x: {
         max: fiveday,
          min: currentday,
          tick: {
            outer: false,
            count: 6,
            values: [currentday, lastday,scondday, thirday, fourday, fiveday]
          }
        },
        y: {
          max: 300,
          min: 0,
          tick: {
            outer: false,
            count: 7,
            values: [0, 50, 100, 150, 200, 250, 300]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })();*/

  // Example C3 Scatter
  // ------------------
  (function () {
    var scatter_chart = c3.generate({
      bindto: '#exampleC3Scatter',
      data: {
        xs: {
          setosa: 'setosa_x',
          versicolor: 'versicolor_x'
        },
        columns: [["setosa_x", 3.5, 3.0, 3.2, 3.1, 3.6, 3.9, 3.4, 3.4, 2.9, 3.1, 3.7, 3.4, 3.0, 3.0, 4.0, 4.2, 3.9, 3.5, 3.8, 3.8, 3.4, 3.7, 3.6, 3.3, 3.4, 3.0, 3.4, 3.5, 3.4, 3.2, 3.1, 3.4, 4.1, 4.2, 3.1, 3.2, 3.5, 3.6, 3.0, 3.4, 3.5, 2.3, 3.2, 3.5, 3.8, 3.0, 3.8, 3.2, 3.7, 3.3], ["versicolor_x", 3.2, 3.2, 3.1, 2.3, 2.8, 2.8, 3.3, 2.4, 2.9, 2.7, 2.0, 3.0, 2.2, 2.9, 2.9, 3.1, 3.0, 2.7, 2.2, 2.5, 3.2, 2.8, 2.5, 2.8, 2.9, 3.0, 2.8, 3.0, 2.9, 2.6, 2.4, 2.4, 2.7, 2.7, 3.0, 3.4, 3.1, 2.3, 3.0, 2.5, 2.6, 3.0, 2.6, 2.3, 2.7, 3.0, 2.9, 2.9, 2.5, 2.8], ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2], ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.6, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.2, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3]],
        type: 'scatter'
      },
      color: {
        pattern: [Config.colors("green", 600), Config.colors("red", 500)]
      },
      axis: {
        x: {
          label: 'Sepal.Width',
          tick: {
            outer: false,
            fit: false
          }
        },
        size: {
          height: 400
        },
        padding: {
          right: 40
        },
        y: {
          label: 'Petal.Width',
          tick: {
            outer: false,
            count: 5,
            values: [0, 0.4, 0.8, 1.2, 1.6]
          }
        }
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })();

  // Example C3 Bar
  // --------------
  (function () {
    var bar_chart = c3.generate({
      bindto: '#exampleC3Bar',
      data: {
        columns: [['data1', 30, 200, 100, 400, 150, 250], ['data2', 130, 100, 140, 200, 150, 50]],
        type: 'bar'
      },
      bar: {
        // width: {
        //  ratio: 0.55 // this makes bar width 55% of length between ticks
        // }
        width: {
          max: 20
        }
      },
      color: {
        pattern: [Config.colors("red", 400), Config.colors("grey", 500), Config.colors("grey", 300)]
      },
      grid: {
        y: {
          show: true
        },
        x: {
          show: false
        }
      }
    });

    setTimeout(function () {
      bar_chart.load({
        columns: [['data3', 130, -150, 200, 300, -200, 100]]
      });
    }, 1000);
  })();

  // Example C3 Stacked Bar
  // ----------------------
  (function () {
    var stacked_bar_chart = c3.generate({
      bindto: '#exampleC3StackedBar',
      data: {
        columns: [['data1', -30, 200, 300, 400, -150, 250], ['data2', 130, 100, -400, 100, -150, 50], ['data3', -230, 200, 200, -300, 250, 250]],
        type: 'bar',
        groups: [['data1', 'data2']]
      },
      color: {
        pattern: [Config.colors("primary", 500), Config.colors("grey", 400), Config.colors("purple", 500), Config.colors("light-green", 500)]
      },
      bar: {
        width: {
          max: 45
        }
      },
      grid: {
        y: {
          show: true,
          lines: [{
            value: 0
          }]
        }
      }
    });

    setTimeout(function () {
      stacked_bar_chart.groups([['data1', 'data2', 'data3']]);
    }, 1000);

    setTimeout(function () {
      stacked_bar_chart.load({
        columns: [['data4', 100, -250, 150, 200, -300, -100]]
      });
    }, 1500);

    setTimeout(function () {
      stacked_bar_chart.groups([['data1', 'data2', 'data3', 'data4']]);
    }, 2000);
  })();

  // Example C3 Combination
  // ----------------------
  (function () {
    var combination_chart = c3.generate({
      bindto: '#exampleC3Combination',
      data: {
        columns: [['data1', 30, 20, 50, 40, 60, 50], ['data2', 200, 130, 90, 240, 130, 220], ['data3', 300, 200, 160, 400, 250, 250], ['data4', 200, 130, 90, 240, 130, 220], ['data5', 130, 120, 150, 140, 160, 150], ['data6', 90, 70, 20, 50, 60, 120]],
        type: 'bar',
        types: {
          data3: 'spline',
          data4: 'line',
          data6: 'area'
        },
        groups: [['data1', 'data2']]
      },
      color: {
        pattern: [Config.colors("grey", 500), Config.colors("grey", 300), Config.colors("yellow", 600), Config.colors("primary", 600), Config.colors("red", 400), Config.colors("green", 600)]
      },
      grid: {
        x: {
          show: false
        },
        y: {
          show: true
        }
      }
    });
  })();

  // Example C3 Pie
  // --------------
  (function () {
    var pie_chart = c3.generate({
      bindto: '#exampleC3Pie',
      data: {
        // iris data from R
        columns: [['data1', 100], ['data2', 40]],
        type: 'pie'
      },
      color: {
        pattern: [Config.colors("primary", 500), Config.colors("grey", 300)]
      },
      legend: {
        position: 'right'
      },
      pie: {
        label: {
          show: false
        },
        onclick: function onclick(d, i) {},
        onmouseover: function onmouseover(d, i) {},
        onmouseout: function onmouseout(d, i) {}
      }
    });
  })();

  // Example C3 Donut
  // ----------------
  (function () {
    var donut_chart = c3.generate({
      bindto: '#exampleC3Donut',
      data: {
        columns: [['data1', 120], ['data2', 40], ['data3', 80]],
        type: 'donut'
      },
      color: {
        pattern: [Config.colors("primary", 500), Config.colors("grey", 300), Config.colors("red", 400)]
      },
      legend: {
        position: 'right'
      },
      donut: {
        label: {
          show: false
        },
        width: 10,
        title: "C3 Dount Chart",
        onclick: function onclick(d, i) {},
        onmouseover: function onmouseover(d, i) {},
        onmouseout: function onmouseout(d, i) {}
      }
    });
  })();

  // Example Sub Chart
  // ----------------
  (function () {
    var donut_chart = c3.generate({
      bindto: '#exampleC3Subchart',
      data: {
        columns: [['data1', 100, 165, 140, 270, 200, 140, 220, 210, 190, 100, 170, 250], ['data2', 110, 80, 100, 85, 125, 90, 100, 130, 120, 90, 100, 115]],
        type: 'spline'
      },
      color: {
        pattern: [Config.colors("primary", 600), Config.colors("green", 600)]
      },
      subchart: {
        show: true
      }
    });
  })();

  // Example C3 Zoom
  // ----------------
  (function () {
    var donut_chart = c3.generate({
      bindto: '#exampleC3Zoom',
      data: {
        columns: [['sample', 30, 200, 100, 400, 150, 250, 150, 200, 170, 240, 350, 150, 100, 400, 150, 250, 150, 200, 170, 240, 100, 150, 250, 150, 200, 170, 240, 30, 200, 100, 400, 150, 250, 150, 200, 170, 240, 350, 150, 100, 400, 350, 220, 250, 300, 270, 140, 150, 90, 150, 50, 120, 70, 40]],
        colors: {
          sample: Config.colors("primary", 600)
        }
      },
      zoom: {
        enabled: true
      }
    });
  })();
});
  
</script>