<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\User;
use App\Quote;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $users = User::orderBy('name')
            ->paginate($request->limit ?? 20);

        $users->appends($request->only('limit', 'keyword'));

        return view('admin.user.index', compact('users'))
            ->withTitle('User');
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     *
     * @return View
     */
    public function show(User $user): View
    {
        // get latest quotes from user
        $quotes = Quote::whereUserId($user->id)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();

        return view('admin.user.show', compact('user', 'quotes'))
            ->withTitle('User Detail');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified user in storage.
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
     * Remove the specified user from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
