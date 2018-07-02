<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:42:"./template/guessing_competition\index.html";i:1529468164;s:29:"./template/public\header.html";i:1528771227;}*/ ?>
﻿<!DOCTYPE html>
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


<div class="jcbox">
    <div class="jcbox_banner">
        <img src="/public/images/nybanner.jpg" alt="竞猜活动">
    </div>
    <div class="jcbox_content">
        <div class="jcbox_contentbox"  id="2">
            <ul class="jcbox_content_ul fl">
                <li class="jcbox_content_ul_li1">
                    <a href="/home<?php echo $navigation[0]['url']; ?>#2"><img src="/public/images/title11.png"></a>
                </li>
                <li class="jcbox_content_ul_li1">
                    <a href="/home<?php echo $navigation[1]['url']; ?>#2"><img src="/public/images/title1.png"></a>
                </li>
                <li class="jcbox_content_ul_li1">
                    <a href="/home<?php echo $navigation[2]['url']; ?>#2"><img src="/public/images/title2.png"></a>
                </li>

            </ul>
            <div class="jcbox_content_box fr">
                <h2 class="jcbox_content_h2">猜胜负，赢优惠券</h2>
                <div class="jcbox_content_div">
                    <ul class="jcbox_content_div_ul">
                        <?php if(is_array($activity_settings) || $activity_settings instanceof \think\Collection || $activity_settings instanceof \think\Paginator): $i = 0; $__LIST__ = $activity_settings;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <li class="jcbox_content_div_ul_li fl">
                            <div class="jcbox_content_div_ul_li_box">
                                <div class="jcbox_content_div_ul_li_div fl">
                                    <div class="jcbox_content_div_ul_li_div_img">
                                        <img class="jcbox_content_div_ul_li_div_img_img" src="<?php echo $vo['activity_team_image1']; ?>" alt="">
                                    </div>
                                    <h2 class="jcbox_content_div_ul_li_div_h2"><?php echo $vo['name1']; ?></h2>
                                    <div class="jcbox_content_div_ul_li_div_number">
                                        <p class="jcbox_content_div_ul_li_div_number_p"><?php echo $vo['activity_team1__count']; ?></p>
                                    </div>
                                </div>
                                <div class="jcbox_content_div_ul_li_vs fl">
                                    <h2 class="jcbox_content_div_ul_li_vs_h2">VS</h2>
                                </div>
                                <div class="jcbox_content_div_ul_li_div fl">
                                    <div class="jcbox_content_div_ul_li_div_img">
                                        <img class="jcbox_content_div_ul_li_div_img_img" src="<?php echo $vo['activity_team_image2']; ?>" alt="">
                                    </div>
                                    <h2 class="jcbox_content_div_ul_li_div_h2"><?php echo $vo['name2']; ?></h2>
                                    <div class="jcbox_content_div_ul_li_div_number">
                                        <p class="jcbox_content_div_ul_li_div_number_p"><?php echo $vo['activity_team2__count']; ?></p>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <ul class="jcbox_content_div_ul_li_ul">
                                <li class="jcbox_content_div_ul_li_ul_li" onclick="submitverify(<?php echo $vo['activity_settings_id']; ?>,<?php echo $vo['activity_team1_id']; ?>);">
                                    <a class="jcbox_content_div_ul_li_ul_li_a" >加油助威</a>
                                </li>
                                <li class="jcbox_content_div_ul_li_ul_li on" onclick="submitverify(<?php echo $vo['activity_settings_id']; ?>,<?php echo $vo['activity_team1_id']; ?>+'_'+<?php echo $vo['activity_team2_id']; ?>);">
                                    <a class="jcbox_content_div_ul_li_ul_li_a">打平</a>
                                </li>
                                <li class="jcbox_content_div_ul_li_ul_li" onclick="submitverify(<?php echo $vo['activity_settings_id']; ?>,<?php echo $vo['activity_team2_id']; ?>);">
                                    <a class="jcbox_content_div_ul_li_ul_li_a">加油助威</a>
                                </li>
                            </ul>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div class="jcbox_content_jies">
                    <h2>竞猜胜负活动简介：</h2>
                    <p>1、车主根据活动比赛场次竞猜胜负，比赛结果揭晓后，所有猜中者将获得威固贴膜优惠券500元（仅限贴全车顶配时使用），未猜中者还有机会继续参与下场活动；</p>
                    <p>2、车主连续猜中比赛结果，所获优惠券金额会以100元为基数自动递增：如A和B第一场都猜中，均获500元优惠券的情况下，A猜中第二场，B没猜中，则A在第二场可获得600元优惠券，B在第二场无法获得优惠券；第三场A没猜中，B猜中，则A在第三场无法获得优惠券，B在第三场可获得500元优惠券，以此类推；
</p>
                    <p>3、所有优惠券都可分享给朋友，但每张优惠券仅限使用一次。</p>
                    <p>4、车主所获得的优惠券不能叠加使用，且该优惠券不能与线下门店世界杯活动同时使用。</p>
                    <p>5、关于核销：车主持所拥有的优惠券至门店消费，需提前展示优惠券给门店，由门店点击核销后才能享受优惠。车主自行点击核销后，优惠券无效。可参加其他活动再次获取优惠券。</p>
                </div>
            </div>
            <div class="clear"></div>
        </div>


    </div>
</div>
<!--<div class="loginsingup-input">-->
<!--<div style="height:800px;"></div>-->




<!--</div>-->


<script>
    function submitverify(activity_settings_id,activity_team_id)
    {
        var data = {activity_settings_id:activity_settings_id,activity_team_id:activity_team_id};
        $.ajax({
            type : 'post',
            url : '/mobile/GuessingCompetition/activityCompResult',
            data : data,
            dataType : 'json',
            success : function(data){
                if(data.status == 1){
                    alert(data.msg);
                    window.location.reload();
                       // window.location.href = data.url;

                }else{
                    alert(data.msg);
                    window.location.reload();
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert('网络异常，请稍后重试');
            }
        })
    }

</script>