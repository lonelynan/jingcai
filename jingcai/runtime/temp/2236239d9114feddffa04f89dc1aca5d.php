<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:29:"./template/coupons\index.html";i:1529547818;s:29:"./template/public\header.html";i:1528771227;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>威固中国竞猜平台</title>
    <!--<link rel="stylesheet" href="__STATIC__/css/style.css">-->
    <link rel="stylesheet" href="__PUBLIC__/css/reset.css">
    <link rel="stylesheet" href="__PUBLIC__/css/index.css">

    <script src="__PUBLIC__/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>-->
    <!--<link href="__PUBLIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
    <script src="__PUBLIC__/js/js.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <!--<link href="__PUBLIC__/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
    <link rel="stylesheet" href="__PUBLIC__/js/layer/skin/layer.css">


</head>
<body class="">


<!--<div class="logo-wrap-bg">-->
    <!--<a class="login-logo-wrap" href="#">-->
        <!--&lt;!&ndash;<img src="__STATIC__//template/mobile/static/images/logo-login.png" alt="LOGO"/>&ndash;&gt;-->
    <!--</a>-->
<!--</div>-->





<div class="jcbox">
    <div class="jcbox_banner">
        <img src="/public/images/nybanner.jpg" alt="竞猜活动">
    </div>
    <div class="jcbox_content">

        <div class="jcbox_contentbox"  id="2">
            <ul class="jcbox_content_ul fl">
                <li class="jcbox_content_ul_li1">
                    <a href="/home<?php echo $navigation[0]['url']; ?>#2"><img src="/public/images/title.png"></a>
                </li>
                <li class="jcbox_content_ul_li1">
                    <a href="/home<?php echo $navigation[1]['url']; ?>#2"><img src="/public/images/title1.png"></a>
                </li>
                <li class="jcbox_content_ul_li1">
                    <a href="/home<?php echo $navigation[2]['url']; ?>#2"><img src="/public/images/title22.png"></a>
                </li>
            </ul>
            <div class="jcbox_content_box fr">
                <div class="kaquanbox">
                    <ul class="kaquanbox_ul">

                        <?php if(is_array($activity_comp_result) || $activity_comp_result instanceof \think\Collection || $activity_comp_result instanceof \think\Paginator): $i = 0; $__LIST__ = $activity_comp_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;switch($vo['cancellation_coupons']): case "0": ?>
                        <li class="kaquanbox_ul_li fl">


                                <?php if($vo['expiration_date_status'] == '0'): ?>
                            <div class="kaquanbox_ul_li_div fl">
                                <div class="kaquanbox_ul_li_div_img fl">
                                    <img src="/template/mobile/static/images/kaquan_05.png">
                                </div>
                                <div class="kaquanbox_ul_li_div_text fl">
                                    <h2 class="kaquanbox_ul_li_div_text_h2"><?php echo $vo['coupon']; ?>元
                                    </h2>

                                    <button class="copy-button" data-clipboard-text="http://jingcai.v-koolchina.com.cn/asccode/c/<?php echo $vo['coupon_code']; ?>" >分享</button>

                                    <div class="clear"></div>

                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="kaquanbox_ul_li_but fl">
                                <h2 class="kaquanbox_ul_li_but_h2" onclick="activityCoupons('<?php echo $vo['coupon_code']; ?>')">
                                    核<br>
                                    销
                                </h2>
                            </div>
                                <?php else: ?>
                            <div class="kaquanbox_ul_li_div fl">
                                <div class="kaquanbox_ul_li_div_img fl">
                                    <img src="/template/mobile/static/images/kaquan_05.png">
                                </div>
                                <div class="kaquanbox_ul_li_div_text fl">
                                    <h2 class="kaquanbox_ul_li_div_text_h2"><?php echo $vo['coupon']; ?>元
                                    </h2>

                                    <button class="copy-button" onclick="alert('此优惠券已过期');" >分享</button>

                                    <div class="clear"></div>

                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="kaquanbox_ul_li_but on fl">
                                <h2 class="kaquanbox_ul_li_but_h2">
                                    已<br>
                                    过<br>
                                    期
                                </h2>
                            </div>
                                <?php endif; ?>


                            <div class="clear"></div>
                        </li>
                        <?php break; case "1": ?>

                        <if condition="($vo.cancellation_coupons eq '1')">
                            <li class="kaquanbox_ul_li fl">
                                <div class="kaquanbox_ul_li_div fl">
                                    <div class="kaquanbox_ul_li_div_img fl">
                                        <img src="/template/mobile/static/images/kaquan_05.png">
                                    </div>
                                    <div class="kaquanbox_ul_li_div_text fl">
                                        <h2 class="kaquanbox_ul_li_div_text_h2">1000元</h2>
                                        <form action="" class="kaquanbox_ul_li_fx">
                                            <input type="text" class="share-input"  value="http://www.youtube.com" id="copy-content"/>
                                            <button class="copy-button on" type="button" > 分享 </button>
                                            <div class="clear"></div>
                                        </form>
                                    </div>
                                    <div class="kaquanbox_ul_li_div_tubiao"></div>
                                    <div class="clear"></div>
                                </div>
                                <div class="kaquanbox_ul_li_but on fl">
                                    <h2 class="kaquanbox_ul_li_but_h2">
                                        已<br>
                                        核<br>
                                        销
                                    </h2>
                                </div>
                                <div class="clear"></div>
                            </li>
                            <?php break; endswitch; endforeach; endif; else: echo "" ;endif; if(is_array($activity_comp_result_champion) || $activity_comp_result_champion instanceof \think\Collection || $activity_comp_result_champion instanceof \think\Paginator): $i = 0; $__LIST__ = $activity_comp_result_champion;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;switch($vo['cancellation_coupons']): case "0": ?>
                            <li class="kaquanbox_ul_li fl">
                                <div class="kaquanbox_ul_li_img fl">
                                    <img src="<?php echo $vo['coupon_img']; ?>">
                                </div>
                                <div class="kaquanbox_ul_li_but fl" onclick="activityCouponsG('<?php echo $vo['coupon_code']; ?>')">
                                    <h2 class="kaquanbox_ul_li_but_h2">
                                        核<br>
                                        销
                                    </h2>
                                </div>
                                <div class="clear"></div>
                            </li>
                            <?php break; case "1": ?>

                            <if condition="($vo.cancellation_coupons eq '1')">
                                <li class="kaquanbox_ul_li fl">
                                    <div class="kaquanbox_ul_li_img fl">
                                        <img src="<?php echo $vo['coupon_img']; ?>">
                                        <div class="kaquanbox_ul_li_div_tubiao"></div>
                                    </div>
                                    <div class="kaquanbox_ul_li_but on fl">
                                        <h2 class="kaquanbox_ul_li_but_h2">
                                            已<br>
                                            核<br>
                                            销
                                        </h2>
                                    </div>
                                    <div class="clear"></div>
                                </li>
                                <?php break; endswitch; endforeach; endif; else: echo "" ;endif; ?>

                    </ul>
                </div>
                <div class="jcbox_content_jies">
                    <h2>卡券使用说明：</h2>
                    <p>1、车主所获优惠券都可分享给朋友，但每张优惠券仅限使用一次。</p>
                    <p>2、车主所获得的的优惠券不能叠加使用，且该优惠券不能与线下门店世界杯活动同时使用。</p>
                    <p>3、车主持所拥有的优惠券至门店消费，需提前展示优惠券给门店，由门店点击核销后才能享受优惠。车主自行点击核销后，优惠券无效。可参加其他活动再次获取优惠券。</p>
                </div>
            </div>
            <div class="clear"></div>
        </div>

    </div>
