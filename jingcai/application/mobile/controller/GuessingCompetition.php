<?php
namespace app\mobile\controller;
use app\mobile\controller\base\Base;
use think\Db;

class GuessingCompetition extends Base
{

    public function index()
    {  if(!session('user')){
        return $this->redirect('/mobile/user/regjc');

    }
        $activity_settings_where['start_date']=array('elt',date('Y-m-d H:m:s',time()));
        $activity_settings_where['end_date']=array('egt',date('Y-m-d H:m:s',time()));
        $activity_settings_where['show_in_nav']=1;
        $activity_settings = db('activity_settings')->alias('ac')
            ->join('activity_team at1','ac.activity_team1_id=at1.activity_team_id')
            ->join('activity_team at2','ac.activity_team2_id=at2.activity_team_id')
            ->field('at1.name name1,at1.activity_team_image activity_team_image1,at2.name name2,at2.activity_team_image activity_team_image2,ac.activity_settings_id,
                     ac.activity_team1_id ,ac.activity_team2_id,number_participants1,number_participants2 ')
        ->where($activity_settings_where)->order('activity_settings_id desc')->select();
        if($activity_settings){
            foreach ($activity_settings as $val){
                $activity_team1__count=db('activity_comp_result')->where(['activity_settings_id'=>$val['activity_settings_id'],'activity_team_id'=>$val['activity_team1_id']])->count();
                $activity_team2__count=db('activity_comp_result')->where(['activity_settings_id'=>$val['activity_settings_id'],'activity_team_id'=>$val['activity_team2_id']])->count();


                $val['activity_team1__count'] = $val['number_participants1']+$activity_team1__count;
                $val['activity_team2__count'] = $val['number_participants2']+$activity_team2__count;
                $list[] = $val;
            }
        }
        $this->assign('activity_settings', $list);
        $navigation = db('navigation')->order('sort')->select();
        $this->assign('navigation', $navigation);

        if($list){
            return $this->fetch();
        }else{
            return $this->fetch("index2");
        }

    }
    public function activityCompResult(){

        $activity_settings_id = input('activity_settings_id');
        $activity_team_id = input('activity_team_id');
        if(!empty(session('user'))){

            if(!(db('activity_participation')->where(['user_id'=>session('user')['id']])->find())){
                db('activity_participation')->insert(['user_id'=>session('user')['id'],'user_name'=>session('user')['nickname']]);
            }

          if($activity_settings_id&&$activity_team_id){

              if(db('activity_comp_result')->where(['user_id'=>session('user')['id'],'activity_settings_id'=>$activity_settings_id])->count()>0){
                  $this->ajaxReturn(['status'=>0,'msg'=>'该组已竞猜过','result'=>'']);
              }

                $data['activity_settings_id']=$activity_settings_id;
                $data['activity_team_id']=$activity_team_id;
                $data['user_id']=session('user')['id'];
                $data['user_name']=session('user')['nickname'];

                $r = db('activity_comp_result')->insert($data);
              db('activity_participation')->where(['user_id'=>session('user')['id']])->setInc('guess_count');
            }else{
                $this->ajaxReturn(['status'=>0,'msg'=>'参数错误','result'=>'user']);
            }
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'未登录','result'=>'user']);
        }
        if($r){
           $activity_team_id = explode("_",$activity_team_id);
            $activity_team="";
            foreach ($activity_team_id as $v){
                $activity_team.= db('activity_team')->where('activity_team_id='.$v)->find()['name']."-";
            }
            $name =substr($activity_team,0,$activity_team.length-1);

            $this->ajaxReturn(['status'=>1,'msg'=>'竞猜成功,您选择的国家是:（'.$name.')','result'=>'']);
        }

    }

}