<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kardexes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->date('operation_date');
            $table->string('detail')->nullable();
            $table->integer('product_entry')->nullable();
            $table->integer('product_exit')->nullable();
            $table->integer('product_stock')->nullable();
            $table->decimal('cost_unit', 10, 2)->nullable();
            $table->decimal('amount_entry', 10, 2)->nullable();
            $table->decimal('amount_exit', 10, 2)->nullable();
            $table->decimal('amount_stock', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardexes');
    }
};
