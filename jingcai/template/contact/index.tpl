<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">



<style>
    /*分页样式*/
    .pagination{text-align:center;margin-top:20px;margin-bottom: 20px;} .pagination li{margin:0px 10px; border:1px solid #e6e6e6;padding: 3px 8px;display: inline-block;} .pagination .active{background-color: #46A3FF;color: #fff;} .pagination .disabled

    {color:#aaa;}
</style>



<div class="wrapper">
    {include file='public:public_header'}
    {include file='public:contact'}
    <section class="content" style="padding:0px 15px;">
        <!-- Main content -->
        <div class="container-fluid">

            <div class="panel panel-default">
                <div class="panel-body ">

                    <!--表单数据-->
                    <form method="post" id="handlepost" action="{:url('')}">
                        <div class="tab-content col-md-3">
                            <div class="tab-pane active" id="tab_tongyong">
                                <ul class="nav ">
                                    <li><a href="javascript:;" data-toggle="tab">联系方式</a></li>
                                </ul>
                                <table class="table ">
                                    <tbody>
                                    <tr>
                                        <td class="col-sm-4">姓名：</td>
                                        <td class="col-sm-8">

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>手机：</td>
                                        <td >

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>邮箱：</td>
                                        <td >

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <div class="tab-content col-md-7">
                        <div class="tab-pane active" id="tab_tongyong">
                            <ul class="nav ">

                                <li><a href="javascript:;" data-toggle="tab">在线留言</a></li>
                            </ul>
                            <table class="table " style="border: 0px solid transparent !important;">
                                <tbody>
                                <tr>
                                    <td class="col-sm-2">姓名：</td>
                                    <td class="col-sm-8">
                                        <input type="text" class="form-control" name="store_name" value="" >
                                        <span id="err_attr_name" style="color:#F00; display:none;"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>手机：</td>
                                    <td >
                         				<input type="text" class="form-control" name="store_title" value="" >
                                        <span id="err_type_id" style="color:#F00; display:none;"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>邮箱：</td>
                                    <td>
                               			<input type="text" class="form-control" name="store_desc" value="" >
                                    </td>
                                </tr>

                                <td>内容：</td>
                                 <td>
                                     <textarea class="form-control" rows="5"></textarea>
                                    </td>
                                </tr>


                                </tbody>
                                <tfoot>
                                	<tr>

                                	<td class="text-right" colspan="2"><input class="btn btn-primary" type="buuton" onclick="adsubmit()" value="提交"></td></tr>
                                </tfoot>
                                </table>
                        </div>
                    </div>
			    	</form><!--表单数据-->
                </div>
            </div>
        </div>
    </section>
</div>
{include file='public:bottom'}
<script>

function adsubmit(){
	$('#handlepost').submit();
}
</script>
</body>
</html>