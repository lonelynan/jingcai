<?php
namespace app\mobile\controller;
use app\mobile\controller\base\Base;
use think\Db;

class Article extends Base
{
    /**
     * 文章内容页
     */
    public function detail()
    {
        $article_id = input('article_id/d', 1);
        $article = Db::name('article')->where("article_id", $article_id)->find();
        $this->assign('article', $article);
        return $this->fetch();
    }
    public function artleList(){
        if(!session('user')){
            return $this->redirect('/mobile/user/regjc');

        }
        $articlelist=db('article')->select();

        $this->assign('articlelist', $articlelist);
        return $this->fetch();
    }

}