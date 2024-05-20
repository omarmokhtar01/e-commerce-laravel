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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable();
            $table->foreignId('category_id')->unsigned()->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->unsigned()->constrained()->onDelete('cascade');
            $table->integer('amount');
            $table->integer('quantity');

            $table->double('discount')->nullable();
            /*
            0: This is the total number of digits stored for the value, including digits on both sides of the decimal point.
            2: This is the number of digits after the decimal point.
            123.45
            */
            $table->double('price', 0, 2);
            $table->boolean('is_avaliable')->default(1);
            $table->boolean('is_trendy')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
