<?php

namespace Database\Seeders;

use App\Models\BasketItem;
use App\Models\Bookmark;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Basket;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Role::factory()->create(['name' => 'admin']);
        Role::factory()->create(['name' => 'user']);

        User::factory(10)->create()->each(function ($user) {
            $user->role()->associate(Role::all()->random());
            $user->save();
        });

        Author::factory(10)->create();

        Genre::factory(6)->create();

        Publisher::factory(5)->create();

        Book::factory(200)->create()->each(function ($book) {
            $book->author()->associate(Author::all()->random());
            $book->genre()->associate(Genre::all()->random());
            $book->publisher()->associate(Publisher::all()->random());
            $book->save();
        });

        Book::all()->each(function ($book) {
            $numberOfFeedbacks = rand(4, 7);
            $numberOfBookmarks = rand(1, 3);

            $randomUsers = User::all()->shuffle()->take($numberOfFeedbacks);

            Bookmark::factory($numberOfBookmarks)->create([
                'book_id' => $book->id,
                'user_id' => function () use ($randomUsers) {
                    return $randomUsers->random()->id;
                },
            ]);

            Feedback::factory($numberOfFeedbacks)->create([
                'book_id' => $book->id,
                'user_id' => function () use ($randomUsers) {
                    return $randomUsers->pop()->id;
                },
            ]);
        });

        Basket::factory(10)->create()->each(function ($basket) {
            $basket->update(['user_id' => User::all()->random()->id]);

            $basket->items()->saveMany([
                BasketItem::factory()->create(['book_id' => Book::all()->random()->id, 'basket_id' => $basket->id]),
                BasketItem::factory()->create(['book_id' => Book::all()->random()->id, 'basket_id' => $basket->id]),
            ]);
        });

        Order::factory(10)->create()->each(function ($order) {
            $user = User::all()->random();
            $order->update(['user_id' => $user->id]);
            $order->items()->saveMany([
               OrderItem::factory()->create(['order_id' => $order->id, 'book_id' => Book::all()->random()->id])
            ]);
            $order->address = $user->address;
            $order->save();
        });
    }
}
