<?php


namespace app\admin\controller;
use think\Page;

class ActivitySettings extends Base {

    public function index(){
        return $this->fetch();
    }
    
    public function activitySettings(){
     	$act = input('act','add');

    	$this->assign('act',$act);
    	$activity_settings_id = input('activity_settings_id');
        $activity_settings_info = array();
    	if($activity_settings_id){
            $activity_settings_info = db('activity_settings')->where('activity_settings_id='.$activity_settings_id)->find();
    		$this->assign('info',$activity_settings_info);
    	}
        $activity_team = db('activity_team')->column('activity_team_id,name');

        $this->assign('activity_team_select', $activity_team);
        $this->assign('info_date', time() + 3600 * 24);

    	$this->assign("URL_Home", "");
    	return $this->fetch();
    }
    public function grantCoupon(){
        $act = input('act','add');

        $this->assign('act',$act);
        $activity_settings_id = input('activity_settings_id');
        $activity_team = array();
        if($activity_settings_id){
            $activity_settings_info = db('activity_settings')->where('activity_settings_id='.$activity_settings_id)->find();

            $rand=array($activity_settings_info['activity_team1_id'],$activity_settings_info['activity_team2_id']);



                foreach ($rand as $key=>$v ){
                    $activity_team[$key]['activity_team_id']=$v;
                    $activity_team[$key]['name']= db('activity_team')->where('activity_team_id='.$v)->find()['name']."";
                }

                $activity_team[2]['activity_team_id']=$activity_team[0]['activity_team_id']."_".$activity_team[1]['activity_team_id'];
            $activity_team[2]['name']=$activity_team[0]['name']."_".$activity_team[1]['name'];
            $this->assign('info',$activity_settings_info);
        }

        $this->assign('activity_team_select', $activity_team);
        $this->assign('info_date', time() + 3600 * 24);

        $this->assign("URL_Home", "");
        return $this->fetch();
    }

    public function grantCouponHandle(){
        $data = input('post.');

        if($data['activity_settings_id']&&$data['activity_team_id']){
            //中奖处理
            $where['activity_settings_id']=$data['activity_settings_id'];
            $where['activity_team_id']=$data['activity_team_id'];

            $where['result']=2;
            $activity_settings['grant_coupon_state']=1;
            db('activity_settings')->where('activity_settings_id='.$data['activity_settings_id'])->update($activity_settings);

            $activity_comp_results=db('activity_comp_result')->where($where)->select();
            $step_arr=array();
            $activity_step_info= db('activity_step')->where(['activity_step_id'=>1])->find();
            $i=0;
            foreach ($activity_step_info as $k=>$v){
            if($i!=0)
                $step_arr[$i]=$v;
                $i++;
            }
            foreach ($activity_comp_results as $activity_comp_result_info){


                //db('activity_participation')->where(['user_id'=>$activity_comp_result_info['user_id']])->setInc('guess_count');
                db('activity_participation')->where(['user_id'=>$activity_comp_result_info['user_id']])->setInc('guessing_count');
                $activity_participation_info= db('activity_participation')->where(['user_id'=>$activity_comp_result_info['user_id']])->find();
                if($activity_participation_info['guessing_count']<=12){
                    $activity_comp_result['result']=1;
                    $activity_comp_result['expiration_date']=$data['expiration_date'];

                    $activity_comp_result['coupon_code']=substr(md5(time().rand(0,100000)), 8, 16);
                    $activity_comp_result['coupon']=$data['coupon']+$step_arr[$activity_participation_info['guessing_count']];
                    $acrs=db('activity_comp_result')->where($where)->update($activity_comp_result);
                }else{
                    $activity_comp_result['expiration_date']=$data['expiration_date'];
                    $activity_comp_result['result']=1;
                    $activity_comp_result['coupon_code']=substr(md5(time().rand(0,100000)), 8, 16);
                    $activity_comp_result['coupon']=$data['coupon']+$step_arr[12];
                    $acrs=db('activity_comp_result')->where($where)->update($activity_comp_result);
                }

            }
            //未中奖处理
            $not_where['activity_settings_id']=$data['activity_settings_id'];
            $not_where['result']=2;
            $not_where['activity_team_id']=array('neq',$data['activity_team_id']);


            $activity_comp_results=db('activity_comp_result')->where($not_where)->select();
            foreach ($activity_comp_results as $activity_comp_result_info){


                //db('activity_participation')->where(['user_id'=>$activity_comp_result_info['user_id']])->setInc('guess_count');
                db('activity_participation')->where(['user_id'=>$activity_comp_result_info['user_id']])->update(['guessing_count'=>0]);


                    $activity_comp_result['result']=0;
                    $activity_comp_result['coupon']=0;
                    $acrs=db('activity_comp_result')->where($not_where)->update($activity_comp_result);

            }



            $activity_comp_result_false['result']=1;
            $activity_comp_result_false['coupon']=$data['coupon'];
            db('activity_comp_result_false')->where($where)->update($activity_comp_result_false);
        }


        if($acrs !== false){
            $this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'操作失败','result'=>'']);
        }
    }

    public function activitySettingsList(){
    	$Ad =  db('activity_settings');
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
    
    public function activitySettingsHandle(){
    	$data = input('post.');

    	if($data['act'] == 'add'){
    		$data['ctime'] = time();
    		$r = db('activity_settings')->insert($data);
    	}
    	if($data['act'] == 'edit'){
    		$r = db('activity_settings')->where('activity_settings_id='.$data['activity_settings_id'])->update($data);
    	}
    	 
    	if($data['act'] == 'del'){
    		$r = db('activity_settings')->where('activity_settings_id='.$data['activity_settings_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
    	 
    	if($r !== false){
			$this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
    	}else{
			$this->ajaxReturn(['status'=>0,'msg'=>'操作失败','result'=>'']);
    	}
    }
    public function export_result(){
        $activity_settings_id = input('activity_settings_id');
        $strTable ='<table width="500" border="1">';
        $strTable .= '<tr>';
        $strTable .= '<td style="text-align:center;font-size:12px;width:120px;">会员名称</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="100">竞猜类型</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">获得积分</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">是否猜中</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">核销优惠券</td>';

        $strTable .= '</tr>';
        $count = db('activity_comp_result')->where('activity_settings_id='.$activity_settings_id)->count();





        $p = ceil($count/5000);
        for($i=0;$i<$p;$i++){
            $start = $i*5000;
            $end = ($i+1)*5000;
            $res = db('activity_comp_result')->where('activity_settings_id='.$activity_settings_id)->page($start,$end)->select();
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
        downloadExcel($strTable,'jingcai'.$activity_settings_id.'_'.$i);
        exit();
    }
}