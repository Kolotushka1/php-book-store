<?php
//
//use Illuminate\Database\Migrations\Migration;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
//
//return new class extends Migration
//{
//    public function up(): void
//    {
//        Schema::create('discounts', function (Blueprint $table) {
//            $table->id();
//            $table->decimal('discount_price', 10, 2);
//            $table->foreignId('book_id')->nullable()->constrained('books');
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('discounts');
//    }
//};
