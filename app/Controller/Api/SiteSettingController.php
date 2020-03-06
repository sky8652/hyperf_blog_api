<?php

declare(strict_types=1);

namespace App\Controller\Api;
use App\Controller\AbstractController;
use App\Request\SiteRequest;
use App\Services\Api\SiteService;
use Hyperf\Di\Annotation\Inject;


class SiteSettingController extends AbstractController
{

    /**
     * @Inject()
     * @var SiteService
     */
    protected $siteService;


    public function settings()
    {
        return $this->success('成功', $this->siteService->getSettings());
    }

    public function save(SiteRequest $request)
    {
        $request->validated();
        return $this->success('成功', $this->siteService->save($request->all()));
    }

    public function saveFriendLink(SiteRequest $request) {
        $request->validated();
        return $this->success('成功', $this->siteService->saveFriendLink($request->all()));
    }

    public function deleteFriendLink(SiteRequest $request) {
        $request->validated();
        return $this->success('成功', $this->siteService->deleteFriendLink($request->input('id')));
    }

    public function friendLinks() {
        return $this->success('成功', $this->siteService->friendLinks());
    }

}