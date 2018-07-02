<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:49:"./template/mobile/guessing_competition\index.html";i:1529468250;s:36:"./template/mobile/public\header.html";i:1528704533;s:38:"./template/mobile/public\wx_share.html";i:1528706496;}*/ ?>
﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>威固中国竞猜平台</title>
    <!--<link rel="stylesheet" href="__STATIC__/css/style.css">-->
    <link rel="stylesheet" href="__STATIC__/css/reset.css">
    <link rel="stylesheet" href="__STATIC__/css/index.css">

    <!--<link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>-->
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <!--<script src="__STATIC__/js/zepto-1.2.0-min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="__STATIC__/js/js.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer.js"  type="text/javascript" ></script>
    <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>

    wx.config({
            debug: false,
            appId:'<?php echo $signPackage['appId']; ?>',
        timestamp:'<?php echo $signPackage['timestamp']; ?>',
    nonceStr: '<?php echo $signPackage['nonceStr']; ?>',
    signature: '<?php echo $signPackage['signature']; ?>',
        jsApiList:['onMenuShareTimeline', 'onMenuShareAppMessage']
    });
    var data = {
        title: 'title', // 分享标题
        desc: 'desc', // 分享描述
        link:'http://www.kajuan.com/mobile', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: 'imgUrl', // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
        }
    };
    wx.ready(function(){
        wx.onMenuShareTimeline(data);
        wx.onMenuShareAppMessage(data);
        wx.onMenuShareQQ(data);
        wx.onMenuShareWeibo(data);
        wx.onMenuShareQZone(data);
    });
   </script>
<body class="">
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
<script type="text/javascript">


	var ShareLink = "http://jingcai.v-koolchina.com.cn/mobile/"; //默认分享链接
	var ShareImgUrl = "http://jingcai.v-koolchina.com.cn__STATIC__/images/vkool_ico.png"; //分享图标
	var ShareTitle = "威固2018世界杯竞猜活动"; //分享标题
	var ShareDesc = "动动拇指，竞猜世界杯，高达1W礼遇；炎热，轻松踢走！"; //分享描述



$(function() {
	if(isWeiXin()){
		$.ajax({
			type : "POST",
			url:"/Mobile/Index/ajaxGetWxConfig/t/"+Math.random(),
			data:{'askUrl':encodeURIComponent(location.href.split('#')[0])},		
			dataType:'JSON',
			success: function(res)
			{
				//微信配置
				wx.config({
				    debug: false,
				    appId: res.appId,
				    timestamp: res.timestamp, 
				    nonceStr: res.nonceStr, 
				    signature: res.signature,
				    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','hideOptionMenu'] // 功能列表，我们要使用JS-SDK的什么功能
				});
			},
			error:function(){
				return false;
			}
		});

		// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在 页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready 函数中。
		wx.ready(function(){
		    // 获取"分享到朋友圈"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareTimeline({
		        title: ShareTitle, // 分享标题
		        link:ShareLink,
		        desc: ShareDesc,
		        imgUrl:ShareImgUrl // 分享图标
		    });

		    // 获取"分享给朋友"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareAppMessage({
		        title: ShareTitle, // 分享标题
		        desc: ShareDesc, // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
		    });
			// 分享到QQ
			wx.onMenuShareQQ({
		        title: ShareTitle, // 分享标题
		        desc: ShareDesc, // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});	
			// 分享到QQ空间
			wx.onMenuShareQZone({
		        title: ShareTitle, // 分享标题
		        desc: ShareDesc, // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});


		});
	}
});

function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}
</script>
<!--微信关注提醒 start-->
<if condition="$Think.session.subscribe eq 0"></if>
<button class="guide" style="display:none;" onclick="follow_wx()">关注公众号</button>
<style type="text/css">
.guide{width:1rem;height:4rem;text-align: center;border-radius: 0.2rem ;font-size:0.5rem;padding:0.2rem 0;border:1px solid #adadab;color:#000000;background-color: #fff;position: fixed;right: 0.1rem;bottom: 10rem;}
#cover{display:none;position:absolute;left:0;top:0;z-index:18888;background-color:#000000;opacity:0.7;}
#guide{display:none;position:absolute;top:0.1rem;z-index:19999;}
#guide img{width: 70%;height: auto;display: block;margin: 0 auto;margin-top: 0.2rem;}
</style>
<script type="text/javascript">
  //关注微信公众号二维码	 
function follow_wx()
{
	layer.open({
		type : 1,  
		title: '关注公众号',
		content: '<img src="<?php echo $wx_qr; ?>" width="100%">',
		style: ''
	});
}
  
$(function(){
	if(isWeiXin()){
		var subscribe = getCookie('subscribe'); // 是否已经关注了微信公众号		
		if(subscribe == 0)
			$('.guide').show();
	}else{
		$('.guide').hide();
	}
})
 
</script> 

<!--微信关注提醒  end-->

<div class="jcbox">
    <div class="jcbox_banner">
        <img src="/template/mobile/static/images/jc_01.jpg" alt="竞猜活动">
    </div>
    <div class="jcbox_content">
        <ul class="jcbox_content_ul">
            <li class="indexbox_ul_li on1">
                <a class="indexbox_ul_li_a" href="/mobile<?php echo $navigation[0]['url']; ?>"><?php echo $navigation[0]['name']; ?></a>
            </li>
            <li class="indexbox_ul_li on2">
                <a class="indexbox_ul_li_a" href="/mobile<?php echo $navigation[1]['url']; ?>"><?php echo $navigation[1]['name']; ?></a>
            </li>
            <li class="indexbox_ul_li on3">
                <a class="indexbox_ul_li_a" href="/mobile<?php echo $navigation[2]['url']; ?>"><?php echo $navigation[2]['name']; ?></a>
            </li>
        </ul>
        <div class="jcbox_content_xian">
            <img src="/template/mobile/static/images/jc_01.png" alt="">
        </div>
        <h2 class="jcbox_content_h2">猜胜负，赢优惠券</h2>
        <div class="jcbox_content_div">
            <ul class="jcbox_content_div_ul">
                <?php if(is_array($activity_settings) || $activity_settings instanceof \think\Collection || $activity_settings instanceof \think\Paginator): $i = 0; $__LIST__ = $activity_settings;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="jcbox_content_div_ul_li">
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
            <p>2、车主连续猜中比赛结果，所获优惠券金额会以100元为基数自动递增：如A和B第一场都猜中，均获500元优惠券的情况下，A猜中第二场，B没猜中，则A在第二场可获得600元优惠券，B在第二场无法获得优惠券；第三场A没猜中，B猜中，则A在第三场无法获得优惠券，B在第三场可获得500元优惠券，以此类推；</p>
            <p>3、所有优惠券都可分享给朋友，但每张优惠券仅限使用一次。</p>
            <p>4、车主所获得的优惠券不能叠加使用，且该优惠券不能与线下门店世界杯活动同时使用。</p>
            <p>5、关于核销：车主持所拥有的优惠券至门店消费，需提前展示优惠券给门店，由门店点击核销后才能享受优惠。车主自行点击核销后，优惠券无效。可参加其他活动再次获取优惠券。</p>
        </div>
    </div>
</div>
<div class="loginsingup-input">





</div>


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