<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('satora_business_presets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('recommended_theme')->default('minimal-luxury');
            $table->string('recommended_template')->default('general');
            $table->json('default_categories')->nullable();
            $table->json('recommended_settings')->nullable();
            $table->json('sample_products')->nullable();
            $table->json('default_pages')->nullable();
            $table->json('navigation')->nullable();
            $table->string('icon')->nullable();
            $table->string('preview_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('satora_business_presets');
    }
};
