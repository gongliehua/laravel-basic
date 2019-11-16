<?php

namespace App\Libraries;

/**
 * 辅助类
 * 不参与框架任何相关的东西,任何位置可调用
 * Class Helper
 * @package App\Libraries
 */
class Helper
{
    /**
     * 无限级数组排序
     * @param array $data 未排序过的二维数组
     * @param int $parent_id 父ID
     * @param int $level 等级
     * @param bool $clear 是否清空静态区
     * @return array 排序后的数组
     */
    public function toTwoArray($data = [], $parent_id = 0, $level = 0, $clear = false)
    {
        static $result = [];
        if ($clear) {
            $result = [];
            return $result;
        }
        foreach ($data as $key=>$value) {
            if ($value['parent_id'] == $parent_id) {
                $value['level'] = $level;
                $result[] = $value;
                $this->toTwoArray($data, $value['id'], $level + 1);
            }
        }
        return $result;
    }

    /**
     * 无限级数组转换成多维数组
     * @param array $data 无限级二维数组
     * @param int $parent_id 父ID
     * @return array 转换后的多维数组
     */
    public function toMultiArray($data = [], $parent_id = 0)
    {
        $result = [];
        foreach ($data as $key=>$value) {
            if ($value['parent_id'] == $parent_id) {
                $value['child'] = $this->toMultiArray($data, $value['id']);
                $result[] = $value;
            }
        }
        return $result;
    }

    /**
     * 无限级多维数组转换成菜单字符串
     * @param array $data 无限级多维数组
     * @return string 返回菜单HTML
     */
    public function toMenuHtml($data = [])
    {
        $result = '';
        foreach ($data as $key=>$value) {
            if (empty($value['child'])) {
                $aTag  = '<a href="/'. $value['path'] .'"><i class="menu-icon fa '. $value['icon'] .'"></i><span class="menu-text">'. $value['title'] .'</span></a><b class="arrow"></b>';
            } else {
                $aTag  = '<a href="'. $value['path'] .'" class="dropdown-toggle"><i class="menu-icon fa '. $value['icon'] .'"></i><span class="menu-text">'. $value['title'] .'</span><b class="arrow fa fa-angle-down"></b></a><b class="arrow"></b>';
            }
            $result .= '<li class="">'.$aTag;
            if (!empty($value['child'])) {
                $result .= '<ul class="submenu">'. $this->toMenuHtml($value['child']) .'</ul>';
            }
            $result .= '</li>';
        }
        return $result;
    }

    /**
     * 无限级获取上级
     * @param array $data 无限级数组
     * @param int $id 当前ID
     * @return array 上级数组
     */
    public function getParents($data = [], $id)
    {
        $result = [];
        foreach ($data as $val) {
            if ($val['id'] == $id) {
                $result[] = $val;
                $result = array_merge($this->getParents($data, $val['parent_id']),$result);
            }
        }
        return $result;
    }

    /**
     * 加密函数
     * @param string $data 需要加密的字符串
     * @param string $key 加密时用的KEY
     * @return string 返回加密后的字符串
     */
    public function setPassword($data, $key)
    {
        $key    = md5(md5(md5($key)));
        $x      = 0;
        $len    = strlen($data);
        $l      = strlen($key);
        $char   = "";
        $str    = "";
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $char .= $key{$i};
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
        }
        return base64_encode($str);
    }

    /**
     * 解密函数,和加密函数配合使用
     * @param string $data 被加密的字符串
     * @param string $key 解密用的KEY
     * @return string 返回解密后的字符串
     */
    public function getPassword($data, $key)
    {
        $data   = base64_decode($data);
        $key    = md5(md5(md5($key)));
        $x      = 0;
        $len    = strlen($data);
        $l      = strlen($key);
        $str    = "";
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) {
                $x = 0;
            }
            $str .= chr(ord($data{$i}) - ord($key{$i}) % 256);
            $x++;
        }
        return $str;
    }

    /**
     * curl函数,一般用于POST请求
     * @param string $url URL地址
     * @param array $data 请求数据
     * @return mixed 请求结果
     */
    public function curlPost($url, $data = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
