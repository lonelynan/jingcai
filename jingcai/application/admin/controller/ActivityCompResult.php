<?php


namespace app\admin\controller;
use think\Page;

class ActivityCompResult extends Base {

    public function index(){
        return $this->fetch();
    }
    
    public function activityCompResult(){
    	$act = input('act','add');
    	$this->assign('act',$act);
    	$activity_comp_result_id = input('activity_comp_result_id');
    	$activity_comp_result_info = array();
    	if($activity_comp_result_id){
    		$activity_comp_result_info = db('activity_comp_result')->where('activity_comp_result_id='.$activity_comp_result_id)->find();



            $activity_comp_result_info['activity_settings_id'] = db('activity_settings')->where('activity_settings_id='.$activity_comp_result_info['activity_settings_id'])->find()['title'];
                $activity_team_id = explode("_",$activity_comp_result_info['activity_team_id']);
                $activity_team="";
                foreach ($activity_team_id as $v){
                    $activity_team.= db('activity_team')->where('activity_team_id='.$v)->find()['name']."-";
                }
            $activity_comp_result_info['activity_team_id'] =substr($activity_team,0,$activity_team.length-1);




    		$this->assign('info',$activity_comp_result_info);
    	}

    	$this->assign("URL_Home", "");
    	return $this->fetch();
    }
    
    public function ActivityCompResultList(){
    	$Ad =  db('activity_comp_result');
	$p = $this->request->param('p');
    	$res = $Ad->order('activity_comp_result_id')->page($p.',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$val['result'] = $val['result']==1 ? '中奖' : '未中奖';
                $val['activity_settings_id'] = db('activity_settings')->where('activity_settings_id='.$val['activity_settings_id'])->find()['title'];
                $activity_team_id = explode("_",$val['activity_team_id']);
                $activity_team="";
                foreach ($activity_team_id as $v){
                    $activity_team.= db('activity_team')->where('activity_team_id='.$v)->find()['name']."-";
                }
                $val['activity_team_id'] =substr($activity_team,0,$activity_team.length-1);
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
    
    public function activityCompResultHandle(){
    	$data = input('post.');
    	if($data['act'] == 'add'){
    		$data['ctime'] = time();
    		$r = db('activity_comp_result')->insert($data);
    	}
    	if($data['act'] == 'edit'){
    		$r = db('activity_comp_result')->where('activity_comp_result_id='.$data['activity_comp_result_id'])->update($data);
    	}
    	 
    	if($data['act'] == 'del'){
    		$r = db('activity_comp_result')->where('activity_comp_result_id='.$data['activity_comp_result_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
    	 
    	if($r !== false){
			$this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
    	}else{
			$this->ajaxReturn(['status'=>0,'msg'=>'操作失败','result'=>'']);
    	}
    }
	 public function export_result(){
        $strTable ='<table width="500" border="1">';
        $strTable .= '<tr>';
        $strTable .= '<td style="text-align:center;font-size:12px;width:120px;">会员名称</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="100">竞猜类型</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">获得积分</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">是否猜中</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">核销优惠券</td>';

        $strTable .= '</tr>';
        $count = db('activity_comp_result')->count();





        $p = ceil($count/5000);
        for($i=0;$i<$p;$i++){
            $start = $i*5000;
            $end = ($i+1)*5000;
            $res = db('activity_comp_result')->order('activity_comp_result_id')->page($start,$end)->select();
            if($res){
                foreach ($res as $val){
                    $val['result'] = $val['result']==1 ? '中奖' : '未中奖';
                    $val['cancellation_coupons'] = $val['cancellation_coupons']==1 ? '已核销' : '未核销';
                    $val['activity_settings_id'] = db('activity_settings')->where('activity_settings_id='.$val['activity_settings_id'])->find()['title'];
                    $activity_team_id = explode("_",$val['activity_team_id']);
                    $activity_team="";
                    foreach ($activity_team_id as $v){
                        $activity_team.= db('activity_team')->where('activity_team_id='.$v)->find()['name']."-";
                    }
                    $val['activity_team_id'] =substr($activity_team,0,$activity_team.length-1);
                    //$val['ctime'] = date('Y-m-d H:i',$val['ctime']);
                    $list[] = $val;
                }
            }
            if(is_array($list)){
                foreach($list as $k=>$val){
                    $strTable .= '<tr>';
                    $strTable .= '<td style="text-align:center;font-size:12px;">'.$val['user_name'].'</td>';
                    $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['activity_settings_id'].' </td>';
                    $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['activity_team_id'].'</td>';
                    $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['result'].'</td>';
                    $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['cancellation_coupons'].'</td>';
                    $strTable .= '</tr>';
                }
                unset($list);
            }
        }
        $strTable .='</table>';
        downloadExcel($strTable,'jingcai_'.$i);
        exit();
    }

}