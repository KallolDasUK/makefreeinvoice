<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceSendMail;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function testEmail()
    {
        Mail::to("invoicepedia@gmail.com")->queue(new TestMail);
    }
}
