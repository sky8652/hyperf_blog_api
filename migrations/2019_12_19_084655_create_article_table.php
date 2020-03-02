<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('article_title',255)->unique()->nullable(false)->default('')->comment('标题');
            $table->string('article_desc',500)->nullable(false)->default('')->comment('简介');
            $table->string('article_img')->nullable(false)->default('')->comment('主图');
            $table->text('article_content')->nullable(false)->comment("内容");
            $table->tinyInteger('article_type')->nullable(false)->default(1)->comment('类型 1 免费 2登录查看 3付费');
            $table->tinyInteger('article_status')->nullable(false)->default(1)->comment('类型   1 正常 2隐藏 ');
            $table->integer('article_count')->nullable(false)->default(0)->comment('点击');
            $table->integer('article_level')->nullable(false)->default(1)->comment('排序');
            $table->bigInteger('tag_id')->index()->nullable(false)->default(0)->comment('标签ID');
            $table->integer('is_recommend')->nullable(false)->default(2)->comment('是否推荐  1 是 2 不是');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
}
