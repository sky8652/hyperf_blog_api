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
use App\Model\Api\TagModel;


class StatusController extends AbstractController
{



    public function typeMapping()
    {
        return $this->success('成功',TagModel::$tagTypeMapping);
    }

    public function statusMapping()
    {
        return $this->success('成功',TagModel::$statusMapping);
    }
}
