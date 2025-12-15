<?php

namespace app\admin\middleware;

use app\admin\enum\CacheKeyEnum;
use app\trait\JWTTrait;
use think\facade\Cache;
use think\facade\Cookie;

class AuthMiddleware
{
    use JWTTrait;

    private function handleUnauthorized($request)
    {
        // 删除无效的 token
        Cookie::delete(CacheKeyEnum::AccessTokenCookie->value);

        // 如果当前请求已经是登录页面，直接返回
        if ($request->pathinfo() === adminRoutePrefix() . '/login') {
            return redirect('/' . adminRoutePrefix() . '/login');
        }

        // 如果是 AJAX 请求，返回 JSON 响应
        if ($request->isAjax()) {
            return json(['code' => 10001, 'status' => false, 'message' => '未登录']);
        }

        // 如果是普通请求，跳转到登录页面
        return redirect('/' . adminRoutePrefix() . '/login');
    }


    public function handle($request, \Closure $next)
    {
        // 获取访问令牌
        $token = Cookie::get(CacheKeyEnum::AccessTokenCookie->value);
        if (!$token) {
            return $this->handleUnauthorized($request);
        }

        // 解析 JWT
        $jwtCon = $this->decodeJWT($token);
        if (!$jwtCon || $jwtCon->exp < time()) {
            return $this->handleUnauthorized($request);
        }

        // 获取缓存中的用户信息
        $user = Cache::get(CacheKeyEnum::UserInfo->value . $jwtCon->jti);
        if (!$user || $user['username'] != $jwtCon->username) {
            return $this->handleUnauthorized($request);
        }

        // 将用户信息放入上下文中，以便后续使用
        $request->user = $user;

        // 已登录，继续请求
        return $next($request);
    }
}
