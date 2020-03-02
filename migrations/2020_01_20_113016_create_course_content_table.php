<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCourseContentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_id')->index()->unsigned()->nullable(false)->default(0)->comment('课程ID');
            $table->string('content_title',255)->nullable(false)->default('')->comment('课程内容标题');
            $table->text('content')->comment('内容');
            $table->tinyInteger('content_type')->unsigned()->nullable(false)->default(1)->comment('课程类型 1 免费 2登录 3收费');
            $table->tinyInteger('content_status')->unsigned()->nullable(false)->default(1)->comment('课程状态 1 显示 2隐藏');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_content');
    }
}
