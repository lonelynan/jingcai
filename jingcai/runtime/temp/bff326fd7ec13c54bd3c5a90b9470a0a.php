<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:82:"./application/admin/view2/activity_settings_champion\activitySettingsChampion.html";i:1528682362;s:44:"./application/admin/view2/public\layout.html";i:1528682356;}*/ ?>
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

<script src="__ROOT__/public/static/js/layer/laydate/laydate.js"></script>

<style type="text/css">
    html, body {
        overflow: visible;
    }
</style>
<body style="background-color: #FFF; overflow: auto;">
<div id="toolTipLayer" style="position: absolute; z-index: 9999; display: none; visibility: visible; left: 95px; top: 573px;"></div>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title"><a class="back" href="javascript:history.back();" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
            <div class="subject">
                <h3>猜冠军活动设置 - 编辑活动</h3>
                <h5>网站系统专题索引与管理</h5>
            </div>
        </div>
    </div>
    <form class="form-horizontal" id="handleposition"  method="post">
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>活动标题</label>
                </dt>
                <dd class="opt">
                    <input type="text" name="title" value="<?php echo $info['title']; ?>"class="input-txt">
                    <span class="err" id="err_title"></span>
                    <p class="notic"></p>
                </dd>
            </dl>
           <!-- <dl class="row">
                <dt class="tit">
                    <label><em>*</em>卡劵积分</label>
                </dt>
                <dd class="opt">
                    <input type="number" name="coupon" value="<?php echo $info['coupon']; ?>"class="input-txt">

                    <p class="notic"></p>
                </dd>
            </dl>-->
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>开始日期</label>
                </dt>
                <dd class="opt">
                    <input type="text" name="start_date"id="start_date" value="<?php echo isset($info['start_date'])?$info['start_date']: ''; ?>"class="input-txt">
                    <span class="add-on input-group-addon">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="articleForm"><em>*</em>发布时间</label>
                </dt>
                <dd class="opt">
                    <input type="text" class="input-txt" id="end_date" name="end_date"  value="<?php echo isset($info['end_date'])?$info['end_date']: ''; ?>">
                    <span class="add-on input-group-addon">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
            </span>
                    <span class="err"></span>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="parent_id">竞猜1</label>
                </dt>
                <dd class="opt">
                    <select class="small form-control" style="width:200px"  tabindex="1" name="activity_team1_id" id="activity_team1_id">
                        <option value="0">请选择</option>
                        <?php if(is_array($activity_team_select) || $activity_team_select instanceof \think\Collection || $activity_team_select instanceof \think\Paginator): if( count($activity_team_select)==0 ) : echo "" ;else: foreach($activity_team_select as $k=>$vo): ?>
                            <option value="<?php echo $k; ?>" <?php if(($info['activity_team1_id'] == $k)): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <span class="err"></span>
                    <p class="notic">如果选择上级分类，那么新增的分类则为被选择上级分类的子分类</p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="parent_id">竞猜2</label>
                </dt>
                <dd class="opt">
                    <select class="small form-control" style="width:200px"  tabindex="1" name="activity_team2_id" id="activity_team2_id">
                        <option value="0">请选择</option>
                        <?php if(is_array($activity_team_select) || $activity_team_select instanceof \think\Collection || $activity_team_select instanceof \think\Paginator): if( count($activity_team_select)==0 ) : echo "" ;else: foreach($activity_team_select as $k=>$vo): ?>
                            <option value="<?php echo $k; ?>" <?php if(($info['activity_team2_id'] == $k)): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <span class="err"></span>
                    <p class="notic">如果选择上级分类，那么新增的分类则为被选择上级分类的子分类</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="parent_id">竞猜3</label>
                </dt>
                <dd class="opt">
                    <select class="small form-control" style="width:200px"  tabindex="1" name="activity_team3_id" id="activity_team3_id">
                        <option value="0">请选择</option>
                        <?php if(is_array($activity_team_select) || $activity_team_select instanceof \think\Collection || $activity_team_select instanceof \think\Paginator): if( count($activity_team_select)==0 ) : echo "" ;else: foreach($activity_team_select as $k=>$vo): ?>
                            <option value="<?php echo $k; ?>" <?php if(($info['activity_team3_id'] == $k)): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <span class="err"></span>
                    <p class="notic">如果选择上级分类，那么新增的分类则为被选择上级分类的子分类</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="parent_id">竞猜4</label>
                </dt>
                <dd class="opt">
                    <select class="small form-control" style="width:200px"  tabindex="1" name="activity_team4_id" id="activity_team4_id">
                        <option value="0">请选择</option>
                        <?php if(is_array($activity_team_select) || $activity_team_select instanceof \think\Collection || $activity_team_select instanceof \think\Paginator): if( count($activity_team_select)==0 ) : echo "" ;else: foreach($activity_team_select as $k=>$vo): ?>
                            <option value="<?php echo $k; ?>" <?php if(($info['activity_team4_id'] == $k)): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <span class="err"></span>
                    <p class="notic">如果选择上级分类，那么新增的分类则为被选择上级分类的子分类</p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label>是否显示</label>
                </dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="article_show1" class="cb-enable <?php if($info['show_in_nav'] == 1): ?>selected<?php endif; ?>">是</label>
                        <label for="article_show0" class="cb-disable <?php if($info['show_in_nav'] == 0): ?>selected<?php endif; ?>">否</label>
                        <input id="article_show1" name="show_in_nav" value="1" type="radio" <?php if($info['show_in_nav'] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="article_show0" name="show_in_nav" value="0" type="radio" <?php if($info['show_in_nav'] == 0): ?> checked="checked"<?php endif; ?>>
                    </div>
                    <p class="notic"></p>
                </dd>
            </dl>
            <div class="bot">

                <a href="JavaScript:void(0);"  onclick="adsubmit(2)" class="ncap-btn-big ncap-btn-green">发布活动</a>
            </div>
        </div>
        <input type="hidden" name="act" value="<?php echo $act; ?>">
        <input type="hidden" name="activity_settings_champion_id" value="<?php echo $info['activity_settings_champion_id']; ?>">
        <input type="hidden" id="state" name="state" value="2">
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $('#start_date').layDate();
    });
    $(function () {
        $('#end_date').layDate();
    });
    function adsubmit(state) {
        $('span.err').hide();
        $('#state').val(state);
        $.ajax({
            type: "POST",
            url: "<?php echo url('Admin/ActivitySettingsChampion/activitySettingsChampionHandle'); ?>",
            data: $('#handleposition').serialize(),
            dataType: "json",
            error: function () {
                layer.alert("服务器繁忙, 请联系管理员!");
            },
            success: function (data) {
                if (data.status === 1) {
                    layer.msg(data.msg, {icon: 1,time: 1000}, function() {
                        location.href = "<?php echo url('Admin/ActivitySettingsChampion/activitySettingsChampionList'); ?>";
                    });
                } else if(data.status === 0) {
                    layer.msg(data.msg, {icon: 2,time: 1000});
                    $.each(data.result, function(index, item) {
                        $('#err_' + index).text(item).show();
                    });
                } else {
                    layer.msg(data.msg, {icon: 2,time: 1000});
                }
            }
        });
    }
    
    function img_call_back(fileurl_tmp)
    {
        $("#topic_image").val(fileurl_tmp);
        $("#img_a").attr('href', fileurl_tmp);
        $("#img_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
    }
</script>
</body>
</html>