<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->string('supplier')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['name','sku']);
            $table->index('category_id');
            $table->index('quantity');
        });
    }
    public function down() { Schema::dropIfExists('products'); }
};