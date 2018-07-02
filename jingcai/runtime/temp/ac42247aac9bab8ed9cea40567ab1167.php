<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:49:"./application/admin/view2/system\system_info.html";i:1528682354;s:44:"./application/admin/view2/public\layout.html";i:1528682356;}*/ ?>
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
<link href="__PUBLIC__/static/css/main.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/css/page.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/font/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="__PUBLIC__/static/font/css/font-awesome-ie7.min.css">
<![endif]-->
<link href="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<link href="__PUBLIC__/static/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css"/>
<style type="text/css">html, body { overflow: visible;}</style>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/layer/layer.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<script type="text/javascript" src="__PUBLIC__/static/js/admin.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.mousewheel.js"></script>
<script src="__PUBLIC__/js/myFormValidate.js"></script>
<script src="__PUBLIC__/js/myAjax2.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
						layer.closeAll();
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }

    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }



    function delAll(obj,name){
    	var a = [];
    	$('input[name*='+name+']').each(function(i,o){
    		if($(o).is(':checked')){
    			a.push($(o).val());
    		}
    	})
    	if(a.length == 0){
    		layer.alert('请选择删除项', {icon: 2});
    		return;
    	}
    	layer.confirm('确认删除？', {btn: ['确定','取消'] }, function(){
    			$.ajax({
    				type : 'get',
    				url : $(obj).attr('data-url'),
    				data : {act:'del',del_id:a},
    				dataType : 'json',
    				success : function(data){
						layer.closeAll();
    					if(data == 1){
    						layer.msg('操作成功', {icon: 1});
    						$('input[name*='+name+']').each(function(i,o){
    							if($(o).is(':checked')){
    								$(o).parent().parent().remove();
    							}
    						})
    					}else{
    						layer.msg(data, {icon: 2,time: 2000});
    					}
    				}
    			})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }

    /**
     * 全选
     * @param obj
     */
    function checkAllSign(obj){
        $(obj).toggleClass('trSelected');
        if($(obj).hasClass('trSelected')){
            $('#flexigrid > table>tbody >tr').addClass('trSelected');
        }else{
            $('#flexigrid > table>tbody >tr').removeClass('trSelected');
        }
    }
    /**
     * 批量公共操作（删，改）
     * @returns {boolean}
     */
    function publicHandleAll(type){
        var ids = '';
        $('#flexigrid .trSelected').each(function(i,o){
//            ids.push($(o).data('id'));
            ids += $(o).data('id')+',';
        });
        if(ids == ''){
            layer.msg('至少选择一项', {icon: 2, time: 2000});
            return false;
        }
        publicHandle(ids,type); //调用删除函数
    }
    /**
     * 公共操作（删，改）
     * @param type
     * @returns {boolean}
     */
    function publicHandle(ids,handle_type){
        layer.confirm('确认当前操作？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    // 确定
                    $.ajax({
                        url: $('#flexigrid').data('url'),
                        type:'post',
                        data:{ids:ids,type:handle_type},
                        dataType:'JSON',
                        success: function (data) {
                            layer.closeAll();
                            if (data.status == 1){
                                layer.msg(data.msg, {icon: 1, time: 2000},function(){
                                    location.href = data.url;
                                });
                            }else{
                                layer.msg(data.msg, {icon: 2, time: 2000});
                            }
                        }
                    });
                }, function (index) {
                    layer.close(index);
                }
        );
    }
</script>

</head>
<body style="background-color: #FFF; overflow: auto;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">

            <ul class="tab-base nc-row">
                <?php if(is_array($group_list) || $group_list instanceof \think\Collection || $group_list instanceof \think\Paginator): if( count($group_list)==0 ) : echo "" ;else: foreach($group_list as $k=>$v): ?>
                    <li><a href="<?php echo url('System/index',['inc_type'=> $k]); ?>" <?php if($k==$inc_type): ?>class="current"<?php endif; ?>><span><?php echo $v; ?></span></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
    <!-- 操作说明 -->

    <form method="post" id="handlepost" action="<?php echo url('System/handle'); ?>" enctype="multipart/form-data" name="form1">
        <input type="hidden" name="form_submit" value="ok" />

        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="store_title">网站标题</label>
                </dt>
                <dd class="opt">
                    <input id="store_title" name="store_title" value="<?php echo $config['store_title']; ?>" class="input-txt" type="text" />
                    <p class="notic">网站标题，将显示在前台顶部欢迎信息等位置</p>
                </dd>
            </dl>
            <!--<dl class="row">-->
                <!--<dt class="tit">-->
                    <!--<label for="record_no">网站备案号</label>-->
                <!--</dt>-->
                <!--<dd class="opt">-->
                    <!--<input id="record_no" name="record_no" value="<?php echo $config['record_no']; ?>" class="input-txt" type="text" />-->
                    <!--<p class="notic">网站备案号，将显示在前台底部欢迎信息等位置</p>-->
                <!--</dd>-->
            <!--</dl>-->
            <!--<dl class="row">-->
                <!--<dt class="tit">-->
                    <!--<label for="store_name">网站名称</label>-->
                <!--</dt>-->
                <!--<dd class="opt">-->
                    <!--<input id="store_name" name="store_name" value="<?php echo $config['store_name']; ?>" class="input-txt" type="text" />-->
                    <!--<p class="notic">网站名称，将显示在前台顶部欢迎信息等位置</p>-->
                <!--</dd>-->
            <!--</dl>-->



            <dl class="row">
                <dt class="tit">
                    <label for="store_logo">PC网站首页背景图</label>
                </dt>
                <dd class="opt">
                    <div class="input-file-show">
                        <span class="show">
                            <a id="pc_home_bg_img_a" class="nyroModal" rel="gal" href="<?php echo $config['pc_home_bg_img']; ?>">
                                <i id="pc_home_bg_img_i" class="fa fa-picture-o" onmouseover="layer.tips('<img src=<?php echo $config['pc_home_bg_img']; ?>>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></i>
                            </a>
                        </span>
                        <span class="type-file-box">
                            <input type="text" id="pc_home_bg" name="pc_home_bg" value="<?php echo $config['pc_home_bg']; ?>" class="type-file-text">
                            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button">
                            <input class="type-file-file" onClick="GetUploadify(1,'','logo','pc_home_bg_call_back')" size="30" hidefocus="true" nc_type="change_pc_home_bg" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
                        </span>
                    </div>
                    <span class="err"></span>
                    <p class="notic">默认网站首页LOGO,通用头部显示，最佳显示尺寸为240*60像素</p>
                </dd>
            </dl>





















            <dl class="row">
                <dt class="tit">
                    <label for="store_logo">网站首页Logo</label>
                </dt>
                <dd class="opt">
                    <div class="input-file-show">
                        <span class="show">
                            <a id="img_a" class="nyroModal" rel="gal" href="<?php echo $config['store_logo']; ?>">
                                <i id="img_i" class="fa fa-picture-o" onmouseover="layer.tips('<img src=<?php echo $config['store_logo']; ?>>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></i>
                            </a>
                        </span>
           	            <span class="type-file-box">
                            <input type="text" id="store_logo" name="store_logo" value="<?php echo $config['store_logo']; ?>" class="type-file-text">
                            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button">
                            <input class="type-file-file" onClick="GetUploadify(1,'','logo','img_call_back')" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
                        </span>
                    </div>
                    <span class="err"></span>
                    <p class="notic">默认网站首页LOGO,通用头部显示，最佳显示尺寸为240*60像素</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="store_logo">网站用户中心Logo</label>
                </dt>
                <dd class="opt">
                    <div class="input-file-show">
                        <span class="show">
                            <a id="userimg_a" class="nyroModal" rel="gal" href="<?php echo $config['store_user_logo']; ?>">
                                <i id="userimg_i" class="fa fa-picture-o" onmouseover="layer.tips('<img src=<?php echo $config['store_user_logo']; ?>>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></i>
                            </a>
                        </span>
           	            <span class="type-file-box">
                            <input type="text" id="store_user_logo" name="store_user_logo" value="<?php echo $config['store_user_logo']; ?>" class="type-file-text">
                            <input type="button" name="button" value="选择上传..." class="type-file-button">
                            <input class="type-file-file" onClick="GetUploadify(1,'','logo','user_img_call_back')" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
                        </span>
                    </div>
                    <span class="err"></span>
                    <p class="notic">默认用户中心网站LOGO,用户中心通用头部显示，最佳显示尺寸为240*60像素</p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="store_desc">网站描述</label>
                </dt>
                <dd class="opt">
                    <input id="store_desc" name="store_desc" value="<?php echo $config['store_desc']; ?>" class="input-txt" type="text" />
                    <p class="notic">网站描述，将显示在前台顶部欢迎信息等位置</p>
                </dd>
            </dl>


            <div class="bot">
                <input type="hidden" name="inc_type" value="<?php echo $inc_type; ?>">
                <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.form1.submit()">确认提交</a>
            </div>
        </div>
    </form>
</div>
<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
<script type="text/javascript">

    //网站首页pc背景图
    function pc_home_bg_call_back(fileurl_tmp)
    {
        $("#pc_home_bg").val(fileurl_tmp);
        $("#pc_home_bg_img_a").attr('href', fileurl_tmp);
        $("#pc_home_bg_img_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
    }

    //网站首页logo
    function img_call_back(fileurl_tmp)
    {
        $("#store_logo").val(fileurl_tmp);
        $("#img_a").attr('href', fileurl_tmp);
        $("#img_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
    }
    //网站用户中心logo
    function user_img_call_back(fileurl_tmp)
    {
        $("#store_user_logo").val(fileurl_tmp);
        $("#userimg_a").attr('href', fileurl_tmp);
        $("#userimg_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
    }
</script>
</html>