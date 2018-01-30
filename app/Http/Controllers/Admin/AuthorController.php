<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Author;
use App\Http\Requests\AuthorRequest;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Numbers\Number;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    /**
     * Display a listing of the author.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $authors = Author::orderBy('name')
            ->when($request->keyword, function ($query) use ($request) {
                return $query->where('name', 'LIKE', '%'.$request->keyword.'%');
            })
            ->paginate($request->limit ?? 20);

        $authors->appends($request->only('limit', 'keyword'));

        return view('admin.author.index', compact('authors'))
            ->withTitle(sprintf(
                'Author (%s)',
                Number::n($authors->total())->format()
            ));
    }

    /**
     * Show the form for creating a new author.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created author in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified author.
     *
     * @param Author $author
     *
     * @return View
     */
    public function show($lang, Author $author): View
    {
        $author->load('quotes', 'quotes.category', 'quotes.language');

        // remove image path if file not exists
        if (!Storage::exists($author->image_path)) {
            $author->image_path = null;
            $author->save();
        }

        return view('admin.author.show', compact('author'))
            ->withTitle('Author Detail');
    }

    /**
     * Show the form for editing the specified author.
     *
     * @param Author $author
     *
     * @return View
     */
    public function edit(Author $author): View
    {
        // remove image path if file not exists
        if (!Storage::exists($author->image_path)) {
            $author->image_path = null;
            $author->save();
        }

        return view('admin.author.edit', compact('author'))
            ->withTitle('Edit Author');
    }

    /**
     * Update the specified author in storage.
     *
     * @param AuthorRequest $request
     * @param Author        $author
     *
     * @return RedirectResponse
     */
    public function update(AuthorRequest $request, Author $author): RedirectResponse
    {
        $picture = $request->file('picture');
        if (!empty($picture) and $picture->isValid()) {
            $directory = sprintf('public/author/%s', Carbon::now()->format('Y/m'));
            $filename = sprintf('%s.%s', str_slug($author->name), $picture->getClientOriginalExtension());
            $path = $picture->storeAs($directory, $filename);

            // crop and resize image
            $image = Image::make(url(Storage::url($path)));
            $image->fit(500)
                ->save(sprintf(
                    '%s/%s',
                    storage_path('app/'.$directory),
                    $filename
                ));

            $author->image_path = $path;
        }

        $author->name = $request->name;
        $author->save();

        return redirect($request->action == 'view' ? route('admin.author.show', $author) : url()->previous())
            ->withSuccess('Author has been updated.');
    }

    /**
     * Remove the specified author from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /**
     * Remove picture from storage.
     *
     * @param Author $author
     *
     * @return RedirectResponse
     */
    public function removePicture(Author $author): RedirectResponse
    {
        DB::transaction(function () use ($author) {
            Storage::delete($author->image_path);

            $author->image_path = null;
            $author->save();
        });

        return redirect()
            ->back()
            ->withSuccess('Picture has been deleted.');
    }
}
