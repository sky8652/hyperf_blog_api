<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateLetterTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable(false)->default(0)->index();
            $table->tinyInteger('from_admin')->nullable(false)->default(0)->comment('是否来自管理员的回复');
            $table->string('content')->nullable(false)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter');
    }
}
