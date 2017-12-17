<?php
/**
 * Created by PhpStorm.
 * User: wyl
 * Date: 2017/12/17
 * Time: 22:01
 */

namespace app\admin\model;


use think\Model;

class GoodsModel extends Model
{
    public function addGoods($data)
    {
        $result = $this->validate(true)->save($data);
        return $result;
    }
}