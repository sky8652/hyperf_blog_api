<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateFriendshipLinkTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('friendship_link', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false)->default('');
            $table->string('link')->nullable(false)->default('');
            $table->tinyInteger('level')->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendship_link');
    }
}
