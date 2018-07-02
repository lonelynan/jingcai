<?php

namespace app\home\Controller;

use think\Controller;
use think\Db;
use think\Session;

class Index extends Base
{


    public function index(){

        if(cookie('is_mobile')==1){

            $this->redirect('/mobile');
        }

        db('config')->where(['name'=>'visit_count'])->setInc('value');

        if(!session('user')){
            return $this->redirect('/home/user');

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

    public function asccode($c=""){
        $url="";
         if(cookie('is_mobile')==1){
             $url='/mobile';
         }else{

         }
        if($c){
            if(db('activity_comp_result')->where(['coupon_code'=>$c,'share_coupon_validate'=>1])->count()){
                if(!session('user')){
                    session('asccode',$c);
                    return $this->redirect($url.'/');

                }else{
                    $data['share_coupon_validate']=0;
                    $data['user_id']=session('user')['id'];
                    $data['user_name']=session('user')['nickname'];

                    $r = db('activity_comp_result')->where(['coupon_code'=>$c,'share_coupon_validate'=>1])->update($data);
                    if($r){
                        return $this->redirect($url.'/');
                    }
                }

            }else{
                echo '<h2>此优惠券已被领取，您可继续参与下场竞猜</h2>';
            }

        }

    }
}
