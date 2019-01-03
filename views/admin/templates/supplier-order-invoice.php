<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
    <head>
               
        <title>New Order | Booking in Time</title>
        
        <link rel="apple-touch-icon" href="<?php echo base_url('assets/images/apple-touch-icon.png');?>">
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico');?>">
       <style type="text/css">
           body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #212529;
  text-align: left;
  background-color: #fff;
}
hr {
  box-sizing: content-box;
  height: 0;
  overflow: visible;
}
p {
  margin-top: 0;
  margin-bottom: 1rem;
}
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
  background-color: transparent;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-borderless th,
.table-borderless td,
.table-borderless thead th,
.table-borderless tbody + tbody {
  border: 0;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-primary,
.table-primary > th,
.table-primary > td {
  background-color: #b8daff;
}

.table-hover .table-primary:hover {
  background-color: #9fcdff;
}

.table-hover .table-primary:hover > td,
.table-hover .table-primary:hover > th {
  background-color: #9fcdff;
}

.table-secondary,
.table-secondary > th,
.table-secondary > td {
  background-color: #d6d8db;
}

.table-hover .table-secondary:hover {
  background-color: #c8cbcf;
}

.table-hover .table-secondary:hover > td,
.table-hover .table-secondary:hover > th {
  background-color: #c8cbcf;
}

.table-success,
.table-success > th,
.table-success > td {
  background-color: #c3e6cb;
}

.table-hover .table-success:hover {
  background-color: #b1dfbb;
}

.table-hover .table-success:hover > td,
.table-hover .table-success:hover > th {
  background-color: #b1dfbb;
}

.table-info,
.table-info > th,
.table-info > td {
  background-color: #bee5eb;
}

.table-hover .table-info:hover {
  background-color: #abdde5;
}

.table-hover .table-info:hover > td,
.table-hover .table-info:hover > th {
  background-color: #abdde5;
}

.table-warning,
.table-warning > th,
.table-warning > td {
  background-color: #ffeeba;
}

.table-hover .table-warning:hover {
  background-color: #ffe8a1;
}

.table-hover .table-warning:hover > td,
.table-hover .table-warning:hover > th {
  background-color: #ffe8a1;
}

.table-danger,
.table-danger > th,
.table-danger > td {
  background-color: #f5c6cb;
}

.table-hover .table-danger:hover {
  background-color: #f1b0b7;
}

.table-hover .table-danger:hover > td,
.table-hover .table-danger:hover > th {
  background-color: #f1b0b7;
}

.table-light,
.table-light > th,
.table-light > td {
  background-color: #fdfdfe;
}

.table-hover .table-light:hover {
  background-color: #ececf6;
}

.table-hover .table-light:hover > td,
.table-hover .table-light:hover > th {
  background-color: #ececf6;
}

.table-dark,
.table-dark > th,
.table-dark > td {
  background-color: #c6c8ca;
}

.table-hover .table-dark:hover {
  background-color: #b9bbbe;
}

.table-hover .table-dark:hover > td,
.table-hover .table-dark:hover > th {
  background-color: #b9bbbe;
}

.table-active,
.table-active > th,
.table-active > td {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover > td,
.table-hover .table-active:hover > th {
  background-color: rgba(0, 0, 0, 0.075);
}

.table .thead-dark th {
  color: #fff;
  background-color: #212529;
  border-color: #32383e;
}

.table .thead-light th {
  color: #495057;
  background-color: #e9ecef;
  border-color: #dee2e6;
}

.table-dark {
  color: #fff;
  background-color: #212529;
}

.table-dark th,
.table-dark td,
.table-dark thead th {
  border-color: #32383e;
}

.table-dark.table-bordered {
  border: 0;
}

.table-dark.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(255, 255, 255, 0.05);
}

.table-dark.table-hover tbody tr:hover {
  background-color: rgba(255, 255, 255, 0.075);
}
h3{color: #000!important;font-style: normal;}
h4{color: #000!important;font-style: normal;}
p{color: #000!important;font-style: normal;}

       </style>
    </head>
    <body class="animsition page-invoice">
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Page -->
        <div class="page">
            <div class="page-content">
                <?php
                $business_id_val = ($post_data['business_id_val'])?$post_data['business_id_val']:$admin_session['business_id'];
                $business_data = getBusinessDetailsById($business_id_val);
                $location_data = getLocationDetailsById($post_data['location_id_val']);
                ?>
                <!-- Panel -->
                <div class="panel">
                    <div class="panel-body container-fluid" >
                        <div class="row">
                            <div style="width: 50%;float: left;">
                                <h3>
                                <img width="150px;" class="mr-10" src="<?php echo base_url('assets/images/logo.png');?>"
                                alt="..."></h3>
                                <address>
                                    <h4>Business Details : </h4>
                                    <p>
                                        Business Name : <?= isset($business_data->name)?$business_data->name:""; ?><br>
                                        Email : <?= isset($business_data->email)?$business_data->email:""; ?><br>
                                        Address : <?= isset($business_data->address1)?$business_data->address1:""; ?><?= isset($business_data->address2)?$business_data->address2:""; ?><br>
                                        City : <?= isset($business_data->city)?$business_data->city:"---"; ?><br>
                                        State : <?= isset($business_data->state)?$business_data->state:"---"; ?><br>
                                        Post Code : <?= isset($business_data->post_code)?$business_data->post_code:"---"; ?><br>
                                        Phone : <?= isset($business_data->phone_number)?$business_data->phone_number:"---"; ?><br>
                                    </p>
                                </address>
                            </div>
                            <div style="width: 45%;float:left;text-align: right;">
                                <h3>&nbsp;</h3>
                                <h4>Location Details : </h4>
                                <p>
                                   Location Name : <?= isset($location_data->location_name)?$location_data->location_name:""; ?><br>
                                    Address : <?= isset($location_data->address1)?$location_data->address1:"";?><?= isset($location_data->address2)?$location_data->address2:""; ?><br>
                                    City : <?= isset($location_data->city)?$location_data->city:"---"; ?><br>
                                    State : <?= isset($location_data->state)?$location_data->state:"---"; ?><br>
                                    Post Code : <?= isset($location_data->post_code)?$location_data->post_code:"---"; ?><br>
                                    Phone : <?= isset($location_data->phone_number)?$location_data->phone_number:"---"; ?><br>
                                </p>
                            </div>
                        </div>
                        <div style="color: #000!important;">
                            <div style="clear: both; color: #000!important;">
                            <b>Message : </b> <?php echo !empty($post_data['notes'])?$post_data['notes']:"No Message from Bowner"; ?>
                            </div> 
                        </div><br>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="text-align: right;">#</th>
                                        <th style="text-align: right;">Product Name</th>
                                        <th style="text-align: right;">product Code</th>
                                        <th style="text-align: right;">Quantity</th>
                                       <!--  <th style="text-align: right;">Price</th>
                                        <th style="text-align: right;">Amount</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $j=0;
                                    $sub_total = 0;
                                    $total_price = 0;
                                    foreach ($post_data['product_id'] as $key => $value) {
                                        $amount = $post_data['quantity'][$key]*$post_data['product_price'][$key];
                                        $total_price = $total_price+$amount;
                                    ?>
                                    <tr>
                                        <td style="text-align: right;">#<?=$i; ?></td>
                                        <td style="text-align: right;"><?php echo getProductName($value); ?></td>
                                        <td style="text-align: right;"><?php echo getProductCode($value); ?></td>
                                        <td style="text-align: right;"><?php echo $post_data['quantity'][$key]; ?></td>
                                       <!--  <td style="text-align: right;"><?php echo $post_data['product_price'][$key]; ?></td>
                                        <td style="text-align: right;"><?php echo $amount; ?></td> -->
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- <div style="text-align: right;clear: both;">
                            <div style="float: right;">
                                <p><b>Grand Total :
                                    <span><?php echo $total_price; ?></span></b>
                                </p>
                            </div>
                        </div> -->
                    </div>
                </div>
                <!-- End Panel -->
            </div>
        </div>
        <!-- End Page -->
    </body>
</html>