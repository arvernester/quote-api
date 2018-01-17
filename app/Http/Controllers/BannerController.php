<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Illuminate\View\View;
use App\Http\Requests\BannerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class BannerController extends Controller
{
    /**
     * Display a listing of the banner.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $banners = Banner::orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('banner.index', compact('banners'))
            ->withTitle('Banner');
    }

    /**
     * Show the form for creating a new banner.
     *
     * @return View
     */
    public function create(): View
    {
        return view('banner.create')
            ->withTitle('Upload Banner');
    }

    /**
     * Store a newly created banner in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request): RedirectResponse
    {
        $image = $request->file('image');
        if ($image->isValid()) {
            $directory = sprintf('public/banner/%s', Carbon::now()->format('Y/m'));
            $path = $image->store($directory);
            $request->merge(['path' => $path]);
        }

        $banner = Banner::create($request->all());

        return redirect()
            ->route('admin.banner.index')
            ->withSuccess('Banner has been uploaded.');
    }

    /**
     * Display the specified banner.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner): View
    {
        return view('banner.show', compact('banner'))
            ->withTitle('Banner Detail');
    }

    /**
     * Show the form for editing the specified banner.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner): View
    {
        return view('banner.edit', compact('banner'));
    }

    /**
     * Update the specified banner in storage.
     *
     * @param BannerRequest $request
     * @param Banner        $banner
     *
     * @return RedirectResponse
     */
    public function update(BannerRequest $request, Banner $banner): RedirectResponse
    {
        $request->merge([
            'is_active' => $request->is_active == 1,
        ]);

        $banner->fill($request->all());
        $banner->save();

        return redirect()
            ->route('admin.banner.index')
            ->withSuccess('Banner has been updated.');
    }

    /**
     * Remove the specified banner from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
