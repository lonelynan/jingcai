<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:25:"./template/user\login.tpl";i:1528097078;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/temp/css/base.css"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/temp/css/myaccount.css"/>
    <script src="__PUBLIC__/temp/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div class="loginsum_cm">
    <div class="w1224 p">
        <div class="login-dl">
            <a href="/" title="首页">
                <img src="__PUBLIC__/temp/img/matmass.png"/>
            </a>
        </div>
        <div class="login-welcome">
            <span>欢迎登录</span>
        </div>
    </div>
</div>
<div class="loginsum_main" style="background: #DDDDDD;">
    <div class="w1224 p">
        <div class="advertisement">
            <adv pid="9" item="v" key="k">
                <a href="">
                    <img src="" title="" style=""/>
                </a>
            </adv>
        </div>
        <div class="login_form">
            <div class="lo_intext">
                <div class="layel1">
                    <span>账户登录</span>
                </div>
                <form id="loginform" method="post">
                    <div class="layel2">
                        <div class="text_uspa">
                            <label class="judgp uspa_user"></label>
                            <input type="text" autofocus="autofocus" class="text_cmu" value="" placeholder="手机号/邮箱"
                                   name="username" id="username" autocomplete="off">
                        </div>
                        <div class="text_uspa">
                            <label class="judgp uspa_pwd"></label>
                            <input type="password" class="text_cmu" value="" placeholder="密码" name="password"
                                   id="password" autocomplete="off">
                        </div>
                        <div class="text_uspa check_cum">
                            <input type="text" class="text_cmu" value="" placeholder="验证码" name="verify_code"
                                   id="verify_code" autocomplete="off">
                        </div>
                        <div class="check_cum_img">
                            <img src="/home/user/verify" id="verify_code_img" onclick="verify()"/>
                        </div>
                        <div class="sum_reme_for p">

                            <div class="foget_pwt">
                                <a href="<?php echo url('Home/User/forget_pwd'); ?>">忘记密码？</a>
                            </div>
                        </div>
                        <div class="login_bnt">
                            <a href="javascript:void(0);" onClick="checkSubmit();" class="J-login-submit"
                               name="sbtbutton">登&nbsp;&nbsp;&nbsp;&nbsp;录</a>
                        </div>
                    </div>
                </form>
                <div class="layel3">
                    <div class="contactsty">
                        <div class="tecant_c">
                            <ul>

                                <li>
                                    <a class="justclix" href="<?php echo url('LoginApi/login',array('oauth'=>'weixin')); ?>"
                                       title="weixin">
                                        <i class="judgp co_wechat"></i>
                                        <span>微信</span>
                                    </a>
                                </li>


                                <li class="spacer"></li>
                                <li>
                                    <a class="justclix" href="<?php echo url('LoginApi/login',array('oauth'=>'qq')); ?>" title="QQ">
                                        <i class="judgp co_qq"></i>
                                        <span>QQ</span>
                                    </a>
                                </li>
                                <li class="spacer"></li>
                                <li>
                                    <a class="justclix" href="<?php echo url('LoginApi/login',array('oauth'=>'alipay')); ?>"
                                       title="支付宝">
                                        <i class="judgp co_alipay"></i>
                                        <span>支付宝</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="register_c">
                            <a class="justclix" href="<?php echo url('Home/User/reg'); ?>">
                                <i class="judgp co_register"></i>
                                <span>立即注册</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer-s-->
<include file="public/footer"/>
<!--footer-e-->
<script type="text/javascript">
    $(function () {
        $('.text_cmu').focus(function () {
            //焦点获取
            $(this).parents('.text_uspa').addClass('text_uspa_focus');
        })
        $('.text_cmu').blur(function () {
            //失去焦点
            $(this).parents('.text_uspa').removeClass('text_uspa_focus');
        })
    })

    function checkSubmit() {

        var username = $.trim($('#username').val());
        var password = $.trim($('#password').val());
        var referurl = $('#referurl').val();
        var verify_code = $.trim($('#verify_code').val());

        if (username == '') {
            showErrorMsg('用户名不能为空!');
            return false;
        }
        if (!checkMobile(username) && !checkEmail(username)) {
            showErrorMsg('账号格式不匹配!');
            return false;
        }
        if (password == '') {
            showErrorMsg('密码不能为空!');
            return false;
        }
        if (verify_code == '') {
            showErrorMsg('验证码不能为空!');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '/home/user/do_login/&t=' + Math.random(),
            data: $('#loginform').serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.status == 1) {
                    window.location.href = res.url;
                } else {
                    showErrorMsg(res.msg);
                    verify();
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                showErrorMsg('网络失败，请刷新页面后重试');
            }
        })

    }

    function checkMobile(tel) {
//        var reg = /(^1[3|4|5|7|8][0-9]{9}$)/;
        var reg = /^1[0-9]{10}$/;
        if (reg.test(tel)) {
            return true;
        } else {
            return false;
        }
        ;
    }

    function checkEmail(str) {
        var reg = /^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if (reg.test(str)) {
            return true;
        } else {
            return false;
        }
    }

    function showErrorMsg(msg) {
       alert(msg);
    }

    function verify() {

        $('#verify_code_img').attr('src', '/home/user/verify/r=' + Math.random());
    }
</script>
</body>
</html>
