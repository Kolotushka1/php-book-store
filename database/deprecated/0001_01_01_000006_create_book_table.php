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
//        Schema::create('books', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('publisher_id')->nullable()->constrained('publishers');
//            $table->decimal('price', 10, 2);
//            $table->year('year');
//            $table->integer('page_count');
//            $table->string('cover_type');
//            $table->integer('edition');
//            $table->integer('age');
//            $table->foreignId('author_id')->nullable()->constrained('authors');
//            $table->foreignId('genre_id')->nullable()->constrained('genres');
//            $table->foreignId('discount_id')->nullable()->constrained('discounts');
//            $table->string('image');
//            $table->string('isbn', 13)->unique();
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('books');
//    }
//};
