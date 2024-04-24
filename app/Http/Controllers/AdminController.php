<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Feedback;
use App\Models\Genre;
use App\Models\Order;
use App\Models\Author;
use App\Models\OrderItem;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use function Symfony\Component\String\b;

class AdminController extends Controller
{
    public function showAdminPanel()
    {
        $orders = Order::orderBy('status', 'asc')->paginate(6);
        $ordersItems = OrderItem::all();

        return view('admin.admin', compact('orders', 'ordersItems'));
    }

    public function updateOrderStatus(Request $request) {
        $order = Order::find($request->input('order_id'));

        $order->update([
            'status' => 1
        ]);

        return back();
    }

    public function showAdminNewBook() {
        $genres = Genre::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        $authors_js = array_values(array_unique(Author::pluck('full_name')->toArray()));
        $publishers_js = array_values(array_unique(Publisher::pluck('name')->toArray()));
        $genres_js = array_values(array_unique(Genre::pluck('name')->toArray()));

        return view('admin.new-book', compact('authors_js', 'publishers_js', 'genres_js'));
    }

    public function createBook(Request $request)
    {
        $request->validate([
            'name-of-book' => 'required',
            'publisher' => 'required',
            'author' => 'required',
            'genre' => 'required',
            'price' => 'required',
            'year' => 'required',
            'pages' => 'required',
            'edition' => 'required',
            'age' => 'required',
            'discount' => '',
            'ISBN' => 'required',
            'formFile' => 'required',
            'description-book' => 'required',
        ]);

        $publisher = Publisher::where('name', $request->input('publisher'))->first();
        $author = Author::where('full_name', $request->input('author'))->first();
        $genre = Genre::where('name', $request->input('genre'))->first();

        if (!$publisher) {
            return back()->with('error', 'Издательство не найдено.');
        }

        if (!$author) {
            return back()->with('error', 'Автор не найден.');
        }

        if (!$genre) {
            return back()->with('error', 'Жанр не найден.');
        }

        $book = new Book();
        $book->title = $request->input('name-of-book');
        $book->description = $request->input('description-book');
        $book->publisher_id = $publisher->id;
        $book->author_id = $author->id;
        $book->genre_id = $genre->id;
        $book->price = $request->input('price');
        $book->year = $request->input('year');
        $book->cover_type = $request->input('cover');
        $book->page_count = $request->input('pages');
        $book->edition = $request->input('edition');
        $book->age = $request->input('age');
        $book->discount = $request->input('discount');
        $book->ISBN = $request->input('ISBN');

        if ($request->hasFile('formFile')) {
            $image = $request->file('formFile');
            $imageName = 'book_' . time() . '.' . $image->getClientOriginalExtension();
            $path = 'images/books/';
            $image->move(public_path($path), $imageName);
            $book->image = '/' . $path . $imageName;
        } else {
            $book->image = '/images/books/no-foto.svg';
        }

        $book->save();

        return back()->with('success', 'Книга успешно добавлена.');
    }

    public function showAdminCatalog()
    {
        $query = Book::query();
        $books = $query->paginate(6);

        return view('admin.catalog-update', compact('books'));
    }

    public function deleteBook(Request $request)
    {

        $bookId = $request->input('book_id');
        $book = Book::find($bookId);

        Feedback::where('book_id', $bookId)->delete();
        BasketItem::where('book_id', $bookId)->delete();
        OrderItem::where('book_id', $bookId)->delete();
        Bookmark::where('book_id', $bookId)->delete();

        $book->delete();

        return redirect()->back()->with('success', 'Книга успешно удалена');
    }

