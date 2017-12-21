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

use think\ArrayHelper;
use think\Model;

class CustomerModel extends Model
{

    public $customer_table = 'p_customer_info';
    public $finance_table  = 'p_finance_info';
    public $page_size = 20;

    /**
     * 查询数据
     * @param $params 参数
     * @return data
     */
    public function getDataList($params)
    {
        $format_where = $this->formatWhere($params,array('order','offset','limit','page','sort'));  //格式化搜索条件数据
        $where = array(
            'a.status' => 1,
            'b.status' => 1
        );
        if($format_where){
            $where = array_merge($where,$format_where);
        }
        $order = 'a.create_time desc';
        if(isset($params['sort']) && $params['sort']){
            $order = $params['sort']." {$params['order']}";
        }
        $limit = ($params['page']-1)*$this->page_size.','.$this->page_size;
        $user_list = $this->table('p_user')->field('id,user_login,user_nickname')->where('user_type = 1')->select()->toArray();
        $user_list = ArrayHelper::getArrayMap($user_list,'id');
        $data = $this->table($this->customer_table)
                ->field('a.id,a.name,a.user_name,a.mobile,a.address,a.create_time,b.invoice_header,b.taxpayer_number,
                b.address as finance_address,b.mobile as finance_mobile,b.account_open_bank,b.bank_account,
                b.customer_manager,b.customer_type,b.intergral_num,b.remarks,b.create_time as finance_create_time')
                ->where($where)
                ->alias('a')
                ->join("{$this->finance_table} b",'a.id = b.customer_id')
                ->order($order)
                ->limit($limit)
                ->select()
                ->toArray();
        if($data){
            foreach($data as &$row){
                $row['customer_manager_name'] = isset($user_list[$row['customer_manager']]['user_login']) ?
                    $user_list[$row['customer_manager']]['user_login'] : '';
            }
            unset($row);
        }
        return $data;
    }

    public function getDataCount($params)
    {
        $where = array(
            'a.status' => 1,
            'b.status' => 1
        );
        $count = $this->table($this->customer_table)
            ->where($where)
            ->alias('a')
            ->join("{$this->finance_table} b",'a.id = b.customer_id')
            ->count('a.id');
        return $count;
    }

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

    public function formatWhere($params, $no_arr)
    {
        $where = array();
        if($params){
            foreach($params as $key=>$row){
                if(in_array($key,$no_arr) || empty($row)){
                   continue;
                }
                switch($key){
                    case 'customer_manager' :
                        $where[$key] = $row;
                        break;
                    case 'name':
                        $where[$key] = ['like','%'.$row.'%'];
                        break;
                    default:
                        $where[] = $key.' = '.$row;
                }
            }
        }
        return $where;
    }
}