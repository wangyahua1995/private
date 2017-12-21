<?php

namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\db;

class GoodsController extends AdminBaseController
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $where = '';
        /**搜索条件**/
        $other = $this->request->param('other');
        $unit = $this->request->param('unit');
        $search_content = trim($this->request->param('search_content'));

        switch ($other) {
            case 0:
                $where .= '(goods_id like '."'%$search_content%'".' or goods_name like '."'%$search_content%'".' or goods_cas like '."'%$search_content%'".' or id like '."'%$search_content%'".')';
                break;
            case 1:
                $where .= 'goods_id like '."'%$search_content%'";
                break;
            case 2:
                $where .= 'goods_name like '."'%$search_content%'";
                break;
            case 3:
                $where .= 'goods_cas like '."'%$search_content%'";
                break;
            case 4:
                $where .= 'id like '."'%$search_content%'";
                break;
            default:
                break;
        }

        if ($unit != '') {
            $where != '' ? $where .= ' and ' : $where = '';
            $where .= '  unit = '."'$unit'";
        }
        $unit = model('goods')->where('unit', 'neq', '')->group('unit')->column('unit');

        $goods = model('goods')
            ->where($where)
            ->order("id DESC")
            ->paginate(10);

        // 获取分页显示
        $page = $goods->render();
        $this->assign("page", $page);
        $this->assign("unit", $unit);
        $this->assign("goods", $goods);
        return $this->fetch();
    }

    public function add()
    {
        $roles = Db::name('role')->where(['status' => 1])->order("id DESC")->select();
        $this->assign("roles", $roles);
        return $this->fetch();
    }


    public function addPost()
    {
        if ($this->request->isPost()) {
            $postData = input('post.');
            $postData['uid'] = session('ADMIN_ID');

            $model = model('goods');

            $result = $model->addGoods($postData);

            if ($result !== false) {
                $this->success("添加成功！", url("goods/index"));
            } else {
                $this->error($model->getError());
            }

        }
    }
}
