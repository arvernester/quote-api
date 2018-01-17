<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the category.
     *
     * @return View
     */
    public function index(): View
    {
        $categories = Category::orderBy('name')
            ->withCount('quotes')
            ->get();

        return view('category.index', compact('categories'))
            ->withTitle('Category');
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created category in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified category.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category): View
    {
        return view('category.show', compact('category'))
            ->withTitle('Category Detail');
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified category in storage.
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
     * Remove the specified category from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
