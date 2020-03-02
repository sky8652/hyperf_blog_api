<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tag_name',30)->unique()->nullable(false)->default('')->comment('标签名称');
            $table->tinyInteger('tag_type')->nullable(false)->default(1)->comment('标签类型 1普通 2需登录查看 3需付费查看');
            $table->tinyInteger('tag_level')->nullable(false)->default(1)->comment('标签排序');
            $table->tinyInteger('tag_status')->nullable(false)->default(1)->comment('标签状态 1 正常显示 2 隐藏');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag');
    }
}
