<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\View\View;
use Unirest\Request as Unirest;
use App\Language;
use App\AuthorProfile;

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
        $language = Language::whereCodeAlternate($lang)->first();

        $author->load(['profiles' => function ($query) use ($language) {
            $query->whereLanguageId($language->id);
        }]);

        if (empty($author->profiles->first())) {
            // get profile from wikipedia
            $wikipedia = Unirest::get('https://'.$language->code_alternate.'.wikipedia.org/w/api.php?action=opensearch&search='.$author->name.'&limit=1&namespace=0&format=json');
            if (!empty($wikipedia->body[2][0])) {
                $description = $wikipedia->body[2][0];
                $url = $wikipedia->body[3][0];

                // save to author profile
                $profile = AuthorProfile::firstOrNew([
                    'language_id' => $language->id,
                    'author_id' => $author->id,
                ]);

                $profile->about = $description;
                $profile->url = $url;
                $profile->save();
            }
        } else {
            $description = $author->profiles->first()->about;
            $url = $author->profiles->first()->url;
        }

        return view('author.show', compact(
            'author',
            'description',
            'url'
        ))
            ->withTitle($author->name);
    }
}
