<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>{$matmass_config.matmass_info_store_name }</title>


    <link href="__PUBLIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="__PUBLIC__/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="__PUBLIC__/temp/p.equipment.css" type="text/css"/>
    <script src="__PUBLIC__/plugins/jQuery/jQuery-2.1.4.min.js"></script>

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
        <input class="btn_srh" type="button" name="submit" value="搜索" onclick="searchResult(this);" style=" height:43px ">
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


