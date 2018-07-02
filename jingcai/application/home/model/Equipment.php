<?php

namespace app\home\model;

use think\Model;
use think\Db;

class Equipment extends Model
{
    protected $categoryDB = "mat_category";

    public function index()
    {

    }

    public function getEquipmentCategory()
    {

        return $query = DB::query("select mec.id,mec.equipment_category_name,COUNT(me.id)as count FROM mat_equipment_category as mec LEFT JOIN mat_equipment as me ON mec.id=me.equipment_category_id GROUP BY mec.id,mec.equipment_category_name ORDER BY id DESC ");
    }

    public function getEquipmentCategoryProvince($province)
    {

        return $query = DB::query("select mec.id,mec.equipment_category_name,COUNT(me.id)as count FROM mat_equipment_category  mec  JOIN mat_equipment  me ON mec.id=me.equipment_category_id and me.province_city=$province  GROUP BY mec.id,mec.equipment_category_name ORDER BY id DESC ");
    }

    public function getEquipmentProvince()
    {
        //只查询分类有数据
        return $query = DB::query("select ap.province_id as id,ap.province,COUNT(me.id)as count FROM ad_province as ap , mat_equipment as me where ap.province_id=me.province_city GROUP BY   id,ap.province ORDER BY count DESC  ");

  }
    public function getEquipmentProvinceS($province)
    {
        //只查询分类有数据
        return $query = DB::query("select ap.province_id as id,ap.province,COUNT(me.id)as count FROM ad_province as ap , mat_equipment as me where ap.province_id=me.province_city and me.province_city=$province GROUP BY   id,ap.province ORDER BY count DESC  ");

    }


    public function getEquipment()
    {
        return $query = DB::query("select * from mat_equipment   limit 1,9 ");
    }

    public function getCountEquipment()
    {
        return $query = DB::query("select COUNT(*)as count from mat_equipment ");
    }

    /*
 * 统计单位
 */
    public function getCountUnitName()
    {

        return $query = DB::query("SELECT count(DISTINCT unit_name) count FROM mat_equipment");
    }

    public function getCountEquipmentS($province)
    {
        return $query = DB::query("select COUNT(*)as count from mat_equipment where province_city=$province");
    }

    /*
 * 统计单位
 */
    public function getCountUnitNameS($province)
    {

        return $query = DB::query("SELECT count(DISTINCT unit_name) count FROM mat_equipment where province_city=$province");
    }

    //查询Equipment表分类ID
    public function getEquipmentCategoryId($equipment_name)
    {
        return $query = DB::query("select DISTINCT equipment_category_id from mat_equipment where ch_name='$equipment_name'");
    }

    //查询Equipment_Category表分类Name
    public function getEquipmentCategoryName($id)
    {
        return $query = DB::query("select  equipment_category_name from mat_equipment_category where id='$id'");
    }

    //图表
    public function getEquipmentChart()
    {

        return $query = DB::query("select mec.equipment_category_name as value,mec.equipment_category_name as name,COUNT(me.id)as num FROM mat_equipment_category as mec LEFT JOIN mat_equipment as me ON mec.id=me.equipment_category_id GROUP BY equipment_category_name
 ");
    }

    /*
     * 根据ID获取行
     */
    public function getEquipmentRow($id)
    {
        return $query = DB::query("select * from mat_equipment   where id=" . $id);
    }

    //获取地区省份
    public function getProvince($province_id)
    {
        return $query = DB::query("select * from ad_province   where province_id=" . $province_id);
    }


}
