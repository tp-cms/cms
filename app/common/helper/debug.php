<?php

if (!function_exists('d')) {
    /**
     * 调试输出变量（支持 CLI / Web 环境），可选是否终止
     *
     * @param mixed ...$args 调试的变量，最后一个可为 bool 表示是否 exit
     * @return void
     */
    function d(...$args): void
    {
        $exit = true;
        if (count($args) && is_bool(end($args))) {
            $exit = array_pop($args);
        }

        $isCli = php_sapi_name() === 'cli';

        // 获取调用位置
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $caller = $trace[0] ?? null;
        $locationStr = isset($caller['file'], $caller['line'])
            ? "{$caller['file']} 第 {$caller['line']} 行"
            : '[未知位置]';

        // CLI 输出
        if ($isCli) {
            foreach ($args as $i => $arg) {
                echo "\033[36m[调试变量 #" . ($i + 1) . "]\033[0m\n";
                var_dump($arg);
                echo "\n";
            }
            echo "\033[33m调试位置：\033[0m{$locationStr}\n";

            if ($exit) {
                exit(1);
            }
            return;
        }

        // Web 输出
        if (!headers_sent()) {
            header('Content-Type: text/html; charset=UTF-8');
        }

        echo <<<HTML
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>调试输出</title>
<style>
    body {
        background-color: #f4f4f4;
        color: #1f2328;
        font-family: Menlo, Consolas, monospace;
        padding: 20px;
    }
    .dd-container {
        background-color: #fff;
        color: #1f2328;
        padding: 16px;
        margin: 16px 0;
        border-radius: 6px;
        font-size: 14px;
        white-space: pre-wrap;
        word-wrap: break-word;
        border-left: 4px solid #4CAF50;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .dd-location {
        background-color: #e8f5e9;
        color: #2e7d32;
        padding: 10px 16px;
        margin: 16px 0;
        border-radius: 4px;
        font-weight: bold;
        border-left: 4px solid #66bb6a;
    }
    details {
        margin: 16px 0;
        background: #fafafa;
        padding: 12px;
        border-radius: 6px;
        color: #1f2328;
        border: 1px solid #ddd;
    }
    summary {
        cursor: pointer;
        font-weight: bold;
        color: #1976d2;
    }
</style></head><body>
HTML;

        foreach ($args as $i => $arg) {
            echo '<details open>';
            echo '<summary>调试变量 #' . ($i + 1) . '</summary>';
            echo '<div class="dd-container">';
            ob_start();
            var_dump($arg);
            echo htmlspecialchars(ob_get_clean(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            echo '</div></details>';
        }

        echo '<div class="dd-location">调试位置：' . htmlspecialchars($locationStr) . '</div>';
        echo '</body></html>';

        if ($exit) {
            exit(1);
        }
    }
}
