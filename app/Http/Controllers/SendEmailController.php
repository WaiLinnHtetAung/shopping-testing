<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function sendEmail() {
        $emails = User::select('email')->get();
        Mail::to($emails)->send(new WelcomeMail());
        return "Email sent done!";
    }
}
