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
use App\Request\AdminRequest;
use App\Services\Api\AdminService;
use Hyperf\Di\Annotation\Inject;
use Phper666\JwtAuth\Jwt;


class AdminController extends AbstractController
{

    /**
     * @Inject()
     * @var AdminService
     */
    protected $adminService;

    public function login(AdminRequest $request)
    {
        $request->validated();

        return $this->success('成功',$this->adminService->login($request->input('email'),$request->input('password')));
    }

    public function adminInfo(Jwt $jwt)
    {
        return $this->success('成功',$jwt->getParserData());
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function logout()
    {
        return $this->success('退出成功',$this->adminService->loutOut());
    }
}
