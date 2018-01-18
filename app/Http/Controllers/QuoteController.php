<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Quote;

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
        $quotes = Quote::orderBy('created_at', 'DESC')
            ->with('author', 'category', 'language')
            ->when($request->category, function ($query) use ($request) {
                return $query->whereCategoryId($request->category);
            })
            ->when($request->keyword, function ($query) use ($request) {
                return $query->where('text', 'LIKE', '%'.$request->keyword.'%')
                    ->orWherehas('author', function ($author) use ($request) {
                        return $author->where('name', 'LIKE', '%'.$request->keyword.'%');
                    });
            })
            ->paginate($request->limit ?? 20);

        $quotes->appends($request->only('limit', 'category', 'keyword'));

        return view('quote.index', compact('quotes'))
            ->withTitle('Quotes');
    }

    /**
     * Show the form for creating a new quote.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created quote in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        return view('quote.show', compact('quote'))
            ->withTitle('Quote Detail');
    }

    /**
     * Show the form for editing the specified quote.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified quote in storage.
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
     * Remove the specified quote from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
