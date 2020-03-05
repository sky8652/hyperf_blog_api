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
// 七牛上传图片
Router::post('/api/upload/image','App\Controller\Api\UploadController@image');

//获取站点信息
Router::get('/api/site/settings','App\Controller\Api\SiteSettingController@settings');

Router::addGroup('/api/home/',function () {

   Router::get('tag','App\Controller\Api\TagController@homeTags');

   Router::get('article','App\Controller\Api\ArticleController@homeArticles');

});

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

    //站点设置
    Router::addGroup('site/',function () {

        Router::post('save','App\Controller\Api\SiteSettingController@save');
    });



    //获取管理员相关信息
    Router::get('admin/info','App\Controller\Api\AdminController@adminInfo');
    Router::post('admin/logout','App\Controller\Api\AdminController@logout');

},['middleware'=>[
    Phper666\JwtAuth\Middleware\JwtAuthMiddleware::class,
]]);