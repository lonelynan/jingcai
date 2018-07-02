<?php


return array(
    'system' => array('name' => '系统', 'child' => array(
        array('name' => '设置', 'child' => array(
            array('name' => '基本设置', 'act' => 'index', 'op' => 'System'),
            array('name' => '自定义导航栏', 'act' => 'navigationList', 'op' => 'System')
        )),
//        array('name' => '会员', 'child' => array(
//            array('name' => '会员列表', 'act' => 'index', 'op' => 'User')
//        )),
    /*    array('name' => '文章', 'child' => array(
            array('name' => '文章列表', 'act' => 'articleList', 'op' => 'Article'),
            array('name' => '文章分类', 'act' => 'categoryList', 'op' => 'Article'),
            array('name' => '专题列表', 'act' => 'topicList', 'op' => 'Topic'),
        )),*/
        array('name' => '权限', 'child' => array(
            array('name' => '管理员列表', 'act' => 'index', 'op' => 'Admin'),
//            array('name' => '角色管理', 'act' => 'role', 'op' => 'Admin'),
//            array('name' => '权限资源列表', 'act' => 'right_list', 'op' => 'System'),
            array('name' => '管理员日志', 'act' => 'log', 'op' => 'Admin'),
            //array('name' => '供应商列表', 'act'=>'supplier', 'op'=>'Admin'),
        )),

    )),
        'lottery' => array('name' => '活动设置', 'child' => array(
    array('name' => '活动内容', 'child' => array(

        array('name' => '猜胜负活动设置', 'act' => 'activitySettingsList', 'op' => 'ActivitySettings'),
        array('name' => '猜冠军活动设置', 'act' => 'activitySettingsChampionList', 'op' => 'ActivitySettingsChampion'),
        array('name' => '奖项阶梯', 'act' => 'activityStep', 'op' => 'ActivityStep'),
        array('name' => '竞猜名字', 'act' => 'activityTeamList', 'op' => 'ActivityTeam'),
       // array('name' => '奖项设置', 'act' => 'activityList', 'op' => 'ActivitySettings'),
    )),
    array('name' => '参与会员', 'child' => array(
        array('name' => '参与会员', 'act' => 'activityParticipationList', 'op' => 'ActivityParticipation'),
        array('name' => '竞猜记录', 'act' => 'activityCompResultList', 'op' => 'ActivityCompResult'),
        array('name' => '冠军竞猜记录', 'act' => 'activityCompResultChampionList', 'op' => 'ActivityCompResultChampion'),
       //array('name' => '中奖列表', 'act' => 'lottery_list', 'op' => 'ActivitySettings'),
        array('name' => '增加竞猜数据', 'act' => 'activityCompResultFalseList', 'op' => 'ActivityCompResultFalse')

    )),


))
);