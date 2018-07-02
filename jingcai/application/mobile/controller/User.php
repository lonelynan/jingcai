<?php
namespace app\mobile\controller;

use app\common\logic\MessageLogic;
use app\common\logic\UsersLogic;
use app\mobile\controller\base\Base;
use think\Page;
use think\Request;
use think\Verify;
use think\db;

class User extends Base
{

    public $user_id = 0;
    public $user = array();

    /*
    * 初始化操作
    */
    public function _initialize()
    {
        parent::_initialize();
        if(cookie('is_mobile')==0){

            $this->redirect('/');
        }
        if (session('?user')) {
            $user = session('user');
            $user = db('users')->where("id", $user['id'])->find();
            session('user', $user);  //覆盖session 中的 user
            $this->user = $user;
            $this->user_id = $user['id'];
            $this->assign('user', $user); //存储用户信息
        }
//        $nologin = array(
//            'login', 'pop_login', 'do_login', 'logout', 'verify', 'set_pwd', 'finished','regphone',
//            'verifyHandle', 'reg', 'send_sms_reg_code', 'find_pwd', 'check_validate_code',
//            'forget_pwd', 'check_captcha', 'check_username', 'send_validate_code', 'express' , 'bind_guide', 'bind_account',
//            'regjc'
//        );
        $nologin = array(
                        'regjc'
        );
        $is_bind_account = tpCache('basic.is_bind_account');
        if (!$this->user_id && !in_array(ACTION_NAME, $nologin)) {
            if(strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') && $is_bind_account){
                header("location:" . url('Mobile/User/bind_guide'));//微信浏览器, 调到绑定账号引导页面
            }else{
             //   header("location:" . url('Mobile/User/login'));
            }
            exit;
        }

    }

    /*
     * 用户中心首页
     */
    public function index()
    {
        $user_id =$this->user_id;
        $logic = new UsersLogic();
        $user = $logic->get_info($user_id); //当前登录用户信息
        $this->assign('user',$user['result']);
        return $this->fetch();
    }


    public function logout()
    {
        session_unset();
        session_destroy();
        setcookie('uname','',time()-3600,'/');
        setcookie('cn','',time()-3600,'/');
        setcookie('user_id','',time()-3600,'/');
        setcookie('PHPSESSID','',time()-3600,'/');
        //$this->success("退出成功",url('Mobile/Index/index'));
        header("Location:" . url('Mobile/Index/index'));
        exit();
    }


    /**
     *  登录
     */
    public function login()
    {
        if ($this->user_id > 0) {
//
//            header("Location: " . url('Mobile/User/index'));
        }
        $referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url("Mobile/User/index");
        $this->assign('referurl', $referurl);
        return $this->fetch();
    }

    /**
     * 登录
     */
    public function do_login()
    {
        $username = trim(input('post.username'));
        $password = trim(input('post.password'));
        //验证码验证
        if (isset($_POST['verify_code'])) {
            $verify_code = input('post.verify_code');
            $verify = new Verify();
            if (!$verify->check($verify_code, 'user_login')) {
                $res = array('status' => 0, 'msg' => '验证码错误');
                exit(json_encode($res));
            }
        }
        $logic = new UsersLogic();
        $res = $logic->login($username, $password);
        if ($res['status'] == 1) {
            $res['url'] = urldecode(input('post.referurl'));
            session('user', $res['result']);
            setcookie('user_id', $res['result']['user_id'], null, '/');
            setcookie('is_distribut', $res['result']['is_distribut'], null, '/');
            $nickname = empty($res['result']['nickname']) ? $username : $res['result']['nickname'];
            setcookie('uname', urlencode($nickname), null, '/');
            setcookie('cn', 0, time() - 3600, '/');
        }
        exit(json_encode($res));
    }

