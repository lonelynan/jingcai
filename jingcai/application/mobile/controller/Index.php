<?php
namespace app\mobile\controller;
use app\common\logic\JssdkLogic;
use app\mobile\controller\base\Base;
use Think\Db;
class Index extends Base {

    public function index(){
        if(cookie('is_mobile')==0){

            $this->redirect('/');
        }
        db('config')->where(['name'=>'visit_count'])->setInc('value');
        /*guessing competition
            //获取微信配置
            $wechat_list = db('wx_user')->select();
            $wechat_config = $wechat_list[0];
            $this->weixin_config = $wechat_config;
            // 微信Jssdk 操作类
            $jssdk = new \Mobile\Logic\Jssdk($this->weixin_config['appid'], $this->weixin_config['appsecret']);
            $signPackage = $jssdk->GetSignPackage();
            print_r($signPackage);
        */
        if(!session('user')){
            return $this->redirect('/mobile/user/regjc');

        }
        $navigation = db('navigation')->order('sort')->select();
        $this->assign('navigation', $navigation);
        return $this->fetch();
    }

    /**
     * 分类列表显示
     */
    public function categoryList(){
        return $this->fetch();
    }

    /**
     * 模板列表
     */
    public function mobanlist(){
        $arr = glob("D:/wamp/www/svn_tpshop/mobile--html/*.html");
        foreach($arr as $key => $val)
        {
            $html = end(explode('/', $val));
            echo "<a href='http://www.php.com/svn_tpshop/mobile--html/{$html}' target='_blank'>{$html}</a> <br/>";            
        }        
    }

    //微信Jssdk 操作类
    public function ajaxGetWxConfig(){
    	$askUrl = input('askUrl');//分享URL
    	$weixin_config = db('wx_user')->find(); //获取微信配置
    	$jssdk = new JssdkLogic($weixin_config['appid'], $weixin_config['appsecret']);
    	$signPackage = $jssdk->GetSignPackage(urldecode($askUrl));

    	if($signPackage){
    		$this->ajaxReturn($signPackage,'JSON');
    	}else{
    		return false;
    	}
    }
       
}