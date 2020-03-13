<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller\Api;
use App\Controller\AbstractController;
use App\Request\ArticleRequest;
use App\Request\TagRequest;
use App\Services\Api\ArticleService;
use Hyperf\Di\Annotation\Inject;


class ArticleController extends AbstractController
{

    /**
     * @Inject()
     * @var ArticleService
     */
    protected $articleService;



    public function list(ArticleRequest $request)
    {
        return $this->success('成功',$this->articleService->list($request->all()));
    }

    public function homeArticles(ArticleRequest $request) {
        return $this->success('成功', $this->articleService->homeArticles($request->input('tag_id')));
    }

    public function row(ArticleRequest $request)
    {
        $request->validated();
        return $this->success('成功',$this->articleService->row($request->input('article_id')));
    }

    public function save(ArticleRequest $request)
    {
        $request->validated();
        return $this->success('成功',$this->articleService->save($request->all()));
    }

    public function delete(ArticleRequest $request)
    {
        $request->validated();

        return $this->success('成功',$this->articleService->delete($request->input('article_id')));
    }

    public function mostReading()
    {
        return $this->success('成功', $this->articleService->mostReadingArticles());
    }

    public function theNewest()
    {
        return $this->success('成功', $this->articleService->newestArticles());
    }

    public function timeline()
    {
        return $this->success('成功', $this->articleService->timeline());
    }
}
