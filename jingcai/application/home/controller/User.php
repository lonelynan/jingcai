<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 采用TP5助手函数可实现单字母函数M D U等,也可db::name方式,可双向兼容
 * ============================================================================
 * 2015-11-21
 */
namespace app\home\controller;
use app\common\logic\UsersLogic;
use think\Verify;
class User extends Base{

	public $user_id = 0;
	public $user = array();
	
    public function _initialize() {      
        parent::_initialize();
        if(cookie('is_mobile')==1){

            $this->redirect('/mobile');
        }
        if(session('?user'))
        {
        	$user = session('user');

            $user = db('users')->where("id", $user['id'])->find();
            session('user',$user);  //覆盖session 中的 user               
        	$this->user = $user;
        	$this->user_id = $user['id'];
        	$this->assign('user',$user); //存储用户信息
        	$this->assign('user_id',$this->user_id);
        }else{

        	$nologin = array(
        			'login','pop_login','do_login','logout','verify','set_pwd','finished',
        			'verifyHandle','reg','send_sms_reg_code','identity','check_validate_code',
                'forget_pwd', 'check_captcha', 'check_username', 'send_validate_code','bind_account','bind_guide','bind_reg','regjc'
        	);
        	if(!in_array(ACTION_NAME,$nologin)){
            $this->redirect('/home/user/login');
        		exit;
        	}
        }
    }

    /*
     * 用户中心首页
     */
    public function index(){
        $logic = new UsersLogic();
        $user = $logic->get_info($this->user_id);
        $user = $user['result'];
        $this->assign('user',$user);
        echo $this->user_id;
       // return $this->fetch();
    }


    public function logout(){
    	setcookie('uname','',time()-3600,'/');
    	setcookie('cn','',time()-3600,'/');
    	setcookie('user_id','',time()-3600,'/');
        setcookie('PHPSESSID','',time()-3600,'/');
        session_unset();
        session_destroy();
        //$this->success("退出成功",U('Home/Index/index'));
        $this->redirect('Home/Index/index');
        exit;
    }

    /**
     *  登录
     */
    public function login(){

        if($this->user_id > 0){
            $this->redirect('Home/User/index');
        }
        $referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url("Home/User/index");
        $this->assign('referurl',$referurl);

            //return $this->fetch();
        return $this->fetch("relogin");
    }

