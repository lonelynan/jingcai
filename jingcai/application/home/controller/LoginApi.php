<?php

namespace app\home\controller;
use app\common\logic\UsersLogic;
use app\common\logic\CartLogic;
class LoginApi extends Base {
    public $config;
    public $oauth;
    public $class_obj;

    public function __construct($oauth=''){

        parent::__construct();
        session('?user');
        $this->oauth = $oauth;
        //获取配置
        $data = db('plugin')->where("code",$this->oauth)->where("type","login")->find();
     
        $this->config = unserialize($data['config_value']); // 配置反序列化
    
   if(!$this->oauth)
           $this->error('非法操作',url('User/login'));
        include_once  "plugins/login/{$this->oauth}/{$this->oauth}.class.php";

        $class = '\\'.$this->oauth; //
        new $class($this->config);
        $this->class_obj = new $class($this->config); //实例化对应的登陆插件
    }

    public function login(){
        if(!$this->oauth)
            $this->error('非法操作',U('User/login'));
        include_once  "plugins/login/{$this->oauth}/{$this->oauth}.class.php";

        $this->class_obj->login();
    }

    public function callback()
    {
        $data = $this->class_obj->respon();
       
        $logic = new UsersLogic();
        $data = $logic->thirdLogin($data);
        if ($data['status'] != 1){
            $this->error($data['msg']);
        }
        session('user', $data['result']);
        setcookie('user_id', $data['result']['id'], null, '/');
        $nickname = empty($data['result']['nickname']) ? '第三方用户' : $data['result']['nickname'];
        setcookie('uname', urlencode($nickname), null, '/');
        setcookie('cn', 0, time() - 3600, '/');
        if (isMobile()){
            $this->success('登陆成功', url('Home/index/index'));
        }else{
             $this->success('登陆成功', url('Home/index/index'));
        }
     
        
    }
}
