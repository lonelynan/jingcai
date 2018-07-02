<style>

    #service{width:161px;height:290px;position:fixed;top:370px;right:10px; z-index:100;}
    #service li{width:161px;height:51px;}
    #service li img{float:right;}
    #service li a{height:49px;float:right;display:block;min-width:47px;max-width:161px;}
    #service li a .shows{display:block;}
    #service li a.weixin_area .hides{display:none;position:absolute;right:143px;}
    #service li a.weixin_area .weixin{display:none;position:absolute;right:0;top:48px}
    a:hover{text-decoration: none}
    img, small, strong, sub, sup, u, i, center, dl, dt, dd, ol, ul, li{margin:0; padding:0; border:0; outline:0; font-size:100%; vertical-align:baseline; background:transparent} .table_parameters a:hover{text-decoration: none} a:hover{text-decoration:none} ol, ul{list-style:none} img{border:0; cursor:pointer;} h3 a.cur

    {color: #f30;}


</style>

<div id="service">
    <ul>
        <li>
            <a href="javascript:void(0)" class="weixin_area">
                <img src="__PUBLIC__/static/images/contact/l02.png" width="47" height="49" class="shows"/>
                <img src="__PUBLIC__/static/images/contact/weixin.jpg" width="190" class="weixin"
                     style="display:none;margin:-110px 46px 0 0"/>
            </a>
        </li>
        <!--  <li>
              <a href="http://wpa.qq.com/msgrd?v=3&uin=800022936&site=qq&menu=yes" target="_blank">
                  <div class="hides" style="width:161px;display:none;" id="qq">
                      <div class="hides" id="p1">
                          <img src="__PUBLIC__/static/images/contact//ll04.png">
                      </div>
                      <div class="hides" id="p2"><span style="color:#FFF;font-size:13px">800022936</span>
                      </div>
                  </div>
                  <img src="__PUBLIC__/static/images/contact//l04.png" width="47" height="49" class="shows" />
              </a>
          </li>-->
        <li id="tel">
            <a href="javascript:void(0)" class="side_tel">
                <img src="__PUBLIC__/static/images/contact/l05.png" width="47" height="49" class="shows"/>
                <div class="tel" style="display:none;">
                    <img src="__PUBLIC__/static/images/contact/tel.jpg" width="170" style="margin:-64px 46px 0 0"/>
                    <div style="margin:-10px 0px 0px -45px;"><span style="font-size: 14px;">Matmass服务热线：</span><br><span style="color: #fd696d;font-size: 18px;margin-top:-8px;">021-60790303</span></div>
                </div>
            </a>
        </li>
        <li id="btn">
            <a id="top_btn">
                <div class="hides" style="width:161px;display:none">
                    <img src="__PUBLIC__/static/images/contact/ll06.png" width="161" height="49"/>
                </div>
                <img src="__PUBLIC__/static/images/contact/l06.png" width="47" height="49" class="shows"/>
            </a>
        </li>
    </ul>
</div>


<script type="text/javascript">
    $(function () {
        $("#top_btn").click(function () {
            $("html,body").animate({scrollTop: 0}, 600);
        });

        //右侧导航 - 二维码
        $(".weixin_area").hover(function () {
            $(this).children(".weixin").show();
        }, function () {
            $(this).children(".weixin").hide();
        })

        //右侧导航 - 电话
        $(".side_tel").hover(function () {
            $(this).children(".tel").show();
        }, function () {
            $(this).children(".tel").hide();
        })
    });

    $("#service ul li  .shows").css("opacity", 1.0)
        .hover(
            function () {
                $(this).animate({opacity:0.4});
            },
            function () {
                $(this).animate({opacity:1.0});
            }
        );
</script>
