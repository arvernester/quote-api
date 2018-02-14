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
use App\Facades\Poster;
use Illuminate\Http\RedirectResponse;

class QuoteController extends Controller
{
    public function index($lang, Request $request): View
    {
        $quotes = Quote::orderBy('created_at')
            ->with('author')
            ->language($request->lang)
            ->paginate(10);

        $quotes->appends($request->only('lang'));

        return view('quote.index', compact('quotes'))
            ->withTitle(
                __('Inspirational and Motivational Quotes That Will Make Your Day!')
            );
    }

    /**
     * Show single quote.
     *
     * @param [type] $lang
     * @param Quote  $quote
     *
     * @return RedirectResponse
     */
    public function show($lang, Quote $quote): RedirectResponse
    {
        return redirect(route_lang('quote.show.slug', $quote->slug));
    }

    public function showBySlug($lang, string $slug): View
    {
        $quote = Quote::whereSlug($slug)
            ->with('author', 'category', 'language')
            ->first();

        abort_if(empty($quote), 404, __('Quote not found.'));

        if (session('lang') and (session('lang') != $quote->language->code_alternate)) {
            $language = Language::whereCodeAlternate(session('lang'))->first();
        }

        $shareQuote = sprintf(
            '%s By %s. Via @%s.',
            $quote->text.$quote->text.$quote->text,
            $quote->author->name,
            env('TWITTER_USERNAME')
        );

        return view('quote.show', compact(
            'quote',
            'language',
            'shareQuote'
        ))
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

            $quote->slug = str_slug($quote->author->name);
            $quote->save();

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

    /**
     * Response random quotes.
     *
     * @param Request $request
     *
     * @return View
     */
    public function random($lang, Request $request): View
    {
        $quotes = Quote::inRandomOrder()
            ->language($request->lang)
            ->take(10)
            ->get();

        return view('quote.random', compact('quotes'))
            ->withTitle(
                __('Get Ten Random Quotes for Your Inspiration and Motivation')
            );
    }

    /**
     * Generate poster on the fly when access quote detail.
     *
     * @param Quote $quote
     */
    public function poster(string $slug): void
    {
        $quote = Quote::whereSlug($slug)
            ->with('author')
            ->first();
        if (!empty($quote)) {
            header('Content-type: image/png');
        }

        Poster::generate($quote);
    }
}