    public function showUpdateBook(Request $request, $id)
    {
        $book = Book::find($id);

        $genres = Genre::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        $authors_js = array_values(array_unique(Author::pluck('full_name')->toArray()));
        $publishers_js = array_values(array_unique(Publisher::pluck('name')->toArray()));
        $genres_js = array_values(array_unique(Genre::pluck('name')->toArray()));

        return view('admin.update-book', compact('book', 'authors_js', 'publishers_js', 'genres_js'));
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $publisher = Publisher::where('name', $request->input('publisher'))->first();
        $author = Author::where('full_name', $request->input('author'))->first();
        $genre = Genre::where('name', $request->input('genre'))->first();

        if (!$publisher) {
            return back()->with('error', 'Издательство не найдено.');
        }
        if (!$author) {
            return back()->with('error', 'Автор не найден.');
        }
        if (!$genre) {
            return back()->with('error', 'Жанр не найден.');
        }

        if ($request->hasFile('formFile')) {
            $image = $request->file('formFile');
            $imageName = 'book_' . time() . '.' . $image->getClientOriginalExtension();
            $path = 'images/books/';
            $image->move(public_path($path), $imageName);
            $book->image = '/' . $path . $imageName;
        } elseif ($book->image != '/images/books/no-foto.svg') {
            $image = $book->image;
        }
        else {
            $image = '/images/books/no-foto.svg';
        }

        $book->update([
            'title' => $request->input('name-of-book'),
            'description' => $request->input('description-book'),
            'publisher_id' => $publisher->id,
            'author_id' => $author->id,
            'genre_id' => $genre->id,
            'price' => $request->input('price'),
            'year' => $request->input('year'),
            'cover_type' => $request->input('cover'),
            'page_count' => $request->input('pages'),
            'edition' => $request->input('edition'),
            'age' => $request->input('age'),
            'discount_id' => $request->input('discount'),
            'ISBN' => $request->input('ISBN'),
            'image' => $image,
        ]);

        $basketItems = BasketItem::where('book_id', $id)->get();
        foreach ($basketItems as $basketItem) {
            $price = $request->input('price') - $request->input('discount');
            $basketItem->price = $price * $basketItem->quantity;
            $basketItem->save();
        }

        return back();
    }

    public function showPublisher(Request $request) {

        $query = Publisher::query();
        $query->where('name', '!=', 'Нет');
        $publishers = $query->paginate(6);

        if ($request->input('publisherToUpdateId')) {
            $publisherToUpdateId = $request->input('publisherToUpdateId');
            $publisherToUpdate = Publisher::where('id', $publisherToUpdateId)->first();
            return view('admin.publisher', compact('publishers', 'publisherToUpdate'));
        }

        $publisherToUpdate = "";
        return view('admin.publisher', compact('publishers', 'publisherToUpdate'));
    }

    public function addPublisher(Request $request) {

        $publisher = new Publisher();
        $publisher->name = $request->input('name');
        $publisher->phone = $request->input('phone');
        $publisher->address = $request->input('address');

        $publisher->save();

        return redirect(route('showPublisher'))->with('success', 'Успешно добавлено!');

    }

    public function updatePublisher(Request $request) {
        $publisher = Publisher::findOrFail($request->input('publisherToUpdate'));

        $publisher->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);
        return redirect(route('showPublisher'))->with('success', 'Успешно изменено!');
    }

    public function deletePublisher(Request $request) {

        $publisherId = $request->input('publisherToDeleteId');
        $publisher = Publisher::find($publisherId);

        Book::where('publisher_id', $publisherId)->update(['publisher_id' => 8]);

        $publisher->delete();

        return redirect(route('showPublisher'))->with('success', 'Успешно удалено!');
    }

    public function showAuthor(Request $request) {

        $query = Author::query();
        $query->where('full_name', '!=', 'Нет');
        $authors = $query->paginate(6);

        if ($request->input('authorToUpdateId')) {
            $authorToUpdateId = $request->input('authorToUpdateId');
            $authorToUpdate = Author::where('id', $authorToUpdateId)->first();
            return view('admin.author', compact('authors', 'authorToUpdate'));
        }

        $authorToUpdate = "";
        return view('admin.author', compact('authors', 'authorToUpdate'));
    }

    public function addAuthor(Request $request) {

        $author = new Author();
        $author->full_name = $request->input('name');

        $author->save();

        return redirect(route('showAuthor'))->with('success', 'Успешно добавлено!');

    }

    public function updateAuthor(Request $request) {
        $author = Author::findOrFail($request->input('authorToUpdateId'));

        $author->update([
            'full_name' => $request->input('name'),
        ]);
        return redirect(route('showAuthor'))->with('success', 'Успешно изменено!');
    }

    public function deleteAuthor(Request $request) {

        $authorId = $request->input('authorToDeleteId');
        $author = Author::find($authorId);

        Book::where('publisher_id', $authorId)->update(['author_id' => 11]);

        $author->delete();

        return redirect(route('showAuthor'))->with('success', 'Успешно удалено!');
    }

}
