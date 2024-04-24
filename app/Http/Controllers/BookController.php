<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Feedback;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BookController extends Controller
{
    public function index()
    {
        $latestBooks = Book::latest()->take(4)->get();
        $genres = Genre::all();
        foreach ($latestBooks as $book) {
            $averageRating = Feedback::where('book_id', $book->id)->avg('rating');
            $book->averageRating = round($averageRating, 1);

            $feedbackCount = Feedback::where('book_id', $book->id)->count();
            $book->feedbackCount = $feedbackCount;
        }

        return view('index.index-main', ['latestBooks' => $latestBooks, 'genres' => $genres]);
    }

    public function booksByGenre(Genre $genre)
    {
        $genres = Genre::all();
        $latestBooks = Book::where('genre_id', $genre->id)
            ->latest()
            ->take(4)
            ->get();

        foreach ($latestBooks as $book) {
            $averageRating = Feedback::where('book_id', $book->id)->avg('rating');
            $book->averageRating = round($averageRating, 1);

            $feedbackCount = Feedback::where('book_id', $book->id)->count();
            $book->feedbackCount = $feedbackCount;
        }

        return view('index.books-by-genre', ['latestBooks' => $latestBooks, 'genres' => $genres]);
    }

    public function showCard(int $id) {
        $book = Book::find($id);

        $averageRating = Feedback::where('book_id', $book->id)->avg('rating');
        $book->averageRating = round($averageRating, 1);

        $feedbackCount = Feedback::where('book_id', $book->id)->count();
        $book->feedbackCount = $feedbackCount;

        $feedbacks = Feedback::where('book_id', $book->id)->get();

        return view('card', ['book' => $book, 'feedbacks' => $feedbacks]);
    }

    public function addFeedback(Request $request, $id) {

        if (!auth()->check()) {
            return redirect()->route('authorization');
        }

        $request->validate([
            'stars' => 'required',
            'feedback-article-user' => 'required',
            'feedback-text-user' => 'required',
        ]);

        $existingFeedback = Feedback::where('book_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if($existingFeedback) {
            return back()->with('error', 'You have already provided feedback for this book.');
        }

        $feedback = new Feedback();
        $feedback->book_id = $id;
        $feedback->user_id = auth()->id();;
        $feedback->rating = $request->input('stars');
        $feedback->title = $request->input('feedback-article-user');
        $feedback->review = $request->input('feedback-text-user');
        $feedback->save();

        return back()->with('success', 'Feedback added successfully.');
    }
}
