<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:27:"./template/index\index.html";i:1528682488;s:29:"./template/public\header.html";i:1528771227;}*/ ?>
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



    <div class="indexbox">
        <div class="indexbox_bg"></div>
        <ul class="indexbox_ul">
            <li class="indexbox_ul_li on1">
                <a class="indexbox_ul_li_a" href="/home<?php echo $navigation[0]['url']; ?>"><?php echo $navigation[0]['name']; ?></a>
            </li>
            <li class="indexbox_ul_li on2">
                <a class="indexbox_ul_li_a" href="/home<?php echo $navigation[1]['url']; ?>"><?php echo $navigation[1]['name']; ?></a>
            </li>
            <li class="indexbox_ul_li on3">
                <a class="indexbox_ul_li_a" href="/home<?php echo $navigation[2]['url']; ?>"><?php echo $navigation[2]['name']; ?></a>
            </li>
        </ul>
    </div>




</body>
</html>
