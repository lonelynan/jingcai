<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:58:"./template/mobile/guessing_competition_champion\index.html";i:1530496218;s:36:"./template/mobile/public\header.html";i:1528704533;s:38:"./template/mobile/public\wx_share.html";i:1528706496;}*/ ?>
<!DOCTYPE html>
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

<!--<div class="logo-wrap-bg">-->
    <!--<a class="login-logo-wrap" href="#">-->
        <!--&lt;!&ndash;<img src="__STATIC__//template/mobile/static/images/logo-login.png" alt="LOGO"/>&ndash;&gt;-->
    <!--</a>-->
<!--</div>-->

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
            <img src="/template/mobile/static/images/cgj_01.png" alt="">
        </div>
        <h2 class="jcbox_content_h2">猜世界杯冠军<br>赢爱车一夏清凉</h2>
        <div class="cgj_box">
            <ul class="cgj_box_ul">
                <?php if(is_array($activity_settings_champion) || $activity_settings_champion instanceof \think\Collection || $activity_settings_champion instanceof \think\Paginator): $i = 0; $__LIST__ = $activity_settings_champion;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="cgj_box_ul_li">
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
            <div class="ewmbox">
                <img  src="/public/images/ewm.jpg">
                <p >威路高端艺术车毯<br>
                    扫描二维码，了解更多详情</p>
                <div class="clear"></div>
            </div>
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
                    showErrorMsg(data.msg);
                    //window.location.reload();
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


    $(".cgj_box_ul_li_ul_li").click(function () {
        $(this).children(".cgj_box_ul_li_ul_li_h2").addClass("on").parents().siblings().children(".cgj_box_ul_li_ul_li_h2").removeClass("on");
        $(this).parents().parents().siblings().children(".cgj_box_ul_li_ul").children().siblings().children(".cgj_box_ul_li_ul_li_h2").removeClass("on");
    })
</script>
