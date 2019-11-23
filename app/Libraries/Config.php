<?php

namespace App\Libraries;

/**
 * 获取配置项(从数据库中获取)
 * Class Config
 * @package App\Libraries
 */
class Config
{
    /**
     * 储存数据
     * 已使用KYE   用途
     * name         站点名称
     * site         站点URL
     * keywords     站点关键词
     * description  站点描述
     * copyright    版权信息
     * limitArticle 前台文章列表每页多少条数据
     * limitArchive 前台归档列表每页多少条数据
     * aliasArticle 文章是否使用别名
     * aliasPage    页面是否使用别名
     * archives     归档页标题
     */
    private $data;

    // 储存实例
    private static $instance;

    // 防止克隆
    private function __clone()
    {
        //
    }

    // 获取数据库配置项
    private function __construct()
    {
        $list = \App\Models\Config::select('variable','value')->pluck('value','variable');
        $this->data = json_decode(json_encode($list), true);
    }

    // 获取实例
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // 判断是否存在
    public function has($key)
    {
        return isset($this->data[$key]);
    }

    // 返回配置值
    public function get($key, $val = null)
    {
        return $this->has($key) ? $this->data[$key] : $val;
    }
}
