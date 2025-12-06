<?php

declare(strict_types=1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class Model extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('mdl')
            ->addArgument('argmdl', Argument::OPTIONAL, 'model name')
            ->setDescription('创建指定Model');
    }

    protected function execute(Input $input, Output $output)
    {
        $model = $input->getArgument('argmdl');
        if (!$model) {
            $output->error('model 不可为空');
            return;
        }

        $namespace = "app\\model";
        $dir = app_path() . 'model' . DIRECTORY_SEPARATOR;
        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            $output->error("无法创建目录：{$dir}");
            return 1;
        }

        $file = $dir . $model . '.php';
        if (file_exists($file)) {
            $output->error("Model {$model} 已经存在");
            return 1;
        }

        $content = <<<PHP
        <?php

        namespace {$namespace};

        class {$model} extends Base{}
        PHP;

        if (false === file_put_contents($file, $content)) {
            $output->error("写入文件失败：{$file}");
            return;
        }

        $output->info("Model {$model} 创建成功");
    }
}
