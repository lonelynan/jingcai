<?php


namespace app\admin\controller;
use think\Page;

class ActivityTeam extends Base {

    public function index(){
        return $this->fetch();
    }
    
    public function activityTeam(){
    	$act = input('act','add');
    	$this->assign('act',$act);
    	 $activity_team_id = input('activity_team_id');
    	$activity_team_info = array();
    	if($activity_team_id){
    		$activity_team_info = db('activity_team')->where('activity_team_id='.$activity_team_id)->find();
    		$this->assign('info',$activity_team_info);
    	}

    	$this->assign("URL_Home", "");
    	return $this->fetch();
    }
    
    public function activityTeamList(){
    	$Ad =  db('activity_team');
	$p = $this->request->param('p');
    	$res = $Ad->order('activity_team_id')->page($p.',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$val['ctime'] = date('Y-m-d H:i',$val['ctime']);
    			$list[] = $val;
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
    
    public function activityTeamHandle(){
    	$data = input('post.');       

    	if($data['act'] == 'add'){
    		$data['ctime'] = time();
    		$r = db('activity_team')->insert($data);
    	}
    	if($data['act'] == 'edit'){
    		$r = db('activity_team')->where('activity_team_id='.$data['activity_team_id'])->update($data);
    	}
    	 
    	if($data['act'] == 'del'){
    		$r = db('activity_team')->where('activity_team_id='.$data['activity_team_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
    	 
    	if($r !== false){
			$this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
    	}else{
			$this->ajaxReturn(['status'=>0,'msg'=>'操作失败','result'=>'']);
    	}
    }
}