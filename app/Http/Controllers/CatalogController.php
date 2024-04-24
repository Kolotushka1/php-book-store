<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Feedback;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CatalogController extends Controller
{
    public function showCatalog()
    {
        $query = Book::query();
        $books = $query->paginate(16);

        $genres = Genre::all();

        foreach ($books as $book) {
            $averageRating = Feedback::where('book_id', $book->id)->avg('rating');
            $book->averageRating = round($averageRating, 1);

            $feedbackCount = Feedback::where('book_id', $book->id)->count();
            $book->feedbackCount = $feedbackCount;
        }

        $totalBooks = Book::count();
        $totalPages = ceil($totalBooks / 16);

        $authors_js = array_values(array_unique(Author::pluck('full_name')->toArray()));
        $publishers_js = array_values(array_unique(Publisher::pluck('name')->toArray()));
        $years_js = array_values(array_unique(Book::pluck('year')->toArray()));

        return view('catalog', ['books' => $books, 'totalPages' => $totalPages,
            'genres' => $genres, 'authors_js' => $authors_js,
            'publishers_js' => $publishers_js, 'years_js' => $years_js]);
    }

    public function showCatalogWithFilters(Request $request) {
        $genres = Genre::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        $genre = $request->genre;
        $authorName = $request->author;
        $publisherName = $request->publisher;
        $year = $request->year;
        $age = $request->age;
        $title = $request->title;
        $sortBy = $request->sortBy;

        $author = null;
        if ($authorName) {
            $author = Author::where('full_name', $authorName)->first();
        }

        $publisher = null;
        if ($publisherName) {
            $publisher = Publisher::where('name', $publisherName)->first();
        }

        $booksQuery = Book::query();
        if ($genre) {
            $booksQuery->where('genre_id', $genre);
        }

        if ($author) {
            $booksQuery->where('author_id', $author->id);
        }

        if ($publisher) {
            $booksQuery->where('publisher_id', $publisher->id);
        }

        if ($year) {
            $booksQuery->where('year', $year);
        }

        if ($age) {
            $booksQuery->whereIn('age', $age);
        }

        if ($title) {
            $booksQuery->where('title', 'like', "%{$title}%")->get();
        }

        switch ($sortBy) {
            case 'rating_asc':
                $booksQuery->leftJoin('feedbacks', 'books.id', '=', 'feedbacks.book_id')
                    ->selectRaw('books.*, round(avg(feedbacks.rating), 1) as averageRating, count(feedbacks.id) as feedbackCount')
                    ->groupBy('books.id')
                    ->orderBy('averageRating', 'asc');
                break;
            case 'rating_desc':
                $booksQuery->leftJoin('feedbacks', 'books.id', '=', 'feedbacks.book_id')
                    ->selectRaw('books.*, round(avg(feedbacks.rating), 1) as averageRating, count(feedbacks.id) as feedbackCount')
                    ->groupBy('books.id')
                    ->orderBy('averageRating', 'desc');
                break;
            case 'price_asc':
                $booksQuery->orderByRaw('(price - discount) ASC');
                break;
            case 'price_desc':
                $booksQuery->orderByRaw('(price - discount) DESC');
                break;
            default:
                break;
        }

        $books = $booksQuery->paginate(16);

        foreach ($books as $book) {
            $averageRating = Feedback::where('book_id', $book->id)->avg('rating');
            $book->averageRating = round($averageRating, 1);

            $feedbackCount = Feedback::where('book_id', $book->id)->count();
            $book->feedbackCount = $feedbackCount;
        }

        $totalBooks = $books->count();
        $totalPages = ceil($totalBooks / 16);

        $authors_js = array_values(array_unique(Author::pluck('full_name')->toArray()));
        $publishers_js = array_values(array_unique(Publisher::pluck('name')->toArray()));
        $years_js = array_values(array_unique(Book::pluck('year')->toArray()));

        return view('catalog', compact('books', 'totalPages', 'genres', 'authors_js', 'publishers_js', 'years_js'));
    }
}
