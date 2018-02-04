<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Mail\ContactMail;
use App\User;
use App\Notifications\GeneralNotification;

class ContactController extends Controller
{
    /**
     * Send email to owner.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function post(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        Mail::to(config('mail.to.address'))->send(new ContactMail($request));

        // send notification to admin
        $user = User::all();
        Notification::send($user, new GeneralNotification(
            __('Message from :sender', ['sender' => $request->name]),
            '',
            'fa-envelope'
        ));

        return response()->json([
            'status' => true,
        ]);
    }
}
