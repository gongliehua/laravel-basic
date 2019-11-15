<?php

namespace App\Traits;

trait Helper
{
    // 无限级数组排序
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

    // 无限级数组转换成多维数组
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

    // 无限级多维数组转换成菜单字符串
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

    // 无限级获取上级
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

    // Laravel文件上传
    public function fileUpload($file, $dir = '', $exceptExtends = [])
    {
        if ($file) {
            $fileName = sha1(uniqid(null, true));
            $fileExtends = $file->getClientOriginalExtension();
            $uploadDir = ($dir != '') ? public_path($dir) : public_path();
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0777);
            }
            if (!is_writeable($uploadDir)) {
                return ['code'=>1, 'msg'=>'上传目录不可写', 'data'=>[]];
            }
            $url = trim(str_replace('\\','/',trim(trim($dir,'/'),'\\').'\\'.$fileName.'.'.$fileExtends),'/');
            if (in_array($fileExtends, $exceptExtends)) {
                return ['code'=>1, 'msg'=>'该文件类型禁止上传', 'data'=>[]];
            }
            if ($file->move($uploadDir, $fileName.'.'.$fileExtends)) {
                return ['code'=>0, 'msg'=>'上传成功', 'data'=>$url];
            } else {
                return ['code'=>1, 'msg'=>'上传失败', 'data'=>[]];
            }
        } else {
            return ['code'=>1, 'msg'=>'请上传文件', 'data'=>[]];
        }
    }

    // 加密函数
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

    // 解密函数
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

    // curl函数
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
