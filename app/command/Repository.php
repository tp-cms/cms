<?php

declare(strict_types=1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class Repository extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('repo')
            ->addArgument('argrepo', Argument::OPTIONAL, 'repository name')
            ->addOption('app', 'a', Option::VALUE_REQUIRED, '应用名')
            ->setDescription('创建指定Repository');
    }

    protected function execute(Input $input, Output $output)
    {
        $repository = $input->getArgument('argrepo');
        if (!$repository) {
            $output->error('repository 不可为空');
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

        $namespace = "app\\{$app}\\repository";
        $dir = app_path() . $app . DIRECTORY_SEPARATOR . 'repository' . DIRECTORY_SEPARATOR;
        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            $output->error("无法创建目录：{$dir}");
            return 1;
        }

        $file = $dir . $repository . 'Repository.php';
        if (file_exists($file)) {
            $output->error("Repository {$repository} 已经存在");
            return 1;
        }

        $content = <<<PHP
        <?php

        namespace {$namespace};

        class {$repository}Repository extends BaseRepository{}
        PHP;

        if (false === file_put_contents($file, $content)) {
            $output->error("写入文件失败：{$file}");
            return;
        }

        $output->info("Repository {$app}/{$repository} 创建成功");
    }
}
