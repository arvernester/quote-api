<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Load router view from Vue Router.
     *
     * @return View
     */
    public function __invoke(): View
    {
        return view('page');
    }
}
