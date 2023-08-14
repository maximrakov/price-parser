<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('link')->unique();
            $table->foreignId('shop');
            $table->string('name');
            $table->integer('price');
            $table->string('image');
            $table->string('parsing_way');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
//        Schema::dropIfExists('products');
//        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
