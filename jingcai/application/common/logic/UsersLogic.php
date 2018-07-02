<?php
namespace app\common\logic;

use app\common\model\UserAddress;
use think\Model;
use think\Page;
use think\db;

/**
 * 分类逻辑定义
 * Class CatsLogic
 * @package Home\Logic
 */
class UsersLogic extends Model
{
    protected $user_id=0;

    /**
     * 设置用户ID
     * @param $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    /*
     * 登陆
     */
    public function login($username,$password){
    	$result = array();
        if(!$username || !$password)
           $result= array('status'=>0,'msg'=>'请填写账号或密码');
        $user = db('users')->where("mobile",$username)->whereOr('email',$username)->find();
        if(!$user){
           $result = array('status'=>-1,'msg'=>'账号不存在!');
        }elseif(encrypt($password) != $user['password']){
           $result = array('status'=>-2,'msg'=>'密码错误!');
        }elseif($user['is_lock'] == 1){
           $result = array('status'=>-3,'msg'=>'账号异常已被锁定！！！');
        }else{
           $result = array('status'=>1,'msg'=>'登陆成功','result'=>$user);
        }
        return $result;
    }

    //绑定账号
    public function oauth_bind_new($user = array())
    {
        $thirdOauth = session('third_oauth');
        
        $thirdName = ['weixin'=>'微信' , 'qq'=>'QQ' , 'alipay'=>'支付宝', 'miniapp' => '微信小程序'];
        
        //1.检查账号密码是否正确
        $ruser = db('Users')->where(array('mobile'=>$user['mobile']))->find();
        if(empty($ruser)){
            return array('status'=>-1,'msg'=>'账号不存在','result'=>'');
        }
        
        if($ruser['password'] != $user['password']){
            return array('status'=>-1,'msg'=>'账号或密码错误','result'=>'');
        }
    
        //2.检查第三方信息是否完整
        $openid = $thirdOauth['openid'];   //第三方返回唯一标识
        $unionid = $thirdOauth['unionid'];   //第三方返回唯一标识
        $oauth = $thirdOauth['oauth'];      //来源
        $oauthCN = $platform = $thirdName[$oauth];
        if((empty($unionid) || empty($openid)) && empty($oauth)){
            return array('status'=>-1,'msg'=>'第三方平台参数有误[openid:'.$openid.' , unionid:'.$unionid.', oauth:'.$oauth.']','result'=>'');
        }
    
        //3.检查当前当前账号是否绑定过开放平台账号
        //1.判断一个账号绑定多个QQ
        //2.判断一个QQ绑定多个账号
        if($unionid){ 
            //如果有 unionid
            
            //1.1此oauth是否已经绑定过其他账号
            $thirdUser = db('OauthUsers')->where(['unionid'=>$unionid, 'oauth'=> $oauth])->find();
            if($thirdUser && $ruser['user_id'] != $thirdUser['user_id'] ){ 
                return array('status'=>-1,'msg'=>'此'.$oauthCN.'已绑定其它账号','result'=>'');
            } 
            
            //1.2此账号是否已经绑定过其他oauth
            $thirdUser = db('OauthUsers')->where(['user_id'=>$ruser['user_id'], 'oauth'=> $oauth])->find();
            if($thirdUser && $thirdUser['unionid'] != $unionid){         
                return array('status'=>-1,'msg'=>'此'.$oauthCN.'已绑定其它账号','result'=>'');
            }
         
        }else{
            //如果没有unionid
            
            //2.1此oauth是否已经绑定过其他账号
            $thirdUser = db('OauthUsers')->where(['openid'=>$openid, 'oauth'=> $oauth])->find();
            if($thirdUser){ 
                return array('status'=>-1,'msg'=>'此'.$oauthCN.'已绑定其它账号','result'=>'');
            }

            //2.2此账号是否已经绑定过其他oauth
            $thirdUser = db('OauthUsers')->where(['user_id'=>$ruser['user_id'], 'oauth'=> $oauth])->find();
            if($thirdUser){
                return array('status'=>-1,'msg'=>'此账号已绑定其它'.$oauthCN.'账号','result'=>'');
            } 
        }
       
        if(!isset($thirdOauth['oauth_child'])){
            $thirdOauth['oauth_child'] = '';
        }
        //4.账号绑定
        db('OauthUsers')->save(array('oauth'=>$oauth , 'openid'=>$openid ,'user_id'=>$ruser['user_id'] , 'unionid'=>$unionid, 'oauth_child'=>$thirdOauth['oauth_child']));
        $ruser['token'] = md5(time().mt_rand(1,999999999));
        $ruser['last_login'] = time();
        
        db('Users')->where('id' , $ruser['user_id'])->save(array('token'=>$ruser['token'] , 'last_login'=>$ruser['last_login']));
        
        return array('status'=>1,'msg'=>'绑定成功','result'=>$ruser);
       
         
    }
 
