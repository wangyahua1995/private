<?php
/**
 * Created by PhpStorm.
 * User: wangyahua
 * Date: 2017/12/21
 * Time: 14:16
 */
namespace think;

class ArrayHelper
{
    /**
     * 数组键值重组
     * @param $array      array( 0 => array('id'=>1, 'time'=>2003, 'name'=>'jack'))
     * @param $columnKey  array('id','time') or 'time'
     * @param $prefix     '_'
     * @return array      array( '1_2003' => array('id'=>1, 'time'=>2003, 'name'=>'jack')) or array( 2003 => array('id'=>1, 'time'=>2003, 'name'=>'jack'))
     */
    public static function getArrayMap($array, $columnKey, $prefix = '')
    {
        if (!is_array($columnKey))
        {
            $array_tmp = array();
            foreach ($array as $row)
            {
                $array_tmp[$row[$columnKey]] = $row;
            }
        }
        else
        {
            $array_tmp = array();
            foreach ($array as $row)
            {
                $key = '';
                foreach ($columnKey as $k => $v)
                {
                    $pre = ($k == 0) ? '' : $prefix;
                    $key .= $pre . $row[$v];
                }
                $array_tmp[$key] = $row;
            }
        }

        return $array_tmp;
    }

    /**
     * 打出数组
     *
     * @author      kuangshunping
     * @since       2012-3-21 am 11:30:58
     * @param       array $data
     * @return      void
     */
    public static function dump($data)
    {
        if (is_array($data))
        {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
        else
        {
            echo $data;
        }
    }

    /**
     * 对多维数组进行排序
     * arrayMultiSort($arr, array('vip'=>array(SORT_DESC,SORT_REGULAR), 'sex'=>SORT_DESC, 'level'=>SORT_DESC, 'cid'=>SORT_ASC));
     *
     * @param array $array
     * @param array $cols
     * @return array
     */
    public static function arrayMultiSort($array, $cols)
    {
        $colarr = array();
        foreach ($cols as $col => $order)
        {
            $colarr[$col] = array();
            foreach ($array as $k => $row)
            {
                $colarr[$col]['_' . $k] = strtolower($row[$col]);
            }
        }
        $params = array();
        foreach ($cols as $col => $order)
        {
            $params[] = &$colarr[$col];
            $params   = array_merge($params, (array)$order);
        }
        call_user_func_array('array_multisort', $params);
        $ret   = array();
        $keys  = array();
        $first = true;
        foreach ($colarr as $col => $arr)
        {
            foreach ($arr as $k => $v)
            {
                if ($first)
                {
                    $keys[$k] = substr($k, 1);
                }
                $k = $keys[$k];
                if (!isset($ret[$k]))
                {
                    $ret[$k] = $array[$k];
                }
                $ret[$k][$col] = $array[$k][$col];
            }
            $first = false;
        }
        return $ret;
    }

    /**
     * 递归出当前节点的所有子节点
     *
     * @param array  $data
     * @param int    $node_id
     * @param string $id_field
     * @param string $pid_field
     * @return boolean
     */
    public static function findChildren($data, $node_id, $id_field = "id", $pid_field = "pid")
    {
        if (is_array($data) && !empty($data))
        {
            foreach ($data as $key => $val)
            {
                if ($val[$pid_field] == $node_id)
                {
                    $arr[] = $val;
                    if (!empty($val[$id_field]))
                    {
                        $arr = array_merge($arr, self::findChildren($data, $val[$id_field], $id_field, $pid_field));
                    }
                }
            }
        }

        if (!empty($arr) && is_array($arr))
        {
            return $arr;
        }
        else
        {
            return array();
        }
    }

    /**
     * 返回值不重复的二维数组
     *
     * @param array $arr
     * @param bool  $is_trim
     * @return array
     */
    public static function uniqueValue($arr, $is_trim = false)
    {
        if (empty($arr))
        {
            return $arr;
        }

        $data = array();
        foreach ($arr as $k => $v)
        {
            if (!isset($data[$v]))
            {
                $data[$v] = $is_trim ? trim($v) : $v;
            }
        }
        return array_values($data);
    }

    /**
     * 返回二维数组中的某一列， 转成一组数组
     *
     * @param array  $array
     * @param string $column
     * @param bool   $is_v
     * @return array
     */
    public static function getArrayIds($array, $column = 'id', $is_v = false)
    {
        if (empty($array))
        {
            return $array;
        }

        $return = array();
        foreach ($array as $v)
        {
            if (!isset($return[$v[$column]]))
            {
                $return[$v[$column]] = !$is_v ? $v[$column] : $v;
            }
        }

        return $return;
    }
}