    public function do_login(){

        $username = trim(input('post.username'));
        $password = trim(input('post.password'));
    	$verify_code = input('post.verify_code');

        $verify = new Verify();
        if (!$verify->check($verify_code,'user_login'))
        {
             $res = array('status'=>0,'msg'=>'验证码错误');
             exit(json_encode($res));
        }

    	$logic = new UsersLogic();
    	$res = $logic->login($username,$password);

    	if($res['status'] == 1){
    		$res['url'] =  urldecode(input('post.referurl'));
    		session('user',$res['result']);
    		setcookie('user_id',$res['result']['id'],null,'/');
    		$nickname = empty($res['result']['nickname']) ? $username : $res['result']['nickname'];
            setcookie('uname',urlencode($nickname),null,'/');
            setcookie('cn',0,time()-3600,'/');
    	   	}
    	exit(json_encode($res));
    }
    /**
     *  注册
     */
    public function reg($t=''){
    	if($this->user_id > 0){
            $this->redirect('Home/User/index');
        }

        $reg_sms_enable = 1;
        $reg_smtp_enable = 1;
        if( $this->request->isPost()){

            $logic = new UsersLogic();
            //验证码检验
//            $this->verifyHandle('user_reg');

            $username = input('post.username','');
            $password = input('post.password','');
            $password2 = input('post.password2','');
            $code = input('post.code','');
            $scene = input('post.scene', 1);

            $session_id = session_id();
            //file_put_contents("a.txt",input());
            /*if(check_mobile($username)){
                if($reg_sms_enable){   //是否开启注册验证码机制
                    //手机功能没关闭
                    $check_code = $logic->check_validate_code($code, $username, 'phone', $session_id, $scene);
                    if($check_code['status'] != 1){
                        $this->error($check_code['msg']);
                    }
                }else{
                    if(!$this->verifyHandle('user_reg')){
                        $this->error('图像验证码错误');
                    };
                }
            }
            if(check_email($username)){
                if($reg_smtp_enable){        //是否开启注册邮箱验证码机制
                    //邮件功能未关闭
                    $check_code = $logic->check_validate_code($code, $username);
                    if($check_code['status'] != 1){
                        $this->error($check_code['msg']);
                    }
                }else{
                    if(!$this->verifyHandle('user_reg')){
                        $this->error('图像验证码错误');
                    };
                }
            }*/


            $data = $logic->reg($username,$password,$password2,0,'');
            if($data['status'] != 1){
                $this->ajaxReturn($data);
            }
            session('user',$data['result']);
    		setcookie('user_id',$data['result']['id'],null,'/');
            $nickname = empty($data['result']['nickname']) ? $username : $data['result']['nickname'];
            setcookie('uname',$nickname,null,'/');
            $this->ajaxReturn($data);
            exit;
        }

        $this->assign('reg_type',$t);
        //$this->assign('regis_sms_enable',tpCache('sms.regis_sms_enable')); // 注册启用短信：
       // $this->assign('regis_smtp_enable',tpCache('smtp.regis_smtp_enable')); // 注册启用邮箱：
       // $sms_time_out = tpCache('sms.sms_time_out')>0 ? tpCache('sms.sms_time_out') : 120;
        //$this->assign('sms_time_out', $sms_time_out); // 手机短信超时时间
        return $this->fetch();
    }
    public function regjc()
    {

        if (IS_POST) {
            $logic = new UsersLogic();
            //验证码检验
            //$this->verifyHandle('user_reg');
            $nickname = input('post.nickname', '');
            $username = input('post.username', '');
            //$username = input('post.mobile', '');
            $password = input('post.password', $username);
            $password2 = input('post.password2', $username);
            $is_bind_account = tpCache('basic.is_bind_account');
            //是否开启注册验证码机制
            $code = input('post.code', '');
            $scene = input('post.scene', 1);

            $session_id = session_id();

            //是否开启注册验证码机制
            if(check_mobile($username)){

                //手机功能没关闭
                $check_code = $logic->check_validate_code($code, $username, 'phone', $session_id, $scene);
                if($check_code['status'] != 1){
                    $this->ajaxReturn($check_code);
                }
            }
            $res = $logic->regjc($username, $password, $password2,0,0);

            if ($res['status'] == 1) {
                $res['url'] = urldecode(input('post.referurl'));
                session('user', $res['result']);
                setcookie('user_id', $res['result']['user_id'], null, '/');
                setcookie('is_distribut', $res['result']['is_distribut'], null, '/');
                $nickname = empty($res['result']['nickname']) ? $username : $res['result']['nickname'];
                setcookie('uname', urlencode($nickname), null, '/');
                setcookie('cn', 0, time() - 3600, '/');
            }
            if(session('asccode')){
                $data['share_coupon_validate']=0;
                $data['user_id']=session('user')['id'];
                $data['user_name']=session('user')['nickname'];
                $r = db('activity_comp_result')->where(['coupon_code'=>session('asccode'),'share_coupon_validate'=>1])->update($data);
                if($r)
                    session('asccode',null);
            }
            $res['result']="";
            exit(json_encode($res));
        }





        $navigation = db('navigation')->order('sort')->select();
        $this->assign('navigation', $navigation);
        if(!session('user')['mobile']) {
            $reg_sms_enable = tpCache('sms.regis_sms_enable');
            $reg_smtp_enable = tpCache('sms.regis_smtp_enable');
            $this->assign('regis_sms_enable',$reg_sms_enable); // 注册启用短信：
            $this->assign('regis_smtp_enable',$reg_smtp_enable); // 注册启用邮箱：
            $sms_time_out = tpCache('sms.sms_time_out')>0 ? tpCache('sms.sms_time_out') : 120;
            $this->assign('sms_time_out', $sms_time_out); // 手机短信超时时间
            $template="regjc";
        }else{
            return $this->redirect('/mobile');
        }

        return $this->fetch($template);
    }

