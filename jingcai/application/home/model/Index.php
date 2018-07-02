<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Index extends Model
{
    protected $categoryDB = 'mat_category';
    public function index()
    {
      return  $query=DB::query('select * from mat_category where del_flg=0');

    }

}
