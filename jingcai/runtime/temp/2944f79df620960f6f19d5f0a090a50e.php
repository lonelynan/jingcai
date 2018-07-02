<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:43:"./template/guessing_competition\index2.html";i:1528682411;s:29:"./template/public\header.html";i:1528771227;}*/ ?>
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
                <img class="jc01_img" src="/public/images/jc1_01.png">
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