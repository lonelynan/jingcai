<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:51:"./template/guessing_competition_champion\index.html";i:1530496074;s:29:"./template/public\header.html";i:1528771227;}*/ ?>
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
                    <a href="/home<?php echo $navigation[1]['url']; ?>#2"><img src="/public/images/title00.png"></a>
                </li>
                <li class="jcbox_content_ul_li1">
                    <a href="/home<?php echo $navigation[2]['url']; ?>#2"><img src="/public/images/title2.png"></a>
                </li>
            </ul>
            <div class="jcbox_content_box fr">
                <h2 class="jcbox_content_h2">猜世界杯冠军<br>赢爱车一夏清凉</h2>
                <div class="cgj_box">
                    <ul class="cgj_box_ul">
                        <?php if(is_array($activity_settings_champion) || $activity_settings_champion instanceof \think\Collection || $activity_settings_champion instanceof \think\Paginator): $i = 0; $__LIST__ = $activity_settings_champion;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <li class="cgj_box_ul_li fl">
                            <div class="cgj_box_ul_li_div"><?php echo $vo['title']; ?></div>
                            <ul class="cgj_box_ul_li_ul">
							<?php if($vo['status1'] == '1'): ?>
                                <li class="cgj_box_ul_li_ul_li fl" onclick="resetCs('<?php echo $vo['name1']; ?>',<?php echo $vo['activity_team1_id']; ?>);">
                                    <div class="cgj_box_ul_li_ul_li_div">
                                        <img src="<?php echo $vo['activity_team_image1']; ?>" alt="">
                                    </div>
                                    <h2  class="cgj_box_ul_li_ul_li_h2"><?php echo $vo['name1']; ?></h2>
                                </li>
								<?php endif; if($vo['status2'] == '1'): ?>
                                <li class="cgj_box_ul_li_ul_li fl" onclick="resetCs('<?php echo $vo['name2']; ?>',<?php echo $vo['activity_team2_id']; ?>);">
                                    <div class="cgj_box_ul_li_ul_li_div">
                                        <img src="<?php echo $vo['activity_team_image2']; ?>" alt="">
                                    </div>
                                    <h2 class="cgj_box_ul_li_ul_li_h2 "><?php echo $vo['name2']; ?></h2>
                                </li>
								<?php endif; if($vo['status3'] == '1'): ?>
                                <li class="cgj_box_ul_li_ul_li fl" onclick="resetCs('<?php echo $vo['name3']; ?>',<?php echo $vo['activity_team3_id']; ?>);">
                                    <div class="cgj_box_ul_li_ul_li_div">
                                        <img src="<?php echo $vo['activity_team_image3']; ?>" alt="">
                                    </div>
                                    <h2 class="cgj_box_ul_li_ul_li_h2"><?php echo $vo['name3']; ?></h2>
                                </li>
								<?php endif; if($vo['status4'] == '1'): ?>
                                <li class="cgj_box_ul_li_ul_li fl" onclick="resetCs('<?php echo $vo['name4']; ?>',<?php echo $vo['activity_team4_id']; ?>);">
                                    <div class="cgj_box_ul_li_ul_li_div">
                                        <img src="<?php echo $vo['activity_team_image4']; ?>" alt="">
                                    </div>
                                    <h2 class="cgj_box_ul_li_ul_li_h2"><?php echo $vo['name4']; ?></h2>
                                </li>
								<?php endif; ?>
                                <div class="clear"></div>
                            </ul>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>


                    </ul>
                    <div class="cgj_box_xuanzhong">
                        <div class="cgj_box_xuanzhong_div">
                            已选中<span class="cgj_box_xuanzhong_span"></span>
                        </div>
                        <input class="cgj_box_xuanzhong_tijiao" type="submit" onclick="submitverify();" value="确认选择">
                    </div>
                </div>
                <div class="jcbox_content_jies">
                    <h2>竞猜冠军活动简介：</h2>
                    <p>1、车主可在活动规定时间段内参加猜冠军有奖活动，选择您心目中的冠军候选，在7月15日世界杯赛程结束后统一抽取各个阶段获奖人；</p>
                    <p>2、具体活动时间段及奖项说明：<br>在所有6月9日-6月20日猜中的玩家中抽取1位免费获赠全车顶配一套  （VK70+X15），价值约10000元，限五座车使用；<br>在所有6月21日-6月30日猜中的玩家中抽取2位免费获赠顶配前挡一个（VK70），价值约3280元；<br>在所有7月1日-7月6日猜中的玩家中抽取3位免费获赠威路VeRoad祈福/探索系列高端艺术车毯一套，价值约2280元；</p>
                    <p>3、中奖者会自动获得后台发放的优惠券，同时威固中国总部将主动联系用户，指导兑换事宜。</p>
                    <div style="width: 310px;margin: 0 auto">
                        <img style="width:120px;margin: 10px auto;float: left" src="/public/images/ewm.jpg">
                        <p style="text-align: left;float: right;margin-top: 40px;">威路高端艺术车毯<br>
                            扫描二维码，了解更多详情</p>
                    </div>

                </div>
            </div>
            <div class="clear"></div>
        </div>

    </div>
</div>
<input type="hidden" name="activity_team_id" id="activity_team_id" >
<input type="hidden"  id="is_name" value=<?php echo $is_name; ?>>

<script type="text/javascript">
if($('#is_name').val())
    showErrorMsg($('#is_name').val());



    function resetCs(name,activity_team_id) {
        $('.cgj_box_xuanzhong_span').html(name);
        $('#activity_team_id').val(activity_team_id);
    }

    function submitverify()
    {

        var data = {activity_team_id:$('#activity_team_id').val()};
        $.ajax({
            type : 'post',
            url : '/mobile/GuessingCompetitionChampion/activityCompResultChampion',
            data : data,
            dataType : 'json',
            success : function(data){
                if(data.status == 1){
                    alert(data.msg);
                   // window.location.reload();
                    // window.location.href = data.url;

                }else{
                    showErrorMsg(data.msg,3000);
                   // alert(data.msg);

                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert('网络异常，请稍后重试');
            }
        })
    }


    $(".cgj_box_ul_li_ul_li").click(function () {
        $(this).children(".cgj_box_ul_li_ul_li_h2").addClass("on").parents().siblings().children(".cgj_box_ul_li_ul_li_h2").removeClass("on");
        $(this).parents().parents().siblings().children(".cgj_box_ul_li_ul").children().siblings().children(".cgj_box_ul_li_ul_li_h2").removeClass("on");
    })
    function showErrorMsg(msg,time){
        layer.open({content:msg,time:time});
    }
</script>
