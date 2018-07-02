<?php
namespace app\mobile\controller;
use app\mobile\controller\base\Base;
use think\Db;

class Coupons extends Base
{

    public function index()
    {
        if(!session('user')){
            return $this->redirect('/mobile/user/regjc');

        }
        $activity_settings_where['user_id']=session('user')['id'];
        $activity_settings_where['result']=1;
        $activity_comp_result = db('activity_comp_result')->where($activity_settings_where)->select();

        $activity_comp_result_champion = db('activity_comp_result_champion')->where($activity_settings_where)->select();

        $activity_comp_result_arr=array();
        foreach ($activity_comp_result as $k=>$acr){
            if(date('Y-m-d',time())>$acr['expiration_date'])
                $acr['expiration_date_status']=1;
            else
                $acr['expiration_date_status']=0;
            array_push($activity_comp_result_arr,$acr);
        }
        $this->assign('activity_comp_result_champion', $activity_comp_result_champion);
        $this->assign('activity_comp_result', $activity_comp_result_arr);
        $navigation = db('navigation')->order('sort')->select();
        $this->assign('navigation', $navigation);
        if( db('activity_comp_result')->where(['result'=>1])->count()&&db('activity_comp_result_champion')->where(['result'=>1])){
            return $this->fetch();
        }else{
            return $this->fetch("index2");
        }

    }

    public function activityCoupons(){


        $code = input('code');
        if(!empty(session('user'))){

            if($code){

                    $data['cancellation_coupons']=1;
                    $r = db('activity_comp_result')->where(['user_id'=>session('user')['id'],'coupon_code'=>$code])->update($data);


            }else{
                $this->ajaxReturn(['status'=>0,'msg'=>'参数错误','result'=>'user']);
            }
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'未登录','result'=>'user']);
        }
        if($r){
            $this->ajaxReturn(['status'=>1,'msg'=>'核销成功','result'=>'']);
        }

    }
    public function activityCouponsG(){


        $code = input('code');
        if(!empty(session('user'))){

            if($code){

                $data['cancellation_coupons']=1;
                $r = db('activity_comp_result_champion')->where(['user_id'=>session('user')['id'],'coupon_code'=>$code])->update($data);


            }else{
                $this->ajaxReturn(['status'=>0,'msg'=>'参数错误','result'=>'user']);
            }
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'未登录','result'=>'user']);
        }
        if($r){
            $this->ajaxReturn(['status'=>1,'msg'=>'核销成功','result'=>'']);
        }

    }
	
    public function shareCoupons(){

        if(session('user')){
            $code = input('code');
            $code= substr($code,count($code)-17);
            $data['share_coupon_validate']=1;
             $r = db('activity_comp_result')->where(['user_id'=>session('user')['id'],'coupon_code'=>$code])->update($data);
        }
        if(r){
            $this->ajaxReturn(['status'=>1,'msg'=>'复制成功','result'=>$code]);
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'您已经分享过此优惠券','result'=>'']);
        }


    }
}