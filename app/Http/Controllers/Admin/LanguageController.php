<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Language;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    /**
     * Display a listing of the language.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $languages = Language::orderBy('name')
            ->with('country')
            ->when($request->keyword, function ($query) use ($request) {
                return $query->where('code', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('name', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('native_name', 'LIKE', '%'.$request->keyword.'%');
            })
            ->when($request->country, function ($query) use ($request) {
                return $query->whereCountryId($request->country);
            })
            ->get();

        return view('admin.language.index', compact('languages'))
            ->withTitle('Language');
    }

    /**
     * Show the form for creating a new language.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created language in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified language.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified language.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified language in storage.
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
     * Remove the specified language from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
