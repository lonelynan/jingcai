<?php
namespace app\mobile\controller;
use app\mobile\controller\base\Base;
use think\Db;

class GuessingCompetitionChampion extends Base
{

    public function index()
    {  if(!session('user')){
        return $this->redirect('/mobile/user/regjc');

    }
	
        $activity_settings_where['start_date']=array('elt',date('Y-m-d H:m:s',time()));
        $activity_settings_where['end_date']=array('egt',date('Y-m-d H:m:s',time()));
        $activity_settings_where['show_in_nav']=1;
	
        $activity_settings = db('activity_settings_champion')->alias('asc')
            ->join('activity_team at1','asc.activity_team1_id=at1.activity_team_id')
            ->join('activity_team at2','asc.activity_team2_id=at2.activity_team_id')
            ->join('activity_team at3','asc.activity_team3_id=at3.activity_team_id')
            ->join('activity_team at4','asc.activity_team4_id=at4.activity_team_id')
            ->field('at1.name name1,at1.activity_team_image activity_team_image1,at2.name name2,at2.activity_team_image activity_team_image2,at3.name name3,at3.activity_team_image activity_team_image3,at4.name name4,at4.activity_team_image activity_team_image4,asc.activity_settings_champion_id
            ,at1.status as status1,at2.status as status2,at3.status as status3,at4.status as status4,asc.activity_team1_id ,asc.activity_team2_id,asc.activity_team3_id ,asc.activity_team4_id,asc.title')
        ->where($activity_settings_where)->order('activity_settings_champion_id')->select();
	
			
$is_name= db('activity_comp_result_champion')->alias('acc')
            ->join('activity_team at','acc.activity_team_id=at.activity_team_id')
            ->field('at.name')
            ->where(['user_id'=>session('user')['id']])->find()['name'];

$is_name= db('activity_comp_result_champion')->alias('acc')
            ->join('activity_team at','acc.activity_team_id=at.activity_team_id')
            ->field('at.name')
            ->where(['user_id'=>session('user')['id']])->find()['name'];

        if($is_name)
        $this->assign('is_name', '您已猜过冠军:('.$is_name.")");
        $this->assign('activity_settings_champion', $activity_settings);
        $navigation = db('navigation')->order('sort')->select();
        $this->assign('navigation', $navigation);
        return $this->fetch();
    }
    public function activityCompResultChampion(){


        $activity_team_id = input('activity_team_id');
        if(!empty(session('user'))){

            if(!(db('activity_participation')->where(['user_id'=>session('user')['id']])->find())){
                db('activity_participation')->insert(['user_id'=>session('user')['id'],'user_name'=>session('user')['nickname']]);
            }

            if($activity_team_id){

                if(db('activity_comp_result_champion')->where(['user_id'=>session('user')['id']])->count()>0){
                    $name= db('activity_comp_result_champion')->alias('acc')
                        ->join('activity_team at','acc.activity_team_id=at.activity_team_id')
                        ->field('at.name')
                        ->where(['user_id'=>session('user')['id']])->find()['name'];

                    $this->ajaxReturn(['status'=>0,'msg'=>'您已猜过冠军:('.$name.")",'result'=>'']);
                }

                $data['activity_settings_id']=0;
                $data['activity_team_id']=$activity_team_id;
                $data['user_id']=session('user')['id'];
                $data['user_name']=session('user')['nickname'];

                $r = db('activity_comp_result_champion')->insert($data);
                db('activity_participation')->where(['user_id'=>session('user')['id']])->setInc('guess_count');
            }else{
                $this->ajaxReturn(['status'=>0,'msg'=>'请选择国家','result'=>'user']);
            }
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'未登录','result'=>'user']);
        }
        if($r){
            $this->ajaxReturn(['status'=>1,'msg'=>'竞猜成功','result'=>'']);
        }

    }

}
