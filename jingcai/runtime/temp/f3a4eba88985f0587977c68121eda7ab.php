<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:34:"./template/mobile/user\mobile.html";i:1528097081;s:36:"./template/mobile/public\header.html";i:1528444143;s:40:"./template/mobile/public\header_nav.html";i:1528097081;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title><?php echo $matmass_config['matmass_info_store_title']; ?>--手机号</title>
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
<body class="绑定手机号">

<div class="classreturn loginsignup ">
    <div class="content">
        <div class="ds-in-bl return">
           <!-- <a href="[href]"><img src="__STATIC__/images/return.png" alt="返回"></a>-->
        </div>
        <div class="ds-in-bl search center">
            <span>手机号</span>
        </div>
        <div class="ds-in-bl menu">
         <!--   <a href="javascript:void(0);"><img src="__STATIC__/images/class1.png" alt="菜单"></a>-->
        </div>
    </div>
</div>
<div class="flool tpnavf">
    <div class="footer">
        <ul>
            <li>
                <a class="yello" href="<?php echo url('Index/index'); ?>">
                    <div class="icon">
                        <i class="icon-shouye iconfont"></i>
                        <p>首页</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo url('Goods/categoryList'); ?>">
                    <div class="icon">
                        <i class="icon-fenlei iconfont"></i>
                        <p>分类</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo url('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

		<div class="loginsingup-input">
            <form action="<?php echo url('Mobile/User/userinfo'); ?>" method="post" onsubmit="return submitverify(this)">
                <div class="reset-pwd-title">绑定手机号码</div>
				<div class="lsu">
					<span class="ico ico-telephone"></span>
					<input type="text" name="mobile" id="tel" value="<?php echo $user['mobile']; ?>" placeholder="请输入您的手机号" onBlur="checkMobilePhone(this.value);"/>
				</div>
				<div class="lsu">
					<span class="ico ico-v-code"></span>
					<input class="v-code-input" type="text" id="mobile_code" value="" name="mobile_code" placeholder="请输入验证码" >
					<a class="btn-text-message" rel="mobile" onClick="sendcode(this)">获取验证码</a>
				</div>



				<div class="lsu-submit">
					<input type="submit" name="" id="" value="确认修改" />
				</div>
			</form>
		</div>
<script>
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
        var s = <?php echo $matmass_config['sms_sms_time_out']; ?>;
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
