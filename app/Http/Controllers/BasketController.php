<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Bookmark;
use DateTime;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function showBasketPage() {
        $user = Auth::user();
        $basket = Basket::where('user_id', $user->id)->first();
        if (!$basket) {
            $basket = new Basket();
            $basket->user_id = $user->id;
            $basket->save();
        }
        $basketItems = BasketItem::with('book')->where('basket_id', $basket->id)->get();
        $totalPrice = $basketItems->sum('price');
        $totalDiscount = 0;
        foreach ($basketItems as $basketItem) {
            $totalDiscount += $basketItem->book->discount * $basketItem->quantity;
        }

        return view('basket', compact('basket', 'basketItems', 'totalPrice', 'totalDiscount'));
    }

    public function addToBasket(Request $request) {
        $user = Auth::user();
        $bookId = $request->input('book_id');
        $book = Book::find($bookId);

        $basket = Basket::where('user_id', $user->id)->first();
        if (!$basket) {
            $basket = new Basket();
            $basket->user_id = $user->id;
            $basket->save();
        }

        $existingItem = BasketItem::where('basket_id', $basket->id)
            ->where('book_id', $book->id)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += 1;
            $existingItem->save();
        } else {
            $basketItem = new BasketItem();
            $basketItem->basket_id = $basket->id;
            $basketItem->book_id = $book->id;
            $basketItem->quantity = 1;
            $basketItem->price = $book->price;
            $basketItem->save();
        }

        return redirect(route('showBasketPage'));
    }

    public function deleteFromBasket(Request $request, BasketItem $basketItem) {
        $basketItem->delete();

        return redirect(route('showBasketPage'));
    }

    public function updateBasketItem(Request $request, $itemId)
    {
        $count = $request->input('count');

        $basketItem = BasketItem::find($itemId);
        if ($basketItem) {
            $basketItem->quantity = $count;
            $basketItem->price = (($basketItem->book->price - $basketItem->book->discount) * $count);
            $basketItem->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function summary()
    {
        $totalDiscount = 0;

        $userId = Auth::user()->id;
        $basketId = Basket::where('user_id', $userId)->first()->id;
        $basketItems = BasketItem::where('basket_id', $basketId)->get();
        foreach ($basketItems as $item) {
            $totalDiscount += $item->book->discount * $item->quantity;
        }
        $totalPrice = $basketItems->sum('price');
        $grandTotal = $totalPrice - $totalDiscount;

        return response()->json([
            'success' => true,
            'itemCount' => $basketItems->sum('quantity'),
            'totalPrice' => $totalPrice,
            'totalDiscount' => $totalDiscount,
            'grandTotal' => $grandTotal
        ]);
    }

    public function acceptOrder(Request $request) {

        $userId = Auth::user()->id;
        $basketId = Basket::where('user_id', $userId)->first()->id;
        $basketItems = BasketItem::where('basket_id', $basketId)->get();

        $date = $request->input('datepicker');
        $grand_total = $request->input('grand_total');

        $order = new Order();
        $order->user_id = $userId;
        $order->cost = $grand_total;
        $order->address = auth()->user()->address;
        $order->date = DateTime::createFromFormat('d.m.Y', $date)->format('Y-m-d H:i:s');
        $order->save();

        foreach ($basketItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->book_id = $item->book_id;
            $orderItem->quantity = $item->quantity;
            $orderItem->price = $item->price;
            $orderItem->save();
        }

        BasketItem::where('basket_id', $basketId)->delete();
        Basket::where('id', $basketId)->delete();

        return redirect(route('showUserPage'));
    }
}
