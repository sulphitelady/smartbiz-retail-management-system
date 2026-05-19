<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('action', ['added','sold','adjusted','returned']);
            $table->integer('quantity_change');
            $table->text('note')->nullable();
            $table->foreignId('sale_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            $table->index(['product_id','action']);
        });
    }
    public function down() { Schema::dropIfExists('inventory_logs'); }
};