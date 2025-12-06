<?php

declare(strict_types=1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class Controller extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('ctrl')
            ->addArgument('argctrl', Argument::OPTIONAL, 'controller name')
            ->addOption('app', 'a', Option::VALUE_REQUIRED, '应用名')
            ->setDescription('创建指定Controller');
    }

    protected function execute(Input $input, Output $output)
    {
        $controller = $input->getArgument('argctrl');
        if (!$controller) {
            $output->error('controller 不可为空');
            return;
        }

        $app = $input->getOption('app');
        if (!$app) {
            $app = 'frontend';
        } else {
            if (!in_array(strtolower($app), ['frontend', 'admin'])) {
                $output->error("不支持{$app}应用名，仅支持 frontend/admin");
                return;
            }
        }

        $namespace = "app\\{$app}\\controller";
        $dir = app_path() . $app . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR;
        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            $output->error("无法创建目录：{$dir}");
            return 1;
        }

        $file = $dir . $controller . '.php';
        if (file_exists($file)) {
            $output->error("Controller {$controller} 已经存在");
            return 1;
        }

        $content = <<<PHP
        <?php
        
        namespace {$namespace};

        class {$controller} extends Base
        {
            public function index()
            {
                return 'Hello, {$controller}';
            }
        }
        PHP;

        if (false === file_put_contents($file, $content)) {
            $output->error("写入文件失败：{$file}");
            return;
        }

        $output->info("Controller {$app}/{$controller} 创建成功");
    }
}
