<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Mail;

class FrontendContactController extends Controller
{
    public function store(Request $request)
    {
        Mail::to(config('global_settings.from_email'))->send(new ContactMail($request->except(['_token'])));

        return redirect()->back()->withSuccess('Sent successsfuly.');
    }
}
