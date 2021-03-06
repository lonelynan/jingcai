<?php
namespace app\home\controller;
use app\common\logic\UsersLogic;
use think\Db;
use think\Session;
use think\Verify;
use think\Cookie;

class Api extends Base {
    public  $send_scene;
    
    public function _initialize() {
        parent::_initialize();
        session('user');
    }
    /*
     * 获取地区
     */
    public function getRegion(){
        $parent_id = input('get.parent_id/d');
        $selected = input('get.selected',0);        
        $data = db('region')->where("parent_id",$parent_id)->select();
        $html = '';
        if($data){
            foreach($data as $h){
            	if($h['id'] == $selected){
            		$html .= "<option value='{$h['id']}' selected>{$h['name']}</option>";
            	}
                $html .= "<option value='{$h['id']}'>{$h['name']}</option>";
            }
        }
        echo $html;
    }
    

    public function getTwon(){
    	$parent_id = input('get.parent_id/d');
    	$data = db('region')->where("parent_id",$parent_id)->select();
    	$html = '';
    	if($data){
    		foreach($data as $h){
    			$html .= "<option value='{$h['id']}'>{$h['name']}</option>";
    		}
    	}
    	if(empty($html)){
    		echo '0';
    	}else{
    		echo $html;
    	}
    }

    /**
     * 获取省
     */
    public function getProvince()
    {
        $province = Db::name('region')->field('id,name')->where(array('level' => 1))->cache(true)->select();
        $res = array('status' => 1, 'msg' => '获取成功', 'result' => $province);
        exit(json_encode($res));
    }

    /**
     * 获取市或者区
     */
    public function getRegionByParentId()
    {
        $parent_id = input('parent_id');
        $res = array('status' => 0, 'msg' => '获取失败，参数错误', 'result' => '');
        if($parent_id){
            $region_list = Db::name('region')->field('id,name')->where(['parent_id'=>$parent_id])->select();
            $res = array('status' => 1, 'msg' => '获取成功', 'result' => $region_list);
        }
        exit(json_encode($res));
    }
    
    /*
     * 获取地区
     */
    public function get_category(){
        $parent_id = input('get.parent_id/d'); // 商品分类 父id
            $list = db('goods_category')->where("parent_id", $parent_id)->select();
        
        foreach($list as $k => $v)
            $html .= "<option value='{$v['id']}'>{$v['name']}</option>";        
        exit($html);
    }  
    
    
    /**
     * 前端发送短信方法: APP/WAP/PC 共用发送方法
     */
    public function send_validate_code(){

        $this->send_scene = config('SEND_SCENE');

        $type = input('type');
        $scene = input('scene');    //发送短信验证码使用场景
        $mobile = input('mobile');
        $sender = input('send');
        $verify_code = input('verify_code');
        $mobile = !empty($mobile) ?  $mobile : $sender ;
        $session_id = input('unique_id' , session_id());
        session("scene" , $scene);

        //注册
//        if($scene == 1 && !empty($verify_code)){
//            $verify = new Verify();
//            if (!$verify->check($verify_code, 'user_reg')) {
//                ajaxReturn(array('status'=>-1,'msg'=>'图像验证码错误'));
//            }
//        }
        if($type == 'email'){
            //发送邮件验证码
            $logic = new UsersLogic();
            $res = $logic->send_email_code($sender);
            ajaxReturn($res);
        }else{

            //发送短信验证码
            $res['status']=1;


            if($res['status'] != 1){
                ajaxReturn($res);
            }

            //判断是否存在验证码
            $data = db('sms_log')->where(array('mobile'=>$mobile,'session_id'=>$session_id, 'status'=>1))->order('id DESC')->find();
            //获取时间配置
          /*  $sms_time_out = tpCache('sms.sms_time_out');
            $sms_time_out = $sms_time_out ? $sms_time_out : 120;
            //120秒以内不可重复发送
            if($data && (time() - $data['add_time']) < $sms_time_out){
                $return_arr = array('status'=>-1,'msg'=>$sms_time_out.'秒内不允许重复发送');
                ajaxReturn($return_arr);
            }*/
            //随机一个验证码
            $code = rand(1000, 9999); 
            $params['code'] =$code;

            //发送短信
            $resp = sendSms($scene , $mobile , $params, $session_id);

            if($resp['status'] == 1){
                //发送成功, 修改发送状态位成功
                db('sms_log')->where(array('mobile'=>$mobile,'code'=>$code,'session_id'=>$session_id , 'status' => 0))->update(array('status' => 1));
                $return_arr = array('status'=>1,'msg'=>'发送成功,请注意查收');
            }else{
                $return_arr = array('status'=>-1,'msg'=>'发送失败'.$resp['msg']);
            }
            ajaxReturn($return_arr);
        }
    }
    
