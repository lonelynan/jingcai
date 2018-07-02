<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:33:"./template/mobile/user\index.html";i:1528097080;}*/ ?>
<include file="public/header" title="个人中心" body="g4"/>
<style>
    .my .content .floor_order ul li {
        width: 25%;
    }
</style>
    <div class="myhearder">
        <div class="person">
            <!--<a href="">-->
                <div class="fl personicon">
                    <div class="personicon">
                        <img src="<?php echo (isset($user[head_pic]) && ($user[head_pic] !== '')?$user[head_pic]:"__STATIC__/images/user68.jpg"); ?>"/>
                    </div>
                </div>
                <div class="fl lors">
                    <span><?php echo $user['nickname']; ?></span>
                    <if condition="$first_nickname neq ''">
                        <br />
                        <span style="font-size:20px">由(<?php echo $first_nickname; ?>)推荐</span>
                    </if>
                </div>
            <!--</a>-->
        </div>
        <div class="set">
            <!--设置-->
            <a class="setting" href="<?php echo U('Mobile/User/userinfo'); ?>"><i></i></a>
            <!--&lt;!&ndash;我的留言&ndash;&gt;-->
            <!--<a class="massage" href="<?php echo U('User/message_notice'); ?>"><i></i></a>-->
        </div>
        <div class="scgz">
            <ul>
                <li>
                    <a href="<?php echo U('Mobile/User/collect_list'); ?>">
                        <h2><?php echo $user['collect_count']; ?></h2>
                        <p>我的收藏</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('Mobile/User/message_notice'); ?>">
                        <h2><?php echo $user_message_count; ?></h2>
                        <p>消息通知</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="floor my p">
        <div class="content">
            <!--订单管理模块-s-->
            <div class="floor myorder ma-to-20 p">
                <div class="content30">
                    <div class="order">
                        <div class="fl">
                            <img src="__STATIC__/images/mlist.png"/>
                            <span>我的订单</span>
                        </div>
                        <div class="fr">
                            <a href="<?php echo U('Mobile/Order/order_list'); ?>">
                                <span>全部订单</span>
                                <i class="Mright"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="floor floor_order">
                <ul>
                    <li>
                        <a href="<?php echo U('/Mobile/Order/order_list',array('type'=>'WAITPAY')); ?>">
                            <span><?php echo $user['waitPay']; ?></span>
                            <img src="__STATIC__/images/q1.png" alt="" />
                            <p>待付款</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('/Mobile/Order/wait_receive',array('type'=>'WAITRECEIVE')); ?>">
                            <span><?php echo $user['waitReceive']; ?></span>
                            <img src="__STATIC__/images/q2.png" alt="" />
                            <p>待收货</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Mobile/Order/comment',array('status'=>0)); ?>">
                            <span><?php echo $user['uncomment_count']; ?></span>
                            <img src="__STATIC__/images/q3.png" alt="" />
                            <p>待评价</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Mobile/Order/return_goods_list',array('type'=>1)); ?>">
                            <span><?php echo $user['return_count']; ?></span>
                            <img src="__STATIC__/images/q4.png" alt="" />
                            <p>退款/退货</p>
                        </a>
                    </li>
                </ul>
            </div>
            <!--订单管理模块-e-->

            <!--资金管理-s-->
            <div class="floor myorder ma-to-20 p">
                <div class="content30">
                    <div class="order">
                        <div class="fl">
                            <img src="__STATIC__/images/mwallet.png"/>
                            <span>我的钱包</span>
                        </div>
                        <div class="fr">
                            <!--<a href="bankrollmm.html">-->
                            <a href="<?php echo U('Mobile/User/account'); ?>">
                                <span>资金管理</span>
                                <i class="Mright"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="floor w3">
                <ul>
                    <li>
                        <a href="<?php echo U('Mobile/User/account'); ?>">
                            <h2><?php echo $user['user_money']; ?></h2>
                            <p>余额</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Mobile/User/coupon'); ?>">
                            <h2><?php echo $user['coupon_count']; ?></h2>
                            <p>优惠券</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Mobile/User/points_list'); ?>">
                            <h2><?php echo $user['pay_points']; ?></h2>
                            <p>积分</p>
                        </a>
                    </li>
                </ul>
            </div>
            <!--资金管理-e-->

            <div class="floor list7 ma-to-20">
                <if condition="$matmass_config['distribut_switch'] eq 1">
                    <div class="myorder p">
                        <div class="content30">
						<a href="javascript:void(0);" onclick="alert('请购买高级版支持哦!');">	
                                <div class="order">
                                    <div class="fl">
                                        <img src="__STATIC__/images/w1.png"/>
                                        <span>我的分销</span>
                                    </div>
                                    <div class="fr">
                                        <i class="Mright"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </if>
                <div class="myorder p">
                    <div class="content30">
					<a href="javascript:void(0);" onclick="alert('请购买高级版支持哦!');">	
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w10.png"/>
                                    <span>虚拟订单</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Order/team_list'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w4.png"/>
                                    <span>拼团订单</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/Order/comment',array('status'=>1)); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w2.png"/>
                                    <span>我的评价</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/Goods/integralMall'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w5.png"/>
                                    <span>积分商城</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/Activity/coupon_list'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w7.png"/>
                                    <span>领券中心</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/User/visit_log'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w3.png"/>
                                    <span>浏览历史</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
					<a href="javascript:void(0);" onclick="alert('请购买高级版支持哦!');">	
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w11.png"/>
                                    <span>签到</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/User/address_list'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w8.png"/>
                                    <span>地址管理</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!--
                <div class="myorder p">
                    <div class="content30">
                        <a href="">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w3.png"/>
                                    <span>我的预售</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w4.png"/>
                                    <span>我的拼团</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w6.png"/>
                                    <span>帮助中心</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w7.png"/>
                                    <span>意见反馈</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                -->
            </div>
        </div>
        <div class="setting">
            <div class="close">
                <a href="<?php echo U('Mobile/User/logout'); ?>" id="logout">安全退出</a>
            </div>
        </div>
    </div>

    <!--底部导航-start-->
    <include file="public/footer_nav"/>
    <!--底部导航-end-->
    <script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>