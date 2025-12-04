<?php

// 添加当前 app\helper 中 .php 文件，除 helper.php（当前） 文件
foreach (glob(__DIR__ . '/*') as $f) {
    if ($f != __FILE__ && is_file($f)) {
        require_once $f;
    }
}
