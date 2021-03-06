<?php
namespace app\home\controller;
use think\Controller;
use think\Db;
use think\Session;

class Base extends Controller {
    public $session_id;
    public $cateTrre = array();
    /*
     * 初始化操作
     */
    public function _initialize() {

        if (input("unique_id")) {           // 兼容手机app
            session_id(input("unique_id"));
            Session::start();
        }
        header("Cache-control: private");  // history.back返回后输入框值丢失问题 参考文章 http://www.tp-shop.cn/article_id_1465.html  http://blog.csdn.net/qinchaoguang123456/article/details/29852881
        $this->session_id = session_id(); // 当前的 session_id
        define('SESSION_ID',$this->session_id); //将当前的session_id保存为常量，供其它方法调用

        // 判断当前用户是否手机
        //
        if(isMobile())
            cookie('is_mobile','1',3600);
        else
            cookie('is_mobile','0',3600);

        $this->public_assign();
    }

    /**
     * 保存公告变量到 smarty中 比如 导航
     */
    public function public_assign()
    {

        $matmass_config = array();
        $mat_config = db('config')->select();
        foreach($mat_config as $k => $v)
        {
            if($v['name'] == 'hot_keywords'){
                $matmass_config['hot_keywords'] = explode('|', $v['value']);
            }
            $matmass_config[$v['inc_type'].'_'.$v['name']] = $v['value'];
        }

        $navigation=db('navigation')->order('sort')->select();
        $this->assign('matmass_config', $matmass_config);
        $this->assign('navigation', $navigation);
        $user = session('user');
        $this->assign('username',$user['nickname']);
    }

    /*
     *
     */
    public function ajaxReturn($data)
    {
        exit(json_encode($data));
    }
}