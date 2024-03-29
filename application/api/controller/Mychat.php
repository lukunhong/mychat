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
        $msg = input('post.');
        if ($this->request->isAjax()){
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
//                $data_arr['isread'] = $msg['isread'];
                $data_arr['isread'] = 0;
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

    /**
     * 异步图片上传
     */
    public function uploadImg()
    {
        $file = $_FILES['file'];
        $from_id = input('post.from_id');
        $to_id = input('post.to_id');
        $online = input('post.online');
        //后缀
        $suffix = strtolower(strrchr($file['name'],'.'));
        $allow_type = array('.jpg','.jpeg','.png','.gif');
        if (!in_array($suffix,$allow_type)){
            return array('status'=>'img type error');
        }
        if ($file['size']/1024 > 5120){
            return array('status'=>'img size too big');
        }
        $file_name = uniqid("mychat_img",false);
        $path = ROOT_PATH.'public\\uploads\\';
        //递归创建目录
        directory($path);
        $file_up = $path.$file_name.$suffix;
        $ret = move_uploaded_file($file['tmp_name'],$file_up);
        if ($ret){
            $name = $file_name.$suffix;
            $data['content'] = $name;
            $data['fromid'] = $from_id;
            $data['toid'] = $to_id;
            $data['fromname'] = $this->getName($from_id);
            $data['toname'] = $this->getName($to_id);
            $data['time'] = time();
//            $data['isread'] = $online;
            $data['isread'] = 0;
            $data['type'] = 2;//图片消息
            $msg_id = Db::name('communication')->insertGetId($data);
            if ($msg_id){
                return array('status'=>'ok','img_name'=>$name);
            }else{
                return array('status'=>'false');
            }
        }
    }

    /**
     * 获取单一头像
     * @param $id
     */
    public function getSingleHead($id)
    {
        $head = Db::name('user')->where('id',$id)->value('headimgurl');
        return $head;
    }

    /**
     * 获取未读
     * @param $fromid
     * @param $toid
     */
    public function getCountNotRead($fromid,$toid)
    {
        return Db::name('communication')->where(array('fromid'=>$fromid,'toid'=>$toid,'isread'=>0))->count('id');
    }

    /**
     * 获取最后一条聊天记录
     * @param $fromid
     * @param $toid
     */
    public function getLastMsg($fromid,$toid)
    {
        $ret = Db::name('communication')->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',
            ['fromid'=>$fromid,'toid'=>$toid,'fromid1'=>$fromid,'toid1'=>$toid])->order('id DESC')->limit(1)->find();
        return $ret;
    }

    /**
     * 根据from_id获取聊天列表
     */
    public function getList()
    {
        if ($this->request->isAjax()){
            $from_id = input('post.id');
            $info = Db::name('communication')->field('fromid,toid,fromname')->where('toid',$from_id)->group('fromid')->order('id DESC')->select();
            $rows = array_map(function ($res){
                return [
                    'hear_url'  => $this->getSingleHead($res['fromid']),
                    'username'  => $res['fromname'],
                    'countNotread'  => $this->getCountNotRead($res['fromid'],$res['toid']),
                    'last_message'  => $this->getLastMsg($res['fromid'],$res['toid']),
                    //前往跳转的地址
                    'mychat_page' => "/index.php/index/index?from_id={$res['toid']}&to_id={$res['fromid']}"
                ];
            },$info);
            return $rows;
        }
    }

    /**
     * 更改消息阅读状态
     */
    public function readMsg(){
        if ($this->request->isAjax()){
            //需要注意接收方不一样
            $to_id = input('post.from_id');
            $from_id = input('post.to_id');
            echo Db::name('communication')->where(array('fromid'=>$from_id,'toid'=>$to_id))->update(array('isread'=>1));
        }
    }

}