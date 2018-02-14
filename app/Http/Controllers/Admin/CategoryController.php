<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Category;
use Illuminate\Http\RedirectResponse;
use App\Quote;
use App\Http\Controllers\Controller;
use Numbers\Number;
use Illuminate\Http\JsonResponse;

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

        return view('admin.category.index', compact('categories'))
            ->withTitle(__('Category (:total)', [
                'total' => Number::n($categories->count())->format(),
            ]));
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
     * @param Category $category
     *
     * @return View
     */
    public function show(Category $category): View
    {
        return view('admin.category.show', compact('category'))
            ->withTitle(__('Category Detail'));
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
     * Update category by column and value.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateable(Request $request): JsonResponse
    {
        $this->validate($request, [
            'pk' => 'required|integer|exists:categories,id',
            'name' => 'required|string|has_column:categories',
        ]);

        $category = Category::whereId($request->pk)
            ->update([$request->name => $request->value]);

        return response()->json([
            'message' => __('Category has been updated.'),
        ]);
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

    /**
     * Show form to merge dupilcate category or movine category.
     *
     * @return View
     */
    public function merge(): View
    {
        $categories = Category::dropdown();

        return view('admin.category.merge', compact('categories'))
            ->withTitle(__('Merge Duplicate Category'));
    }

    /**
     * Move from one category to another one category.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function fuse(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'source' => 'required|int|exists:categories,id',
            'destination' => 'required|int|different:source|exists:categories,id',
        ]);

        Quote::where('category_id', $request->source)
            ->update(['category_id' => $request->destination]);

        return redirect()
            ->route('admin.category.index')
            ->withSuccess(__('Quote inside source category has been migrated to destination category.'));
    }
}
