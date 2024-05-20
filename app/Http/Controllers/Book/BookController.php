<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\GetDataRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(GetDataRequest $req) {
        $show = $req->show ?? 10;
        $sortBy = $req->sortBy ?? "created_at";
        $sorting = $req->sorting ?? "DESC";
        $search = $req->search;

        try {
            $books = Book::where([
                [function($query) use($search){
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('author', 'like', '%'.$search.'%');
                }],
            ])
            ->orderBy($sortBy, $sorting)
            ->paginate($show);

            return $this->successResponse('books data', $books);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function getById($id) {
        try {
            $book = Book::select(
                'id',
                'name',
                'author',
                'updated_by',
                'created_at',
                'updated_at',
            )
            ->where('id', $id)
            ->first();

            if (!$book) {
                return $this->notFoundResponse('book with id ' . $id . ' not found');
            }

            return $this->successResponse('book data', $book);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function store(BookRequest $req) {
        try {
            $book = Book::Create(array_merge($req->validated()));
            return $this->successResponse('create book success', $book);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(BookRequest $req, $id) {
        if (!$book = Book::find($id)) {
            return $this->notFoundResponse('book with id ' . $id . ' not found');
        }

        try {
            $book->update(array_merge($req->validated()));
            return $this->successResponse('update book success', $book);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function destroy($id) {
        if (!$book = Book::find($id)) {
            return $this->notFoundResponse('book with id ' . $id . ' not found');
        }

        try {
            $book->delete();
            return $this->successResponse('delete book success');
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