    /*
     * 第三方登录: (第一种方式:第三方账号直接创建账号, 不需要额外绑定账号)
     */
    public function thirdLogin($data=array()){
	     
   $openid = $data['openid']; //第三方返回唯一标识
        $oauth = $data['oauth']; //来源
        $unionid = $data['unionid']; //$unionid

        if(!$openid || !$oauth)
            return array('status'=>-1,'msg'=>'参数有误','result'=>'');
        //获取用户信息
        if(!empty($data['unionid'])){
        	$map['unionid'] = $data['unionid'];
        	$user = get_user_info($data['unionid'],4,$oauth);
        }else{
            $user = get_user_info($openid,3,$oauth);
        }
        $user2 = session('user');
       
        
        $map['last_login'] = time();
        $map['last_ip']=request()->ip();
        if(!$user){
            //账户不存在 注册一个
            $map['password'] = '';
            $map['openid'] = $openid;
            $map['nickname'] = $data['nickname'];
            $map['reg_time'] = time();

            $map['oauth'] = $oauth;
            $map['head_pic'] = $data['head_pic'];
            $map['sex'] = $data['sex'] === null ? 0 :  $data['sex'];
            if(@$_GET['first_leader'])
                $map['first_leader'] = $_GET['first_leader']; // 微信授权登录返回时 get 带着参数的


            //$map['is_distribut']  = 1;
            $row_id =db('users')->insertGetId($map);
            $user = db('users')->where(array('id'=>$row_id))->find();
            
            if(!isset($data['oauth_child'])){
                $data['oauth_child'] = '';
            }

            //不存在则创建个第三方账号
            db('oauth_users')->insert(array('oauth'=>$oauth , 'openid'=>$openid ,'user_id'=>$row_id , 'unionid'=>$unionid, 'oauth_child'=>$data['oauth_child']));
             
        } else {
            db('users')->where("id = ".$user['id'])->update($map);
            $user['last_login'] = $map['last_login'];
        }
    
        return array('status'=>1,'msg'=>'登陆成功5','result'=>$user);
    }
    

