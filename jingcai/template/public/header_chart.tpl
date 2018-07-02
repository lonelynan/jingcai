<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>{$matmass_config.matmass_info_store_name }</title>
    <script src="__PUBLIC__/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="__PUBLIC__/temp/p.equipment.css" type="text/css"/>
</head>

<body>
<script type="text/javascript">
  //  document.oncontextmenu=new Function("event.returnValue=false;");
  //  document.onselectstart=new Function("event.returnValue=false;");
</script>
<style>
    .search-public li {
        display: inherit !important
    }
</style>
<div style="width:100%;height:20px;margin-bottom:40px;background-color: #EEEEEE"></div>

<div class="logo2017 jz">

    <dl class="logo2017-l" >

        <dd>
            <p><img src="__PUBLIC__/temp/img/matmass.png "><span>{$matmass_config.matmass_info_store_name }</span>
            <p>
        </dd>
    </dl>



    <div class="search-public">

        <div class="search-c1">
            <input class="inp_srh dataQuery" id="query" placeholder="请输入搜索关键字" value="">
        </div>
        <input class="btn_srh" type="button" name="submit" value="搜索" onclick="searchResult(this);">
    </div>
</div>


<script type="text/javascript">
    function searchResult() {
        query = document.getElementById('query').value;
        location.href = "/home/equipment/getsearch/search/" + query+"";

    }
</script>


<div class="nav">
    <ul>
        {volist name="navigation" id="vo"}

            <li><a href="{:Url($vo.url)}">{$vo.name}</a></li>
        {/volist}
    </ul>
</div>
<br>
<div class="search" style=" height:42px; margin-bottom: 6px">
    <div style="float: left">

        <div class="search_left">地区分类：</div>

    </div>

    <div class="search_right">
        {volist name="equipment_province" id="vo"}

            <a href="{:Url('/home/equipment/getchart',array('province'=>$vo.id))}">
                {$vo.province}<span>{$vo.count}</span>
            </a>
        {/volist}
    </div>
    <!--
    <hr style="width:1150px; height:1px;border:none;border-top:1px dotted #EFF5FF;">
    <div style="float: left">

        <div class="search_left">设备分类：</div>
        <div class="search_left ">全部：<span style="color:red;margin-left:10px;">{$equipment_count}</span></div>
        <div class="search_left ">所在单位：<span style="color:red;margin-left:10px;">{$equipment_count_unitname}</span></div>
    </div>

    <div class="search_right">
        {volist name="equipment_category" id="vo"}

            <a href="{:Url('/home/equipment/getchart',array('province'=>$province,'ec_id'=>$vo.id))}">
                {$vo.equipment_category_name}<span>{$vo.count}</span>
            </a>
        {/volist}
    </div>-->

</div>

{include file='public:contact'}