<?php


namespace app\admin\controller;
use think\Page;

class ActivitySettingsChampion extends Base {

    public function index(){
        return $this->fetch();
    }
    
    public function activitySettingsChampion(){
     	$act = input('act','add');

    	$this->assign('act',$act);
    	$activity_settings_champion_id = input('activity_settings_champion_id');
        $activity_settings_champion_info = array();
    	if($activity_settings_champion_id){
            $activity_settings_champion_info = db('activity_settings_champion')->where('activity_settings_champion_id='.$activity_settings_champion_id)->find();
    		$this->assign('info',$activity_settings_champion_info);
    	}
        $activity_team = db('activity_team')->column('activity_team_id,name');

        $this->assign('activity_team_select', $activity_team);
        $this->assign('info_date', time() + 3600 * 24);

    	$this->assign("URL_Home", "");
    	return $this->fetch();
    }
    public function grantCouponChampion(){
        $activity_team= db('activity_team')->select();
        $this->assign('activity_team_select', $activity_team);
        //$this->assign('info_date', date('Y-m-d H:m:s',time()));
        $this->assign("URL_Home", "");
        return $this->fetch();
    }

    public function grantCouponChampionHandle(){
        $data = input('post.');

        if($data['activity_team_id']){

            //中奖处理

            $where['activity_team_id']=$data['activity_team_id'];
            $where['result']=2;


            $activity_comp_result_champion['result']=1;
            $activity_comp_result_champion['coupon']=$data['coupon'];
            $acrs=db('activity_comp_result_champion')->where($where)->update($activity_comp_result_champion);


            //未中奖处理

            $not_where['result']=2;
            $not_where['activity_team_id']=array('neq',$data['activity_team_id']);

            $activity_comp_result_champion['result']=0;
            $activity_comp_result_champion['coupon']=0;
            $acrs=db('activity_comp_result_champion')->where($not_where)->update($activity_comp_result_champion);


        }


        if($acrs !== false){
            $this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'操作失败','result'=>'']);
        }
    }

    public function activitySettingsChampionList(){
    	$Ad =  db('activity_settings_champion');
    	$p = $this->request->param('p');
    	$res = $Ad->order('order_sort')->page($p.',10')->select();
    	if($res){
    		foreach ($res as $val){
    			//$val['topic_state'] = $val['topic_state']>1 ? '已发布' : '未发布';
    			//$val['ctime'] = date('Y-m-d H:i',$val['ctime']);
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
    
    public function activitySettingsChampionHandle(){
    	$data = input('post.');

    	if($data['act'] == 'add'){
    		$data['ctime'] = time();
    		$r = db('activity_settings_champion')->insert($data);
    	}
    	if($data['act'] == 'edit'){
    		$r = db('activity_settings_champion')->where('activity_settings_champion_id='.$data['activity_settings_champion_id'])->update($data);
    	}
    	 
    	if($data['act'] == 'del'){
    		$r = db('activity_settings_champion')->where('activity_settings_champion_id='.$data['activity_settings_champion_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
    	 
    	if($r !== false){
			$this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
    	}else{
			$this->ajaxReturn(['status'=>0,'msg'=>'操作失败','result'=>'']);
    	}
    }
}