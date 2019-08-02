<?php
namespace app\index\controller;

use think\Controller;
class Index extends Controller
{
    /**
     * 聊天界面
     */
    public function index()
    {
        $from_id = input('from_id');
        $to_id = input('to_id');
        $this->assign('from_id',$from_id);
        $this->assign('to_id',$to_id);
        return $this->fetch();
    }

    /**
     * 聊天列表
     */
    public function lists()
    {
        $from_id = input('from_id');
        $this->assign('from_id',$from_id);
        return $this->fetch();
    }
}
