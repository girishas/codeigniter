<!DOCTYPE html>
<html>
    <head>
        <title>Invoice</title>
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
        h1, h2, h3, h4, h5, h6 {
        margin-top: 0;
        margin-bottom: 0.5rem;
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
        @media (max-width: 575.98px) {
        .table-responsive-sm {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        }
        .table-responsive-sm > .table-bordered {
        border: 0;
        }
        }
        @media (max-width: 767.98px) {
        .table-responsive-md {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        }
        .table-responsive-md > .table-bordered {
        border: 0;
        }
        }
        @media (max-width: 991.98px) {
        .table-responsive-lg {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        }
        .table-responsive-lg > .table-bordered {
        border: 0;
        }
        }
        @media (max-width: 1199.98px) {
        .table-responsive-xl {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        }
        .table-responsive-xl > .table-bordered {
        border: 0;
        }
        }
        .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        }
        .table-responsive > .table-bordered {
        border: 0;
        }
        .container {
        margin-right: auto;
        margin-left: auto;
        padding-left: 15px;
        padding-right: 15px;
        }
        @media (min-width: 768px) {
        .container {
        width: 750px;
        }
        }
        @media (min-width: 992px) {
        .container {
        width: 970px;
        }
        }
        @media (min-width: 1200px) {
        .container {
        width: 1170px;
        }
        }
        .container-fluid {
        margin-right: auto;
        margin-left: auto;
        padding-left: 15px;
        padding-right: 15px;
        }
        .row {
        margin-left: -15px;
        margin-right: -15px;
        }
        .col-md-6{
        width: 50%;
        float: left;
        }
        .clear{
        clear: both;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="page-main">
                <div class="page-content">
                    <div class="panel">
                        <!-- Contacts Content Header -->
                        
                        <div class="panel-body" id="printable">
                            <?php 
                            $logo = getBusinessLogo($business_id);
                            if($logo !="" && !empty($logo)):
                            ?>
                            <div style="text-align:center;">
                            <img class="img-responsive"  src="<?= base_url('images/staff/thumb/'.$logo); ?>" style="max-width: 150px;">
                        </div>
                        <?php endif ?>
                         <div style="text-align:center;">
                            <h2>
                            <?php echo getBusinessNameById($business_id); ?>
                            </h2>
                        </div>
                            <div class="row">
                               <div class="col-md-12">
                                     <?php $businessDetails= getBusinessData($business_id); ?>
                      ABN No. : <?php echo $businessDetails['abn_number'] ;

                        ?>  </div>  
                         <div class="col-md-12">
                                     <?php $locationDetails= getLocationData($location_id); ?>
                       Address. : <?php echo $locationDetails['address1'] ;

                        ?>  </div> 
                            </div><br><br>
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><b class="black">Year</b></th>
                                            <th class="text-center"><b class="black">Month</b></th>
                                            <th class="text-center"><b class="black">Cash</b></th>
                                            <th class="text-center"><b class="black">Card </b></th>
                                            <th class="text-center"><b class="black">Voucher</b></th>
                                            <th class="text-center"><b class="black">Others </b></th>
                                            <th class="text-center"><b class="black">Total </b></th>
                                        </tr>
                                    </thead>
                                    <tbody>                                        
                                    <tr>                                            
                                        <td class="text-right"><?= $year; ?></td>
                                        <td class="text-right"><?= date("F", mktime(0, 0, 0, $month, 10)); ?></td>
                                        <td class="text-right"><?=$cash; ?></td>
                                        <td class="text-right"><?=$card; ?></td>
                                        <td class="text-right"><?=$voucher; ?></td>
                                        <td class="text-right"><?=$others; ?></td>
                                        <td class="text-right"><?=$total; ?></td>
                                    </tr>                                        
                                    </tbody>
                                </table>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('global/vendor/jquery/jquery.js');?>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                window.print();
            });
        </script>
    </body>
</html>