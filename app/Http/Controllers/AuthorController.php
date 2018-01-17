<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Author;
use App\Http\Requests\AuthorRequest;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
            ->paginate($request->limit ?? 20);

        $authors->appends($request->only('limit'));

        return view('author.index', compact('authors'))
            ->withTitle('Author');
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
    public function show(Author $author): View
    {
        return view('author.show', compact('author'))
            ->withTitle('Author Detail');
    }

    /**
     * Show the form for editing the specified author.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author): View
    {
        return view('author.edit', compact('author'))
            ->withTitle('Edit Author');
    }

    /**
     * Update the specified author in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorRequest $request, Author $author): RedirectResponse
    {
        $picture = $request->file('picture');
        if ($picture->isValid()) {
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

            $author->fill(['image_path' => $path]);
            $author->save();
        }

        return redirect()
            ->route('admin.author.index')
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
}