    /*
     * 个人信息
     */
    public function info(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        if(IS_POST){
            I('post.nickname') ? $post['nickname'] = I('post.nickname') : false; //昵称
            I('post.qq') ? $post['qq'] = I('post.qq') : false;  //QQ号码
            I('post.head_pic') ? $post['head_pic'] = I('post.head_pic') : false; //头像地址
            I('post.sex') ? $post['sex'] = I('post.sex') : $post['sex'] = 0;  // 性别
            I('post.birthday') ? $post['birthday'] = strtotime(I('post.birthday')) : false;  // 生日
            I('post.province') ? $post['province'] = I('post.province') : false;  //省份
            I('post.city') ? $post['city'] = I('post.city') : false;  // 城市
            I('post.district') ? $post['district'] = I('post.district') : false;  //地区
            if(!$userLogic->update_info($this->user_id,$post))
                $this->error("保存失败");
            setcookie('uname',urlencode($post['nickname']),null,'/');
            $this->success("操作成功");
            exit;
        }
        $this->assign('user',$user_info);
        $this->assign('sex',config('SEX'));
        $this->assign('active','info');
        return $this->fetch();
    }

    /*
     * 邮箱验证
     */
    public function email_validate(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = I('get.step',1);
        if(IS_POST){
            $email = I('post.email');
            $old_email = I('post.old_email',''); //旧邮箱
            $code = I('post.code');
            $info = session('validate_code');
            if(!$info)
                $this->error('非法操作');
            if($info['time']<time()){
            	session('validate_code',null);
            	$this->error('验证超时，请重新验证');
            }
            //检查原邮箱是否正确
            if($user_info['email_validated'] == 1 && $old_email != $user_info['email'])
                $this->error('原邮箱匹配错误');
            //验证邮箱和验证码
            if($info['sender'] == $email && $info['code'] == $code){
                session('validate_code',null);
                if(!$userLogic->update_email_mobile($email,$this->user_id))
                    $this->error('邮箱已存在');
                $this->success('绑定成功',U('Home/User/index'));
                exit;
            }
            $this->error('邮箱验证码不匹配');
        }
        $this->assign('user_info',$user_info);
        $this->assign('step',$step);
        return $this->fetch();
    }


