<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_models', function (Blueprint $table) {
            $table->id();
            $table->string('data_scope', 20); // ppic / produksi
            $table->unsignedInteger('number');
            $table->string('model', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['data_scope', 'number']);
            $table->unique(['data_scope', 'model']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('master_model_id')
                ->nullable()
                ->after('id')
                ->constrained('master_models')
                ->cascadeOnDelete();

            $table->string('data_scope', 20)
                ->nullable()
                ->after('master_model_id');

            $table->index(['data_scope', 'master_model_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('user_group', 20)
                ->nullable()
                ->after('role');
        });

        Schema::table('repair_orders', function (Blueprint $table) {
            $table->foreignId('master_model_id')
                ->nullable()
                ->after('product_id')
                ->constrained('master_models')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('repair_orders', function (Blueprint $table) {
            $table->dropForeign(['master_model_id']);
            $table->dropColumn('master_model_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_group');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['master_model_id']);
            $table->dropIndex(['data_scope', 'master_model_id']);
            $table->dropColumn(['master_model_id', 'data_scope']);
        });

        Schema::dropIfExists('master_models');
    }
};
