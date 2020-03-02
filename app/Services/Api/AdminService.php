<?php
/**
 *
 * User: xiaowei<13177839316@163.com>
 * Date: 2020/1/20
 * Time: 14:03
 */

namespace App\Services\Api;


use App\Exception\WrongRequestException;
use App\Model\Api\Admin;
use Hyperf\Di\Annotation\Inject;
use Phper666\JwtAuth\Jwt;

class AdminService
{

    /**
     * @Inject()
     * @var Jwt
     */
    protected $jwt;


    public function login($email, $password)
    {
        $admin = Admin::query()->where('email',$email)->first();
        if (empty($admin)) {
            throw new WrongRequestException("无此账户!");
        }

        if (!password_verify($password,$admin->password)) {
            throw new WrongRequestException("账户密码错误!");
        }

        $admin = $admin->toArray();
        $admin['uid'] = $admin['id'];

        $token = (string)$this->jwt->getToken($admin);

        return ['token'=>$token,'admin'=>$admin];
    }


    /**
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function loutOut()
    {
        $this->jwt->logout();
        return true;
    }

}
