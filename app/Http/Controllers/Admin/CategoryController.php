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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Upload poster background via category.
     *
     * @param Category $category
     *
     * @return View
     */
    public function poster(Category $category): View
    {
        // check if poster file is exists
        if (!Storage::exists($category->poster_path)) {
            $category->fill(['poster_path' => null])->save();
        }

        return view('admin.category.poster', compact('category'))
            ->with(__('Poster Background'));
    }

    public function uploadPoster(Request $request, Category $category): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'background' => 'required|image|mimes:jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }

        $directory = 'public/background/category';
        $path = $request->file('background')->store($directory);

        if ($path) {
            if ($category->poster_path and Storage::exists($category->poster_path)) {
                Storage::delete($category->poster_path);
            }

            $category->fill(['poster_path' => $path]);
            $category->save();

            // resize image
            $image = \Image::make(Storage::path($category->poster_path));
            $image->resize(600, 400, function ($ratio) {
                $ratio->aspectRatio();
            });
            $image->save(Storage::path($category->poster_path));
        }

        $route = $request->action == 'submit_view' ? route('admin.category.show', $category) : route('admin.category.poster', $category);

        return redirect($route)
            ->withSuccess(__('Poster background has been uploaded.'));
    }
}
