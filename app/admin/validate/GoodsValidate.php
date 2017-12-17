<?php
/**
 * Created by PhpStorm.
 * User: wyl
 * Date: 2017/12/17
 * Time: 22:43
 */

namespace app\admin\validate;


use think\Validate;

class GoodsValidate extends Validate
{
    protected $rule = [
        'goods_id'  =>  'require|max:25',
        'goods_name' =>  'require',
        'goods_cas' =>  'require',
        'p_price' =>  'number|float',
        's_price' =>  'number|float',
    ];

    protected $message = [
        'goods_id.require'  =>  '商品编号必须',
        'goods_id.max' =>  '商品编号最大长度为25字符',
        'goods_name.require' =>  '商品名称必须',
        'goods_cas.require' =>  'CAS号必须',
        'p_price.number' =>  '进价必须为数字类型',
        's_price.number' =>  '售价必须为数字类型',
    ];

    protected $scene = [
        'add'   =>  ['goods_id','goods_name','goods_cas','p_price','s_price'],
        'edit'  =>  ['email'],
    ];

}