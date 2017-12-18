<?php
/**
 *-----------------------------------
 * @Author: Wang Ya Hua
 * @Email : 13146042502@163.com
 * @Time  : 2017/12/18  22:51
 * @File  : CustomerModel.php
 * @Description :
 *-----------------------------------
 */
namespace app\admin\model;

use think\Model;

class CustomerModel extends Model
{

    public $customer_table = 'p_customer_info';
    public $finance_table  = 'p_finance_info';

    /**
     * 添加数据
     * @param $data
     * @return bool
     */
    public function addData($data)
    {
        $this->startTrans();
        try{
            $create_time = time();
            $customer_data = $data['customer'];
            $customer_data['create_time'] = $create_time;
            $customer_result = $this->table($this->customer_table)->insertGetId($customer_data);
            $finance_data  = $data['finance'];
            $finance_data['create_time'] = $create_time;
            $finance_data['customer_id'] = $customer_result;
            $finance_result = $this->table($this->finance_table)->insert($finance_data);
            if($customer_result && $finance_result){
                $this->commit();
                return true;
            }else{
                $this->rollback();
                return false;
            }
        } catch (\Exception $e) {
            // 回滚事务
            $this->rollback();
            return false;
        }
    }
}