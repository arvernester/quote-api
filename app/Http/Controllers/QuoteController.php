<?php

namespace App\Http\Controllers;

use App\Quote;
use Illuminate\View\View;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Author;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class QuoteController extends Controller
{
    /**
     * Show single quote.
     *
     * @param string $lang
     * @param Quote  $quote
     *
     * @return View
     */
    public function show($lang, Quote $quote): View
    {
        $quote->load('author', 'category', 'language');

        if (session('lang') and (session('lang') != $quote->language->code_alternate)) {
            $language = Language::whereCodeAlternate(session('lang'))->first();
        }

        return view('quote.show', compact('quote', 'language'))
            ->withTitle(__('Quote by :author', ['author' => $quote->author->name]));
    }

    /**
     * Submit new quote.
     *
     * @return View
     */
    public function create(): View
    {
        return view('quote.create')
            ->withTitle(__('Submit New Quote'));
    }

    /**
     * Store new quote from user contribution.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'author' => 'max:100|sometimes',
            'quote' => 'required|string',
        ]);

        DB::transaction(function () use (&$quote, $request) {
            $author = Author::firstOrCreate([
                'name' => $request->author ?? 'Anonymous',
            ]);

            // set default category to uncategorized
            $category = Category::firstOrCreate([
                'name' => 'Uncategorized',
            ]);

            // set default language to english
            $language = Language::whereCodeAlternate('en')
                ->first();
            $quote = Quote::create([
                'user_id' => Auth::id() ?? null,
                'author_id' => $author->id,
                'category_id' => $category->id,
                'language_id' => $language->id,
                'text' => $request->quote,
                'status' => 'I',
            ]);

            $users = User::all();
            Notification::send($users, new GeneralNotification(
                __('New quote has been submitted.'),
                route('admin.quote.show', $quote, false), // relative path
                'fa-quote-right'
            ));
        });

        return response()->json([
            'status' => true,
            'quote' => $quote,
        ]);
    }
}