    /*
    * 手机验证
    */
    public function mobile_validate()
    {
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); //获取用户信息
        $user_info = $user_info['result'];
        $config = tpCache('sms');
        $sms_time_out = $config['sms_time_out'];
        $step = I('get.step', 1);
        if (IS_POST) {
            $mobile = I('post.mobile');
            $old_mobile = I('post.old_mobile');
            $code = I('post.code');
            $scene = I('post.scene', 6);
            $session_id = I('unique_id', session_id());

            $logic = new UsersLogic();
            $res = $logic->check_validate_code($code, $mobile, 'phone', $session_id, $scene);

            if (!$res && $res['status'] != 1) $this->error($res['msg']);

            //检查原手机是否正确
            if ($user_info['mobile_validated'] == 1 && $old_mobile != $user_info['mobile'])
                $this->error('原手机号码错误');
            //验证手机和验证码

            if ($res['status'] == 1) {
                //验证有效期
                if (!$userLogic->update_email_mobile($mobile, $this->user_id, 2))
                    $this->error('手机已存在');
                $this->success('绑定成功', U('Home/User/index'));
                exit;
            } else {
                $this->error($res['msg']);
            }

        }
        $this->assign('time', $sms_time_out);
        $this->assign('step', $step);
        $this->assign('user_info', $user_info);
        return $this->fetch();
    }


    /*
     * 密码修改
     */
    public function password(){
        //检查是否第三方登录用户
        $logic = new UsersLogic();
        $data = $logic->get_info($this->user_id);
        $user = $data['result'];
        if($user['mobile'] == ''&& $user['email'] == '')
            $this->error('请先绑定手机或邮箱',U('Home/User/info'));
        if(IS_POST){
            $userLogic = new UsersLogic();
            $data = $userLogic->password($this->user_id,I('post.old_password'),I('post.new_password'),I('post.confirm_password')); // 获取用户信息
            if($data['status'] == -1)
                $this->error($data['msg']);
            $this->success($data['msg']);
            exit;
        }
        return $this->fetch();
    }

    public function forget_pwd()
    {
        if ($this->user_id > 0) {
            header("Location: " . U('Home/User/Index'));
        }
        if (IS_POST) {
            $username = I('username');
            if (!empty($username)) {
                $field = 'mobile';
                if (check_email($username)) {
                    $field = 'email';
                }
                $user = M('users')->where("email", $username)->whereOr('mobile', $username)->find();
                
                if ($user) {
                    session('find_password', array('user_id' => $user['user_id'], 'username' => $username,
                        'email' => $user['email'], 'mobile' => $user['mobile'], 'type' => $field));
                    header("Location: " . U('User/identity'));
                    exit;
                } else {
                   echo "用户名不存在，请检查";
                    $this->error("用户名不存在，请检查");
                }
            }
        }
        return $this->fetch();
    }
    
    public function set_pwd(){
    	if($this->user_id > 0){
            $this->redirect('Home/User/Index');
    	}
    	$check = session('validate_code');
    	$logic = new UsersLogic();
    	if(empty($check)){
            $this->redirect('Home/User/forget_pwd');
    	}elseif($check['is_check']==0){
    		$this->error('验证码还未验证通过',U('Home/User/forget_pwd'));
    	}    	
    	if(IS_POST){
    		$password = I('post.password');
    		$password2 = I('post.password2');
    		if($password2 != $password){
    			$this->error('两次密码不一致',U('Home/User/forget_pwd'));
    		}
    		if($check['is_check']==1){
    			//$user = get_user_info($check['sender'],1);
                $user = M('users')->where("mobile|email", '=', $check['sender'])->find();
    			M('users')->where("user_id", $user['user_id'])->save(array('password'=>encrypt($password)));
    			session('validate_code',null);
                $this->redirect('Home/User/finished');
    		}else{
    			$this->error('验证码还未验证通过',U('Home/User/forget_pwd'));
    		}
    	}
    	return $this->fetch();
    }
    
    public function finished(){
    	if($this->user_id > 0){
            $this->redirect('Home/User/Index');
    	}
    	return $this->fetch();
    }
    public function check_captcha(){
    	$verify = new Verify();
    	$type = I('post.type','user_login');
    	if (!$verify->check(I('post.verify_code'), $type)) {
    		exit(json_encode(0));
    	}else{
    		exit(json_encode(1));
    	}
    }
    
    public function check_username(){
    	$username = I('post.username');
    	if(!empty($username)){
    		$count = M('users')->where("email", $username)->whereOr('mobile', $username)->count();
    		exit(json_encode(intval($count)));
    	}else{
    		exit(json_encode(0));
    	}  	
    }

    public function identity()
    {
        if ($this->user_id > 0) {
            header("Location: " . U('Home/User/Index'));
        }
        $user = session('find_password');
        if (empty($user)) {
            $this->error("请先验证用户名", U('User/forget_pwd'));
        }
        $this->assign('userinfo', $user);
        return $this->fetch();
    }
      
    /**
     * 验证码验证
     * $id 验证码标示
     */
    private function verifyHandle($id)
    {
        $verify = new Verify();
        $result = $verify->check(I('post.verify_code'), $id ? $id : 'user_login');
        if (!$result) {
            return false;
        }else{
            return true;
        }
    }

    /**
     * 验证码获取
     */
    public function verify()
    {
        //验证码类型
        $type = input('get.type') ? input('get.type') : 'user_login';
        $config = array(
            'fontSize' => 40,
            'length' => 4,
            'useCurve' => true,
            'useNoise' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry($type);
		exit();
    }
}