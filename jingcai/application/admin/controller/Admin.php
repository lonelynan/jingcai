<?php


namespace app\admin\controller;

use think\Page;
use think\Verify;
use think\Db;
use think\Session;

class Admin extends Base {

    public function index(){
    	$list = array();
    	$keywords = input('keywords/s');
    	if(empty($keywords)){
    		$res = db('admin')->select();
    	}else{
			$res = DB::name('admin')->where('user_name','like','%'.$keywords.'%')->order('admin_id')->select();
    	}
    	$role = db('admin_role')->field('role_id,role_name')->select();


    	if($res && $role){
    		foreach ($res as $val){
    			$val['role'] =  $val['role_id'];
    			$val['add_time'] = date('Y-m-d H:i:s',$val['add_time']);
    			$list[] = $val;
    		}
    	}

    	$this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 修改管理员密码
     * @return \think\mixed
     */
    public function modify_pwd(){
        $admin_id = input('admin_id/d',0);
        $oldPwd = input('old_pw/s');
        $newPwd = input('new_pw/s');
        $new2Pwd = input('new_pw2/s');

        if($admin_id){
            $info = db('admin')->where("admin_id", $admin_id)->find();
            $info['password'] =  "";
            $this->assign('info',$info);
        }

         if(IS_POST){
            //修改密码
            $enOldPwd = encrypt($oldPwd);
            $enNewPwd = encrypt($newPwd);
            $admin = db('admin')->where('admin_id' , $admin_id)->find();
            if(!$admin || $admin['password'] != $enOldPwd){
                exit(json_encode(array('status'=>-1,'msg'=>'旧密码不正确')));
            }else if($newPwd != $new2Pwd){
                exit(json_encode(array('status'=>-1,'msg'=>'两次密码不一致')));
            }else{
                $row = db('admin')->where('admin_id' , $admin_id)->save(array('password' => $enNewPwd));
                if($row){
                    exit(json_encode(array('status'=>1,'msg'=>'修改成功')));
                }else{
                    exit(json_encode(array('status'=>-1,'msg'=>'修改失败')));
                }
            }
        }
        return $this->fetch();
    }

    public function admin_info($admin_id=''){
    	//$admin_id = input('get.admin_id/d',0);

    	if($admin_id){
    		$info = db('admin')->where("admin_id", $admin_id)->find();
			$info['password'] =  "";
    		$this->assign('info',$info);
    	}
    	$act = empty($admin_id) ? 'add' : 'edit';
    	$this->assign('act',$act);
    	$role = db('admin_role')->select();

    	$this->assign('role',$role);
    	return $this->fetch();
    }

    public function adminHandle(){
    	$data = input('post.');
    	if(empty($data['password'])){
    		unset($data['password']);
    	}else{
    		$data['password'] = encrypt($data['password']);
    	}
    	if($data['act'] == 'add'){
    		unset($data['admin_id']);
    		$data['add_time'] = time();
    		if(db('admin')->where("user_name", $data['user_name'])->count()){
    			$this->error("此用户名已被注册，请更换",url('Admin/Admin/admin_info'));
    		}else{
    			$r = db('admin')->insert($data);
    		}
    	}

    	if($data['act'] == 'edit'){
    		$r = db('admin')->where('admin_id', $data['admin_id'])->update($data);
    	}

        if($data['act'] == 'del' && $data['admin_id']>1){
    		$r = db('admin')->where('admin_id', $data['admin_id'])->delete();
    		exit(json_encode(1));
    	}

    	if($r){
    		$this->success("操作成功",url('Admin/Admin/index'));
    	}else{
    		$this->error("操作失败",url('Admin/Admin/index'));
    	}
    }


    /*
     * 管理员登陆
     */
    public function login(){

        if(session('?admin_id') && session('admin_id')>0){
             $this->error("您已登录",url('Admin/Index/index'));
        }

        if(IS_POST){

            $verify = new Verify();
            if (!$verify->check(input('post.vertify'), "admin_login")) {

            	exit(json_encode(array('status'=>0,'msg'=>'验证码错误')));
            }

            $condition['user_name'] = input('post.username/s');
            $condition['password'] = input('post.password/s');
//            $condition['user_name'] = "admin";
//            $condition['password'] = "admin123";

            if(!empty($condition['user_name']) && !empty($condition['password'])){
                $condition['password'] = encrypt($condition['password']);
                	$admin_info = db('admin')->join(PREFIX.'admin_role', PREFIX.'admin.role_id='.PREFIX.'admin_role.role_id','INNER')->where($condition)->find();
                if(is_array($admin_info)){
                    session('admin_id',$admin_info['admin_id']);
                    session('act_list',$admin_info['act_list']);
                    db('admin')->where("admin_id = ".$admin_info['admin_id'])->update(array('last_login'=>time(),'last_ip'=>  request()->ip()));
                    session('last_login_time',$admin_info['last_login']);
                    session('last_login_ip',$admin_info['last_ip']);
                    adminLog('后台登录');
                    $url = session('from_url') ? session('from_url') : url('Admin/Index/index');
                    exit(json_encode(array('status'=>1,'url'=>$url)));
                }else{
                    exit(json_encode(array('status'=>0,'msg'=>'账号密码不正确')));
                }
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'请填写账号密码')));
            }
        }

       return $this->fetch();
    }

    /**
     * 退出登陆
     */
    public function logout(){
        session_unset();
        session_destroy();
		session::clear();
        $this->success("退出成功",url('Admin/Admin/login'));
    }

    /**
     * 验证码获取
     */
    public function vertify()
    {
        $config = array(
            'fontSize' => 30,
            'length' => 4,
            'useCurve' => true,
            'useNoise' => false,
        	'reset' => false
        );
        $Verify = new Verify($config);
        $Verify->entry("admin_login");
        exit();
    }

    public function role(){
    	$list = db('admin_role')->order('role_id desc')->select();
    	$this->assign('list',$list);
    	return $this->fetch();
    }

    public function role_info($role_id=''){
    	//$role_id = input('get.role_id/d');
    	$detail = array();
    	if($role_id){
    		$detail = db('admin_role')->where("role_id",$role_id)->find();
    		$detail['act_list'] = explode(',', $detail['act_list']);
    		$this->assign('detail',$detail);
    	}
		$right = db('system_menu')->order('id')->select();
		foreach ($right as $val){
			if(!empty($detail)){
				$val['enable'] = in_array($val['id'], $detail['act_list']);
			}
			$modules[$val['group']][] = $val;
		}
		//权限组
		$group = array('system'=>'系统设置','content'=>'内容管理','goods'=>'商品中心','member'=>'会员中心',
				'order'=>'订单中心','marketing'=>'营销推广','tools'=>'插件工具','count'=>'统计报表'
		);
		$this->assign('group',$group);
		$this->assign('modules',$modules);
    	return $this->fetch();
    }

    public function roleSave(){
    	$data = input('post.');
    	$res = $data['data'];
    	$res['act_list'] = is_array($data['right']) ? implode(',', $data['right']) : '';
        if(empty($res['act_list']))
            $this->error("请选择权限!");
    	if(empty($data['role_id'])){
			$admin_role = Db::name('admin_role')->where(['role_name'=>$res['role_name']])->find();
			if($admin_role){
				$this->error("已存在相同的角色名称!");
			}else{
				$r = db('admin_role')->insertGetId($res);
			}
    	}else{
			$admin_role = Db::name('admin_role')->where(['role_name'=>$res['role_name'],'role_id'=>['<>',$data['role_id']]])->find();
			if($admin_role){
				$this->error("已存在相同的角色名称!");
			}else{
				$r = db('admin_role')->where('role_id', $data['role_id'])->insertGetId($res);
			}
    	}
		if($r){
			adminLog('管理角色');
			$this->success("操作成功!",url('Admin/Admin/role_info',array('role_id'=>$data['role_id'])));
		}else{
			$this->error("操作失败!",url('Admin/Admin/role'));
		}
    }

    public function roleDel(){
    	$role_id = input('post.role_id/d');
    	$admin = db('admin')->where('role_id',$role_id)->find();
    	if($admin){
    		exit(json_encode("请先清空所属该角色的管理员"));
    	}else{
    		$d = db('admin_role')->where("role_id", $role_id)->delete();
    		if($d){
    			exit(json_encode(1));
    		}else{
    			exit(json_encode("删除失败"));
    		}
    	}
    }

    public function log(){
    	$p = input('p/d',1);
    	$logs = DB::name('admin_log')->alias('l')->join('__ADMIN__ a','a.admin_id =l.admin_id')->order('log_time DESC')->page($p.',20')->select();
    	$this->assign('list',$logs);
    	$count = DB::name('admin_log')->count();
    	$Page = new Page($count,20);
    	$show = $Page->show();
		$this->assign('pager',$Page);
		$this->assign('page',$show);
    	return $this->fetch();
    }




}