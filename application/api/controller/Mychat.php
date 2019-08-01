<?php
/**
 * Created by PhpStorm.
 * User: lulu
 */
namespace app\api\controller;

use think\Controller;
use think\Db;

class Mychat extends Controller{

    protected function _initialize()
    {
        parent::_initialize();
    }
    /**
     * 保存聊天记录
     */
    public function saveMsg()
    {
        if ($this->request->isAjax()){
            $msg = input('post.');
            //组装数据
            $fromname = $this->getName($msg['from_id']);
            $toname = $this->getName($msg['to_id']);
            if (!empty($fromname) && !empty($toname)) {
                $data_arr['fromid'] = $msg['from_id'];
                $data_arr['fromname'] = $fromname;
                $data_arr['toid'] = $msg['to_id'];
                $data_arr['toname'] = $toname;
                $data_arr['content'] = $msg['data'];
                $data_arr['time'] = $msg['time'];
                $data_arr['isread'] = $msg['isread'];
                $data_arr['type'] = 1; //文本消息
                Db::name('communication')->insert($data_arr);
            }
        }
    }

    /**
     * 获取用户名
     */
    public function getName($uid)
    {
        $uname = '';
        $uname = Db::name('user')->where('id',$uid)->value('nickname');
        return $uname;
    }

    /**
     * 获取头像
     */
    public function getHead()
    {
        if ($this->request->isAjax()){
            $from_id = input('post.from_id');
            $to_id = input('post.to_id');
            $head_arr =  Db::name('user')->where('id','in',array($from_id,$to_id))->field('id,headimgurl')->select();
            $ret = array();
            //避免前端找不到变量
            $ret['from_head'] = '';
            $ret['to_head'] = '';
            foreach ($head_arr as $value){
                if ($value['id'] == $from_id){
                    $ret['from_head']  =$value['headimgurl'];
                }else{
                    $ret['to_head']  =$value['headimgurl'];
                }
            }
            return $ret;
        }else{
            return '异常请求';
        }
    }

    /**
     * 获取聊天内容
     */
    public function loadMsg()
    {
        if ($this->request->isAjax()){
            $from_id = input('post.from_id');
            $to_id = input('post.to_id');
            //利用占位符实现查询最新记录
            $count = Db::name('communication')->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',
                ['fromid'=>$from_id,'toid'=>$to_id,'fromid1'=>$from_id,'toid1'=>$to_id])->count('id');
            if ($count >= 10){
                $msg = Db::name('communication')->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',
                    ['fromid'=>$from_id,'toid'=>$to_id,'fromid1'=>$from_id,'toid1'=>$to_id])->limit($count-10,10)->order('id')->select();
            }else{
                $msg = Db::name('communication')->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',
                    ['fromid'=>$from_id,'toid'=>$to_id,'fromid1'=>$from_id,'toid1'=>$to_id])->order('id')->select();
            }
            return $msg;
        }else{
            return '异常请求';
        }
    }

}