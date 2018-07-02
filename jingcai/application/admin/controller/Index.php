<?php

namespace app\admin\controller; 
use think\AjaxPage;
use think\Controller;
use think\Url;
use think\Config;
use think\Page;
use think\Verify;
use think\Db;
class Index extends Base {

    public function index(){

        $act_list = session('act_list');
        $menu_list = getMenuList($act_list);         
        $this->assign('menu_list',$menu_list);//view
        $admin_info = getAdminInfo(session('admin_id'));
        $this->assign('admin_info',$admin_info);             
        $this->assign('menu',getMenuArr());   //view2
        return $this->fetch();
    }
   
    public function welcome(){
    	$this->assign('sys_info',$this->get_sys_info());
//    	$today = strtotime("-1 day");
    	$today = strtotime(date("Y-m-d"));

        $count['visit_count'] =  db('config')->where(['name'=>'visit_count'])->find()['value'];
    	$count['article'] =  db('article')->where("1=1")->count();//文章总数
    	$count['users'] = db('users')->where("1=1")->count();//会员总数
    	$count['today_login'] = db('users')->where("last_login>=$today")->count();//今日访问
    	$count['new_users'] = db('users')->where("reg_time>=$today")->count();//新增会员
    	$this->assign('count',$count);
        return $this->fetch();
    }
    
    public function get_sys_info(){

		$sys_info['os']             = PHP_OS;
		$sys_info['zlib']           = function_exists('gzclose') ? 'YES' : 'NO';//zlib
		$sys_info['safe_mode']      = (boolean) ini_get('safe_mode') ? 'YES' : 'NO';//safe_mode = Off		
		$sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
		$sys_info['curl']			= function_exists('curl_init') ? 'YES' : 'NO';	
		$sys_info['web_server']     = $_SERVER['SERVER_SOFTWARE'];
		$sys_info['phpv']           = phpversion();
		$sys_info['ip'] 			= GetHostByName($_SERVER['SERVER_NAME']);
		$sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
		$sys_info['max_ex_time'] 	= @ini_get("max_execution_time").'s'; //脚本最大执行时间
		$sys_info['set_time_limit'] = function_exists("set_time_limit") ? true : false;
		$sys_info['domain'] 		= $_SERVER['HTTP_HOST'];
		$sys_info['memory_limit']   = ini_get('memory_limit');
        $sys_info['mysql_version']=db::query('SELECT VERSION() as mysql_version')[0]['mysql_version'];
        $sys_info['gdinfo']="";
		return $sys_info;
    }

    /**
     * ajax 修改指定表数据字段  一般修改状态 比如 是否推荐 是否开启 等 图标切换的
     * table,id_name,id_value,field,value
     */
    public function changeTableVal(){  
            $table = I('table'); // 表名
            $id_name = I('id_name'); // 表主键id名
            $id_value = I('id_value'); // 表主键id值
            $field  = I('field'); // 修改哪个字段
            $value  = I('value'); // 修改字段值                        
            db($table)->where("$id_name = $id_value")->insert(array($field=>$value)); // 根据条件保存修改的数据
    }	    

    public function about(){
    	return $this->fetch();
    }
}