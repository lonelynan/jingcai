<?php


namespace app\admin\controller;
use think\Page;
use app\admin\logic\RndChinaName;
class ActivityCompResultFalse extends Base {

    public function index(){
        return $this->fetch();
    }
    
    public function activityCompResultFalse(){
    	$act = input('act','add');
    	$this->assign('act',$act);
    	$activity_comp_result_false_id = input('activity_comp_result_false_id');
    	$activity_comp_result_false_info = array();

    	if($activity_comp_result_false_id){
    		$activity_comp_result_false_info = db('activity_comp_result_false')->where('activity_comp_result_false_id='.$activity_comp_result_false_id)->find();
            $activity_comp_result_false_info['activity_settings_id'] = db('activity_settings')->where('activity_settings_id='.$activity_comp_result_false_info['activity_settings_id'])->find()['title'];
                $activity_team_id = explode("_",$activity_comp_result_false_info['activity_team_id']);
                $activity_team="";
                foreach ($activity_team_id as $v){
                    $activity_team.= db('activity_team')->where('activity_team_id='.$v)->find()['name']."-";
                }
            $activity_comp_result_false_info['activity_team_id'] =substr($activity_team,0,$activity_team.length-1);




    		$this->assign('info',$activity_comp_result_false_info);
            $this->assign("URL_Home", "");
            return $this->fetch();
    	}else{

    	    $activity_settings= db('activity_settings')->select();

            $this->assign("activity_settings", $activity_settings);
            $this->assign("URL_Home", "");
            return $this->fetch('addActivityCompResultFalse');
        }


    }
    
    public function ActivityCompResultFalseList(){



    	$Ad =  db('activity_comp_result_false');
	$p = $this->request->param('p');
    	$res = $Ad->order('activity_comp_result_false_id')->page($p.',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$val['result'] = $val['result']==1 ? '中奖' : '未中奖';
                $val['activity_settings_id'] = db('activity_settings')->where('activity_settings_id='.$val['activity_settings_id'])->find()['title'];
                $activity_team_id = explode("_",$val['activity_team_id']);
                $activity_team="";
                if($activity_team_id){
                    foreach ($activity_team_id as $v){

                        $activity_team.= db('activity_team')->where('activity_team_id='.$v)->find()['name']."-";
                    }
                    $val['activity_team_id'] =substr($activity_team,0,$activity_team.length-1);
                    //$val['ctime'] = date('Y-m-d H:i',$val['ctime']);
                    $list[] = $val;
                }

    		}
    	}
    	$this->assign('list',$list);// 赋值数据集
    	$count = $Ad->count();// 查询满足要求的总记录数
    	$Page = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
    	$show = $Page->show();// 分页显示输出
	    $this->assign('pager',$Page);
    	$this->assign('page',$show);// 赋值分页输出
    	return $this->fetch();
    }
    
    public function activityCompResultFalseHandle(){
    	$data = input('post.');







    	if($data['act'] == 'add'){

            $activity_settings_info=db('activity_settings')->where('activity_settings_id='.$data['activity_settings_id'])->find();
            $rand=array($activity_settings_info['activity_team1_id'],$activity_settings_info['activity_team2_id'],$activity_settings_info['activity_team1_id']._.$activity_settings_info['activity_team2_id']);




            for($j=0;$j<$data['number'];$j++){


                $name_obj = new RndChinaName();
                $name = $name_obj->getName(2);
                $data['user_id']=0;
                $data['user_name']=$name;
                $data['activity_team_id']=$rand[mt_rand(0,count($rand)-1)];
                $r = db('activity_comp_result_false')->insert($data);
            }

    		//$data['add_time'] = time();

    	}
    	if($data['act'] == 'edit'){
    		$r = db('activity_comp_result_false')->where('activity_comp_result_false_id='.$data['activity_comp_result_false_id'])->update($data);
    	}
    	 
    	if($data['act'] == 'del'){
    		$r = db('activity_comp_result_false')->where('activity_comp_result_false_id='.$data['activity_comp_result_false_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
    	 
    	if($r !== false){
			$this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
    	}else{
			$this->ajaxReturn(['status'=>0,'msg'=>'操作失败','result'=>'']);
    	}
    }
}