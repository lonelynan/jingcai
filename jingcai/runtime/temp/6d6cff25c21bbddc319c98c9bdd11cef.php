<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:52:"./application/admin/view2/system\navigationList.html";i:1528682355;s:44:"./application/admin/view2/public\layout.html";i:1528682356;}*/ ?>
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
<body style="background-color: rgb(255, 255, 255); overflow: auto; cursor: default; -moz-user-select: inherit;">

<div class="page">
    <!-- 操作说明 -->
    <div class="flexigrid">
        <div class="mDiv">
            <div class="ftitle">
                <h3>前台导航列表</h3>
                <h5>(共<?php echo count($navigationList); ?>条记录)</h5>
            </div>
            <div title="刷新数据" class="pReload"><i class="fa fa-refresh"></i></div>
        </div>
        <div class="hDiv">
            <div class="hDivBox">
                <table cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th class="sign" axis="col0">
                            <div style="width: 24px;"><i class="ico-check"></i></div>
                        </th>
                        <th align="left" abbr="article_title" axis="col3" class="">
                            <div style="text-align: left; width: 100px;" class="">导航名称</div>
                        </th>
                        <th align="left" abbr="ac_id" axis="col4" class="">
                            <div style="text-align: left; width: 350px;" class="">链接地址</div>
                        </th>
                        <th align="center" abbr="article_show" axis="col5" class="">
                            <div style="text-align: center; width: 80px;" class="">显示</div>
                        </th>
                        <th align="center" abbr="article_new" axis="col6" class="">
                            <div style="text-align: center; width: 80px;" class="">新窗口打开</div>
                        </th>
                        <th align="center" abbr="article_time" axis="col6" class="">
                            <div style="text-align: center; width: 150px;" class="">排序</div>
                        </th>
                        <th align="center" axis="col1" class="handle">
                            <div style="text-align: center; width: 150px;">操作</div>
                        </th>
                        <th style="width:100%" axis="col7">
                            <div></div>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tDiv">
            <div class="tDiv2">
                <div class="fbutton"> <a href="<?php echo url('Admin/System/addEditNav'); ?>">
                    <div class="add" title="新增导航">
                        <span><i class="fa fa-plus"></i>新增导航</span>
                    </div>
                </a> </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="bDiv" style="height: auto;">
            <div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
                <table>
                    <tbody>
                    <?php if(is_array($navigationList) || $navigationList instanceof \think\Collection || $navigationList instanceof \think\Paginator): if( count($navigationList)==0 ) : echo "" ;else: foreach($navigationList as $k=>$vo): ?>
                        <tr>
                            <td class="sign">
                                <div style="width: 24px;"><i class="ico-check"></i></div>
                            </td>
                            <td align="left" class="">
                                <div style="text-align: left; width: 100px;"><?php echo $vo['name']; ?></div>
                            </td>
                            <td align="left" class="">
                                <div style="text-align: left; width: 350px;"><?php echo $vo['url']; ?></div>
                            </td>
                            <td align="center" class="">
                                <div style="text-align: center; width: 80px;">
                                    <?php if($vo['is_show'] == 1): ?>
                                        <span class="yes" onClick="changeTableVal('navigation','id','<?php echo $vo['id']; ?>','is_show',this)" ><i class="fa fa-check-circle"></i>是</span>
                                        <?php else: ?>
                                        <span class="no" onClick="changeTableVal('navigation','id','<?php echo $vo['id']; ?>','is_show',this)" ><i class="fa fa-ban"></i>否</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td align="center" class="">
                                <div style="text-align: center; width: 80px;">
                                    <?php if($vo['is_new'] == 1): ?>
                                        <span class="yes" onClick="changeTableVal('navigation','id','<?php echo $vo['id']; ?>','is_new',this)" ><i class="fa fa-check-circle"></i>是</span>
                                        <?php else: ?>
                                        <span class="no" onClick="changeTableVal('navigation','id','<?php echo $vo['id']; ?>','is_new',this)" ><i class="fa fa-ban"></i>否</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="sort">
                                <div style="text-align: center; width: 150px;">
                                    <input style="text-align: center;" type="text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onblur="changeTableVal('navigation','id','<?php echo $vo['id']; ?>','sort',this)"  size="4"  value="<?php echo $vo['sort']; ?>" />
                                </div>
                            </td>
                            <td align="center" class="handle">
                                <div style="text-align: center; width: 170px; max-width:170px;">
                                    <?php if($vo['url'] != NULL): ?>
                                        <a class="btn blue"  target="_blank" href="<?php echo $vo['url']; ?>"><i class="fa fa-search"></i>查看</a>
                                    <?php endif; ?>
                                    <a class="btn red" href="<?php echo url('System/delNav',array('id'=>$vo['id'])); ?>"><i class="fa fa-trash-o"></i>删除</a>
                                    <a href="<?php echo url('Admin/System/addEditNav',array('id'=>$vo['id'])); ?>" class="btn blue"><i class="fa fa-pencil-square-o"></i>编辑</a> </div>
                            </td>
                            <td align="" class="" style="width: 100%;">
                                <div>&nbsp;</div>
                            </td>
                        </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="iDiv" style="display: none;"></div>
        </div>
        <!--分页位置-->

    </div>
</div>
<script>
    $(document).ready(function(){
        // 表格行点击选中切换
        $('#flexigrid > table>tbody >tr').click(function(){
            $(this).toggleClass('trSelected');
        });

        // 点击刷新数据
        $('.fa-refresh').click(function(){
            location.href = location.href;
        });

    });

</script>
</body>
</html>