    /**
     * 注册
     * @param $username  邮箱或手机
     * @param $password  密码
     * @param $password2 确认密码
     * @return array
     */
    public function reg($username,$password,$password2,$push_id = 0,$invite=array(),$nickname="",$head_pic=""){

    	$is_validated = 0 ;
        if(check_email($username)){
            $is_validated = 1;
            $map['email_validated'] = 1;
            $map['nickname'] = $map['email'] = $username; //邮箱注册
        }

        if(check_mobile($username)){
            $is_validated = 1;
            $map['mobile_validated'] = 1;
            $map['nickname'] = $map['mobile'] = $username; //手机注册
        }

        if(!empty($nickname)){
            $map['nickname'] = $nickname;
        }
        
        if(!empty($head_pic)){
            $map['head_pic'] = $head_pic;
        }
        
        if($is_validated != 1)
            return array('status'=>-1,'msg'=>'请用手机号或邮箱注册','result'=>'');

        if(!$username || !$password)
            return array('status'=>-1,'msg'=>'请输入用户名或密码','result'=>'');

        //验证两次密码是否匹配
        if($password2 != $password)
            return array('status'=>-1,'msg'=>'两次输入密码不一致','result'=>'');
        //验证是否存在用户名
        if(get_user_info($username,1)||get_user_info($username,2))
            return array('status'=>-1,'msg'=>'账号已存在','result'=>'');

        $map['password'] = encrypt($password);
        $map['reg_time'] = time();

		if(is_array($invite) && !empty($invite)){
			$map['first_leader'] = $invite['user_id'];
			$map['second_leader'] = $invite['first_leader'];
			$map['third_leader'] = $invite['second_leader'];
		}
        $map['last_login'] = time();
                
        $user_id = db('users')->insertGetId($map);
        if($user_id === false)
            return array('status'=>-1,'msg'=>'注册失败');

        $user = db('users')->where("id", $user_id)->find();
        return array('status'=>1,'msg'=>'注册成功','result'=>$user);
    }


    public function regjc($username,$password,$password2,$push_id = 0,$invite=array(),$nickname="",$head_pic=""){

        $is_validated = 0 ;


        if(check_mobile($username)){

            $is_validated = 1;
            $map['mobile_validated'] = 1;
            $map['nickname'] = $map['mobile'] = $username; //手机注册
        }

        if(!empty($nickname)){
            $map['nickname'] = $nickname;
        }

        if(!empty($head_pic)){
            $map['head_pic'] = $head_pic;
        }

        if($is_validated != 1)
            return array('status'=>-1,'msg'=>'请用手机号或邮箱注册','result'=>'');

        if(!$username || !$password)
            return array('status'=>-1,'msg'=>'请输入用户名或密码','result'=>'');

        //验证两次密码是否匹配
        if($password2 != $password)
            return array('status'=>-1,'msg'=>'两次输入密码不一致','result'=>'');
        //验证是否存在用户名
        if(get_user_info($username,1)||get_user_info($username,2)){



            $user = db('users')->where("mobile", $username)->find();
            return  array('status'=>1,'msg'=>'登陆成功','result'=>$user);
        }


        $map['password'] = encrypt($password);
        $map['reg_time'] = time();

        if(is_array($invite) && !empty($invite)){
            $map['first_leader'] = $invite['user_id'];
            $map['second_leader'] = $invite['first_leader'];
            $map['third_leader'] = $invite['second_leader'];
        }
        $map['last_login'] = time();

        $user_id = db('users')->insertGetId($map);
        if($user_id === false)
            return array('status'=>-1,'msg'=>'注册失败');

        $user = db('users')->where("id", $user_id)->find();
        return array('status'=>1,'msg'=>'注册成功','result'=>$user);
    }

    /*
     * 获取当前登录用户信息
     */
    public function get_info($user_id)
    {
        if (!$user_id) {
            return array('status'=>-1, 'msg'=>'缺少参数');
        }

        $user = db('users')->where('id', $user_id)->find();
        if (!$user) {
            return false;
        }
        return ['status' => 1, 'msg' => '获取成功', 'result' => $user];
     }
     