    /**
     * 验证短信验证码: APP/WAP/PC 共用发送方法
     */
    public function check_validate_code(){
          
        $code = input('post.code');
        $mobile = input('mobile');
        $send = input('send');
        $sender = empty($mobile) ? $send : $mobile; 
        $type = input('type');
        $session_id = input('unique_id', session_id());
        $scene = input('scene', -1);

        $logic = new UsersLogic();
        $res = $logic->check_validate_code($code, $sender, $type ,$session_id, $scene);
        ajaxReturn($res);
    }
    
    /**
     * 检测手机号是否已经存在
     */
    public function issetMobile()
    {
      $mobile = input("mobile",'0');  
      $users = db('users')->where('mobile',$mobile)->find();
      if($users)
          exit ('1');
      else 
          exit ('0');      
    }

    public function issetMobileOrEmail()
    {
        $mobile = input("mobile",'0');        
        $users = db('users')->where("email",$mobile)->whereOr('mobile',$mobile)->find();
        if($users)
            exit ('1');
        else
            exit ('0');
    }

    /**
     * 广告位js
     */
    public function ad_show()
    {
        $pid = input('pid/d',1);
        $where = array(
            'pid'=>$pid,
            'enable'=>1,
            'start_time'=>array('lt',strtotime(date('Y-m-d H:00:00'))),
            'end_time'=>array('gt',strtotime(date('Y-m-d H:00:00'))),
        );
        $ad = D("ad")->where($where)->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->find();
        $this->assign('ad',$ad);
        return $this->fetch();
    }
    /**
     *  搜索关键字
     * @return array
     */
    public function searchKey(){
        $searchKey = input('key');
        $searchKeyList = Db::name('search_word')
            ->where('keywords','like',$searchKey.'%')
            ->whereOr('pinyin_full','like',$searchKey.'%')
            ->whereOr('pinyin_simple','like',$searchKey.'%')
            ->limit(10)
            ->select();
        if($searchKeyList){
            return json(['status'=>1,'msg'=>'搜索成功','result'=>$searchKeyList]);
        }else{
            return json(['status'=>0,'msg'=>'没记录','result'=>$searchKeyList]);
        }
    }

    /**
     * 根据ip设置获取的地区来设置地区缓存
     */
    public function doCookieArea()
    {
//        $ip = '183.147.30.238';//测试ip
        $address = input('address/a',[]);
        if(empty($address) || empty($address['province'])){
            $this->setCookieArea();
            return;
        }
        $province_id = Db::name('region')->where(['level' => 1, 'name' => ['like', '%' . $address['province'] . '%']])->limit('1')->value('id');
        if(empty($province_id)){
            $this->setCookieArea();
            return;
        }
        if (empty($address['city'])) {
            $city_id = Db::name('region')->where(['level' => 2, 'parent_id' => $province_id])->limit('1')->order('id')->value('id');
        } else {
            $city_id = Db::name('region')->where(['level' => 2, 'parent_id' => $province_id, 'name' => ['like', '%' . $address['city'] . '%']])->limit('1')->value('id');
        }
        if (empty($address['district'])) {
            $district_id = Db::name('region')->where(['level' => 3, 'parent_id' => $city_id])->limit('1')->order('id')->value('id');
        } else {
            $district_id = Db::name('region')->where(['level' => 3, 'parent_id' => $city_id, 'name' => ['like', '%' . $address['district'] . '%']])->limit('1')->value('id');
        }
        $this->setCookieArea($province_id, $city_id, $district_id);
    }

    /**
     * 设置地区缓存
     * @param $province_id
     * @param $city_id
     * @param $district_id
     */
    private function setCookieArea($province_id = 1, $city_id = 2, $district_id = 3)
    {
        Cookie::set('province_id', $province_id);
        Cookie::set('city_id', $city_id);
        Cookie::set('district_id', $district_id);
    }
    
}