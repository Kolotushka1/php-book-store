<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Bookmark;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUserPage() {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();
        $bookmarks = Bookmark::where('user_id', $user->id)->get();

        return view('user-page', compact('user', 'orders', 'bookmarks'));
    }

    public function updateUserInfo(Request $request) {
        $userId = $request->input('user_id');
        $user = User::find($userId);

        $user->update([
            'email' => $request->input('user-email'),
            'full_name' => $request->input('user-full-name'),
            'phone' => $request->input('user-phone-number'),
            'address' => $request->input('user-address'),
        ]);

        return back()->with('success', 'Данные обновлены');
    }

    public function deleteUserOrder(Request $request) {

        $orderId = $request->input('order_id');

        OrderItem::where('order_id', $orderId)->delete();
        Order::where('id', $orderId)->delete();

        return back();
    }

    public function addUserBookmarks(Request $request) {
        $bookId = $request->input('book_id');
        $userId = $request->input('user_id');

        $existingBookmark = Bookmark::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($existingBookmark) {
            return back()->with('error', 'Закладка для этой книги уже существует');
        }

        $userBookmark = new Bookmark();
        $userBookmark->user_id = $userId;
        $userBookmark->book_id = $bookId;

        $userBookmark->save();

        return back();
    }

    public function deleteUserBookmarks(Request $request) {
        $bookmarkId = $request->input('bookmark_id');
        $bookmark = Bookmark::find($bookmarkId);

        $bookmark->delete();
        return back();
    }

    public function destroy(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
