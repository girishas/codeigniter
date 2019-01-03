<html><head><META http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <META http-equiv="X-UA-Compatible" content="IE=8">
        <TITLE></TITLE>
        <META name="generator" content="BCL easyConverter SDK 5.0.140">
        <STYLE type="text/css">
        body {margin-top: 0px;margin-left: 0px;}
        #page_1 {
        position:relative; overflow: hidden;margin: 11px 0px 17px 14px;padding: 0px;border: none;width: 780px;height: 388px;
            background: url("<?=base_url('global/images/3.png')?>");
            background-size: cover;
            background-position: inherit;
            left: 0;
        }
        #page_1 #p1dimg1 {position:absolute;top:0px;left:0px;z-index:-1;width:768px;height:346px;}
        #page_1 #p1dimg1 #p1img1 {width:768px;height:346px;}
        .content-outer{margin-left: 100px;}
        .title{
            margin-top: 40px;
            color: darkgoldenrod;
            font-weight: 500;
            font-family: serif;
            margin-bottom: 50px;
            font-size: 33px;
        }
        .b-content{
            color: darkgoldenrod    ;
        }
        .turms-data{margin-left: 100px; }
        </STYLE></head><body><div id="page_1">
           <!--  <div id="p1dimg1">
                <img src="<?=base_url('global/images/2.png')?>" style="max-height: 100%;">
            </div> -->
            <div class="content-outer">
                <div class="title-header">
                    <h2 class="title"><?php echo getBusinessNameById($admin_session['business_id']); ?></h2>
                </div>
                <div class="b-content">
                    <p>G I F T V O U C H E R</p>
                </div>
                <div style="font-size: 15px;">
                    <p><span>To : </span><?=$postDatas['voucher_to_name'];?></p>
                    <p><span>From : </span><?=$postDatas['voucher_from_name'];?></p>
                    <p><span>Value : </span>$<?=$postDatas['unit_price']?> &nbsp;Code : <?=$postDatas['voucher_code']?></p>
                    <p><span>valid : <?=date("D, d M Y",strtotime($postDatas['expiry_date']));?></span></p>
                </div>
            </div>
        </div>
        <div class="turms-data">
            <h2>Terms and Conditions</h2>
            <ul>
                <?php foreach ($terms as $key => $value) {
                    echo "<li>".$value['detail']."</li>";
                } ?>
            </ul>
        </div></body></html>