    /*
      * 获取当前登录用户信息
      */
    public function getApiUserInfo($user_id)
    {
        if (!$user_id) {
            return array('status'=>-1, 'msg'=>'账户未登陆');
        }

        $user = db('users')->where('id', $user_id)->find();
        if (!$user) {
            return false;
        }

        $activityLogic = new \app\common\logic\ActivityLogic;             //获取能使用优惠券个数
        $user['coupon_count'] = $activityLogic->getUserCouponNum($user_id, 0);
        
        $user['collect_count'] = $this->getGoodsCollectNum($user_id);; //获取收藏数量
        $user['visit_count']   = db('goods_visit')->where('id', $user_id)->count();   //商品访问记录数
        $user['return_count'] = db('return_goods')->where("id=$user_id and status<2")->count();   //退换货数量
        
        $user['waitPay']     = db('order')->where("id = :user_id ".config('WAITPAY'))->bind(['user_id'=>$user_id])->count(); //待付款数量
        $user['waitSend']    = db('order')->where("id = :user_id ".config('WAITSEND'))->bind(['user_id'=>$user_id])->count(); //待发货数量
        $user['waitReceive'] = db('order')->where("id = :user_id ".config('WAITRECEIVE'))->bind(['user_id'=>$user_id])->count(); //待收货数量
        $user['order_count'] = $user['waitPay'] + $user['waitSend'] + $user['waitReceive'];
        
        $messageLogic = new \app\common\logic\MessageLogic();
        $user['message_count'] = $messageLogic->getUserMessageCount();

        $commentLogic = new CommentLogic;
        $user['comment_count'] = $commentLogic->getHadCommentNum($user_id); //已评论数
        $user['uncomment_count'] = $commentLogic->getWaitCommentNum($user_id); //待评论数




            
         return ['status' => 1, 'msg' => '获取成功', 'result' => $user];
     }
     


    /**
     * 邮箱或手机绑定
     * @param $email_mobile  邮箱或者手机
     * @param int $type  1 为更新邮箱模式  2 手机
     * @param int $user_id  用户id
     * @return bool
     */
    public function update_email_mobile($email_mobile,$user_id,$type=1){
        //检查是否存在邮件
        if($type == 1)
            $field = 'email';
        if($type == 2)
            $field = 'mobile';
        $condition['user_id'] = array('neq',$user_id);
        $condition[$field] = $email_mobile;

        $is_exist = db('users')->where($condition)->find();
        if($is_exist)
            return false;
        unset($condition[$field]);
        $condition['id'] = $user_id;
        $validate = $field.'_validated';
        db('users')->where($condition)->save(array($field=>$email_mobile,$validate=>1));
        return true;
    }

    /**
     * 更新用户信息
     * @param $user_id
     * @param $post  要更新的信息
     * @return bool
     */
    public function update_info($user_id,$post=array()){
        $model = db('users')->where("id", $user_id);
        $row = $model->setField($post);
        if($row === false)
           return false;
        return true;
    }

    /**
     * 地址添加/编辑
     * @param $user_id 用户id
     * @param $user_id 地址id(编辑时需传入)
     * @return array
     */
    public function add_address($user_id,$address_id=0,$data){
        $post = $data;
        if($address_id == 0)
        {
            $c = db('UserAddress')->where("user_id", $user_id)->count();
            if($c >= 20)
                return array('status'=>-1,'msg'=>'最多只能添加20个收货地址','result'=>'');
        }

        //检查手机格式
        if($post['consignee'] == '')
            return array('status'=>-1,'msg'=>'收货人不能为空','result'=>'');
        if(!$post['province'] || !$post['city'] || !$post['district'])
            return array('status'=>-1,'msg'=>'所在地区不能为空','result'=>'');
        if(!$post['address'])
            return array('status'=>-1,'msg'=>'地址不能为空','result'=>'');
        if(!check_mobile($post['mobile']))
            return array('status'=>-1,'msg'=>'手机号码格式有误','result'=>'');

        //编辑模式
        if($address_id > 0){

            $address = db('user_address')->where(array('address_id'=>$address_id,'user_id'=> $user_id))->find();
            if($post['is_default'] == 1 && $address['is_default'] != 1)
                db('user_address')->where(array('user_id'=>$user_id))->save(array('is_default'=>0));
            $row = db('user_address')->where(array('address_id'=>$address_id,'user_id'=> $user_id))->save($post);
            if($row !== false){
                return array('status'=>1,'msg'=>'编辑成功','result'=>$address_id);
            }else{
                return array('status'=>-1,'msg'=>'操作完成','result'=>$address_id);
            }

        }
        //添加模式
        $post['user_id'] = $user_id;
        
        // 如果目前只有一个收货地址则改为默认收货地址
        $c = db('user_address')->where("user_id", $post['user_id'])->count();
        if($c == 0)  $post['is_default'] = 1;
        
        $address_id = db('user_address')->add($post);
        //如果设为默认地址
        $insert_id = DB::name('user_address')->getLastInsID();
        $map['user_id'] = $user_id;
        $map['address_id'] = array('neq',$insert_id);
               
        if($post['is_default'] == 1)
            db('user_address')->where($map)->save(array('is_default'=>0));
        if(!$address_id)
            return array('status'=>-1,'msg'=>'添加失败','result'=>'');
        
        
        return array('status'=>1,'msg'=>'添加成功','result'=>$address_id);
    }



