<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Quote;
use App\Category;
use App\Author;
use App\Language;
use App\Http\Requests\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Numbers\Number;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class QuoteController extends Controller
{
    /**
     * Display a listing of the quote.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $this->validate($request, [
            'lang' => 'string|exists:languages,code_alternate',
            'category' => 'string|exists:categories,slug',
        ]);

        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('author', 'category', 'language')
            ->when($request->user, function ($query) use ($request) {
                return $query->whereUserId($request->user);
            })
            ->category($request->category)
            ->language($request->lang)
            ->when($request->keyword, function ($query) use ($request) {
                return $query->where('text', 'LIKE', '%'.$request->keyword.'%')
                    ->orWherehas('author', function ($author) use ($request) {
                        return $author->where('name', 'LIKE', '%'.$request->keyword.'%');
                    });
            })
            ->paginate($request->limit ?? 20);

        $quotes->appends($request->only('limit', 'category', 'keyword', 'user'));

        return view('admin.quote.index', compact('quotes'))
            ->withTitle(__('Quote (:total)', [
                'total' => Number::n($quotes->total())->format(),
            ]));
    }

    /**
     * Quotes submitted by user.
     *
     * @param Request $request
     *
     * @return View
     */
    public function submitted(Request $request): View
    {
        $quotes = Quote::orderBy('created_at')
            ->with('author', 'category', 'language')
            ->pending()
            ->paginate();

        return view('admin.quote.submitted', compact('quotes'))
            ->withTitle(__('Submitted Quote'));
    }

    /**
     * Show the form for creating a new quote.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Category::dropdown();
        $languages = Language::dropdown();

        return view('admin.quote.create', compact('categories', 'languages'))
            ->withTitle(__('Create Quote'));
    }

    /**
     * Store a newly created quote in storage.
     *
     * @param QuoteRequest $request
     *
     * @return RedirectResponse
     */
    public function store(QuoteRequest $request): RedirectResponse
    {
        DB::transaction(function () use (&$quote, $request) {
            $author = Author::firstOrCreate([
                'name' => $request->author ?? 'Anonymous',
            ]);

            $request->merge([
                'author_id' => $author->id,
                'category_id' => $request->category,
                'language_id' => $request->language,
                'user_id' => Auth::id(),
            ]);

            $quote = Quote::create($request->all());
        });

        return redirect()
            ->route('admin.quote.show', $quote)
            ->withSuccess('Quote has been created successfully.');
    }

    /**
     * Display the specified quote.
     *
     * @param Quote $quote
     *
     * @return View
     */
    public function show(Quote $quote): View
    {
        return view('admin.quote.show', compact('quote'))
            ->withTitle('Quote Detail');
    }

    /**
     * Show the form for editing the specified quote.
     *
     * @param Quote $quote
     *
     * @return View
     */
    public function edit(Quote $quote): View
    {
        $quote->load('author');

        return view('admin.quote.edit', compact('quote'))
            ->with([
                'categories' => Category::dropdown(),
                'languages' => Language::dropdown(),
            ])
            ->withTitle('Edit Quote');
    }

    /**
     * Update the specified quote in storage.
     *
     * @param QuoteRequest $request
     * @param Quote        $quote
     *
     * @return RedirectResponse
     */
    public function update(QuoteRequest $request, Quote $quote): RedirectResponse
    {
        $author = Author::firstOrCreate(['name' => $request->author]);

        $request->merge([
            'category_id' => $request->category,
            'language_id' => $request->language,
            'author_id' => $author->id,
            'status' => $request->status == 1 ? 'A' : 'I',
            'slug' => str_slug($author->name),
        ]);

        $quote->fill($request->all());
        $quote->save();

        $route = $request->action == 'view' ? route('admin.quote.show', $quote) : url()->previous();

        return redirect($route)
            ->withSuccess('Quote has been updated successfully.');
    }

    /**
     * Remove the specified quote from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function poster(Quote $quote): View
    {
        // check if file is exists
        if (!Storage::exists($quote->poster_path)) {
            $quote->fill(['poster_path' => null]);
            $quote->save();
        }

        return view('admin.quote.poster', compact('quote'))
            ->withTitle(__('Upload Poster Background'));
    }

    public function uploadPoster(Request $request, Quote $quote): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'background' => 'required|image|mimes:jpeg,jpg',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }

        $sub = Carbon::now()->format('Y/m');
        $directory = 'public/background/poster/quote/'.$sub;
        $path = $request->file('background')->store($directory);

        if ($path) {
            // delete existing file
            if (Storage::exists($quote->poster_path)) {
                Storage::delete($quote->poster_path);
            }

            $quote->fill(['poster_path' => $path]);
            $quote->save();

            // resize image using intervention
            $image = \Image::make(Storage::get($quote->poster_path));
            $image->resize(600, 400, function ($ratio) {
                $ratio->aspectRatio();
            });
            $image->save(Storage::path($quote->poster_path));
        }

        $route = $request->action == 'submit_view' ? route('admin.quote.show', $quote) : route('admin.quote.poster', $quote);

        return redirect($route);
    }
}
