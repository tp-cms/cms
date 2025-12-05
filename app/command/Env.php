<?php

declare(strict_types=1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\console\output\Ask;
use think\console\output\question\Choice;

class Env extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('env')
            ->addArgument('envarg', Argument::OPTIONAL, "环境：local/dev/prod")
            ->setDescription('环境切换。1:local 2:dev 3:prod');
    }

    protected function execute(Input $input, Output $output)
    {
        // 可选环境列表
        $map = ['local', 'dev', 'prod'];

        $env = null;
        $inputEnv = $input->getArgument('envarg');
        if ($inputEnv) {
            // 范围验证
            if (!in_array($inputEnv, $map)) {
                $output->error("无效环境：{$inputEnv}，可选值为 local/dev/prod");
                return;
            }

            $env = $inputEnv;
        } else {
            // 提示选择
            $question = new Choice('选择要切换的环境', [1 => 'local', 2 => 'dev', 3 => 'prod'], 1);
            $ask = new Ask($input, $output, $question);
            $env = $ask->run();
        }


        // 修改 .env 文件
        $file = root_path() . '.env';

        if (!file_exists($file)) {
            $output->error(".env 文件不存在");
            return;
        }

        file_put_contents($file, $env . "\n");

        $output->info("已切换环境为：{$env}");
    }
}
