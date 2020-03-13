<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Api\Admin;
use App\Services\Api\AdminService;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @Command
 */
class CreateAdminCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('create:admin');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('创建管理员账号信息!');
    }

    public function handle()
    {
        $this->line('正在为您创建管理员!', 'info');
        $email = $this->input->getArgument('email');
        $password = $this->input->getArgument('password');
        $name = $this->input->getArgument('name') ?? '超管';

        if (empty($email) || empty($password) ) {
            $this->line("请输入管理员邮箱和密码");
            return;
        }

        $this->line("邮箱:{$email},密码:{$password},名称:{$name}",'info');
        try {
            Admin::query()->create([
                'email' => $email,
                'password'=> password_hash($password.AdminService::$halt,PASSWORD_BCRYPT),
                'name' => $name
            ]);
        } catch (\Exception $e) {
            $this->line($e->getMessage(),'info');
        }

        $this->line('创建成功','info');

    }

    protected function getArguments()
    {
        return [
            ['email', InputArgument::REQUIRED, '邮箱'],
            ['password', InputArgument::REQUIRED, '密码'],
            ['name', InputArgument::OPTIONAL, '名称'],
        ];
    }
}
