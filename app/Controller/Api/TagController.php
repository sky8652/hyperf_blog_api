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
use App\Request\TagRequest;
use App\Services\Api\TagService;
use Hyperf\Di\Annotation\Inject;


class TagController extends AbstractController
{

    /**
     * @Inject()
     * @var TagService
     */
    protected $tagService;



    public function list(TagRequest $request)
    {
        return $this->success('成功',$this->tagService->list($request->all()));
    }

    public function save(TagRequest $request)
    {
        $request->validated();

        return $this->success('成功',$this->tagService->save($request->all()));
    }

    public function delete(TagRequest $request)
    {
        $request->validated();

        return $this->success('成功',$this->tagService->delete($request->input('tag_id')));
    }

    public function tags()
    {
        return $this->success('成功', $this->tagService->tags());
    }
}