    /**
     * 设置默认收货地址
     * @param $user_id
     * @param $address_id
     */
    public function set_default($user_id,$address_id){
        db('user_address')->where(array('user_id'=>$user_id))->save(array('is_default'=>0)); //改变以前的默认地址地址状态
        $row = db('user_address')->where(array('user_id'=>$user_id,'address_id'=>$address_id))->save(array('is_default'=>1));
        if(!$row)
            return false;
        return true;
    }

    /**
     * 修改密码
     * @param $user_id  用户id
     * @param $old_password  旧密码
     * @param $new_password  新密码
     * @param $confirm_password 确认新 密码
     * @param bool|true $is_update
     * @return array
     */
    public function password($user_id,$old_password,$new_password,$confirm_password,$is_update=true){
        $user = db('users')->where('user_id', $user_id)->find();
        if(strlen($new_password) < 6)
            return array('status'=>-1,'msg'=>'密码不能低于6位字符','result'=>'');
        if($new_password != $confirm_password)
            return array('status'=>-1,'msg'=>'两次密码输入不一致','result'=>'');
        //验证原密码
        if($is_update && ($user['password'] != '' && encrypt($old_password) != $user['password']))
            return array('status'=>-1,'msg'=>'密码验证失败','result'=>'');
        $row = db('users')->where("user_id", $user_id)->save(array('password'=>encrypt($new_password)));
        if(!$row)
            return array('status'=>-1,'msg'=>'修改失败','result'=>'');
        return array('status'=>1,'msg'=>'修改成功','result'=>'');
    }

    /**
     *  针对 APP 修改密码的方法
     * @param $user_id  用户id
     * @param $old_password  旧密码
     * @param $new_password  新密码
     * @param $confirm_password 确认新 密码
     */
    public function passwordForApp($user_id,$old_password,$new_password,$is_update=true){
        $user = db('users')->where('user_id', $user_id)->find();
        if(strlen($new_password) < 6){
            return array('status'=>-1,'msg'=>'密码不能低于6位字符','result'=>'');
        }
        //验证原密码
        if($is_update && ($user['password'] != '' && $old_password != $user['password'])){
            return array('status'=>-1,'msg'=>'旧密码错误','result'=>'');
        }

        $row = db('users')->where("user_id='{$user_id}'")->update(array('password'=>$new_password));
        if(!$row){
            return array('status'=>-1,'msg'=>'密码修改失败','result'=>'');
        }
        return array('status'=>1,'msg'=>'密码修改成功','result'=>'');
    }
    