</div>




<script>
    function activityCoupons(code)
    {

        var data = {code:code};
        $.ajax({
            type : 'post',
            url : '/mobile/Coupons/activityCoupons',
            data : data,
            dataType : 'json',
            success : function(data){
                if(data.status == 1){
                    showErrorMsg(data.msg);
                    window.location.reload();
                    // window.location.href = data.url;

                }else{
                    showErrorMsg(data.msg);
                    if (codeExist) {
                        verify();
                    } else {
                        location.reload();
                    }
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                showErrorMsg('网络异常，请稍后重试');
            }
        })
    }

    function activityCouponsG(code)
    {
        var data = {code:code};
        $.ajax({
            type : 'post',
            url : '/mobile/Coupons/activityCouponsG',
            data : data,
            dataType : 'json',
            success : function(data){
                if(data.status == 1){
                    showErrorMsg(data.msg);
                    window.location.reload();
                    // window.location.href = data.url;

                }else{
                    showErrorMsg(data.msg);
                    if (codeExist) {
                        verify();
                    } else {
                        location.reload();
                    }
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                showErrorMsg('网络异常，请稍后重试');
            }
        })
    }
</script>




<script src="__PUBLIC__/js/clipboard.min.js"></script>


<script>

    var clipboard = new ClipboardJS('.copy-button');





    clipboard.on('success', function(e) {
        $.ajax({
            url:"/home/Coupons/shareCoupons",
            data:{code:e.text},
            type : 'post',
            dataType : 'json',
            success:function(res){

                if(res.status==1){
                    alert("优惠券链接已复制成功，快去粘贴分享吧~");

                }else{
                    alert(res.msg);
                }

            }
        })

    });

    clipboard.on('error', function(e) {

    });

</script>