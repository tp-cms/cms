<?php

namespace app\admin\enum;

enum CacheKeyEnum: string
{
    case AccessTokenCookie = 'atc';
    case AccessToken = 'access_token:';
    case UserInfo = 'user_info:';
    case CaptchaCookie = 'captcha_cookie';
    case Captcha = 'captcha:';
    case CaptchaIP = 'captcha_ip:';
}
