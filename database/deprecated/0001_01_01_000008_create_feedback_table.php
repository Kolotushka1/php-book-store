<?php
//
//use Illuminate\Database\Migrations\Migration;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
//
//return new class extends Migration
//{
//    public function up() : void
//    {
//        Schema::create('feedbacks', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('book_id')->nullable()->constrained('books');
//            $table->foreignId('user_id')->nullable()->constrained('users');
//            $table->timestamps();
//        });
//    }
//
//    public function down() : void
//    {
//        Schema::dropIfExists('feedbacks');
//    }
//};
