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
        $where = ["user_type" => 1];
        /**搜索条件**/
        $user_login = $this->request->param('user_login');
        $user_email = trim($this->request->param('user_email'));

        if ($user_login) {
            $where['user_login'] = ['like', "%$user_login%"];
        }

        if ($user_email) {
            $where['user_email'] = ['like', "%$user_email%"];;
        }
        $users = Db::name('user')
            ->where($where)
            ->order("id DESC")
            ->paginate(10);
        // 获取分页显示
        $page = $users->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }
        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("users", $users);
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
