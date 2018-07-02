<?php


namespace app\admin\controller;
use think\Page;

class Topic extends Base {

    public function index(){
        return $this->fetch();
    }
    
    public function topic(){
    	$act = input('get.act','add');
    	$this->assign('act',$act);
    	$topic_id = input('get.topic_id');
    	$topic_info = array();
    	if($topic_id){
    		$topic_info = db('topic')->where('topic_id='.$topic_id)->find();
    		$this->assign('info',$topic_info);
    	}
    	
    	$this->assign("URL_upload", url('Admin/UeditorController.class/imageUp',array('savepath'=>'topic')));
    	$this->assign("URL_fileUp", url('Admin/UeditorController.class/fileUp',array('savepath'=>'topic')));
    	$this->assign("URL_scrawlUp", url('Admin/UeditorController.class/scrawlUp',array('savepath'=>'topic')));
    	$this->assign("URL_getRemoteImage", url('Admin/UeditorController.class/getRemoteImage',array('savepath'=>'topic')));
    	$this->assign("URL_imageManager", url('Admin/UeditorController.class/imageManager',array('savepath'=>'topic')));
    	$this->assign("URL_imageUp", url('Admin/UeditorController.class/imageUp',array('savepath'=>'topic')));
    	$this->assign("URL_getMovie", url('Admin/UeditorController.class/getMovie',array('savepath'=>'topic')));
    	$this->assign("URL_Home", "");
    	return $this->fetch();
    }
    
    public function topicList(){
    	$Ad =  db('topic');
	$p = $this->request->param('p');
    	$res = $Ad->order('ctime')->page($p.',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$val['topic_state'] = $val['topic_state']>1 ? '已发布' : '未发布';
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
    
    public function topicHandle(){
    	$data = input('post.');       
        $data['topic_content'] = $_POST['topic_content']; // 这个内容不做转义        
    	if($data['act'] == 'add'){
    		$data['ctime'] = time();
    		$r = db('topic')->insert($data);
    	}
    	if($data['act'] == 'edit'){
    		$r = db('topic')->where('topic_id='.$data['topic_id'])->update($data);
    	}
    	 
    	if($data['act'] == 'del'){
    		$r = db('topic')->where('topic_id='.$data['topic_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
    	 
    	if($r !== false){
			$this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
    	}else{
			$this->ajaxReturn(['status'=>0,'msg'=>'操作失败','result'=>'']);
    	}
    }
}