    /**
     *  注册
     */
    public function reg()
    {

        if($this->user_id > 0) {
            $this->redirect(url('Mobile/User/index'));
        }
        $reg_sms_enable = tpCache('sms.regis_sms_enable');
        $reg_smtp_enable = tpCache('sms.regis_smtp_enable');

        if (IS_POST) {
            $logic = new UsersLogic();
            //验证码检验
            //$this->verifyHandle('user_reg');
            $nickname = input('post.nickname', '');
            $username = input('post.username', '');
            $password = input('post.password', '');
            $password2 = input('post.password2', '');
            $is_bind_account = tpCache('basic.is_bind_account');
            //是否开启注册验证码机制
            $code = input('post.mobile_code', '');
            $scene = input('post.scene', 1);
            
            $session_id = session_id();

            //是否开启注册验证码机制
            if(check_mobile($username)){
                if($reg_sms_enable){
                    //手机功能没关闭
                    $check_code = $logic->check_validate_code($code, $username, 'phone', $session_id, $scene);
                    if($check_code['status'] != 1){
                        $this->ajaxReturn($check_code);
                    }
                }
            }
            //是否开启注册邮箱验证码机制
            if(check_email($username)){
                if($reg_smtp_enable){
                    //邮件功能未关闭
                    $check_code = $logic->check_validate_code($code, $username);
                    if($check_code['status'] != 1){
                        $this->ajaxReturn($check_code);
                    }
                }
            }
            
            $invite = input('invite');
            if(!empty($invite)){
                $invite = get_user_info($invite,2);//根据手机号查找邀请人
            }else{
                $invite = array();
            }
            
            if($is_bind_account && session("third_oauth")){ //绑定第三方账号
                $thirdUser = session("third_oauth");
                $head_pic = $thirdUser['head_pic'];
                $data = $logic->reg($username, $password, $password2, 0, $invite ,$nickname , $head_pic);
                //用户注册成功后, 绑定第三方账号
                $userLogic = new UsersLogic();
                $data = $userLogic->oauth_bind_new($data['result']);
            }else{
                $data = $logic->reg($username, $password, $password2,0,$invite);
            }
             
            
            if ($data['status'] != 1) $this->ajaxReturn($data);
            
            //获取公众号openid,并保持到session的user中
            $oauth_users = db('OauthUsers')->where(['user_id'=>$data['result']['user_id'] , 'oauth'=>'weixin' , 'oauth_child'=>'mp'])->find();
            $oauth_users && $data['result']['open_id'] = $oauth_users['open_id'];
            
            session('user', $data['result']);
            setcookie('user_id', $data['result']['user_id'], null, '/');
            setcookie('is_distribut', $data['result']['is_distribut'], null, '/');

            $this->ajaxReturn($data);
            exit;
        }
        $this->assign('regis_sms_enable',$reg_sms_enable); // 注册启用短信：
        $this->assign('regis_smtp_enable',$reg_smtp_enable); // 注册启用邮箱：
        $sms_time_out = tpCache('sms.sms_time_out')>0 ? tpCache('sms.sms_time_out') : 120;
        $this->assign('sms_time_out', $sms_time_out); // 手机短信超时时间
        return $this->fetch();
    }
    /**
     *  注册
     */
    public function bindMobile()
    {

        if(!session('user')['mobile']) {
            $reg_sms_enable = tpCache('sms.regis_sms_enable');
            $reg_smtp_enable = tpCache('sms.regis_smtp_enable');
            $this->assign('regis_sms_enable',$reg_sms_enable); // 注册启用短信：
            $this->assign('regis_smtp_enable',$reg_smtp_enable); // 注册启用邮箱：
            $sms_time_out = tpCache('sms.sms_time_out')>0 ? tpCache('sms.sms_time_out') : 120;
            $this->assign('sms_time_out', $sms_time_out); // 手机短信超时时间
          $template="mobile";
        }else{
            $template="userinfo";
        }

        return $this->fetch($template);
    }
    /**
     *  注册
     */
    public function regjc()
    {
        if (IS_POST) {
            $logic = new UsersLogic();
            //验证码检验
            //$this->verifyHandle('user_reg');
            $nickname = input('post.nickname', '');
            $username = input('post.username', '');
            $username = input('post.mobile', '');
            $password = input('post.password', $username);
            $password2 = input('post.password2', $username);
            $is_bind_account = tpCache('basic.is_bind_account');
            //是否开启注册验证码机制
            $code = input('post.mobile_code', '');
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
    public function bind_guide(){
        $data = session('third_oauth');
        $this->assign("nickname", $data['nickname']);
        $this->assign("oauth", $data['oauth']);
        $this->assign("head_pic", $data['head_pic']);
    
        return $this->fetch();
    }
    
    /**
     * 绑定已有账号
     * @return \think\mixed
     */
    public function bind_account()
    {
        if(IS_POST){
            $data = input('post.');
            $userLogic = new UsersLogic();
            $user['mobile'] = $data['mobile'];
            $user['password'] = encrypt($data['password']);
            $res = $userLogic->oauth_bind_new($user);
            if ($res['status'] == 1) {


                $res['url'] = urldecode(input('post.referurl'));
                $res['result']['nickname'] = empty($res['result']['nickname']) ? $res['result']['mobile'] : $res['result']['nickname'];
                setcookie('user_id', $res['result']['user_id'], null, '/');
                setcookie('is_distribut', $res['result']['is_distribut'], null, '/');
                setcookie('uname', urlencode($res['result']['nickname']), null, '/');
                setcookie('head_pic', urlencode($res['result']['head_pic']), null, '/');
                setcookie('cn', 0, time() - 3600, '/');
                //获取公众号openid,并保持到session的user中
                $oauth_users = db('OauthUsers')->where(['user_id'=>$res['result']['user_id'] , 'oauth'=>'weixin' , 'oauth_child'=>'mp'])->find();
                $oauth_users && $res['result']['open_id'] = $oauth_users['open_id'];
                session('user', $res['result']);

                return $this->success("绑定成功", url('Mobile/User/index'));
            }else{
                return $this->error("绑定失败,失败原因:".$res['msg']);
            }
        }else{
            return $this->fetch();
        }
    }


    /*
     * 地址编辑
     */
    public function address()
    {

         $id = session('user')['id'];
        $address = db('users')->where(array( 'id' => $this->user_id))->find();
        if (IS_POST) {
            $source = input('source');
            $goods_id = input('goods_id/d');
            $item_id = input('item_id/d');
            $goods_num = input('goods_num/d');
            $action = input('action');
            $order_id = input('order_id/d');
            $post_data = input('post.');
            $logic = new UsersLogic();
            $data = $logic->add_address($this->user_id, $id, $post_data);

                $data['url']= url('/Mobile/User/userinfo');
                $this->ajaxReturn($data);

        }
        //获取省份
        $p = db('region')->where(array('parent_id' => 0, 'level' => 1))->select();

        $c = db('region')->where(array('parent_id' => $address['province'], 'level' => 2))->select();
        $d = db('region')->where(array('parent_id' => $address['city'], 'level' => 3))->select();

        $this->assign('province', $p);
        $this->assign('city', $c);
        $this->assign('district', $d);
        $this->assign('detailed_address', $address['detailed_address']);
        $this->assign('address', $address);
        return $this->fetch();
    }

    /*
     * 设置默认收货地址
     */
    public function set_default()
    {
        $id = input('get.id/d');
        $source = input('get.source');
        db('user_address')->where(array('id' => $this->user_id))->update(array('is_default' => 0));
        $row = db('user_address')->where(array('id' => $this->user_id, 'address_id' => $id))->update(array('is_default' => 1));
        if ($source == 'cart2') {
            header("Location:" . url('Mobile/Cart/cart2'));
            exit;
        } else {
            header("Location:" . url('Mobile/User/address_list'));
        }
    }

    /*
     * 地址删除
     */
    public function del_address()
    {
        $id = input('get.id/d');

        $address = db('user_address')->where("address_id", $id)->find();
        $row = db('user_address')->where(array('user_id' => $this->user_id, 'address_id' => $id))->delete();
        // 如果删除的是默认收货地址 则要把第一个地址设置为默认收货地址
        if ($address['is_default'] == 1) {
            $address2 = db('user_address')->where("user_id", $this->user_id)->find();
            $address2 && db('user_address')->where("address_id", $address2['address_id'])->update(array('is_default' => 1));
        }
        if (!$row)
            $this->error('操作失败', url('User/address_list'));
        else
            $this->success("操作成功", url('User/address_list'));
    }


    /*
     * 个人信息
     */
    public function userinfo()
    {

        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        if (IS_POST) {
        	if ($_FILES['head_pic']['tmp_name']) {
        		$file = $this->request->file('head_pic');
                $image_upload_limit_size = config('image_upload_limit_size');
        		$validate = ['size'=>$image_upload_limit_size,'ext'=>'jpg,png,gif,jpeg'];
        		$dir = 'public/upload/head_pic/';
        		if (!($_exists = file_exists($dir))){
        			$isMk = mkdir($dir);
        		}
        		$parentDir = date('Ymd');
        		$info = $file->validate($validate)->move($dir, true);
        		if($info){
        			$post['head_pic'] = '/'.$dir.$parentDir.'/'.$info->getFilename();
        		}else{
        			$this->error($file->getError());//上传错误提示错误信息
        		}
        	}
            input('post.nickname') ? $post['nickname'] = input('post.nickname') : false; //昵称
            input('post.qq') ? $post['qq'] = input('post.qq') : false;  //QQ号码
            input('post.head_pic') ? $post['head_pic'] = input('post.head_pic') : false; //头像地址
            input('post.sex') ? $post['sex'] = input('post.sex') : $post['sex'] = 0;  // 性别
            input('post.birthday') ? $post['birthday'] = strtotime(input('post.birthday')) : false;  // 生日
            input('post.province') ? $post['province'] = input('post.province') : false;  //省份
            input('post.city') ? $post['city'] = input('post.city') : false;  // 城市
            input('post.district') ? $post['district'] = input('post.district') : false;  //地区
            input('post.email') ? $post['email'] = input('post.email') : false; //邮箱
            input('post.mobile') ? $post['mobile'] = input('post.mobile') : false; //手机

            input('post.company_name') ? $post['company_name'] = input('post.company_name') : false;  //公司
            input('post.position') ? $post['position'] = input('post.position') : false; //职位
            input('post.industry') ? $post['industry'] = input('post.industry') : false; //行业

            $email = input('post.email');
            $mobile = input('post.mobile');
            $code = input('post.mobile_code', '');
            $scene = input('post.scene', 6);

            if (!empty($email)) {
                $c = db('users')->where(['email' => input('post.email'), 'id' => ['<>', $this->user_id]])->count();
                $c && $this->error("邮箱已被使用");
            }
            if (!empty($mobile)) {
                $c = db('users')->where(['mobile' => input('post.mobile'), 'id' => ['<>', $this->user_id]])->count();
                $c && $this->error("手机已被使用");
                if (!$code)
                    $this->error('请输入验证码');
                $check_code = $userLogic->check_validate_code($code, $mobile, 'phone', $this->session_id, $scene);
                if ($check_code['status'] != 1)
                    $this->error($check_code['msg']);
            }

            if (!$userLogic->update_info($this->user_id, $post))
                $this->error("保存失败","/mobile/user/bindmobile",2);
            setcookie('uname',urlencode($post['nickname']),null,'/');
            $this->success("操作成功","/mobile/user/bindmobile",1);
            exit;
        }
        //  获取省份
        $province = db('region')->where(array('parent_id' => 0, 'level' => 1))->select();
        //  获取订单城市
        $city = db('region')->where(array('parent_id' => $user_info['province'], 'level' => 2))->select();
        //  获取订单地区
        $area = db('region')->where(array('parent_id' => $user_info['city'], 'level' => 3))->select();
        $this->assign('province', $province);
        $this->assign('city', $city);
        $this->assign('area', $area);
        $this->assign('user', $user_info);
        $this->assign('sex', config('SEX'));
        //从哪个修改用户信息页面进来，
        $dispaly = input('action');
        if ($dispaly != '') {
            return $this->fetch("$dispaly");
        }
        return $this->fetch();
    }

    /**
     * 修改绑定手机
     * @return mixed
     */
    public function setMobile(){
        $userLogic = new UsersLogic();
        if (IS_POST) {
            $mobile = input('mobile');
            $mobile_code = input('mobile_code');
            $scene = input('post.scene', 6);
            $validate = input('validate',0);
            $status = input('status',0);
            $c = Db::name('users')->where(['mobile' => mobile, 'user_id' => ['<>', $this->user_id]])->count();
            $c && $this->error('手机已被使用');
            if (!$mobile_code)
                $this->error('请输入验证码');
            $check_code = $userLogic->check_validate_code($mobile_code, $mobile, 'phone', $this->session_id, $scene);
            if($check_code['status'] !=1){
                $this->error($check_code['msg']);
            }
            if($validate == 1 & $status == 0){
                $res = Db::name('users')->where(['user_id' => $this->user_id])->update(['mobile'=>$mobile]);
                if($res){
                    $this->success('修改成功',url('User/userinfo'));
                }
                $this->error('修改失败');
            }
        }
        $this->assign('status',$status);
        return $this->fetch();
    }

    /*
     * 邮箱验证
     */
    public function email_validate()
    {
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = input('get.step', 1);
        //验证是否未绑定过
        if ($user_info['email_validated'] == 0)
            $step = 2;
        //原邮箱验证是否通过
        if ($user_info['email_validated'] == 1 && session('email_step1') == 1)
            $step = 2;
        if ($user_info['email_validated'] == 1 && session('email_step1') != 1)
            $step = 1;
        if (IS_POST) {
            $email = input('post.email');
            $code = input('post.code');
            $info = session('email_code');
            if (!$info)
                $this->error('非法操作');
            if ($info['email'] == $email || $info['code'] == $code) {
                if ($user_info['email_validated'] == 0 || session('email_step1') == 1) {
                    session('email_code', null);
                    session('email_step1', null);
                    if (!$userLogic->update_email_mobile($email, $this->user_id))
                        $this->error('邮箱已存在');
                    $this->success('绑定成功', url('Home/User/index'));
                } else {
                    session('email_code', null);
                    session('email_step1', 1);
                    redirect(url('Home/User/email_validate', array('step' => 2)));
                }
                exit;
            }
            $this->error('验证码邮箱不匹配');
        }
        $this->assign('step', $step);
        return $this->fetch();
    }

    /*
    * 手机验证
    */
    public function mobile_validate()
    {
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = input('get.step', 1);
        //验证是否未绑定过
        if ($user_info['mobile_validated'] == 0)
            $step = 2;
        //原手机验证是否通过
        if ($user_info['mobile_validated'] == 1 && session('mobile_step1') == 1)
            $step = 2;
        if ($user_info['mobile_validated'] == 1 && session('mobile_step1') != 1)
            $step = 1;
        if (IS_POST) {
            $mobile = input('post.mobile');
            $code = input('post.code');
            $info = session('mobile_code');
            if (!$info)
                $this->error('非法操作');
            if ($info['mobile'] == $mobile || $info['code'] == $code) {
                if ($user_info['email_validated'] == 0 || session('email_step1') == 1) {
                    session('mobile_code', null);
                    session('mobile_step1', null);
                    if (!$userLogic->update_email_mobile($mobile, $this->user_id, 2))
                        $this->error('手机已存在');
                    $this->success('绑定成功', url('Home/User/index'));
                } else {
                    session('mobile_code', null);
                    session('email_step1', 1);
                    redirect(url('Home/User/mobile_validate', array('step' => 2)));
                }
                exit;
            }
            $this->error('验证码手机不匹配');
        }
        $this->assign('step', $step);
        return $this->fetch();
    }

    /**
     * 用户收藏列表
     */
    public function collect_list()
    {
        $userLogic = new UsersLogic();
        $data = $userLogic->get_goods_collect($this->user_id);
        $this->assign('page', $data['show']);// 赋值分页输出
        $this->assign('goods_list', $data['result']);
        if (IS_AJAX) {      //ajax加载更多
            return $this->fetch('ajax_collect_list');
            exit;
        }
        return $this->fetch();
    }

    /*
     *取消收藏
     */
    public function cancel_collect()
    {
        $collect_id = input('collect_id/d');
        $user_id = $this->user_id;
        if (db('goods_collect')->where(['collect_id' => $collect_id, 'user_id' => $user_id])->delete()) {
            $this->success("取消收藏成功", url('User/collect_list'));
        } else {
            $this->error("取消收藏失败", url('User/collect_list'));
        }
    }

    /**
     * 我的留言
     */
    public function message_list()
    {
        config('TOKEN_ON', true);
        if (IS_POST) {
            if(!$this->verifyHandle('messages')){
                $this->error('验证码错误', url('User/message_list'));
            };

            $data = input('post.');
            $data['user_id'] = $this->user_id;
            $user = session('user');
            $data['user_name'] = $user['nickname'];
            $data['msg_time'] = time();
            if (db('feedback')->insertGetId($data)) {
                $this->success("留言成功", url('User/message_list'));
                exit;
            } else {
                $this->error('留言失败', url('User/message_list'));
                exit;
            }
        }
        $msg_type = array(0 => '留言', 1 => '投诉', 2 => '询问', 3 => '售后', 4 => '求购');
        $count = db('feedback')->where("user_id", $this->user_id)->count();
        $Page = new Page($count, 100);
        $Page->rollPage = 2;
        $message = db('feedback')->where("user_id", $this->user_id)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $showpage = $Page->show();
        header("Content-type:text/html;charset=utf-8");
        $this->assign('page', $showpage);
        $this->assign('messages', $message);
        $this->assign('msg_type', $msg_type);
        return $this->fetch();
    }



    
    /*
     * 密码修改
     */
    public function password()
    {
        if (IS_POST) {
            $logic = new UsersLogic();
            $data = $logic->get_info($this->user_id);
            $user = $data['result'];
            if ($user['mobile'] == '' && $user['email'] == '')
                $this->ajaxReturn(['status'=>-1,'msg'=>'请先绑定手机或邮箱','url'=>url('/Mobile/User/index')]);
            $userLogic = new UsersLogic();
            $data = $userLogic->password($this->user_id, input('post.old_password'), input('post.new_password'), input('post.confirm_password'));
            if ($data['status'] == -1)
                $this->ajaxReturn(['status'=>-1,'msg'=>$data['msg']]);
            $this->ajaxReturn(['status'=>1,'msg'=>$data['msg'],'url'=>url('/Mobile/User/index')]);
            exit;
        }
        return $this->fetch();
    }

    function forget_pwd()
    {
        if ($this->user_id > 0) {
            $this->redirect("User/index");
        }
        $username = input('username');
        if (IS_POST) {
            if (!empty($username)) {
                if(!$this->verifyHandle('forget')){
                    $this->error("验证码错误");
                };
                $field = 'mobile';
                if (check_email($username)) {
                    $field = 'email';
                }
                $user = db('users')->where("email", $username)->whereOr('mobile', $username)->find();
                if ($user) {
                    session('find_password', array('user_id' => $user['user_id'], 'username' => $username,
                        'email' => $user['email'], 'mobile' => $user['mobile'], 'type' => $field));
                    header("Location: " . url('User/find_pwd'));
                    exit;
                } else {
                    $this->error("用户名不存在，请检查");
                }
            }
        }
        return $this->fetch();
    }

    function find_pwd()
    {
        if ($this->user_id > 0) {
            header("Location: " . url('User/index'));
        }
        $user = session('find_password');
        if (empty($user)) {
            $this->error("请先验证用户名", url('User/forget_pwd'));
        }
        $this->assign('user', $user);
        return $this->fetch();
    }


    public function set_pwd()
    {
        if ($this->user_id > 0) {
            $this->redirect('Mobile/User/index');
        }
        $check = session('validate_code');
        if (empty($check)) {
            header("Location:" . url('User/forget_pwd'));
        } elseif ($check['is_check'] == 0) {
            $this->error('验证码还未验证通过', url('User/forget_pwd'));
        }
        if (IS_POST) {
            $password = input('post.password');
            $password2 = input('post.password2');
            if ($password2 != $password) {
                $this->error('两次密码不一致', url('User/forget_pwd'));
            }
            if ($check['is_check'] == 1) {
                $user = db('users')->where("mobile", $check['sender'])->whereOr('email', $check['sender'])->find();
                db('users')->where("id", $user['user_id'])->update(array('password' => encrypt($password)));
                session('validate_code', null);
                return $this->fetch('reset_pwd_sucess');
                exit;
            } else {
                $this->error('验证码还未验证通过', url('User/forget_pwd'));
            }
        }
        $is_set = input('is_set', 0);
        $this->assign('is_set', $is_set);
        return $this->fetch();
    }
 
    /**
     * 验证码验证
     * $id 验证码标示
     */
    private function verifyHandle($id)
    {
        $verify = new Verify();
        if (!$verify->check(input('post.verify_code'), $id ? $id : 'user_login')) {
            return false;
        }
        return true;
    }

    /**
     * 验证码获取
     */
    public function verify()
    {
        //验证码类型
        $type = input('get.type') ? input('get.type') : 'user_login';
        $config = array(
            'fontSize' => 30,
            'length' => 4,
            'imageH' =>  60,
            'imageW' =>  300,
            'fontttf' => '5.ttf',
            'useCurve' => true,
            'useNoise' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry($type);
		exit();
    }

    /**
     * 我的关注
     * @author lxl
     * @time   2017/1
     */
    public function myfocus()
    {
        return $this->fetch();
    }

    /**
     *  用户消息通知
     * @author dyr
     * @time 2016/09/01
     */
    public function message_notice()
    {
        return $this->fetch();
    }

    /**
     * ajax用户消息通知请求
     * @author dyr
     * @time 2016/09/01
     */
    public function ajax_message_notice()
    {
        $type = input('type');
        $user_logic = new UsersLogic();
        $message_model = new MessageLogic();
        if ($type === '0') {
            //系统消息
            $user_sys_message = $message_model->getUserMessageNotice();
        } else if ($type == 1) {
            //活动消息：后续开发
            $user_sys_message = array();
        } else {
            //全部消息：后续完善
            $user_sys_message = $message_model->getUserMessageNotice();
        }
        $this->assign('messages', $user_sys_message);
        return $this->fetch('ajax_message_notice');

    }

    /**
     * ajax用户消息通知请求
     */
    public function set_message_notice()
    {
        $type = input('type');
        $msg_id = input('msg_id');
        $user_logic = new UsersLogic();
        $res =$user_logic->setMessageForRead($type,$msg_id);
        $this->ajaxReturn($res);
    }


    /**
     * 设置消息通知
     */
    public function set_notice(){
        //暂无数据
        return $this->fetch();
    }


    /**
     *  点赞
     * @author lxl
     * @time  17-4-20
     * 拷多商家Order控制器
     */
    public function ajaxZan()
    {
        $comment_id = input('post.comment_id/d');
        $user_id = $this->user_id;
        $comment_info = db('comment')->where(array('comment_id' => $comment_id))->find();  //获取点赞用户ID
        $comment_user_id_array = explode(',', $comment_info['zan_userid']);
        if (in_array($user_id, $comment_user_id_array)) {  //判断用户有没点赞过
            $result['success'] = 0;
        } else {
            array_push($comment_user_id_array, $user_id);  //加入用户ID
            $comment_user_id_string = implode(',', $comment_user_id_array);
            $comment_data['zan_num'] = $comment_info['zan_num'] + 1;  //点赞数量加1
            $comment_data['zan_userid'] = $comment_user_id_string;
            db('comment')->where(array('comment_id' => $comment_id))->update($comment_data);
            $result['success'] = 1;
        }
        exit(json_encode($result));
    }



}