    /**
     * 设置支付密码
     * @param $user_id  用户id
     * @param $new_password  新密码
     * @param $confirm_password 确认新 密码
     */
    public function paypwd($user_id,$new_password,$confirm_password){
        if(strlen($new_password) < 6)
            return array('status'=>-1,'msg'=>'密码不能低于6位字符','result'=>'');
        if($new_password != $confirm_password)
            return array('status'=>-1,'msg'=>'两次密码输入不一致','result'=>'');
        $row = db('users')->where("user_id",$user_id)->update(array('paypwd'=>encrypt($new_password)));
        if(!$row){
            return array('status'=>-1,'msg'=>'修改失败','result'=>'');
        }
        $url = session('payPriorUrl') ? session('payPriorUrl'): U('User/userinfo');
        session('payPriorUrl',null);
    	return array('status'=>1,'msg'=>'修改成功','url'=>$url);
    }
    /**
     * 发送验证码: 该方法只用来发送邮件验证码, 短信验证码不再走该方法
     * @param $sender 接收人
     * @param $type 发送类型
     * @return json
     */
    public function send_email_code($sender){
    	$sms_time_out = tpCache('sms.sms_time_out');
    	$sms_time_out = $sms_time_out ? $sms_time_out : 180;
    	//获取上一次的发送时间
    	$send = session('validate_code');
    	if(!empty($send) && $send['time'] > time() && $send['sender'] == $sender){
    		//在有效期范围内 相同号码不再发送
    		$res = array('status'=>-1,'msg'=>'规定时间内,不要重复发送验证码');
            return $res;
    	}
    	$code =  mt_rand(1000,9999);
		//检查是否邮箱格式
		if(!check_email($sender)){
			$res = array('status'=>-1,'msg'=>'邮箱码格式有误');
            return $res;
		}
		$send = send_email($sender,'验证码','您好，你的验证码是：'.$code);
    	if($send['status'] == 1){
    		$info['code'] = $code;
    		$info['sender'] = $sender;
    		$info['is_check'] = 0;
    		$info['time'] = time() + $sms_time_out; //有效验证时间
    		session('validate_code',$info);
    		$res = array('status'=>1,'msg'=>'验证码已发送，请注意查收');
    	}else{
    		$res = $send;
    	}
    	return $res;
    }    
     
    /**
     * 检查短信/邮件验证码验证码
     * @param unknown $code
     * @param unknown $sender
     * @param unknown $session_id
     * @return multitype:number string
     */
    public function check_validate_code($code, $sender, $type ='email', $session_id=0 ,$scene = -1){
    	
        $timeOut = time();
        $inValid = true;  //验证码失效

        //短信发送否开启
        //-1:用户没有发送短信
        //空:发送验证码关闭
        $sms_status = checkEnableSendSms($scene);

        //邮件证码是否开启
        $reg_smtp_enable = tpCache('smtp.regis_smtp_enable');
        
        if($type == 'email'){            
            if(!$reg_smtp_enable){//发生邮件功能关闭
                $validate_code = session('validate_code');
                $validate_code['sender'] = $sender;
                $validate_code['is_check'] = 1;//标示验证通过
                session('validate_code',$validate_code);
                return array('status'=>1,'msg'=>'邮件验证码功能关闭, 无需校验验证码');
            }            
            if(!$code)return array('status'=>-1,'msg'=>'请输入邮件验证码');                
            //邮件
            $data = session('validate_code');
            $timeOut = $data['time'];
            if($data['code'] != $code || $data['sender']!=$sender){
            	$inValid = false;
            }  
        }else{
            if($scene == -1){
                return array('status'=>-1,'msg'=>'参数错误, 请传递合理的scene参数');
            }elseif($sms_status['status'] == 0){
                $data['sender'] = $sender;
                $data['is_check'] = 1; //标示验证通过
                session('validate_code',$data);
                return array('status'=>1,'msg'=>'短信验证码功能关闭, 无需校验验证码');
            } 
            
            if(!$code)return array('status'=>-1,'msg'=>'请输入短信验证码');
            //短信
            $sms_time_out = tpCache('sms.sms_time_out');
            $sms_time_out = $sms_time_out ? $sms_time_out : 180;
            $data = db('sms_log')->where(array('mobile'=>$sender,'session_id'=>$session_id , 'status'=>1))->order('id DESC')->find();
            //file_put_contents('./test.log', json_encode(['mobile'=>$sender,'session_id'=>$session_id, 'data' => $data]));
            if(is_array($data) && $data['code'] == $code){
            	$data['sender'] = $sender;
            	$timeOut = $data['add_time']+ $sms_time_out;
            }else{
            	$inValid = false;
            }           
        }
        
       if(empty($data)){
           $res = array('status'=>-1,'msg'=>'请先获取验证码');
       }elseif($timeOut < time()){
           $res = array('status'=>-1,'msg'=>'验证码已超时失效');
       }elseif(!$inValid)
       {
           $res = array('status'=>-1,'msg'=>'验证失败,验证码有误');
       }else{
            $data['is_check'] = 1; //标示验证通过
            session('validate_code',$data);
            $res = array('status'=>1,'msg'=>'验证成功');
        }

        return $res;
    }
     
    
    /**
     * @time 2016/09/01
     * 设置用户系统消息已读
     */
    public function setSysMessageForRead()
    {
        $user_info = session('user');
        if (!empty($user_info['user_id'])) {
            $data['status'] = 1;
            db('user_message')->where(array('user_id' => $user_info['user_id'], 'category' => 0))->save($data);
        }
    }

