<?php

declare(strict_types=1);

namespace app\command;

use app\admin\repository\UserRepository;
use app\common\util\EnvUtil;
use think\App;
use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;

class User extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('user')
            ->addOption('pwd', 'p', Option::VALUE_REQUIRED, '密码')
            ->setDescription('管理员创建、修改密码');
    }

    protected function execute(Input $input, Output $output)
    {
        // 修改密码选项
        $password = $input->getOption('pwd');

        // 密码相关
        if ($password) {
            // 正则下密码
        } else {
            // 随机生成下
            $password = dechex(time());
        }

        // 生成一个随机的盐（16字节）
        $salt = random_bytes(16);

        // 密码哈希化：使用手动生成的盐
        // 将盐转换为可用于哈希的格式
        $saltString = base64_encode($salt);

        // 使用盐和密码进行哈希处理
        $passwordHash = password_hash($password . $saltString, PASSWORD_BCRYPT);

        // 加载下配置
        $envUtil = new EnvUtil();
        $envUtil->init(root_path());
        $envConfigFile = $envUtil->getEnvConfigFile();

        // 这里执行下index.php的流程吧，有点难受🙄
        // 不然会提示 SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost' (using password: NO)
        $app = new App();
        // 配置文件加载
        $app->env->load($envConfigFile);
        $app->http->run();

        // 用户信息
        $userId = 1;
        $username = $app->env->get('app.username', 'admin');

        // 当前时间
        $now = date('Y-m-d H:i:s');

        $userRepo = new UserRepository();
        $isCreate = false;

        // 用户信息
        $info = $userRepo->info($userId);
        if ($info) {
            $isCreate = true;
            // 修改密码
            $userData = [
                'salt' => $salt,
                'password' => $passwordHash,
                'updated_at' => $now,
            ];
        } else {
            // 新增
            $userData = [
                'id' => $userId,
                'username' => $username,
                'uuid' => generateUUID4(),
                'phone' => '',
                'email' => '',
                'salt' => $salt,
                'password' => $passwordHash,
                'disabled' => 0,
                'created_by' => 1,
            ];
        }
        $userRepo->cmdSave($userData, $isCreate);

        $action = $isCreate ? '创建' : '更新';
        $output->info("{$action}成功！密码：$password");
    }
}
