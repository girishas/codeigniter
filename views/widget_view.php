<!DOCTYPE html>
<html lang="en">

<head>
    <!--- Basic Page Needs  -->
    <meta charset="utf-8">
    <title>Online Widget Booking</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Meta  -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/fonts/raleway.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/fonts/roboto.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/fonts/workSans.css');?>">
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/icofont.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/jquery-ui.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/font-awesome.min.css');?>"> 
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/animate.css');?>">   
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/style.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/frontend/css/responsive.css');?>">
    <link rel="stylesheet"  href="<?php echo base_url('global/vendor/jquery-labelauty/jquery-labelauty.css');?>">


    <!-- Favicon -->
    <link rel="shortcut icon"  type="image/png" href="<?php echo base_url('global/frontend/css/icons/favicon.ico');?>">
    

    <!-- county with ISD code -->
    <link rel="stylesheet" href="<?php echo base_url('assets/selectbox_isd_code/build/css/intlTelInput.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('global/vendor/bootstrap-datepicker/bootstrap-datepicker.css');?>">
    <!-- county with ISD code -->

    <style>
    .group-item-chevron-right {
    float: right;
    display: none;
}
      .widget-banner-box { border: 0px solid #eaeaea !important;}
      .outer-box { border: 0px solid #eaeaea; }
      .outer-box .group-name { padding: 20px; }
      .group { border-bottom: 1px solid #eaeaea; overflow-y: hidden;}
      .group-step2 { border-top: 1px solid #eaeaea; height: auto;   overflow-y: hidden; }
      .group-step3 { border-top: 1px solid #eaeaea; height: auto;   overflow-y: hidden; }
      .group-item:hover { background-color: #eaeaea; }
      .group-item-input{ padding: 10px; }
      .regular,.floating { display: none; }
      .staff-member-group { padding: 10px;height: 50px; }
      .group-item-chevron-right { float: right; }
      .staff-member-group-submit {  padding: 0;border: none;width: 100%;background: #fff;text-align: left; }
      .cf-ib-submit1{margin-top: 10px;}
      .intl-tel-input { width: 100% !important; }
      .label{    margin-top:6px !important;margin-left: 2px!important;}

        .label__checkbox {
         zoom:1.5;
        }

        .label__check {
          display: inline-block;
          border-radius: 50%;
          border: 5px solid rgba(0,0,0,0.1);
          background: white;
          vertical-align: middle;
          margin-right: 20px;
          width: 2em;
          height: 2em;
          cursor: pointer;
          display: flex;
          align-items: center;
          justify-content: center;
          transition: border .3s ease;
          
          i.icon {
            opacity: 0.2;
            font-size: ~'calc(1rem + 1vw)';
            color: transparent;
            transition: opacity .3s .1s ease;
            -webkit-text-stroke: 3px rgba(0,0,0,.5);
          }
          
          &:hover {
            border: 5px solid rgba(0,0,0,0.2);
          }
        }

        .label__checkbox:checked + .label__text .label__check {
          animation: check .5s cubic-bezier(0.895, 0.030, 0.685, 0.220) forwards;
          
          .icon {
            opacity: 1;
            transform: scale(0);
            color: white;
            -webkit-text-stroke: 0;
            animation: icon .3s cubic-bezier(1.000, 0.008, 0.565, 1.650) .1s 1 forwards;
          }
        }

        /*.center {
          position: absolute;
          top: 23px; left: 30px;
          transform: translate(-50%,-50%);
        }*/

        @keyframes icon {
          from {
            opacity: 0;
            transform: scale(0.3);
          }
          to {
            opacity: 1;
            transform: scale(1)
          }
        }

        @keyframes check {
          
          100% {
            width: 2em;
            height: 2em;
            background: #5dcdef;
            border: 0;
            opacity: 1;
          }
        }

      

    .pointer {cursor: pointer;}

   /* .classA{  
      height: 500px !important;
      overflow-y: scroll;
}*/
input[type=text]{
  height:40px!important;
}select{
  height:40px!important;
}
.col1{
  width: 10%;
  float: left;
}
.col2{
  width: 15%;
  float: left;
}
.col10{
  width: 75%;
  float: left;
}

.cf-input-box input[type="submit"] {
      padding: 12px 26px!important;
  }

  .fa {
    cursor: pointer!important;
  }
    
    </style>
    
</head>

<body class="home2-body">

  <?php $get_hours_range_fifteen = get_hours_range_fifteen(); ?>
    
    <form autocomplete="off" method="post"  action="<?php echo base_url('online-bookings/').$this->uri->segment('2'); ?>"  name="widget_form" enctype="multipart/form-data" id="form1">
							

	
	<!-- contact-area-start -->
   
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          <?php if(isset($step) and $step==0){ ?> 

				    <input type="hidden" name="step" value="10">   
            <div class="widget_banner blog-widget">
                <div class="widget-banner-box"> 
                    <strong><?php echo $_SESSION['busines']['name']?></strong><br/> <b><small>(Online Booking) </small></b>
                </div> 
                <div class="row"> 
                   <!-- <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="h2-logo" style="padding:0px !important; margin-left: 23px;"> 
                       <a href="javascript:void(0);"  ><img src="<?php echo base_url('assets/images/logo.png');?>" alt="" style="height:106px !important;" ></a>
                    </div>
                  </div> -->  
                  <div class="container outer-box">  
                  <div class="col-md-12 cf-input-box cf-ib-submit cf-ib-submit1" style="text-align: center; margin-top: 20px;">
                    <input id="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic" name="submit" type="submit" value="Start Your Online bOoking Here">
                  </div> 
            <?php }

            elseif(isset($step) and $step==9){ ?>
              <input type="hidden" name="step" value="1"> 
              <div class="widget-banner-box">
              <div class="row">
                <div class="col-sm-1">
                  <button type="submit" name="step10" value="Submit" class="form-control" style="border:none !important;display: inline-block;"><i class="fa fa-chevron-left fa-3x" aria-hidden="true" ></i></button> 
                </div>
                <div class="col-sm-11"><div class="widget-banner-box"> 
                    <strong><?php echo $_SESSION['busines']['name']?></strong><br/> <b><small>(Online Booking) </small></b>
                </div></div>
              </div>
              </div>  
              <div class="classA">
                <div class='scrollable'> 
                    <?php 
                    $i=0;
                    foreach ($locations as $key => $value): 
                      if(isset($_SESSION['booking']['location_id'])){
                        $check = ($_SESSION['booking']['location_id']==$value['id'])?"checked":"";
                      }
                      ?>
                        <div class='container-fluid group'>
                          <div class="row group-item">
                            <div class="col1">
                              <div class="center">
                                <label class="label pointer">  
                               <input <?php if(isset($check)) {echo $check;} ?> id="checkbox_check_<?php echo $i; ?>" class="label__checkbox checkbox_check" required="required" type="radio" id="location_id" name="location_id" value="<?php echo $value['id']; ?>"/> 
                                </label>
                              </div> 
                            </div>
                            <label class="col10 pointer"  for="checkbox_check_<?php echo $i; ?>">  
                              <div class='title'><?php echo $value['location_name']; ?></div>
                            </label> 
                          </div>
                        </div>
                    <?php
                    $i++;
                    endforeach ?>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-sx-12 cf-input-box cf-ib-submit cf-ib-submit1">
                    <input id="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic" name="submit" type="submit" value="Next">
                    </div>
           <?php }


            elseif(isset($step) and $step==1){ ?>
              <input type="hidden" name="step" value="2"> 
              <div class="widget-banner-box">
              <div class="row">
                <div class="col-sm-1">
                  <button type="submit" name="step9" value="Submit" class="form-control" style="border:none !important;display: inline-block;"><i class="fa fa-chevron-left fa-3x" aria-hidden="true" ></i></button> 
                </div>
                <div class="col-sm-11"><div class="widget-banner-box"> 
                    <strong><?php echo $_SESSION['busines']['name']?></strong><br/> <b><small>(Online Booking) </small></b>
                </div></div>
              </div>
              </div>  
              <div class="classA">
                <div class='scrollable'> 
                   <div class="row form-group">
                      <div class="col-sm-12">
                        <label class="form-control-label" for="inputGrid2">Date</label>
                <input type="text" class="form-control datep datepickstart" required="required" data-date-format="d-m-Y" id="date_staff" name="date" value="<?php echo date('d-m-Y') ?>">
                      </div>
                    </div>
                    <?php 
                     //date_default_timezone_set('Asia/Kolkata');
         $currentTime = date( 'h:i', time () );
         ?>
                     <div class="row form-group">
                      <div class="col-sm-12">
                      <label class="form-control-label" for="inputGrid2">Time</label>
                      <select class="form-control" required="required" name="time" id="time">
                        <!-- <?php
                        foreach ($get_hours_range_fifteen as $key => $value): ?>
                        <?php if ($currentTime < $key) { ?>
                         <option <?= ($key=="09:00:00")?"selected":""; ?> value="<?=$key?>"><?= $value; ?></option>
                         
                       <?php } ?>
                       
                        <?php endforeach ?> -->
                      </select>
                    </div>
                    </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-sx-12 cf-input-box cf-ib-submit cf-ib-submit1">
                    <input id="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic" name="submit" type="submit" value="Next">
                    </div>
           <?php }

           elseif(isset($step) and $step==10){ ?> 
            <input type="hidden" name="step" value="9"> 
            <div class="widget-banner-box">
              <div class="row">
                <div class="col-sm-1">
                  <button type="submit" name="step0" value="Submit" class="form-control" style="border:none !important;display: inline-block;"><i class="fa fa-chevron-left fa-3x" aria-hidden="true" ></i></button> 
                </div>
                <div class="col-sm-10"><div class="widget-banner-box"> 
                    <strong><?php echo $_SESSION['busines']['name']?></strong><br/> <b><small>(Online Booking) </small></b>
                </div></div>
                <div class="col-sm-1"> </div>
              </div>
            </div>  
            <div class="classA">
              <div class='scrollable'>
                    <?php
                    $i=0; 
                    if(isset($_SESSION['booking']['service_listing'])){
                      $array = $_SESSION['booking']['service_listing']; 
                      $count_item = count((array)$array);

                       $sum_item = 0; 
                       foreach($_SESSION['booking']['service_listing'] as $key=>$val3) {
                                if ($val3['special_price']){  
                                    $sum_item+= $val3['special_price'];
                                 }else{
                                  $sum_item+= $val3['retail_price'];
                                 } 
                              } 
                    }else{
                      $count_item = 0;
                      $sum_item =0;
                    } ?>
                    <div class="accordion" id="accordionExample">
                      <?php 
                      $i=0;
                      $key=0;
                      foreach ($service_list as $keys => $value): ?> 
                      <div class="card">
                        <div class="card-header" id="headingOne">
                          <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne_<?=$key?>" aria-expanded="true" aria-controls="collapseOne">
                             <h4><?=$value['name'];?>

                                
                              </h4> 
                            </button>
                          </h5>
                        </div>
                        <div id="collapseOne_<?=$key?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                          <div class="card-body">
                            <!-- Loop -->
                            <?php foreach ($value['services'] as $kkey => $vvalue): ?>
                              <?php foreach ($vvalue['service_timing'] as $kkkey => $vvvalue): 
                                 if(isset($_SESSION['booking']['service_listing_arr'])){
                                    $check = (in_array($vvvalue['id'], $_SESSION['booking']['service_listing_arr']))?"checked":"";
                                  }
                                ?>                             
                              <div class='container-fluid group'>
                                  <div class="row group-item " >
                                    <div class="col1">
                                      <div class="center">
                                        <label class="label pointer"> 
                                      <?php if($vvvalue['special_price']){ ?>  
                                       <input <?php if(isset($check)) {echo $check;} ?> id="checkbox_check_<?php echo $i; ?>" class="label__checkbox checkbox_check "  type="checkbox" name="id[]" value="<?php echo $vvvalue['id']; ?>" rel="<?php echo $vvvalue['special_price']; ?>" /> 
                                      <?php }else{ ?>
                                        <input <?php if(isset($check)) {echo $check;} ?> id="checkbox_check_<?php echo $i; ?>" class="checkbox-custom"  type="checkbox" name="id[]" value="<?php echo $vvvalue['id']; ?>" rel="<?php echo $vvvalue['retail_price']; ?>" />
                                      <?php } ?> 
                                        </label>
                                      </div> 
                                    </div>
                                    <label class="col10 pointer"  for="checkbox_check_<?php echo $i; ?>">  
                                      <div class='title'><?php //echo $vvalue['sku']; ?>  <?php echo $vvalue['service_name']; ?> <?php echo $vvvalue['caption']; ?>
                                        </div>
                                        <!-- <label style="font-size: 12px;">
                                         <?php/* 
                                         if (strlen($vvalue['description'])<31) {
                                           echo $vvalue['description'];
                                         }
                                         else{
                                          echo substr($vvalue['description'],0,30).'....';
                                         } */?>
                                           
                                         </label> -->
                                         
                                          
                                          
                                       
                                      <!-- <div class='subtitle'>
                                      <?php
                                      $timeArr = explode(":", $vvvalue['duration']);
                                       echo $timeArr[0].' Hours: '. $timeArr[1].' Minutes';
                                        ?> </div>   -->   
                                    </label> 
                                       <label class="col2 pointer" for="checkbox_check_<?php echo $i; ?>">
                                      <?php if($vvvalue['special_price']){ ?> 
                                       <div class='js-price text-right' data-price=<?php echo $vvvalue['special_price']; ?>>$<?php echo $vvvalue['special_price']; ?></div>
                                      <?php }else{ ?>
                                        <div class='js-price text-right' data-price=<?php echo $vvvalue['retail_price']; ?>>$<?php echo $vvvalue['retail_price']; ?></div>
                                      <?php } ?>
                                    </label> 
                                  </div>
                                </div>
                                 <?php
                                  $i++;
                                  endforeach; ?>
                                <?php endforeach ?>
                                <!-- Loop -->
                          </div>
                        </div>
                      </div> 
                       <?php 
                        $key++;
                       endforeach ?>
                    </div>


                   <?php $key+1;

                    ?>
                      <div class="accordion" id="accordionExample">
                       <!-- <h2>Service Group</h2> --> 

                       <h2> Special Offers </h2>

                      <?php 
                     
                      foreach ($options_gs as $keys => $value): ?> 
                      <div class="card">
                        <div class="card-header" id="headingOne">
                          <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne_<?=$key?>" aria-expanded="true" aria-controls="collapseOne">

                             <h4><?=$value['package_name'];?>
                            
                                
                              </h4> 
                            </button>
                          </h5>
                        </div>
                        <div id="collapseOne_<?=$key?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                          <div class="card-body">
                            <?php $allservices = getServicesByServiceGroup($value['id']); ?>
							<?php /* <div class='container-fluid group'>
							  <div class="row group-item " >
								<div class="col1">
								  <div class="center">
									<label class="label pointer"> 
								  <?php if($value['discounted_price']){ ?>  
								   <input <?php if(isset($check)) {echo $check;} ?> id="checkbox_check_<?php echo $i; ?>" class="label__checkbox checkbox_check check_all_<?php echo $key; ?>"  type="checkbox" name="id[]" value="<?php echo $value['id']; ?>" rel="<?php echo $value['discounted_price']; ?>" /> 
								  <?php }else{ ?>
									<input <?php if(isset($check)) {echo $check;} ?> id="checkbox_check_<?php echo $i; ?>" class="checkbox-custom"  type="checkbox" name="id[]" value="<?php echo $value['id']; ?>" rel="<?php echo $value['cost_price']; ?>" />
								  <?php } ?> 
									</label>
								  </div> 
								</div>
								<label class="col10 pointer"  for="checkbox_check_<?php echo $i; ?>"> 
								   <!--<input type="hidden"  name="group_service_id[<?php echo $value['id']; ?>]" class="form-control" value="<?php echo $value['id']; ?>">-->

								  <div class='title'> <?php echo $value['package_name']; ?> 
									</div>                                        
								</label> 
								   <label class="col2 pointer" for="checkbox_check_<?php echo $i; ?>">
								  <?php if($value['discounted_price']){ ?> 
								   <div class='js-price text-right' data-price=<?php echo $value['discounted_price']; ?>>$<?php echo $value['discounted_price']; ?></div>
								  <?php }else{ ?>
									<div class='js-price text-right' data-price=<?php echo $value['cost_price']; ?>>$<?php echo $value['cost_price']; ?></div>
								  <?php } ?>
								</label> 
							  </div>
							</div> */ ?>

                            <!-- Loop -->
								
                              <?php $display_first = 0;
							  foreach ($allservices as $kkkey => $vvvalue): 
                                 $display_first++;
								 if(isset($_SESSION['booking']['service_listing_arr'])){
                                    $check = (in_array($vvvalue['id'], $_SESSION['booking']['service_listing_arr']))?"checked":"";
                                  }
                                ?> 
								<?php if($display_first == 1){?>	
								<div class='container-fluid group'  >
                                  <div class="row group-item " >
                                    <div class="col1">
                                      <div class="center">
                                        <label class="label pointer"> 
                                       <?php if($vvvalue['special_price']){ ?>  
                                       <input <?php if(isset($check)) {echo $check;} ?> id="checkbox_check_<?php echo $i; ?>" class="label__checkbox checkbox_check check_all_<?php echo $key; ?>"  type="checkbox" name="id[]" value="<?php echo $vvvalue['id']; ?>" rel="<?php echo $vvvalue['special_price']; ?>" /> 
                                      <?php }else{ ?>
                                        <input <?php if(isset($check)) {echo $check;} ?> id="checkbox_check_<?php echo $i; ?>" class="checkbox-custom"  type="checkbox" name="id[]" value="<?php echo $vvvalue['id']; ?>" rel="<?php echo $vvvalue['retail_price']; ?>" />
                                      <?php } ?> 
                                        </label>
                                      </div> 
                                    </div>
                                    <label class="col10 pointer"  for="checkbox_check_<?php echo $i; ?>"> 
                                       <input type="hidden"  name="group_service_id[<?php echo $vvvalue['id']; ?>]" class="form-control" value="<?php echo $value['id']; ?>">

                                      <div class='title'> <?php echo $value['package_name']; ?> 
                                        </div>                                        
                                    </label> 
                                       <label class="col2 pointer" for="checkbox_check_<?php echo $i; ?>">
                                      <?php if($value['discounted_price']){ ?> 
                                       <div class='js-price text-right' data-price=<?php echo $value['discounted_price']; ?>>$<?php echo $value['discounted_price']; ?></div>
                                      <?php }else{ ?>
                                        <div class='js-price text-right' data-price=<?php echo $value['cost_price']; ?>>$<?php echo $value['cost_price']; ?></div>
                                      <?php } ?>
                                    </label> 
                                  </div>
                                </div>
								<?php }else{ ?>
								<div class='container-fluid group'  style="display:none;">
                                  <div class="row group-item " >
                                    <div class="col1">
                                      <div class="center">
                                        <label class="label pointer"> 
                                      <?php if($vvvalue['special_price']){ ?>  
                                       <input <?php if(isset($check)) {echo $check;} ?> id="checkbox_check_<?php echo $i; ?>" class="label__checkbox checkbox_check check_all_<?php echo $key; ?>"  type="checkbox" name="id[]" value="<?php echo $vvvalue['id']; ?>" rel="<?php echo $vvvalue['special_price']; ?>" /> 
                                      <?php }else{ ?>
                                        <input <?php if(isset($check)) {echo $check;} ?> id="checkbox_check_<?php echo $i; ?>" class="checkbox-custom"  type="checkbox" name="id[]" value="<?php echo $vvvalue['id']; ?>" rel="<?php echo $vvvalue['retail_price']; ?>" />
                                      <?php } ?> 
                                        </label>
                                      </div> 
                                    </div>
                                    <label class="col10 pointer"  for="checkbox_check_<?php echo $i; ?>"> 
                                       <input type="hidden"  name="group_service_id[<?php echo $vvvalue['id']; ?>]" class="form-control" value="<?php echo $value['id']; ?>">

                                      <div class='title'><?php //echo $vvalue['sku']; ?>  <?php echo $vvvalue['service_name']; ?> <?php echo $vvvalue['caption']; ?>
                                        </div>                                        
                                    </label> 
                                       <label class="col2 pointer" for="checkbox_check_<?php echo $i; ?>">
                                      <?php if($vvvalue['special_price']){ ?> 
                                       <div class='js-price text-right' data-price=<?php echo $vvvalue['special_price']; ?>>$<?php echo $vvvalue['special_price']; ?></div>
                                      <?php }else{ ?>
                                        <div class='js-price text-right' data-price=<?php echo $vvvalue['retail_price']; ?>>$<?php echo $vvvalue['retail_price']; ?></div>
                                      <?php } ?>
                                    </label> 
                                  </div>
                                </div>
                                 <?php
                                  $i++;
								}
                                  endforeach; ?>
                                
                                <!-- Loop -->
                          </div>
                        </div>
                      </div>  
                       <?php 
                       $key++;
                       endforeach ?>
                    </div>





                  </div>
                </div>
                  </br>
                   <div class="row">
                        <div class="col-md-6 col-sm-6 col-sx-6">
                    <div class='regular summary'>
                      <div class='selection-summary'>
                        <div class='text normal'>
                        You have selected
                        </div>
                        <!-- <div class='text at-limit'>
                        Maximum selected
                        </div> -->
                        <span class='services-total-count'><?php echo $count_item; ?></span>
                        <span class='services-total-items-text'>item(s),</span>
                        <span class='services-total-price'>$<?php echo $sum_item ?> </span>
                      </div>
                      <div class='actions'>
                        <!-- <input type="submit" name="commit" value="Book now" /> -->
                      </div>
                    </div>

                   
                    
                    <div class='floating summary'>
                      <div class='selection-summary'>
                      <div class='text normal'>
                      You have selected
                      </div>
                      <!-- <div class='text at-limit'>
                      Maximum selected
                      </div> -->
                      <span class='services-total-count'>0</span>
                      <span class='services-total-items-text'>item(s),</span>
                      <span class='services-total-price'>-</span>
                      </div>
                      <div class='actions'>
                      <!-- <input type="submit" name="commit" value="Book now" /> -->
                      </div>
                    </div>
                     </div> 
                     <div class="col-md-6 col-sm-6 col-sx-6 cf-input-box cf-ib-submit cf-ib-submit1">
                    <input id="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic" name="submit" type="submit" value="Submit">
                    </div> 
                </div>
                 </div> 
                </div>
            </div> 
				  <?php }else if(isset($step) and $step==2){  ?>         
            <input type="hidden" name="step" value="3"> 
            <div class="widget-banner-box">
              <div class="row">
                <div class="col-sm-1">
                  <button type="submit" name="step1" value="Submit" class="form-control" style="border:none !important;display: inline-block;"><i class="fa fa-chevron-left fa-3x" aria-hidden="true" ></i></button>
                   
                </div>
                <div class="col-sm-10"><div class="widget-banner-box"> 
                    <strong><?php echo $_SESSION['busines']['name']?></strong><br/> <b><small>(Online Booking) </small></b>
                </div></div>
                <div class="col-sm-1"> </div>
              </div>
            </div> 
            <div class="blog-sidebar" style="width: 100%;"> 
              <div class="outer-box">
                <!-- <input placeholder="STAFF MEMBERS" type="text"> -->
                <h2 style="padding: 20px;">STAFF MEMBERS</h2> 
                <!-- <button><i class="fa fa-search"></i></button> -->
              </div>

              <div class="container outer-box group-step2">
               <input id="test1" type="hidden" name="staff_id" value=""> 
                  <?php foreach($staff_list as $value){?>
                  <button name="submit" type="submit" value="Submit" class="button staff-member-group-submit" rel="<?php echo $value['id']; ?>">
                  <div class="row group-item staff-member-group">
                    <div class="col-sm-11">
                      <div class=''><?php echo $value['first_name']; ?> <?php echo $value['last_name']; ?></div>
                    </div>
                    <div class="col-sm-1">
                      <div class='group-item-chevron-right' ><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                    </div>
                  </div>
                  </button> 
                  <?php } ?> 
              </div> 
          <?php }else if(isset($step) and $step==3 ){  ?>	 
            <div class="widget-banner-box">
              <div class="row">
                <div class="col-sm-1">
                  <button type="submit" name="step2" type="submit" value="Submit" class="form-control" style="border:none !important;display: inline-block;"><i class="fa fa-chevron-left fa-3x" aria-hidden="true" ></i></button>
                </div>
                <div class="col-sm-10"><div class="widget-banner-box"> 
                    <strong><?php echo $_SESSION['busines']['name']?></strong><br/> <b><small>(Online Booking) </small></b>
                </div></div>
                <div class="col-sm-1"> </div>
              </div>
            </div> 
            <input type="hidden" name="step" value="4">  
            <div class=" group-step3 container outer-box">
              
              <!-- <form autocomplete="off" method="post"  action="<?php echo base_url('sign_up'); ?>" enctype="multipart/form-data"> -->
                      
                <input type="hidden" name="action" value="save">   

                <div class="row">
                  <div class="col-sm-7" >
                    CLIENT DETAILS
                    <hr>
                    <div class="row form-group">
                      <div class="col-sm-12">
                        <label class="form-control-label" for="inputGrid1">First Name*</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php if(isset($first_name)){ echo $first_name; }?>">
                      </div>
                      <div class="admin_content_error"><?php echo form_error('first_name'); ?></div>
                    </div>
                      <div class="row form-group">
                      <div class="col-sm-12">
                        <label class="form-control-label" for="inputGrid2">Last Name*</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if(isset($last_name)){ echo $last_name; }?>">
                      </div>
                      <div class="admin_content_error"><?php echo form_error('last_name'); ?></div>
                    </div>

                    <div class="row form-group">
                      <div class="col-sm-12">
                        <label class="form-control-label" for="inputGrid1">Email*</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($email)){ echo $email; }?>">
                      </div>
                      <div class="admin_content_error"><?php echo form_error('email'); ?></div>
                    </div>

                    <div class="row form-group">
                      <div class="col-sm-12">
                        <label class="form-control-label" for="inputGrid1">MOBILE NUMBER*</label>
                        <!-- <input type="text" class="form-control" id="email" name="email" > -->
                        <div><input type="text" id="demo" class="form-control" value="<?php if(isset($customer_number)){ echo $customer_number; }?>" name="customer_number"></div>
                      </div>
                      <div class="admin_content_error"><?php echo form_error('customer_number'); ?></div>
                    </div>

                    <div class="row form-group">
                      <div class="col-sm-12">
                        <label class="form-control-label" for="inputGrid1">BOOKING NOTES </label>
                        <textarea class="form-control" rows="2" name="staff_notes"></textarea>
                      </div>
                      <div class="admin_content_error"><?php echo form_error('staff_notes'); ?></div>
                    </div>

                    <div class="row form-group">
                      <div class="col-sm-12">
                        <div class="col-md-12 cf-input-box " >
                          <input id="submit11" class="btn-contact111 btn btn-success waves-effect waves-classic waves-effect waves-classic" name="submit" type="submit" value="Confirm" style="float: left;">
                        </div>
                      </div>
                    </div> 
                  </div>
                  <div class="col-sm-5" >
                    YOUR BOOKING
                    <hr>
                    <div class="row form-group">
                      <div class="col-sm-12">
                      <div class="table-responsive">
                      <table class="table">
                        <thead>
                           <tr> 
                            <th>Service</th>
                            <th>Time(Duration)</th>
                            <th>Staff </th>
                            <th>Price</th>
                          </tr>
                        </thead>
                        <tbody> 


                         <?php foreach($_SESSION['booking']['service_timing_listing'] as $key=>$val) { 
                          if (isset($val['id'])&& $val['id']>0) {
                            
                         
                          ?> 
                         <tr>
                         
                         <td><?php echo getServiceNameByTiming($val['id']).' - '.getCaptionName($val['id']);?></td>
                         <td>(<?php echo $val['duration']; ?>)</td>

                         <!--  <div><label class="form-control-label" for="inputGrid2"><?php echo $val['caption']; ?> (<?php echo $val['duration']; ?>)</label></div> -->
                        <?php 
                        

                         if(isset($_SESSION['booking']['staff_list_id']) && count((array)$_SESSION['booking']['staff_list_id']) != 0){ ?> 

                        <?php foreach($_SESSION['booking']['staff_list_id'] as $key=>$val1) {  ?>
                           <!-- <div><label id="staff_name" class="form-control-label" for="inputGrid2" rel="<?php echo $val1['id']; ?>">with <?php echo $val1['first_name']; ?> <?php echo $val1['last_name']; ?></label></div> -->
                           <td>with <?php echo $val1['first_name']; ?> <?php echo $val1['last_name']; ?></td>
                            <?php } ?>
                         <?php }else{?>
                            <!-- <div><label class="form-control-label" for="inputGrid2">with No Preference</label></div> -->
                             <td>with No Preference</td> 
                         
                         <?php } ?>  
                          <?php if ($val['special_price']>0) {
                               ?><td>$<?php echo $val['special_price']; ?></td>
                            <?php }
                             else{
                              ?><td>$<?php echo $val['retail_price']; ?></td>

                           <?php } ?>
                         </tr>


                        <?php  } } ?> 




                          <?php foreach($_SESSION['booking']['group_packages_listing'] as $key=>$val) { 
                          ?> 
                         <tr>
                         
                         <td><?php echo $val['package_name'] ?></td>
                         <td><?= get_total_group_duration($val['id']);?>

                         
                          </td>
                       <!--   <td>(<?php echo $val['duration']; ?>)</td> -->

                      
                        <?php 
                        

                         if(isset($_SESSION['booking']['staff_list_id']) && count((array)$_SESSION['booking']['staff_list_id']) != 0){ ?> 

                        <?php foreach($_SESSION['booking']['staff_list_id'] as $key=>$val1) {  ?>
                           <!-- <div><label id="staff_name" class="form-control-label" for="inputGrid2" rel="<?php echo $val1['id']; ?>">with <?php echo $val1['first_name']; ?> <?php echo $val1['last_name']; ?></label></div> -->
                           <td>with <?php echo $val1['first_name']; ?> <?php echo $val1['last_name']; ?></td>
                            <?php } ?>
                         <?php }else{?>
                            <!-- <div><label class="form-control-label" for="inputGrid2">with No Preference</label></div> -->
                             <td>with No Preference</td> 
                         
                         <?php } ?>  
							
                         <td><?php echo isset($val['discounted_price'])?$val['discounted_price']:$val['cost_price'] ?></td>
                       
                         </tr>
                        <?php  } ?> 



                        </tbody>
                         </table>
                      </div>
                      </div>
                    </div>   

                   <!--  <div class="row form-group">
                      <div class="col-sm-12">
                          <div><label class="form-control-label" for="inputGrid2">Haircut (1h 30min)</label></div>
                          <div><label class="form-control-label" for="inputGrid2">with Wendy Smith</label></div>
                        </div>
                    </div> -->



                    <!-- <div class="row form-group">
                      <div class="col-sm-12">
                        <label class="form-control-label" for="inputGrid2">Date</label>
                        <input type="text" class="form-control datep" id="date_staff" name="date" value="<?php if(isset($date)){ echo $date; }?>">
                      </div>
                    </div> -->
                     
                      <!-- <div class="col-sm-12">
                        <label class="form-control-label" for="inputGrid2">Time</label>
                        <input type="text" class="form-control" id="time" name="time" value="<?php if(isset($time)){ echo $time; }?>">
                      </div> -->
                     <!--  <div class="row form-group">
                      <div class="col-sm-12">
                      <label class="form-control-label" for="inputGrid2">Time</label>
                      <select class="form-control" required="required" name="time">
                        <?php
                        foreach ($get_hours_range_fifteen as $key => $value): ?>
                        <option <?= ($key=="09:00:00")?"selected":""; ?> value="<?=$key?>"><?= $value; ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    </div> -->
                    <div class="row form-group">
                      <div class="col-sm-12">
                          <div><label class="form-control-label" for="inputGrid2">At:<strong><?php  echo getBusinessNameById($_SESSION['booking']['business_id']); ?></strong></label></div>
                        <!-- <div><label class="form-control-label" for="inputGrid2">Total price</label></div> -->
                        <!-- <div><label class="form-control-label" for="inputGrid2">$ 75</label></div> -->
                          <div><label class="form-control-label" for="inputGrid2">
                             <?php $sum = 0; foreach($_SESSION['booking']['service_listing'] as $key=>$val2) {
                              if ($val2['special_price']){  
                                  $sum+= $val2['special_price'];
                               }else{
                                 $sum+= $val2['retail_price'];
                               } 
                             } ?>

                         Total price :<strong> $<?php echo $sum; ?></strong>
                           
                         </label></div>
                         <input type="hidden" name="appointment_total_amount" value="<?php echo $sum ?>">
                        
                      </div>
                    </div>

                  </div>
                </div>

              <!-- </form> -->

                
            </div>
					
			        <?php }  ?>	
            </div>
				 
          </div>
        </div>
    
	 </form>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>  
<script src="<?php echo base_url('assets/selectbox_isd_code/build/js/intlTelInput.js');?>"></script> 
<script src="<?php echo base_url('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js');?>"></script>




    <script>
      $(document).ready(function(){
        $('.datep').datepicker({
            todayHighlight:true
          });
		  
	});
    </script>


<!-- step 1 -->



<script type="text/javascript">
$(".regular").show();
$(".cf-ib-submit1").hide();
var i =  <?php echo $count_item; ?>;

var total = <?php echo $sum_item; ?>;

if(i>0){
$(".cf-ib-submit1").show();
}

$('.checkbox_check').on('click',function () { 
  var checkVaL = $(this).attr('rel'); 
  

					 
	var myClass = $(this).attr("class");
	var check_all = myClass.split(" ").pop();
	if(check_all){
		if ($(this).prop("checked") == true ) {
			$("."+check_all).prop('checked', true);	
       i++;
			$("."+check_all).each(function() {
				checkVaL = $(this).attr('rel');
				if(checkVaL!=""){
				 
				  total = parseFloat(total) + parseFloat(checkVaL);
				} 
				//mvar += $(this).html();
			});
				      
		}else{
			$("."+check_all).prop('checked', false);
      i--;
			$("."+check_all).each(function() {
				checkVaL = $(this).attr('rel');
				
				total = parseFloat(total) - parseFloat(checkVaL);
				//mvar += $(this).html();
			});
			
		}
		
		
	}else{
		if ($(this).prop("checked") == true ) {
			if(checkVaL!=""){
			  i++;
			  total = parseFloat(total) + parseFloat(checkVaL);
			}       
		  }else{
			 i--;
			  total = parseFloat(total) - parseFloat(checkVaL);
		  }
		
		
	}
		


  
  
  if(i>0){
    $(".regular").hide();
    $(".floating").show();
    $(".cf-ib-submit1").show();
    //$(".regular .services-total-count").text(i);
   // $(".regular .services-total-price").text(total;);

    $(".floating .services-total-count").text(i);
    $(".floating .services-total-price").text(total);

  }else{
    $(".regular").show();
    $(".regular .services-total-count").text(0);
    $(".regular .services-total-price").text('');
    $(".floating").hide();
    $(".cf-ib-submit1").hide();
  }

});





</script>



<!-- step 1 -->

<!-- step 3 -->


<script>

$("#demo").intlTelInput();

</script>


<script>
  
// Get the extension part of the current number
var extension = $("#demo").intlTelInput("getExtension");

// Get the current number in the given format
var intlNumber = $("#demo").intlTelInput("getNumber");

// Get the type (fixed-line/mobile/toll-free etc) of the current number. 
var numberType = $("#demo").intlTelInput("getNumberType");

// Get the country data for the currently selected flag.
var countryData = $("#demo").intlTelInput("getSelectedCountryData");

// Get more information about a validation error. 
// var error = $("#demo").intlTelInput("get<a href="https://www.jqueryscript.net/tags.php?/Validation/">Validation</a>Error");

// Vali<a href="https://www.jqueryscript.net/time-clock/">date</a> the current number
var isValid = $("#demo").intlTelInput("isValidNumber");

// Load the utils.js script (included in the lib directory) to enable formatting/validation etc.
$("#demo").intlTelInput("loadUtils", "<?php echo base_url('assets/selectbox_isd_code/build/js/utils.js');?>");

// Change the country selection
$("#demo").intlTelInput("selectCountry", "AU");

// Insert a number, and update the selected flag accordingly.
$("#demo").intlTelInput("setNumber", "+61 ");


    $(".staff-member-group-submit").click(function(){
      var id = $(this).attr('rel');
     // alert(id);
        $("#test1").val(id);
    });
   

</script>


<script type="text/javascript">

  if(window.location.host=='192.168.31.148'){
     var site_url = window.location.protocol + '//' + window.location.host + '/codeigniter/demo/';
       var base_url = window.location.protocol + '//' + window.location.host + '/codeigniter/demo/';
      }else{
       var base_url = window.location.protocol + '//' + window.location.host + '/';
      var site_url = window.location.protocol + '//' + window.location.host + '/';
     }
 jQuery(document).ready(function($) {
           $("#date_staff").datepicker({ minDate: new Date()});
           ('#date_staff').datepicker('setDate', new Date());
        });



 var date = new Date();
     date.setDate(date.getDate());
    $('.datepickstart').datepicker({
     autoclose: true,
     todayHighlight: true,
     format: 'dd-mm-yyyy',
      startDate: date
    });
    /*$('.datepickstart').datepicker().on('changeDate', function() {
      var temp = $(this).datepicker('getDate');
      var d = new Date(temp);
      d.setDate(d.getDate() + 1);
      $('.datepickend').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy',
     startDate: d
    }).on('changeDate', function() {
      var temp1 = $(this).datepicker('getDate');
      var d1 = new Date(temp1);
       d1.setDate(d1.getDate() + 1);
      $('.datepickthird').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy',
     startDate: d1
    });
    });
    });*/
    

</script>

<script type="text/javascript"> 
    $(document).ready(function() {  
	$('#date_staff').datepicker()
    .on("input change", function (e) { 
      var date_staff = e.target.value;  
            $.ajax({
                url: site_url +'verify_bookingtime',
                type: 'POST',
                data:{
                  date_staff:date_staff,
                },
               dataType: 'json',
                beforeSend: function() {
                },
                success: function(data) {  
             // alert(data);
                 if (data.status=='success') { 
                     $('#time').html(data.staff_html);
                   }

                }
            });
    });
});
</script> 
<?php
if (isset($step) and $step==1) { ?>

  <script type="text/javascript"> 
    $(document).ready(function() {    
  //  $('#date_staff').blur(function() {  
      var date_staff = $("#date_staff").val();    
            $.ajax({
                url: site_url +'verify_bookingtime',
                type: 'POST',
                data:{
                  date_staff:date_staff,
                },
                dataType: 'json',
                beforeSend: function() {
                },
                success: function(data) { 
              // alert(data);
                 if (data.status=='success') { 
                     $('#time').html(data.staff_html);
                   }

                }
            });
				
			
			
   // });
});
</script>
<?php } ?>
 

 