<?php

namespace app\home\Controller;

use think\Controller;
use think\Db;
use think\Wechat;

class Demo extends Controller
{
    function menu(){


//        $options = array(
//            'token' => '7ucYstn1qcOstDJHaZtYN', //填写你设定的key
//            'encodingaeskey' => 'encodingaeskey', //填写加密用的EncodingAESKey，如接口为明文模式可忽略
//            'appid' => 'wxb889c7e461d57aa4',
//            'appsecret' => '12811267ea2a29f7a0210aa5d7175ec7'
//        );
        $options = array(
            'token' => '7ucYstn1qcOstDJHaZtYN', //填写你设定的key
            'encodingaeskey' => 'encodingaeskey', //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            'appid' => 'wx6682f473f392a22d',
            'appsecret' => '8231e0ca36c36eeef96dc8fd3bf208cd'
        );

        $weObj = new Wechat($options);
           //获取菜单操作:
         //  $menu = $weObj->getMenu();
           //设置菜单
           $newmenu =  array(
    		"button"=>
    			array(
    				array('type'=>'view','name'=>'1','url'=>'http://kajuan.lonelynan.cn/home/index/close'),
    				array('name'=>'测试','sub_button'=>array(
                         array('type'=>'view','name'=>'咨询','url'=>'http://kajuan.lonelynan.cn/mobile/article/artlelist'),
                        array('type'=>'view','name'=>'2','url'=>'http://kajuan.lonelynan.cn/home/index/close'))),
                       array('name'=>'个人中心','sub_button'=>array(
                        array('type'=>'view','name'=>'账号','url'=>'http://kajuan.lonelynan.cn/mobile/user/bindmobile'),
                        array('type'=>'view','name'=>'客服','url'=>'http://kajuan.lonelynan.cn/home/index/close'),
                        array('type'=>'view','name'=>'关注','url'=>'http://kajuan.lonelynan.cn/home/index/close'))),
));

    $result = $weObj->createMenu($newmenu);
}
    function test()
    {

        //include "/wechat.class.php";
        //import('library.Wechat',EXTEND_PATH,'.class.php');
        // import('@.library.Wechat');
        $strText = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\r\n";

        $body = @file_get_contents('php://input');
        file_put_contents("log.txt", $body."------\r\n".$strText."\r\n", FILE_APPEND);
        $options = array(
            'token' => '7ucYstn1qcOstDJHaZtYN', //填写你设定的key
            'encodingaeskey' => 'encodingaeskey' //填写加密用的EncodingAESKey，如接口为明文模式可忽略
        );

        $weObj = new Wechat($options);
        $weObj->valid();//明文或兼容模式可以在接口验证通过后注释此句，但加密模式一定不能注释，否则会验证失败
        $type = $weObj->getRev()->getRevType();
        $data = $weObj->getRev()->getRevData();


        switch ($type) {
            case Wechat::MSGTYPE_TEXT:
                $search = $data['Content'];
                $equipment_array=array();

                $where = ['ch_name' => ['like', '%' . $search . '%']];

                $equipment = db::connect('DB_Config_1')->name("mat_equipment")
                    ->where($where)
                    ->paginate(8);
                foreach ($equipment as $key=>$v) {
                    if($key==0){
                        $equipment_array[$key]['Title']="查看更多设备";
                        $equipment_array[$key]['Description']="";
                        $equipment_array[$key]['PicUrl']='http://image.sgst.cn/INSTRU/instrument201607.jpg';
                        $equipment_array[$key]['Url']="http://wx.matmass.com";
                    }else{
                        $equipment_array[$key]['Title']=$v['ch_name'];
                        $equipment_array[$key]['Description']="";
                        $equipment_array[$key]['PicUrl']='http://image.sgst.cn/INSTRU/42500858-5%E7%A7%91%E5%8F%91556.jpg';
                        $equipment_array[$key]['Url']="http://wx.matmass.com/home/equipment/getEquipmentDetailed/id/".$v['id'];
                    }

                }

                $weObj->news($equipment_array )->reply();

               /* if (is_numeric(strpos($data['Content'], "设备"))) {
                    $weObj->text("您是要查找设备数据库吗？<a href='wx.matmass.com'>进入</a>")->reply();
                }*/
                exit;
                break;
            case Wechat::MSGTYPE_EVENT:
                $weObj->text("文本待开放")->reply();
                exit;
                break;
            case Wechat::MSGTYPE_IMAGE:

           /*     $weObj->news(array(

                    "0" => array(
                        'Title' => '1动态机械分析仪.差示扫描量热仪',
                        'Description' => 'summary text',
                        'PicUrl' => 'http://image.sgst.cn/INSTRU/42500858-5%E7%A7%91%E5%8F%91556.jpg',
                        'Url' => 'http://wx.matmass.com/home/equipment/getEquipmentDetailed/id/87448.shtml'
                    ), "1" => array(
                        'Title' => '蠕变试验机',
                        'Description' => 'summary text',
                        'PicUrl' => 'http://image.sgst.cn/INSTRU/42500858-54ZJ6191.jpg',
                        'Url' => 'http://wx.matmass.com/home/equipment/getEquipmentDetailed/id/87450.shtml'

                    ), "2" => array(
                        'Title' => '蠕变试验机',
                        'Description' => 'summary text',
                        'PicUrl' => 'http://image.sgst.cn/INSTRU/42500858-54ZJ6191.jpg',
                        'Url' => 'http://wx.matmass.com/home/equipment/getEquipmentDetailed/id/87450.shtml'

                    )))->reply();*/
                exit;
                break;
            case Wechat::MSGTYPE_VOICE:

                $data_voice = $weObj->getRev()->getRevContent();


                 $search = substr($data_voice,0,strlen($data_voice)-3);

                    $equipment_array=array();

                    $where = ['ch_name' => ['like', '%' . $search . '%']];

                    $equipment = db::connect('DB_Config_1')->name("mat_equipment")
                        ->where($where)
                        ->paginate(8);

                if(count($equipment)!=0){

                    foreach ($equipment as $key=>$v) {
                        if($key==0){
                            $equipment_array[$key]['Title']="查看更多设备";
                            $equipment_array[$key]['Description']="";
                            $equipment_array[$key]['PicUrl']='http://image.sgst.cn/INSTRU/instrument201607.jpg';
                            $equipment_array[$key]['Url']="http://wx.matmass.com";
                        }else{
                            $equipment_array[$key]['Title']=$v['ch_name'];
                            $equipment_array[$key]['Description']="";
                            $equipment_array[$key]['PicUrl']='http://image.sgst.cn/INSTRU/42500858-5%E7%A7%91%E5%8F%91556.jpg';
                            $equipment_array[$key]['Url']="http://wx.matmass.com/home/equipment/getEquipmentDetailed/id/".$v['id'];
                        }

                    }

                    $weObj->news($equipment_array )->reply();

                }else{
                    $weObj->text("您搜索的设备名：" . $data_voice."没有找到")->reply();
                }

                exit;
                break;
            default:
                $weObj->text("")->reply();
        }
    }


}
