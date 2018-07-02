<?php


namespace app\admin\controller;
use think\Page;

class ActivityStep extends Base {

    public function index(){
        return $this->fetch();
    }
    
    public function activityStep(){

    		$topic_info = db('activity_step')->where('activity_step_id=1')->find();
    		$this->assign('info',$topic_info);


    	$this->assign("URL_Home", "");
    	return $this->fetch();
    }

    public function activityStepHandle(){
    	$data = input('post.');
    		$r = db('activity_step')->where('activity_step_id=1')->update($data);

    	if($r !== false){
			$this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
    	}else{
			$this->ajaxReturn(['status'=>0,'msg'=>'操作失败','result'=>'']);
    	}
    }
}