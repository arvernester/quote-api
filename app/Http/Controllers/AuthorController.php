<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\View\View;

class AuthorController extends Controller
{
    /**
     * Show author detail.
     *
     * @param Author $author
     *
     * @return view
     */
    public function show($lang = null, Author $author): View
    {
        return view('author.show', compact('author'))
            ->withTitle($author->name);
    }
}
