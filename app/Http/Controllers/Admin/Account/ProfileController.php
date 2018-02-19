<?php

namespace App\Http\Controllers\Admin\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show form for update profile.
     *
     * @param Request $request
     *
     * @return View
     */
    public function edit(Request $request): View
    {
        return view('admin.account.profile.edit')
            ->with('user', Auth::user())
            ->withTitle(__('Edit Profile'));
    }

    /**
     * Update current logged user profile.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }

        Auth::user()->fill($request->only('name'))->save();

        return redirect()
            ->route('admin.account.profile.edit')
            ->withSuccess(__('Your profile has been update successfully.'));
    }
}
