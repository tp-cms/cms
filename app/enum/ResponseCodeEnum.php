<?php

namespace app\enum;

enum ResponseCodeEnum:int{
    case SuccessCoce = 20826;
    case ErrorCode = 10000;
    case UnauthorizedCode = 2157;

    // layui
    case LayuiSuccess = 0;
    case LayuiError = 1;
}