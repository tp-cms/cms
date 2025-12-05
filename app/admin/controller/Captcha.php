<?php

namespace app\admin\controller;

use app\admin\enum\CacheKeyEnum;
use app\admin\enum\ExpiresEnum;
use think\facade\Cache;
use think\facade\Cookie;

class Captcha extends Base
{
    // 生成验证码
    public function generate()
    {
        // TODO:获取真实ip方法
        if (!env('app.debug', false)) {
            $ip = request()->ip();
            $ipKey = CacheKeyEnum::CaptchaIP->value . $ip;

            $maxTimes = 10;

            // 当前次数
            $data  = Cache::get($ipKey, 0);

            if (!$data) {
                // 第一次访问
                $data = [
                    'count' => 1,
                    'expire_at' => time() + ExpiresEnum::CaptchaCookie->value
                ];
                Cache::set($ipKey, $data, ExpiresEnum::CaptchaCookie->value);
            } else {
                // 限制判断
                if ($data['count'] >= $maxTimes) {
                    return $this->err('获取验证码过于频繁，请稍后再试');
                }

                // count +1
                $data['count']++;

                // 计算剩余 TTL，不改变原到期时间
                $ttl = $data['expire_at'] - time();
                if ($ttl < 1) {
                    $ttl = 1;
                }

                Cache::set($ipKey, $data, $ttl);
            }
        }

        // 生成验证码字符串
        $code = $this->randomCode(4);

        $captchaKey = Cookie::get(CacheKeyEnum::CaptchaCookie->value);
        if ($captchaKey) {
            $foundKey = Cache::get(CacheKeyEnum::Captcha->value . $captchaKey);
            if ($foundKey) {
                Cache::set($captchaKey, strtolower($code), ExpiresEnum::Captcha->value);
                // 生成图片
                return $this->createImage($code);
            }
            return $this->err('异常请求');
        }
        return $this->err('仅登录时使用');
    }

    // 随机验证码字符串
    private function randomCode($length = 4)
    {
        $chars = '345678abcdefhkmnpqrstwxyABCDEFGHKMNPQRTWXY';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $str;
    }

    private function createImage($code)
    {
        // 固定高度和宽度（整数，避免浮点数）
        $h = 57;
        $w = 121; // 可以直接设定整数宽度

        // 创建图片
        $img = imagecreate($w, $h);

        // 背景颜色
        imagecolorallocate($img, 255, 255, 255);

        // 文字颜色
        $textColor = imagecolorallocate($img, 0, 0, 0);

        // 干扰线
        for ($i = 0; $i < 4; $i++) {
            $lineColor = imagecolorallocate($img, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));
            imageline($img, mt_rand(0, $w), mt_rand(0, $h), mt_rand(0, $w), mt_rand(0, $h), $lineColor);
        }

        // 噪点
        for ($i = 0; $i < 30; $i++) {
            $dotColor = imagecolorallocate($img, mt_rand(150, 255), mt_rand(150, 255), mt_rand(150, 255));
            imagesetpixel($img, mt_rand(0, $w), mt_rand(0, $h), $dotColor);
        }

        // TTF 字体文件路径
        // https://fonts.google.com/specimen/Rubik?hl=zh-cn
        $fontFile = public_path() . '/assets/font/Rubik-VariableFont_wght.ttf';

        // 字体文件检查（不改变原注释，只增加保护）
        if (!is_file($fontFile)) {
            // 回退到内置字体
            imagestring($img, 5, 22, 20, $code, $textColor);
            header("Content-Type: image/png");
            imagepng($img);
            // imagedestroy($img);
            unset($img);
            exit;
        }


        // 字体大小
        $fontSize = 24;
        $angle = mt_rand(-12, 12);

        // 文字居中计算
        $bbox = imagettfbbox($fontSize, $angle, $fontFile, $code);

        // 被遮挡问题
        $textWidth  = max($bbox[2], $bbox[4]) - min($bbox[0], $bbox[6]);
        $textHeight = $bbox[1] - $bbox[7];

        $x = intval(($w - $textWidth) / 2); // 整数
        $y = intval(($h + $textHeight) / 2); // 整数

        // 写文字
        imagettftext($img, $fontSize, $angle, $x, $y, $textColor, $fontFile, $code);

        // 输出图片
        header("Content-Type: image/png");
        imagepng($img);
        // imagedestroy($img);
        unset($img);
        exit;
    }
}
