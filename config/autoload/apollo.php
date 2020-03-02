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

return [
    'enable' => false,
    'server' => 'http://127.0.0.1:8080',
    'appid' => 'Your APP ID',
    'cluster' => 'default',
    'namespaces' => [
        'application',
    ],
    'interval' => 5,
    'strict_mode' => false,
    // 客户端IP
    'client_ip' => current(swoole_get_local_ip()),
    // 拉取配置超时时间
    'pullTimeout' => 10,
    // 拉取配置间隔
    'interval_timeout' => 60,
];
