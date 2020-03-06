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

//管理员登录
Router::post('/api/admin/login','App\Controller\Api\AdminController@login');

// 七牛上传图片
Router::post('/api/upload/image','App\Controller\Api\UploadController@image');

//获取站点信息
Router::get('/api/site/settings','App\Controller\Api\SiteSettingController@settings');

//获取友情链接
Router::get('/api/site/friend_links','App\Controller\Api\SiteSettingController@friendLinks');

//获取文章详情
Router::get('/api/article/row','App\Controller\Api\ArticleController@row');

//前端页面
Router::addGroup('/api/home/',function () {

   Router::get('tag','App\Controller\Api\TagController@homeTags');

   Router::get('article','App\Controller\Api\ArticleController@homeArticles');

});

//后台管理接口
Router::addGroup('/api/',function (){

    //相关状态
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

        Router::post('save','App\Controller\Api\ArticleController@save');

        Router::post('delete','App\Controller\Api\ArticleController@delete');

    });

    //站点设置
    Router::addGroup('site/',function () {

        //保存站点信息
        Router::post('save','App\Controller\Api\SiteSettingController@save');

        //保存友情链接
        Router::post('save_friend_link','App\Controller\Api\SiteSettingController@saveFriendLink');

        //删除友情链接
        Router::post('delete_friend_link','App\Controller\Api\SiteSettingController@deleteFriendLink');
    });



    //获取管理员相关信息
    Router::get('admin/info','App\Controller\Api\AdminController@adminInfo');

    //退出登录
    Router::post('admin/logout','App\Controller\Api\AdminController@logout');

},['middleware'=>[
    Phper666\JwtAuth\Middleware\JwtAuthMiddleware::class,
]]);