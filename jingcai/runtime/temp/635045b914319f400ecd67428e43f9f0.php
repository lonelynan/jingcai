<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:29:"./template/qttopic\index.html";i:1528977353;s:44:"./template/mobile\public\wx_share_topic.html";i:1528977580;}*/ ?>
﻿<script src="__PUBLIC__/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
<script type="text/javascript">


	var ShareLink = "http://jingcai.v-koolchina.com.cn/home/qttopic"; //默认分享链接
	var ShareImgUrl = "http://jingcai.v-koolchina.com.cn/template/mobile/static/images/vkool_ico.png"; //分享图标
	var ShareTitle = "威固2018世界杯活动"; //分享标题
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>威固世界杯活动</title>
	<meta name="sharecontent" data-msg-img="" data-msg-title="威固世界杯活动" data-msg-content="“膜”力世界杯，足“购”大盛会" data-msg-callBack="" data-line-img="" data-line-title="威固世界杯活动" data-line-callBack=""/>
    <link rel="stylesheet" href="/template/qttopic/reset.css">
    <link rel="stylesheet" href="/template/qttopic/zty.css">

</head>
<body>

<div class="dztbanner">
    <img src="/template/qttopic/images/ztbanner.jpg">
</div>
<div class="dztbox">
    <ul class="dztbox_ul">
        <li class="dztbox_ul_li fl on">
            <a href="http://jingcai.v-koolchina.com.cn" target="_blank">
                <div class="dztbox_ul_li_img">
                    <img src="/template/qttopic/images/zt_01.png">
                </div>
                <div class="dztbox_ul_li_text on1">
                    <img src="/template/qttopic/images/zt_02.png">
                </div>
            </a>
        </li>
        <li class="dztbox_ul_li fr">
            <a href="http://wechat.v-koolchina.com.cn/submit/index.html" target="_blank">
                <div class="dztbox_ul_li_img">
                    <img src="/template/qttopic/images/zt_01.png">
                </div>
                <div class="dztbox_ul_li_text on2">
                    <img src="/template/qttopic/images/zt_03.png">
                </div>
            </a>
        </li>
    </ul>
    <div class="dztbox_div">
        <div class="dztbox_div_title">
            <img src="/template/qttopic/images/zt_06.png">
        </div>
        <div class="dztbox_div_content">
            <ul class="dztbox_div_content_ul">
                <?php if(is_array($zhuanti) || $zhuanti instanceof \think\Collection || $zhuanti instanceof \think\Paginator): $i = 0; $__LIST__ = $zhuanti;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

				<h2 class="dztbox_div_content_ul_li_h2"><?php echo $key; ?></h2>


                <li class="dztbox_div_content_ul_li">
                    <h2 class="dztbox_div_content_ul_li_h2"><?php echo $k; ?>.<?php echo $vo['1'][0]; ?></h2>
                    <p class="dztbox_div_content_ul_li_p"><?php echo $vo['1'][1]; ?></p>
                     <?php if(!empty($vo['2'])): ?>
					<p class="dztbox_div_content_ul_li_p">电话：<?php echo $vo['1'][2]; ?></p>
					<?php endif; ?>
                    <h3 class="dztbox_div_content_ul_li_h3">★★★★★</h3>
                </li>

			<?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="dztbox_div_content_img">
                <img src="/template/qttopic/images/zt_07.png">
            </div>
        </div>
    </div>
</div>