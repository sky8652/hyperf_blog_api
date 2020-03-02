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

use Hyperf\HttpServer\Router\Router;

Router::post('/api/admin/login','App\Controller\Api\AdminController@login');

Router::addGroup('/api/',function (){

    Router::addGroup('status/',function () {

        Router::get('type_mapping','App\Controller\Api\StatusController@typeMapping');

        Router::get('status_mapping','App\Controller\Api\StatusController@statusMapping');

    });


    //标签管理
    Router::addGroup('tag/',function () {

       Router::get('list','App\Controller\Api\TagController@list');

       Router::get('tags','App\Controller\Api\TagController@tags');

       Router::post('save','App\Controller\Api\TagController@save');

       Router::post('delete','App\Controller\Api\TagController@delete');

    });

    //文章管理
    Router::addGroup('article/',function () {

        Router::get('list','App\Controller\Api\ArticleController@list');

        Router::get('row','App\Controller\Api\ArticleController@row');

        Router::post('save','App\Controller\Api\ArticleController@save');

        Router::post('delete','App\Controller\Api\ArticleController@delete');

    });



    Router::get('admin/info','App\Controller\Api\AdminController@adminInfo');
    Router::post('admin/logout','App\Controller\Api\AdminController@logout');

    // 七牛上传图片
    Router::post('upload/image','App\Controller\Api\UploadController@image');

},['middleware'=>[
    Phper666\JwtAuth\Middleware\JwtAuthMiddleware::class,
]]);



