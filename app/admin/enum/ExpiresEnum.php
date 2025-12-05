<?php

namespace app\admin\enum;

enum ExpiresEnum: int
{
    case AccessUserToken = 60 * 60;
    case CaptchaCookie = 5 * 60;
    case Captcha = 60;
}
