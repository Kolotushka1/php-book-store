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
//        Schema::create('orders', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('user_id')->nullable()->constrained('users');
//            $table->foreignId('basket_id')->nullable()->constrained('baskets');
//            $table->string('address');
//            $table->dateTime('date');
//            $table->decimal('cost', 10, 2);
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('orders');
//    }
//};
