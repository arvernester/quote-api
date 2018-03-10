<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\View\View;
use Unirest\Request as Unirest;
use App\Language;
use App\AuthorProfile;
use Illuminate\Http\RedirectResponse;

class AuthorController extends Controller
{
    /**
     * Redirect to friendly url.
     *
     * @param string $lang
     * @param Author $author
     *
     * @return RedirectResponse
     */
    public function show(string $lang = null, Author $author): RedirectResponse
    {
        return redirect(route_lang('author.show.slug', $author->slug));
    }

    /**
     * Show author detail by given slug.
     *
     * @param Author $author
     *
     * @return view
     */
    public function showBySlug(string $lang = null, string $slug): View
    {
        $language = Language::whereCodeAlternate($lang)->first();

        $author = Author::whereSlug($slug)
            ->with(['profiles' => function ($profile) use ($language) {
                return $profile->whereLanguageId($language->id);
            }])
            ->first();

        abort_if(empty($author), 404, __('Author not found.'));

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

        // show quotes from author grouped by lang
        $languages = Language::with(['quotes' => function ($quote) use ($author) {
            return $quote->whereAuthorId($author->id);
        }])
            ->whereHas('quotes')
            ->get();

        return view('author.show', compact(
            'author',
            'description',
            'url',
            'languages'
        ))
            ->withTitle(__('Quote by :author', ['author' => $author->name]));
    }
}
