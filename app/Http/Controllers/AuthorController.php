<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the author.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $authors = Author::orderBy('name')
            ->paginate($request->limit ?? 20);

        $authors->appends($request->only('limit'));

        return view('author.index', compact('authors'))
            ->withTitle('Author');
    }

    /**
     * Show the form for creating a new author.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created author in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified author.
     *
     * @param Author $author
     *
     * @return View
     */
    public function show(Author $author): View
    {
        return view('author.show', compact('author'))
            ->withTitle('Author Detail');
    }

    /**
     * Show the form for editing the specified author.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified author in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified author from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
