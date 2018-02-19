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
use Illuminate\Support\Facades\Notification;
use App\Facades\Poster;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use App\Notifications\Quote\SubmitNotification as QuoteSubmitNotification;

class QuoteController extends Controller
{
    /**
     * Show all quotes separated by pagination.
     *
     * @param string  $lang
     * @param Request $request
     *
     * @return View
     */
    public function index(string $lang, Request $request): View
    {
        $this->validate($request, [
            'locale' => 'string|exists:languages,code_alternate',
            'category' => 'string|exists:categories,slug',
        ]);

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('author')
            ->language($request->locale)
            ->category($request->category)
            ->published()
            ->paginate(10);

        $quotes->appends($request->only('locale', 'category'));

        return view('quote.index', compact('quotes'))
            ->withTitle(
                __('Inspirational and Motivational Quotes That Will Make Your Day!')
            );
    }

    /**
     * Show single quote.
     *
     * @param string $lang
     * @param Quote  $quote
     *
     * @return RedirectResponse
     */
    public function show(string $lang, Quote $quote): RedirectResponse
    {
        return redirect(route_lang('quote.show.slug', $quote->slug));
    }

    /**
     * Get quote by slug attribute.
     *
     * @param string $lang
     * @param string $slug
     *
     * @return View
     */
    public function showBySlug(string $lang, string $slug): View
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

            $users = User::all();
            Notification::send($users, new QuoteSubmitNotification($quote));
        });

        return response()->json([
            'status' => true,
            'quote' => $quote,
        ]);
    }

    /**
     * Response random quotes.
     *
     * @param string  $lang
     * @param Request $request
     *
     * @return View
     */
    public function random(string $lang, Request $request): View
    {
        $this->validate($request, [
            'locale' => 'string|exists:languages,code_alternate',
            'category' => 'string|exists:categories,slug',
        ]);

        $quotes = Quote::inRandomOrder()
            ->with('author')
            ->language($request->locale)
            ->category($request->category)
            ->published()
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

    /**
     * Return feed as JSON and JSONP format.
     * https://jsonfeed.org/version/1.
     *
     * @return JsonResponse
     */
    public function feed(string $lang, Request $request): JsonResponse
    {
        $this->validate($request, [
            'callback' => 'string|valid_callback',
            'limit' => 'integer|max:50',
        ]);

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('author')
            ->take(20)
            ->paginate();

        $quotes->appends($request->only('limit', 'callback'));

        return response()
            ->json([
                'version' => 'https://jsonfeed.org/version/1',
                'title' => __('Motivational & Inspirational Quotes'),
                'home_page_url' => route_lang('index'),
                'feed_url' => route_lang('quote.feed'),
                'description' => __('Inspirational and Motivational Quotes That Will Make Your Day!'),
                'next_url' => $quotes->nextPageUrl(),
                'author' => [
                    'name' => config('app.name'),
                ],
                '_api' => [
                    'about' => __('Restful API service for quotes'),
                    'url' => route('api'),
                ],
                'items' => $quotes->map(function ($quote) {
                    return [
                        'id' => $quote->id,
                        'url' => route_lang('quote.show.slug', $quote->slug),
                        'title' => __('Quote by :author', ['author' => $quote->author->name]),
                        'content_text' => $quote->text,
                        'image' => route('quote.poster', $quote->slug),
                        'date_published' => $quote->created_at->format(Carbon::RFC3339),
                        'date_modified' => $quote->updated_at->format(Carbon::RFC3339),
                        'author' => $quote->author->name,
                    ];
                }),
            ])
            ->withCallback($request->callback);
    }
}
