<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

    /**
     * 递归创建文件
     */
    function directory($dir):bool
    {
        return  is_dir ( $dir ) or Directory(dirname( $dir )) and  mkdir ( $dir , 0777);
    }
    /**
     * 文本日志记录
     * @param string $content 内容
     * @param string $filename 文件名
     * @param bool $debug  是否记录日志开关
     */
    function writeLog(string $content, string $filename = 'log.log', bool $debug = true):bool
    {
        if ($debug) {
            $filepath = $_SERVER['DOCUMENT_ROOT'] . '/log/';
            $filename = $filepath . $filename;
            if (!is_dir($filename)){
                directory($filepath);
            }
            $fp = fopen($filename, "a");
            flock($fp, LOCK_EX) ;
            fwrite($fp, "\n执行日期：" . date('Y-m-d H:i:s') . "\n" . $content . "\n");
            flock($fp, LOCK_UN);
            return fclose($fp);
        }
}