<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Mahsulot bilan bog'lash
            $table->string('attribute_name')->nullable(); // Variant nomi (masalan, RAM, rang)
            $table->string('attribute_value'); // Variant qiymati (masalan, 8GB, qora)
            $table->decimal('price_difference', 10, 2)->default(0); // Narxga qo‘shiladigan qiymat        
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
