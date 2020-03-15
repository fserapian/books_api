<?php

namespace App\Http\Controllers;

use App\Book;
use App\Traits\ApiResponsor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponsor;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // Return a list of books
    public function index()
    {
        $books = Book::all();
        return $this->successResponse($books);
    }

    // Create a new book
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1'
        ];

        $this->validate($request, $rules);

        $book = Book::create($request->all());

        return $this->successResponse($book, Response::HTTP_CREATED);
    }

    // Return a book by id
    public function show($book)
    {
        $book = Book::findOrFail($book);
        return $this->successResponse($book);
    }

    // Update a book by id
    public function update(Request $request, $book)
    {
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'min:1',
            'author_id' => 'min:1'
        ];

        $this->validate($request, $rules);

        $book = Book::findOrFail($book);
        $book->fill($request->all());

        if ($book->isClean()) {
            return $this->errorResponse(
                'Must change at least one value',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $book->save();

        return $this->successResponse($book);
    }

    // Delete a book by id
    public function destroy($book)
    {
        $book = Book::findOrFail($book);
        $book->delete();
        return $this->successResponse($book);
    }
}
