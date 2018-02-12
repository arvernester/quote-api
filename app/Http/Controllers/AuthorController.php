<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\View\View;
use Unirest\Request as Unirest;

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
        $wikipedia = Unirest::get('https://'.session('lang').'.wikipedia.org/w/api.php?action=opensearch&search='.$author->name.'&limit=1&namespace=0&format=json');

        if (!empty($wikipedia->body[2][0])) {
            $description = $wikipedia->body[2][0];
            $url = $wikipedia->body[3][0];
        }

        return view('author.show', compact(
            'author',
            'description',
            'url'
        ))
            ->withTitle($author->name);
    }
}
