<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->timestamps();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20);
            $table->string('address');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('full_name');
            $table->string('address');
            $table->string('phone')->unique();
            $table->string('password');
            $table->foreignId('role_id')->nullable()->constrained('roles');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('publisher_id')->nullable()->constrained('publishers');
            $table->integer('price');
            $table->year('year');
            $table->integer('page_count');
            $table->string('cover_type');
            $table->integer('edition');
            $table->string('age');
            $table->foreignId('author_id')->nullable()->constrained('authors');
            $table->foreignId('genre_id')->nullable()->constrained('genres');
            $table->string('image');
            $table->string('isbn', 13)->unique();
            $table->integer('discount');
            $table->timestamps();
        });

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->nullable()->constrained('books');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->integer('rating');
            $table->string('title', 256);
            $table->text('review');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('cost');
            $table->string('address');
            $table->dateTime('date');
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('book_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('basket_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('basket_id');
            $table->unsignedBigInteger('book_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();

            $table->foreign('basket_id')->references('id')->on('baskets')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

//        Schema::create('baskets', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('user_id');
//            $table->timestamps();
//        });
//
//        Schema::create('basket_items', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('basket_id');
//            $table->foreign('basket_id')->references('id')->on('baskets')->onDelete('cascade');
//            $table->unsignedBigInteger('book_id');
//            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
//            $table->timestamps();
//        });
//
//        Schema::create('orders', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('user_id');
//            $table->foreign('user_id')->references('id')->on('users');
//            $table->unsignedBigInteger('basket_id');
//            $table->foreign('basket_id')->references('id')->on('baskets')->onDelete('cascade');
//            $table->string('address');
//            $table->dateTime('date');
//            $table->integer('cost');
//            $table->boolean('status')->default(0);
//            $table->timestamps();
//        });

        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('baskets');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('books');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('publishers');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('bookmarks');
    }
};
