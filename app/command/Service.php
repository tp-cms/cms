<?php

declare(strict_types=1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class Service extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('srv')
            ->addArgument('argsrv', Argument::OPTIONAL, 'service name')
            ->addOption('app', 'a', Option::VALUE_REQUIRED, '应用名')
            ->setDescription('创建指定Service');
    }

    protected function execute(Input $input, Output $output)
    {
        $service = $input->getArgument('argsrv');
        if (!$service) {
            $output->error('service 不可为空');
            return;
        }
        $app = $input->getOption('app');
        if (!$app) {
            $app = 'frontend';
        } else {
            if (!in_array(strtolower($app), ['frontend', 'admin'])) {
                $output->error("不支持{$app}应用名仅支持 frontend/admin");
                return;
            }
        }

        $namespace = "app\\{$app}\\service";
        $dir = app_path() . $app . DIRECTORY_SEPARATOR . 'service' . DIRECTORY_SEPARATOR;
        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            $output->error("无法创建目录：{$dir}");
            return 1;
        }

        $file = $dir . $service . 'Service.php';
        if (file_exists($file)) {
            $output->error("Service {$service} 已经存在");
            return 1;
        }

        $content = <<<PHP
        <?php

        namespace {$namespace};

        class {$service}Service extends BaseService{}
        PHP;

        if (false === file_put_contents($file, $content)) {
            $output->error("写入文件失败：{$file}");
            return;
        }

        $output->info("Service {$app}/{$service} 创建成功");
    }
}
