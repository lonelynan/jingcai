<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:31:"./template/mobile/user\reg.html";i:1528097080;s:36:"./template/mobile/public\header.html";i:1528443300;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
    <!--<meta name = "format-detection" content="telephone = no" />-->
    <title><?php echo $matmass_config['matmass_info_store_title']; ?>--</title>
    <link rel="stylesheet" href="__STATIC__/css/style.css">
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
<body class="">

<div class="classreturn loginsignup ">
    <div class="content">

        <div class="ds-in-bl search center">
            <span>注册</span>
        </div>

    </div>
</div>
<style>
    #verify_code_img{
        padding: .55467rem .21333rem;
        width: 4.6rem;
        height: 2.9rem;
        color: white;
        border-radius: .128rem;
    }
</style>
<div class="logo-wrap-bg">
    <a class="login-logo-wrap" href="#">
       <!-- <img src="__STATIC__/images/logo-login.png" alt="LOGO"/>-->
    </a>
</div>
<!--注册表单-s-->
<div class="loginsingup-input">
    <form action="" method="post" id="regFrom" >
    	<input type="hidden" name="is_bind" value="<?php echo \think\Request::instance()->param('is_bind'); ?>">
        <div class="lsu">
            <span class="ico ico-telephone"></span>
            <input type="text" name="username" id="username" value="" placeholder="请输入手机号"  class="c-form-txt-normal" onBlur="checkMobilePhone(this.value);">
            <span id="mobile_phone_notice"></span>
        </div>
        <if condition="$regis_sms_enable eq 1">
            <div class="lsu">
                <span class="ico ico-v-code"></span>
                <input class="v-code-input" type="text" id="mobile_code" value="" name="mobile_code" placeholder="请输入验证码" >
                <a class="btn-text-message" rel="mobile" onClick="sendcode(this)">获取验证码</a>
            </div>
        </if>

        <!-- <div class="lsu">
             <span class="ico ico-password"></span>
             <input type="password" name="password" id="password" value="" placeholder="请设置6-20位登录密码" class="c-form-txt-normal" onBlur="check_password(this.value);">
             <span id="password_notice"></span>
         </div>
         <div class="lsu">
             <span class="ico ico-password"></span>
             <input type="password" id="password2" name="password2" value="" placeholder="确认密码" onBlur="check_confirm_password(this.value);">
             <span id="confirm_password_notice"></span>
         </div>-->

        <div class="lsu-submit">
            <input type="button" name="" id="" onclick="checkSubmit()" value="注 册"/>
        </div>
        <div class="signup-find">

        </div>
    </form>
</div>

<!--注册表单-s-->
<script type="text/javascript">
    //提交表单
    function checkSubmit()
    {
        $.ajax({
            type:'POST',
            url:"/Mobile/User/reg",
            dataType:'JSON',
            data:$('#regFrom').serialize(),
            success:function(data){
                if(data.status == 1){
                    location.href='/Mobile/User/index';
                }else{
                    showErrorMsg(data.msg);
                }
            }
        })
    }
    var flag = false;
    //手机验证
    function checkMobilePhone(mobile){
        if(mobile == ''){
            showErrorMsg('手机不能空');
            flag = false;
        }else if(checkMobile(mobile)){ //判断手机格式
            $.ajax({
                type : "GET",
                url:"/Home/Api/issetMobile",//+tab,
                data :{mobile:mobile},// 你的formid 搜索表单 序列化提交
                success: function(data)
                {
                    if(data == '0')
                    {
                        flag = true;
                    }else{
                        showErrorMsg('* 手机号已存在');
                        flag = false;
                    }
                }
            });
        }else{
            showErrorMsg('* 手机号码格式不正确');
           flag = false;
        }
    }

    //密码
    function check_password(password) {
        var password = $.trim(password);
        if(password == ''){
            showErrorMsg("*登录密码不能包含空格");
           flag = false;
        }else if (password.length < 6) {
            showErrorMsg('*登录密码不能少于 6 个字符。');
           flag = false;
        }
    }

    //验证确认密码
    function check_confirm_password(confirm_password) {
        var password1 = $.trim($('#password').val());
        var password2 = $.trim(confirm_password);
        if (password1 == '') {
            showErrorMsg("*确认密码不能包含空格");
           flag = false;
        }
        if (password2.length < 6) {
            showErrorMsg('*登录密码不能少于 6 个字符。');
           flag = false;
        }
        if (password2 != password1) {
            showErrorMsg('*两次密码不一致');
           flag = false;
        }else{
            flag = true;
        }
    }

    function countdown(obj) {
        var s = <?php echo $matmass_config['sms_sms_time_out']; ?>;
        //改变按钮状态
        obj.disabled = true;
        callback();
        //循环定时器
        var T = window.setInterval(callback,1000);
        function callback()
        {
            if(s <= 0){
                //移除定时器
                window.clearInterval(T);
                obj.disabled=false;
                obj.innerHTML='获取验证码';
            }else{
                if(s<=10){
                    obj.innerHTML = '0'+ --s + '秒后再获取';
                }else{
                    obj.innerHTML = --s+ '秒后再获取';
                }
            }
        }
    }

    //发送短信验证码
    function sendcode(obj){
        if(flag){
            $.ajax({
                url:'/Home/Api/send_validate_code/t/'+Math.random() ,
                type:'post',
                dataType:'json',
                data:{type:$(obj).attr('rel'),send:$.trim($('#username').val()), scene:1},
                success:function(res){
                    if(res.status==1){
                        //成功
                        countdown(obj)
                        showErrorMsg(res.msg);
                    }else{
                        //失败
                        showErrorMsg(res.msg);
                    }
                }
            })
        }else{
            showErrorMsg('请输入手机号！');
        }
    }

    /**
     * 提示弹窗
     * */
    function showErrorMsg(msg){
        layer.open({content:msg,time:2});
    }
    // 普通 图形验证码
    //    function verify(){
    //        $('#verify_code_img').attr('src','/index.php?m=Home&c=User&a=verify&type=user_reg&r='+Math.random());
    //    }
</script>
	</body>
</html>
