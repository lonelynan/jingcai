<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:33:"./template/mobile/user\regjc.html";i:1528704067;s:37:"./template/mobile/public\header1.html";i:1528705842;s:38:"./template/mobile/public\wx_share.html";i:1528706496;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>威固中国竞猜平台</title>

    <link rel="stylesheet" href="__STATIC__/css/style.css">
    <link rel="stylesheet" href="__STATIC__/css/reset.css">
    <link rel="stylesheet" href="__STATIC__/css/index.css">

    <link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <!--<script src="__STATIC__/js/zepto-1.2.0-min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="__STATIC__/js/js.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer.js"  type="text/javascript" ></script>
    <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
</head>

<body class="body">
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

<div class="indexbox">
	<div class="indexbox_bg"></div>
	<div class="loginsingup-input" >

		<div class="reset-pwd-title">手机号码快捷登录</div>
		<div class="lsu">
			<span class="ico ico-telephone"></span>
			<input type="text" name="mobile" id="tel" value="<?php echo $user['mobile']; ?>" placeholder="请输入您的手机号" />
		</div>
		<div class="lsu">
			<span class="ico ico-v-code"></span>
			<input class="v-code-input" type="text" id="mobile_code" value="" name="mobile_code" placeholder="请输入验证码" >
			<a class="btn-text-message" rel="mobile" onClick="sendcode(this)">获取验证码</a>
		</div>



		<div class="lsu-submit">
			<input type="submit" name="" id="" value="确认登录" onclick="regjc()"/>
		</div>

	</div>
	<ul class="indexbox_ul">
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

</div>




<script>

    function regjc(){
       // submitverify();
        if(checkMobile($('#tel').val())) {

            $.ajax({
                type: "POST",
                dataType:'json',
                url: "<?php echo url('Mobile/User/regjc'); ?>",//+tab,
                data: {mobile: $('#tel').val(),mobile_code:$('#mobile_code').val()},// 你的formid 搜索表单 序列化提交
                success: function (res) {

                    if (res.status == 1) {
                        window.location.href="/mobile";
                    } else {
                        $('#fcode').attr('id','fetchcode');
                        showErrorMsg(res.msg);
                        return false;
                    }
                }
            });
        }else{
            showErrorMsg('手机号码格式不正确！');
            return false;
        }
    }


    //手机验证
    function checkMobilePhone(mobile){
        if(mobile == ''){
            showErrorMsg('请输入您的手机号');
            return false;
        }else  if(checkMobile(mobile)) {

            $.ajax({
                type: "GET",
                url: "/Home/Api/issetMobile",//+tab,
                data: {mobile: mobile},// 你的formid 搜索表单 序列化提交
                success: function (data) {
                    if (data == '0') {
                        return true;
                    } else {
                        $('#fcode').attr('id','fetchcode');
                        showErrorMsg('手机号已存在！');
                        return false;
                    }
                }
            });
        }else{
            showErrorMsg('手机号码格式不正确！');
            return false;
        }
    }


    //发送短信验证码
    function sendcode(obj){
        var tel = $.trim($('#tel').val());

        var obj = $(obj);
        if(tel == ''){
            showErrorMsg('请输入您的号码！');
            return false;
        }
        var s = <?php echo $sms_time_out; ?>;

        //改变按钮状态
        obj.unbind('click');
        //添加样式
        obj.attr('id','fetchcode');
        callback();
        //循环定时器
        var T = window.setInterval(callback,1000);
        function callback()
        {
            if(s <= 0){
                //移除定时器
                window.clearInterval(T);
                obj.bind('click',sendcode)
                obj.removeAttr('id','fetchcode');
                obj.text('获取验证码');
            }else{
                obj.text(--s + '秒后再获取');
            }
        }
        $.ajax({
            url : "/Home/Api/send_validate_code/scene/1/type/mobile/send/"+tel,
            type:'post',
            dataType:'json',
            data:{type:obj.attr('rel'),send:tel},
            success:function(res){
                if(res.status==1){
                    //成功
                    showErrorMsg(res.msg);
                }else{
                    //失败
                    showErrorMsg(res.msg);
                    //移除定时器
                    window.clearInterval(T);
                    obj.removeAttr('id','fetchcode');
                    obj.text('获取验证码');
                }
            }
        })
    }

    //提交前验证表单
    function submitverify(obj){
        var tel = $.trim($('#tel').val());
        if(tel == ''){
            showErrorMsg('请输入您的手机号！');
            return false;
        }
        if($('#mobile_code').val() == ''){
            showErrorMsg('验证码不能空！');
            return false;
        }
        $(obj).onsubmit();
    }
</script>
</body>
</html>
