<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('satora_business_presets', function (Blueprint $table) {
            if (! Schema::hasColumn('satora_business_presets', 'attributes')) {
                $table->json('attributes')->nullable()->after('navigation');
            }
            if (! Schema::hasColumn('satora_business_presets', 'attribute_family')) {
                $table->json('attribute_family')->nullable()->after('attributes');
            }
            if (! Schema::hasColumn('satora_business_presets', 'email_templates')) {
                $table->json('email_templates')->nullable()->after('attribute_family');
            }
            if (! Schema::hasColumn('satora_business_presets', 'widgets')) {
                $table->json('widgets')->nullable()->after('email_templates');
            }
            if (! Schema::hasColumn('satora_business_presets', 'banners')) {
                $table->json('banners')->nullable()->after('widgets');
            }
            if (! Schema::hasColumn('satora_business_presets', 'roles')) {
                $table->json('roles')->nullable()->after('banners');
            }
            if (! Schema::hasColumn('satora_business_presets', 'product_types')) {
                $table->json('product_types')->nullable()->after('roles');
            }
        });
    }

    public function down(): void
    {
        Schema::table('satora_business_presets', function (Blueprint $table) {
            $table->dropColumn([
                'attributes', 'attribute_family', 'email_templates',
                'widgets', 'banners', 'roles', 'product_types',
            ]);
        });
    }
};