    /**
     * 设置用户消息已读
     * @param int $category 0:系统消息|1：活动消息
     * @param $msg_id
     * @throws \think\Exception
     */
    public function setMessageForRead($category = 0,$msg_id)
    {
        $user_info = session('user');
        if (!empty($user_info['user_id'])) {
            $data['status'] = 1;
            $set_where['user_id'] = $user_info['user_id'];
            $set_where['category'] = $category;
            if($msg_id){
                $set_where['message_id'] = $msg_id;
            }
            $updat_meg_res = Db::name('user_message')->where($set_where)->update($data);
            if ($updat_meg_res){
                return ['status'=>1,'msg'=>'操作成功'];
            }
        }
        return ['status'=>-1,'msg'=>'操失败'];
    }

    /**
     * 获取访问记录
     * @param type $user_id
     * @param type $p
     * @return type
     */
    public function getVisitLog($user_id, $p = 1)
    {
        $visit = db('goods_visit')->alias('v')
            ->field('v.visit_id, v.goods_id, v.visittime, g.goods_name, g.shop_price, g.cat_id')
            ->join('__GOODS__ g', 'v.goods_id=g.goods_id')
            ->where('v.user_id', $user_id)
            ->order('v.visittime desc')
            ->page($p, 20)
            ->select();

        /* 浏览记录按日期分组 */
        $curyear = date('Y');
        $visit_list = [];
        foreach ($visit as $v) {
            if ($curyear == date('Y', $v['visittime'])) {
                $date = date('m月d日', $v['visittime']);
            } else {
                $date = date('Y年m月d日', $v['visittime']);
            }
            $visit_list[$date][] = $v;
        }

        return $visit_list;
    }
    
    /**
     * 上传头像
     */
    public function upload_headpic($must_upload = true)
    {
        if ($_FILES['head_pic']['tmp_name']) {
            $file = request()->file('head_pic');
            $image_upload_limit_size = config('image_upload_limit_size');
            $validate = ['size'=>$image_upload_limit_size,'ext'=>'jpg,png,gif,jpeg'];
            $dir = 'public/upload/head_pic/';
            if (!($_exists = file_exists($dir))) {
                mkdir($dir);
            }
            $parentDir = date('Ymd');
            $info = $file->validate($validate)->move($dir, true);
            if ($info) {
                $pic_path = '/'.$dir.$parentDir.'/'.$info->getFilename();
            } else {
                return ['status' => -1, 'msg' => $file->getError()];
            }
        } elseif ($must_upload) {
            return ['status' => -1, 'msg' => "图片不存在！"];
        }
        return ['status' => 1, 'msg' => '上传成功', 'result' => $pic_path];
    }
    

}
