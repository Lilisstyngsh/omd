<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('data_scope', 20);
            $table->string('name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['data_scope', 'name']);
            $table->index(['data_scope', 'is_active']);
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->foreignId('plant_id')
                ->nullable()
                ->after('id')
                ->constrained('plants')
                ->nullOnDelete();

            $table->index(['plant_id', 'is_active']);
        });

        Schema::table('master_models', function (Blueprint $table) {
            $table->foreignId('plant_id')
                ->nullable()
                ->after('data_scope')
                ->constrained('plants')
                ->nullOnDelete();

            $table->foreignId('area_id')
                ->nullable()
                ->after('plant_id')
                ->constrained('areas')
                ->nullOnDelete();

            $table->index(['data_scope', 'plant_id', 'area_id']);
        });
    }

    public function down(): void
    {
        Schema::table('master_models', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
            $table->dropForeign(['plant_id']);
            $table->dropIndex(['data_scope', 'plant_id', 'area_id']);
            $table->dropColumn(['plant_id', 'area_id']);
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->dropForeign(['plant_id']);
            $table->dropIndex(['plant_id', 'is_active']);
            $table->dropColumn('plant_id');
        });

        Schema::dropIfExists('plants');
    }
};
