<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Api\Admin;
use App\Model\Api\ArticleModel;
use App\Model\Api\FriendshopLinkModel;
use App\Model\Api\SiteSettingModel;
use App\Model\Api\TagModel;
use App\Services\Api\AdminService;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\DbConnection\Db;
use Psr\Container\ContainerInterface;

/**
 * @Command
 */
class InitBlogCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('init:blog');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('初始化博客!');
    }

    public function handle()
    {
        $email = 'fastblog@blog.com';
        $password = 'fastblog';
        $name = '超管';

        try {
            Db::beginTransaction();

            // create admin
            Admin::query()->create([
                'email'    => $email,
                'password' => password_hash($password . AdminService::$halt, PASSWORD_BCRYPT),
                'name'     => $name
            ]);

            //create site setting
            SiteSettingModel::query()->create([
                'site_name'       => 'FastBlog',
                'site_desc'       => '一个流畅的博客',
                'site_record'     => '一个流畅的博客',
                'site_owner'      => 'FastBlog',
                'site_owner_desc' => '一个流畅的博客',
                'site_notice'     => '一个流畅的博客',
                'site_icon'       => 'http://qiniu.txwei.cn/Fs8ImVi6zDzIoHTG0HaGck56LJVu',
            ]);

            //create tag
            $tagId = TagModel::query()->create([
                'tag_name'   => 'FastBlog',
                'tag_type'   => 1,
                'tag_status' => 1,
                'tag_level'  => 100,
                'is_series'  => 2
            ])->id;

            //create tag article
            ArticleModel::query()->create([
                'article_title'   => '一个流畅的博客',
                'article_content' => '一个流畅的博客',
                'article_type'    => 1,
                'article_status'  => 1,
                'article_level'   => 100,
                'tag_id'          => $tagId,
                'is_recommend'    => 1,
            ]);

            //create series tag
            $tagId = TagModel::query()->create([
                'tag_name'   => 'FastBlogSeries',
                'tag_type'   => 1,
                'tag_status' => 1,
                'tag_level'  => 100,
                'is_series'  => 1
            ])->id;

            //create series tag article
            ArticleModel::query()->create([
                'article_title'   => '一个流畅的博客',
                'article_content' => '一个流畅的博客',
                'article_type'    => 1,
                'article_status'  => 1,
                'article_level'   => 100,
                'tag_id'          => $tagId,
                'is_recommend'    => 1,
            ]);

            //create friendship link
            FriendshopLinkModel::query()->insert([
                [
                    'name' => 'Laravel China 社区 | Laravel China 社区 - 高品质的 Laravel 开发者社区',
                    'link' => 'https://learnku.com/laravel',
                    'level' => 100,
                ],[
                    'name' => 'Hyperf',
                    'link' => 'https://doc.hyperf.io/#/',
                    'level' => 99,
                ]
            ]);

            Db::commit();

        } catch (\Exception $e) {

            $this->line($e->getMessage(),'info');
            Db::rollBack();
        }

        $this->line('初始化成功','info');
        $this->line("登录邮箱:{$email},密码:{$password},名称:{$name}",'info');
    }
}
