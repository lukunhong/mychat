<?php
/**
 * Created by PhpStorm.
 * User: lulu
 */
namespace app\api\controller;

use think\Controller;
use think\Db;

class Mychat extends Controller{
    /**
     * 保存聊天记录
     */
    public function saveMsg()
    {
        if ($this->request->isAjax()){
            $msg = input('post.');
            //组装数据
            $data_arr['fromid'] = $msg['from_id'];
            $data_arr['fromname'] = $this->getName($data_arr['fromid']);
            $data_arr['toid'] = $msg['to_id'];
            $data_arr['toname'] = $this->getName($data_arr['toid']);
            $data_arr['content'] = $msg['data'];
            $data_arr['time'] = $msg['time'];
            $data_arr['isread'] = $msg['isread'];
            $data_arr['type'] = 1; //文本消息
            Db::name('communication')->insert($data_arr);
        }
    }

    /**
     * 获取用户名
     */
    public function getName($uid)
    {
        $uname = Db::name('user')->where('id',$uid)->value('nickname');
        return $uname;
    }

}