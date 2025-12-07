<?php

namespace app\admin\controller;

use app\admin\enum\CacheKeyEnum;
use app\admin\enum\ExpiresEnum;
use app\admin\service\UserService;
use think\App;
use think\facade\Cache;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\View;

class User extends Base
{
    protected UserService $user;

    public function __construct(App $app)
    {
        $this->user = new UserService();
        return parent::__construct($app);
    }

    // 登录
    public function login()
    {
        // 验证码随机 cookie key
        $captchaKey = Cookie::get(CacheKeyEnum::CaptchaCookie->value);
        if (!$captchaKey) {
            $captchaKey = generateUUID4();
            Cache::set(CacheKeyEnum::Captcha->value . $captchaKey, true, ExpiresEnum::CaptchaCookie->value);
            Cookie::set(CacheKeyEnum::CaptchaCookie->value, $captchaKey, ExpiresEnum::CaptchaCookie->value);
        }

        // 最开始是前后端不分离，这里兼容下
        if (Request::isPost()) {
            $username = input('post.username');
            $password = input('post.password');
            $captcha = input('post.captcha');

            // 只简单判断下
            if (!$username || !$password || !$captcha) {
                return $this->err('参数不完整');
            }

            // 验证验证码
            $cacheCaptcha = Cache::get($captchaKey);
            if (!$cacheCaptcha) {
                return $this->err('验证码已过期');
            }
            // 删除验证码缓存
            Cache::delete($captchaKey);
            if (strtolower($captcha) != $cacheCaptcha) {
                return $this->err('验证码错误');
            }

            if ($username && $password) {
                $checkRes = $this->user->checkPassword($username, $password);

                if (!$checkRes['status']) {
                    return $this->err('用户名或密码错误');
                }

                // 删除验证码cookie
                Cookie::delete(CacheKeyEnum::CaptchaCookie->value);

                // 登录成功，设置 cookie
                // TODO:.env文件处理问题，可以存在空值
                // TODO:访问令牌 & 刷新令牌
                $jwtJti = generateUUID4();
                $payload = array_merge($checkRes['jwt'], ['jti' => $jwtJti]);
                $token = $this->encodeJWT($payload, ExpiresEnum::AccessUserToken->value);
                Cookie::set(CacheKeyEnum::AccessTokenCookie->value, $token, ExpiresEnum::AccessUserToken->value);

                // 将token放在checkRes中
                Cache::set(CacheKeyEnum::UserInfo->value . $jwtJti, $checkRes['user'], ExpiresEnum::AccessUserToken->value);

                if (!env('app.debug', false)) {
                    // 删除验证码访问限制
                    $ip = request()->ip();
                    $ipKey = CacheKeyEnum::CaptchaIP->value . $ip;
                    Cache::delete($ipKey);
                }
                return $this->suc();
            }

            return $this->err('用户不存在');
        }

        // 页面展示
        return View::fetch('admin@user/login');
    }

    // 退出登录
    public function logout()
    {
        // 获取当前的 token
        $token = Cookie::get(CacheKeyEnum::AccessTokenCookie->value);

        // 如果没有 token 或 token 无效，返回未登录或会话已过期
        if (!$token) {
            return $this->unauthorized();
        }

        // 解析 JWT 并检查有效性
        $jwtCon = $this->decodeJWT($token);
        if (!$jwtCon || $jwtCon->exp < time()) {
            // Token 无效，删除 token 并返回
            Cookie::delete(CacheKeyEnum::AccessTokenCookie->value);
            return $this->unauthorized();
        }

        // 获取缓存中的用户信息，并验证用户名一致性
        $user = Cache::get(CacheKeyEnum::UserInfo->value . $jwtCon->jti);
        if (!$user || $user['username'] !== $jwtCon->username) {
            // 如果缓存中的用户信息异常，删除 token 并返回
            Cookie::delete(CacheKeyEnum::AccessTokenCookie->value);
            return $this->err('异常访问');
        }

        // 删除 token 和缓存中的用户信息
        Cookie::delete(CacheKeyEnum::AccessTokenCookie->value);
        Cache::delete(CacheKeyEnum::UserInfo->value . $jwtCon->jti);

        // 返回退出成功消息
        return $this->suc();
    }
}
