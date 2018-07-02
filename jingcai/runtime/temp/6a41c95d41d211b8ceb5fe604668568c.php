<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:42:"./application/admin/view2/index\index.html";i:1528682359;s:42:"./application/admin/view2/public\left.html";i:1528682357;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $tpshop_config['matmass_info_store_logo']; ?>" media="screen"/>
<title>后台管理</title>
<script type="text/javascript">
  var SITEURL = window.location.host +'/index.php/admin';
</script>

<link href="__PUBLIC__/static/css/main.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/font/css/font-awesome.min.css" rel="stylesheet" />
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
  <script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.js"></script>
  <script type="text/javascript" src="__PUBLIC__/static/js/dialog/dialog.js" id="dialog_js"></script>
  <script type="text/javascript" src="__PUBLIC__/static/js/jquery.cookie.js"></script>
  <script type="text/javascript" src="__PUBLIC__/static/js/admincp.js"></script>
  <script type="text/javascript" src="__PUBLIC__/static/js/jquery.validation.min.js"></script>
  <script src="__PUBLIC__/js/layer/layer.js"></script><!--弹窗js 参考文档 http://layer.layui.com/-->
  <script src="__PUBLIC__/js/upgrade.js"></script>
</head>
<body>
<div class="admincp-header">
  <div class="bgSelector"></div>
  <div id="foldSidebar"><i class="fa fa-outdent " title="展开/收起侧边导航"></i></div>
  <div class="admincp-name" onClick="javascript:openItem('welcome|Index');">
    <h1 style="cursor:pointer;">平台系统管理中心</h1>

  </div>
  <div class="nc-module-menu">
    <ul class="nc-row">
      <li data-param="system"><a href="javascript:void(0);">系统</a></li>
      <li data-param="lottery"><a href="javascript:void(0);">活动设置</a></li>
      <!--<li data-param="thirdparty"><a href="javascript:void(0);">第三方平台</a></li>-->
    </ul>
  </div>
  <div class="admincp-header-r">
    <div class="manager">

      
      <dl>
        <dt class="name"></dt>
        <dd class="group"></dd>
      </dl>    
      <dl>
        <dt class="name"><?php echo $admin_info['user_name']; ?></dt>
        <dd class="group">管理员</dd>
      </dl>
     <i class="arrow" id="admin-manager-btn" title="显示快捷管理菜单"></i>
      <div class="manager-menu">
        <div class="title">
          <h4>最后登录</h4>
          <a href="javascript:void(0);" onClick="CUR_DIALOG = ajax_form('modifypw', '修改密码', '<?php echo Url('Admin/modify_pwd',array('admin_id'=>$admin_info['admin_id'])); ?>');" class="edit-password">修改密码</a> </div>
        <div class="login-date"> <?php echo date('Y-m-d H:i:s',session('last_login_time'));?> <span>(IP: <?php echo session('last_login_ip');?> )</span> </div>

      </div>
    </div>
    <ul class="operate nc-row">
       <!-- li><a class="sitemap show-option" tptype="map_on" href="javascript:void(0);" title="查看全部管理菜单">&nbsp;</a></li -->
      <!-- li><a class="style-color show-option" id="trace_show" href="javascript:void(0);" title="给管理中心换个颜色">&nbsp;</a></li -->
        <li><a class="sitemap show-option" id="trace_show" href="<?php echo Url('System/cleanCache'); ?>" target="workspace" title="更新缓存">&nbsp;</a></li>

      <li><a class="login-out show-option" href="<?php echo Url('Admin/logout'); ?>" title="安全退出管理中心">&nbsp;</a></li>
    </ul>
  </div>
  <div class="clear"></div>
</div>
<div class="admincp-container unfold">
<div class="admincp-container-left">
    <div class="top-border"><span class="nav-side"></span><span class="sub-side"></span></div>
    <div id="admincpNavTabs_index" class="nav-tabs">
    	<dl>
		    <dt><a href="javascript:void(0);"><span class="ico-microshop-1"></span><h3>概览</h3></a></dt>
		    <dd class="sub-menu">
			    <ul>
				    <li><a href="javascript:void(0);" data-param="welcome|Index">系统后台</a></li>
			    </ul>
		    </dd>
	    </dl>
    </div>
    <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $mk=>$vo): ?>
    <div id="admincpNavTabs_<?php echo $mk; ?>" class="nav-tabs">
    	<?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): if( count($vo['child'])==0 ) : echo "" ;else: foreach($vo['child'] as $key=>$v2): ?>
	    <dl>
		    <dt><a href="javascript:void(0);"><span class="ico-<?php echo $mk; ?>-<?php echo $key; ?>"></span><h3><?php echo $v2['name']; ?></h3></a></dt>
		    <dd class="sub-menu">
			    <ul>
			    	<?php if(is_array($v2['child']) || $v2['child'] instanceof \think\Collection || $v2['child'] instanceof \think\Paginator): if( count($v2['child'])==0 ) : echo "" ;else: foreach($v2['child'] as $key=>$v3): ?>
				    	<li><a href="javascript:void(0);" data-param="<?php echo $v3['act']; ?>|<?php echo $v3['op']; ?>"><?php echo $v3['name']; ?></a></li>
				    <?php endforeach; endif; else: echo "" ;endif; ?>
			    </ul>
		    </dd>
	    </dl>
    	<?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>

</div>
  <div class="admincp-container-right">
    <div class="top-border"></div>
    <iframe src="" id="workspace" name="workspace" style="overflow: visible;" frameborder="0" width="100%" height="94%" scrolling="yes" onload="window.parent"></iframe>
  </div>
</div>
</body>
<script type="text/javascript"> 


    $("#admin-manager-btn").click(function () {
        if ($(".manager-menu").css("display") == "none") {
            $(".manager-menu").css('display', 'block');
			$("#admin-manager-btn").attr("title","关闭快捷管理");
			$("#admin-manager-btn").removeClass().addClass("arrow-close");
        }
        else {
            $(".manager-menu").css('display', 'none');
			$("#admin-manager-btn").attr("title","显示快捷管理");
			$("#admin-manager-btn").removeClass().addClass("arrow");
        }
    });
</script>
</html>