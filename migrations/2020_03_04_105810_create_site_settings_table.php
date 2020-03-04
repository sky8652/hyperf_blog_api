<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('site_name')->nullable(false)->default('');
            $table->string('site_desc')->nullable(false)->default('');
            $table->string('site_icon')->nullable(false)->default('');
            $table->string('site_record')->nullable(false)->default('')->comment('备案号');
            $table->string('site_owner')->nullable(false)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
}
