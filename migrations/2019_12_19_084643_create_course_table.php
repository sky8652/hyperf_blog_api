<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('course_name',255)->unique()->nullable(false)->default('')->comment('课程名称');
            $table->string('course_desc',500)->nullable(false)->default('')->comment('课程简介');
            $table->string('course_img')->nullable(false)->default('')->comment('课程主图');
            $table->tinyInteger('course_type')->nullable(false)->default(1)->comment('课程类型 1 免费 2登录查看 3付费');
            $table->tinyInteger('course_status')->nullable(false)->default(1)->comment('课程状态 1显示  2隐藏');
            $table->integer('course_count')->nullable(false)->default(0)->comment('点击');
            $table->integer('course_level')->nullable(false)->default(0)->comment('排序');
            $table->enum('pid',[0,1])->nullable(false)->default(0)->comment('父级 最多2级 0最顶级 1子级');
            $table->integer('is_recommend')->nullable(false)->default(2)->comment('是否推荐  1 是 2 不是');
            $table->integer('created_id')->nullable(false)->default(0)->comment('创建人ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course');
    }
}
