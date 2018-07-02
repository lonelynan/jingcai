<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:33:"./template/mobile/user\login.html";i:1528439717;s:36:"./template/mobile/public\header.html";i:1528444143;s:40:"./template/mobile/public\header_nav.html";i:1528097081;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title><?php echo $matmass_config['matmass_info_store_title']; ?>--登录</title>
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
<body class="">

<div class="classreturn loginsignup ">
    <div class="content">
        <div class="ds-in-bl return">
           <!-- <a href="javascript:history.back(-1);"><img src="__STATIC__/images/return.png" alt="返回"></a>-->
        </div>
        <div class="ds-in-bl search center">
            <span>登录</span>
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
<div class="logo-wrap-bg">
    <a class="login-logo-wrap" href="#">
        <!--<img src="__STATIC__/images/logo-login.png" alt="LOGO"/>-->
    </a>
</div>

<div class="loginsingup-input">
    <!--登录表单-s-->
    <form  id="loginform" method="post"  >
        <input type="hidden" name="referurl" id="referurl" value="<?php echo $referurl; ?>">
        <div class="lsu">
            <span class="ico ico-username"></span>
            <input type="text" name="username" id="username" value=""  placeholder="请输入用户名"/>
        </div>
        <div class="lsu">
            <span class="ico ico-password"></span>
            <input type="password" name="password" id="password" value="" placeholder="请输入密码"/>
        </div>
        <notempty name="first_login">
        <div class="lsu">
            <span class="ico ico-v-code"></span>
            <input class="v-code-input" type="text" name="verify_code" id="verify_code" value="" placeholder="请输入验证码"/>
            <img class="v-code-pic"  id="verify_code_img" src="<?php echo url('Mobile/User/verify'); ?>" onClick="verify()"/>
        </div>
        </notempty>
        <div class="lsu-submit">
            <input type="button"  value="登 录"  onclick="submitverify()" class="btn_big1"  />
        </div>
    </form>
    <div class="signup-find p">
        <a class="note fl" href="<?php echo url('User/reg'); ?>">快速注册</a>
        <a class="note fr" href="<?php echo url('User/forget_pwd'); ?>">忘记密码？</a>
    </div>
<!--登录表单-e-->
    <!--第三方登陆-s-->
    <!--<div class="thirdlogin">
        <h4>第三方登陆</h4>
        <div class="third-login-list">
        <tpshop sql="select * from __PREFIX__plugin where type='login' AND status = 1" item="v" key="k">
            &lt;!&ndash;<if condition="$v['code'] eq 'weixin' AND is_weixin() neq 1">
                <a class="item-ico ico-wechat-login" href="<?php echo url('LoginApi/login',array('oauth'=>'weixin')); ?>" target="_blank" title="weixin"></a>
       </if>&ndash;&gt;
            <if condition="$v['code'] eq 'qq' AND is_qq() neq 1">
                <a class="item-ico ico-qq-login" href="<?php echo url('LoginApi/login',array('oauth'=>'qq')); ?>" target="_blank" title="QQ"></a>
            </if>
            <if condition="$v['code'] eq 'alipay' AND is_alipay() neq 1">
            <a class="item-ico ico-alipay-login" href="<?php echo url('LoginApi/login',array('oauth'=>'alipay')); ?>"></a>
            </if>
        </tpshop>
        </div>
    </div>-->
     <!--第三方登陆-e-->
</div>


<script type="text/javascript">
    function verify(){
        $('#verify_code_img').attr('src','/Mobile/User/verify/r/'+Math.random());
    }

    //复选框状态
    function remember(obj){
         var che= $(obj).attr("class");
        if(che == 'che check_t'){
            $("#autologin").prop('checked',false);
        }else{
            $("#autologin").prop('checked',true);
        }
    }
    function submitverify()
    {
        var username = $.trim($('#username').val());
        var password = $.trim($('#password').val());
        var remember = $('#remember').val();
        var referurl = $('#referurl').val();
        var verify_code = $.trim($('#verify_code').val());
        if(username == ''){
            showErrorMsg('用户名不能为空!');
            return false;
        }
        if(!checkMobile(username) && !checkEmail(username)){
            showErrorMsg('账号格式不匹配!');
            return false;
        }
        if(password == ''){
            showErrorMsg('密码不能为空!');
            return false;
        }
        var codeExist = $('#verify_code').length;
        if (codeExist && verify_code == ''){
            showErrorMsg('验证码不能为空!');
            return false;
        }

        var data = {username:username,password:password,referurl:referurl};
        if (codeExist) {
            data.verify_code = verify_code;
        }
        $.ajax({
            type : 'post',
            url : '/index.php?m=Mobile&c=User&a=do_login&t='+Math.random(),
            data : data,
            dataType : 'json',
            success : function(data){
                if(data.status == 1){
                    var url = data.url.toLowerCase();
                    if (url.indexOf('user') !=  false && url.indexOf('login') != false || url == '') {
                        window.location.href = '/index.php/mobile';
                    }else{
                        window.location.href = data.url;
                    }
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
</body>
</html>
